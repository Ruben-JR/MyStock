from pydantic import BaseModel


class LoginSchema(BaseModel):
    username: str
    password: str

class RegisterSchema(BaseModel):
    username: str
    firstName: str
    lastName: str
    email: str
    password: str
    phone: int
    

class KeycloakUserUpdateSchema(BaseModel):
    firstName: str
    email: str

class KeycloakSelfUserUpdateSchema(BaseModel):
    firstName: str


class ChangePasswordSchema(BaseModel):
    old_password: str
    new_password: str
