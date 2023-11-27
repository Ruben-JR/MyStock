import os
import requests
import json
from keycloak import KeycloakAdmin
from keycloak import KeycloakOpenIDConnection
from keycloak.exceptions import KeycloakError, KeycloakPutError
from app.auth.keycloak_schemas import KeycloakUserUpdateSchema, KeycloakSelfUserUpdateSchema

from dotenv import load_dotenv
load_dotenv()

SERVER_URL = os.getenv('SERVER_URL', "SERVER_URL")
#USERNAME = os.getenv('KEYCLOAK_ADMIN_USERNAME', "admin")
#PASSWORD = os.getenv('KEYCLOAK_ADMIN_PASSWORD', "admin")
REALM_NAME = os.getenv('REALM_NAME', "REALM_NAME")
CLIENT_ID = os.getenv('CLIENT_ID', "CLIENT_ID")
CLIENT_SECRET = os.getenv('CLIENT_SECRET', "CLIENT_SECRET")

keycloak_connection = KeycloakOpenIDConnection(
    server_url=SERVER_URL,
    client_secret_key=CLIENT_SECRET,
    realm_name=REALM_NAME,
    client_id=CLIENT_ID,
    verify=True)

keycloak_admin = KeycloakAdmin(connection=keycloak_connection)
access_token = keycloak_admin.token['access_token']


def get_client_id():
    headers = {
        'Authorization': f'Bearer {access_token}'
    }
    response = requests.get(f'{SERVER_URL}admin/realms/{REALM_NAME}/clients', headers=headers)

    if response.status_code == 200:
        clients = response.json()
        for client in clients:
            if client['clientId'] == CLIENT_ID:
                return client['id']
    else:
        raise Exception(f'GET /admin/realms/{REALM_NAME}/clients/ failed: {response.content}')


def get_client_role_by_name(client_id: str, role: str):
    headers = {
        'Authorization': f'Bearer {access_token}'
    }

    response = requests.get(f'{SERVER_URL}admin/realms/{REALM_NAME}/clients/{client_id}/roles/{role}',
                            headers=headers)

    if response.status_code == 200:
        return response.json()
    elif response.status_code == 404:
        return None
    else:
        raise Exception(
            f'{SERVER_URL}admin/realms/{REALM_NAME}/clients/{client_id}/roles/{role} failed: {response.content}')


def create_client_role(client_id: str, role: dict):
    return keycloak_admin.create_client_role(client_role_id=client_id, payload=role)


def create_keycloak_user(keycloak_user_payload: dict, user_role: str):
    keycloak_system_admin = keycloak_admin.get_users({'email': keycloak_user_payload.get('email')})
    if len(keycloak_system_admin) == 0:
        try:
            keycloak_user_id = keycloak_admin.create_user(payload=keycloak_user_payload)
            keycloak_admin.set_user_password(keycloak_user_id, "Teste12345.", False)
            client_id = get_client_id()
            role = get_client_role_by_name(client_id, user_role)
            keycloak_admin.assign_client_role(user_id=keycloak_user_id, client_id=client_id, roles=[role])
        except KeycloakError as err:
            error_response_body = json.loads(err.response_body.decode('utf-8'))
            return {'error': error_response_body.get('error_description'), 'status_code': err.response_code}
        return {'success': "User with role {} created successfully".format(user_role)}
    else:
        return {'error': 'User already exists in Keycloak.', 'status_code': 400}


def update_keycloak_user(keycloak_user_update_payload: KeycloakUserUpdateSchema) -> dict:
    try:
        user_keycloak_id = keycloak_admin.get_user_id(keycloak_user_update_payload.email)
    except KeycloakError as err:
        return {'error': err.response_body.__str__(), 'status_code': err.response_code}

    try:
        keycloak_admin.update_user(user_id=user_keycloak_id,
                                   payload=keycloak_user_update_payload.__dict__)
    except KeycloakError as err:
        return {'error': err.response_body.__str__(), 'status_code': err.response_code}

    return keycloak_user_update_payload.__dict__


def update_keycloak_self_user(keycloak_user_update_payload: KeycloakSelfUserUpdateSchema, user_keycloak_id: str) -> dict:
    try:
        keycloak_admin.update_user(user_id=user_keycloak_id,
                                   payload=keycloak_user_update_payload.__dict__)
    except KeycloakError as err:
        return {'error': err.response_body.__str__(), 'status_code': err.response_code}
