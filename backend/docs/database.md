To load database credentials from a `.env` file and use them in your `config/database.php` file, you'll need to use a package or library to handle environment variables and configuration. The most commonly used package for this purpose in PHP projects is `vlucas/phpdotenv`.

Here are the steps to achieve this:

1. **Install `composer`:** Composer installation in ArchLinux:

   ```bash
   sudo pacman -S composer
   ```
2. **Install `vlucas/phpdotenv`:** Use Composer to install the `vlucas/phpdotenv` package if you haven't already:

   ```bash
   composer require vlucas/phpdotenv
   ```

3. **Create a `.env` File:** Create a `.env` file in the root of your project directory. In this file, you can define your database credentials and other environment-specific settings:

   ```
   DB_HOST=localhost
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Load Environment Variables:** In your `config/database.php` file, you need to load the environment variables from the `.env` file using `vlucas/phpdotenv`.

With this setup, your database credentials are loaded from the `.env` file, making it easy to keep sensitive information separate from your codebase. Additionally, you can use these environment variables throughout your application configuration.

Make sure to add the `.env` file to your `.gitignore` to avoid accidentally exposing sensitive credentials when you push your code to a version control system.