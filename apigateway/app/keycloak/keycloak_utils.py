import os
import requests
import json
from keycloak import KeycloakAdmin
from keycloak import KeycloakOpenIDConnection
from keycloak.exceptions import KeycloakError, KeycloakPutError
from app.keycloak.keycloak_schemas import KeycloakUserUpdateSchema, KeycloakSelfUserUpdateSchema

from dotenv import load_dotenv
load_dotenv()

SERVER_URL = os.getenv('SERVER_URL', "SERVER_URL")
# USERNAME = os.getenv('KEYCLOAK_ADMIN_USERNAME', "USERNAME")
# PASSWORD = os.getenv('KEYCLOAK_ADMIN_PASSWORD', "PASSWORD")
REALM_NAME = os.getenv('REALM_NAME', "REALM_NAME")
CLIENT_ID = os.getenv('CLIENT_ID', "CLIENT_ID")
CLIENT_SECRET = os.getenv('CLIENT_SECRET', "CLIENT_SECRET")

keycloak_connection = KeycloakOpenIDConnection(
    server_url=SERVER_URL,
    client_secret_key=CLIENT_SECRET,
    realm_name=REALM_NAME,
    client_id=CLIENT_ID,
    verify=True
)

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
