You will need to `install` the `Fast Api` with python pip so make sure you its installed.

1. **FastApi Installation**

    ```
    pip install fastapi
    ```

2. You will also need an **ASGI server**, for production such as Uvicorn or Hypercorn.

    ```
    pip install "uvicorn[standard]"
    ```

3. **Run the server with:** Make sure you are inside the rot folder

    ```
    uvicorn app.main:app --reload
    ```

4. **Open your browser at:** http://127.0.0.1:8000/

For more information you can follow the documentation - <a href="https://fastapi.tiangolo.com/#installation" target="_blank">Here</a>
