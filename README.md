# Project Management System (Laravel)

This project is a Project Management System that includes modules for managing projects, tracking expenses, and generating invoices, helping streamline operations and improve project oversight and financial management.

**Sidenote**: When registering a new user, the initial password will be automatically set to `12341234`.

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [PHP](https://www.php.net/) (recommended version: 8.x)
- [Composer](https://getcomposer.org/)
- [Laravel Installer](https://laravel.com/docs/8.x/installation#installing-laravel)
- [MySQL](https://www.mysql.com/) or any other preferred database (if required)

## Clone the Repository

1. Clone the repository to your local machine using the following command:

   ```
   git clone https://github.com/your-username/your-repository.git
   ```

2. Navigate to the project directory:

   ```
   cd your-repository
   ```

## Install Dependencies

3. Install the project dependencies using Composer:

   ```
   composer install
   ```

## Set Up Environment

4. Copy the `.env.example` file to create your `.env` file:

   ```
   cp .env.example .env
   ```

5. Generate the application key:

   ```
   php artisan key:generate
   ```

6. Set up your database and other environment configurations in the `.env` file. Update the following variables as needed:

   - `DB_CONNECTION=mysql` (or your preferred database)
   - `DB_HOST=127.0.0.1`
   - `DB_PORT=3306`
   - `DB_DATABASE=your_database`
   - `DB_USERNAME=root`
   - `DB_PASSWORD=your_password`

## Run Database Migrations (if applicable)

7. Run the database migrations and seed the database to set up your database schema:

   ```
   php artisan migrate --seed
   ```

## Start the Development Server

8. Start the local development server:

   ```
   php artisan serve
   ```

9. The application should now be running at `http://127.0.0.1:8000`. Open this URL in your web browser.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
