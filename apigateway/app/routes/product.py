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
async def create_product(payload: ProductSchema, user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")

    check_user_role(user, ['Admin'])

    headers = {"Content-Type": "application/json"}
    r = requests.post(BACKEND_URL, headers=headers + "/create-products", json=payload.dict())
    if r.status_code == 200:
        response = r.json()
        return response
    elif r.status_code == 404:
        raise HTTPException(status_code=404, detail="Item not created")
    else:
        raise HTTPException(status_code=r.status_code, detail="Server error")

@router.get("/get-products")
async def get_product(user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")

    check_user_role(user, ['Admin'])

    r = requests.get(BACKEND_URL + "/get-products")
    if r.status_code == 200:
        response = r.json()
        return response
    elif r.status_code == 404:
        raise HTTPException(status_code=404, detail="Item not found")
    else:
        raise HTTPException(status_code=r.status_code, detail="Server error")

@router.get("/get-products-id/{id}")
async def get_product_id(id: int, user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")

    check_user_role(user, ['Admin'])

    r = requests.get(BACKEND_URL + f"/get-products-id/{id}")
    if r.status_code == 200:
        response = r.json()
        return response
    elif r.status_code == 404:
        raise HTTPException(status_code=404, detail="Item not found")
    else:
        raise HTTPException(status_code=r.status_code, detail="Server error")

@router.put("/update-products/{id}")
async def update_product(id: int, payload: ProductSchema, user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")

    check_user_role(user, ['Admin'])

    headers = {"Content-Type": "application/json"}
    r = requests.put(BACKEND_URL, headers=headers + f"/update-products/{id}", json=payload.dict())
    if r.status_code == 200:
        response = r.json()
        return response
    elif r.status_code == 404:
        raise HTTPException(status_code=404, detail="Item not found")
    else:
        raise HTTPException(status_code=r.status_code, detail="Server error")

@router.delete("/delete-products/{id}")
async def delete_product(user: dict = Depends(get_user)):
    if user is None:
        raise HTTPException(status_code=401, detail="Invalid token or user information not found")

    check_user_role(user, ['Admin'])

    headers = {"Content-Type": "application/json"}
    r = requests.delete(BACKEND_URL, headers=headers + f"/delete-products/{id}")
    if r.status_code == 200:
        response = r.json()
        return response
    elif r.status_code == 404:
        raise HTTPException(status_code=404, detail="Item not found")
    else:
        raise HTTPException(status_code=r.status_code, detail="Server error")
