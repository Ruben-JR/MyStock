import json

from fastapi import APIRouter, Depends, HTTPException, Request
from fastapi.security import HTTPAuthorizationCredentials, HTTPBearer
from .keycloak_utils import keycloak_connection, keycloak_admin
from .keycloak_schemas import LoginSchema, ChangePasswordSchema, RegisterSchema
from app.keycloak.keycloak_utils import keycloak_connection
from keycloak.exceptions import KeycloakPostError, KeycloakError

router = APIRouter(tags=["keycloak-authentication"])

security = HTTPBearer()


@router.post("/login")
async def login(payload: LoginSchema):
    try:
        token = keycloak_connection.keycloak_openid.token(payload.username, payload.password)
    except KeycloakError as err:
        raise HTTPException(status_code=err.response_code, detail=err.response_body.__str__())

    access_token = token['access_token']
    try:
        userinfo = keycloak_connection.keycloak_openid.userinfo(token=access_token)
    except Exception as err:
        print(err.__str__())
        raise HTTPException(status_code=401, detail="Invalid token")

    return {'token': token}


@router.post("/register")
async def register(payload: RegisterSchema):
    try:
        keycloak_user_id = keycloak_admin.create_user(
            {
                "username": payload.username,
                "email": payload.email,
                "enabled": True,
                "firstName": payload.firstName,
                "lastName": payload.lastName,
                "emailVerified": True,
                "attributes": {
                    "phone": payload.phone,
                }
            },
            exist_ok=False
        )

        keycloak_admin.set_user_password(keycloak_user_id, payload.password, False)

    except KeycloakError as err:
        raise HTTPException(status_code=err.response_code, detail=err.response_body.__str__())

    return {'user_id': keycloak_user_id}


@router.post("/logout")
async def logout(request: Request):
    token = request.headers.get('Authorization')
    if token is not None:
        try:
            token = token.split()[1]
            keycloak_connection.keycloak_openid.logout(token)
            return {"message": "successful logout"}
        except KeycloakPostError as err:
            raise HTTPException(status_code=err.response_code, detail="Invalid refresh token")
        except Exception as err:
            raise HTTPException(status_code=400, detail=err.__str__())
    else:
        raise HTTPException(status_code=401, detail="Not authenticated")


async def get_user(credentials: HTTPAuthorizationCredentials = Depends(security)):
    if not credentials:
        raise HTTPException(status_code=401, detail="Not authenticated")

    access_token = credentials.credentials

    try:
        userinfo = keycloak_connection.keycloak_openid.userinfo(token=access_token)
    except Exception as err:
        print(err.__str__())
        raise HTTPException(status_code=401, detail="Invalid token")

    if "sub" in userinfo:
        return userinfo

    raise HTTPException


# def update_keycloak_user(keycloak_user_update_payload: KeycloakUserUpdateSchema) -> dict:
#     try:
#         user_keycloak_id = keycloak_admin.get_user_id(keycloak_user_update_payload.email)
#     except KeycloakError as err:
#         return {'error': err.response_body.__str__(), 'status_code': err.response_code}

#     try:
#         keycloak_admin.update_user(user_id=user_keycloak_id,
#                                    payload=keycloak_user_update_payload.__dict__)
#     except KeycloakError as err:
#         return {'error': err.response_body.__str__(), 'status_code': err.response_code}

#     return keycloak_user_update_payload.__dict__


# def update_keycloak_self_user(keycloak_user_update_payload: KeycloakSelfUserUpdateSchema, user_keycloak_id: str) -> dict:
#     try:
#         keycloak_admin.update_user(user_id=user_keycloak_id,
#                                    payload=keycloak_user_update_payload.__dict__)
#     except KeycloakError as err:
#         return {'error': err.response_body.__str__(), 'status_code': err.response_code}


@router.patch("/change-password")
async def update_password(change_password_payload: ChangePasswordSchema, user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")

    user_keycloak_id = user.get('sub')
    user_email = user.get('email')

    try:
        token = keycloak_connection.keycloak_openid.token(user_email, change_password_payload.old_password)
    except KeycloakError as err:
        error_response_body = json.loads(err.response_body.decode('utf-8'))
        raise HTTPException(status_code=err.response_code, detail=error_response_body.get('error_description'))

    if token:
        try:
            keycloak_admin.set_user_password(user_id=user_keycloak_id, password=change_password_payload.new_password,
                                             temporary=False)
        except KeycloakError as err:
            error_response_body = json.loads(err.response_body.decode('utf-8'))
            raise HTTPException(status_code=err.response_code, detail=error_response_body.get('error_description'))

        return {'message': 'Password successfully updated for user {}'.format(user_keycloak_id)}
    else:
        return {'message': 'Fail to update password, old password invalid'}


def check_user_role(user: dict, allowed_roles: list[str]):
    roles = user.get("resource_access").get(CLIENT_ID).get('roles')
    if roles is None or len(roles) == 0:
        raise HTTPException(status_code=401, detail="User roles not found")

    for user_role in roles:
        if user_role in allowed_roles:
            return True

    raise HTTPException(status_code=401, detail="You don't have the required roles authorized")
