from typing import Union
from fastapi import FastAPI
from pydantic import BaseModel
from fastapi import APIRouter, Depends, HTTPException, Response
from fastapi.middleware.cors import CORSMiddleware


from app.keycloak.authentication import get_user, check_user_role
from app.keycloak.authentication import router as authRouter 
from app.keycloak.keycloak_utils import get_client_id, get_client_role_by_name, create_client_role
from app.keycloak.keycloak_utils import keycloak_admin
from app.keycloak.authentication import get_user, check_user_role


from app.keycloak.authentication import router as authRouter 
from app.routes.product import router as prouctRouter

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(authRouter)
app.include_router(prouctRouter)
