from pydantic import BaseModel

class ProductSchema(BaseModel):
    id: int
    fornecedor: str
    designacao: str
    fabricantes: str
    numRef: int
    lote: int
    testeEmbal: int
    apres: str
    precoEuro: int
    precoEscudo: int