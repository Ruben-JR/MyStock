This is a basic configuration to `integrate` with `keycloak`. for more information go to keyclaok documentation

For this project  we `use` the `keycloak` with docker, so make sure you have a docker installed.

1. **Start keycload:** from a terminal, enter the following command to start Keycloak:

    ```
    docker run -p 8080:8080 -e KEYCLOAK_ADMIN=admin -e KEYCLOAK_ADMIN_PASSWORD=admin quay.io/keycloak/keycloak:23.0.0 start-dev
    ```

    This command starts Keycloak exposed on the local port 8080 and creates an initial admin user with the username admin and password admin.

2. **Log in** in to the admin console

    1. Go to the Keycloak Admin Console.
    2. Log in with the username and password you created earlier.
    3. Create a new realm
    4. Create a new user
    5. Create a new client

3. **Create a .env file app folder:** add the follow environments variable

    ```
    SERVER_URL      = http://localhost:8080/
    REALM_NAME      = your_realm_name
    CLIENT_ID       = your_client_id
    CLIENT_SECRET   = your_client_secret
    ```

    After `create a client` in `keycloak` copy the client `credencial` and add to your `.env variables`

With all this configuration the API Gateway will connect with keycloak for users managements
