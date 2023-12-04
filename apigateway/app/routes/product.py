import os
from typing import Union

import requests
from fastapi import FastAPI
from pydantic import BaseModel
from dotenv import load_dotenv
from fastapi import APIRouter, Depends, HTTPException, Response

from app.keycloak.keycloak_utils import get_client_id, get_client_role_by_name, create_client_role
from app.keycloak.keycloak_utils import keycloak_admin
from app.keycloak.authentication import get_user, check_user_role
from app.schemas.product import ProductSchema

load_dotenv()
BACKEND_URL = os.getenv("BACKEND_URL")

router = APIRouter(tags=["Products"])

@router.post("/create-products")
def create_product(payload: ProductSchema, user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")
    
    headers = {"Content-Type": "application/json"}
    r = requests.post(BACKEND_URL, headers=headers + "/create-products")
    response = r.json()
    return response

@router.get("/get-products")
def get_product(user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")
    
    r = requests.get(BACKEND_URL + "/get-products")
    response = r.json()
    return response

@router.get("/get-products-id/<id>")
def get_product_id(id: int, user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")
    
    r = requests.post(BACKEND_URL + "/get-products-id/<id>")
    response = r.json()
    return response

@router.put("/update-products/<id>")
def update_product(payload: ProductSchema, user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")
    
    headers = {"Content-Type": "application/json"}
    r = requests.post(BACKEND_URL, headers=headers + "/update-products/<id>")
    response = r.json()
    return response

@router.delete("/delete-products/<id>")
def delete_product(user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")
    
    headers = {"Content-Type": "application/json"}
    r = requests.post(BACKEND_URL, headers=headers + "/delete-products/<id>")
    response = r.json()
    return response
