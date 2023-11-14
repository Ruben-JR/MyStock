To run pre-commit you need to install it with python environments.

Here are the steps to achieve this:

1. **Install `virtual environment`:** python pip installation in ArchLinux:

   ```bash
   python -m pip install --user virtualenv
   ```
2. **Creating `virtual environment`:** Use python to create it: Create venvs folder ext create a folder to put projects environments:

   ```bash
   mkdir ~/.venvs
   python -m venv ~/.venvs/folderProjectName
   ```

3. **Before** you can `start installing or using packages` in your virtual environment:

   ```
   source ~/.venvs/FolderNameProject/bin/activate
   ```

4. **Using** pip

    ```
    pip install pre-commit
    ```

5. **Run** the following command to set up the git hook scripts

    ```
    pre-commit install
    ```

6. **install** the requirements.txt

    ```
    pip install -r requirements.txt
    ```

7. **Run against all the files**

    ```
    pre-commit run --all-files
    ```
