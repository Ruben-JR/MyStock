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
    
class KeycloakUserSchema(BaseModel):
    firstName: str
    lastName: str
    username: str
    email: str
    emailVerified: bool = True
    enabled: bool = True


class KeycloakUserUpdateSchema(BaseModel):
    firstName: str
    email: str

class KeycloakSelfUserUpdateSchema(BaseModel):
    firstName: str


class ChangePasswordSchema(BaseModel):
    old_password: str
    new_password: str
