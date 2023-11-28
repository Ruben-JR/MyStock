from typing import Union

from fastapi import FastAPI
from pydantic import BaseModel

from app.keycloak.authentication import get_user, check_user_role
from app.keycloak.authentication import router as authRouter 
from app.keycloak.keycloak_utils import get_client_id, get_client_role_by_name, create_client_role


app = FastAPI()
app.include_router(authRouter)


class Item(BaseModel):
    name: str
    price: float
    is_offer: Union[bool, None] = None

@app.on_event("startup")
async def create_roles_event():
    roles = [
        {
            "name": "admin",
            "description": "Administrator of the system"
        },
        {
            "name": "normal-user",
            "description": "User with normal permissions and accesses to the system"
        },
    ]

    client_id = get_client_id()

    all_roles = []
    for role in roles:
        res = get_client_role_by_name(client_id=client_id, role=role.get('name'))

        if res is None:
            created_role = create_client_role(client_id=client_id, role=role)
            all_roles.append(created_role)
        else:
            all_roles.append(role.get('name'))
    return all_roles
