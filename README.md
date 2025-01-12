# Project Management System (Laravel)

This is a comprehensive Laravel-based Project Management System designed to help organizations efficiently manage projects, track expenses, and generate invoices. It includes various modules that streamline project creation, monitoring, and completion, while automating budgeting, expense tracking, and invoice generation for seamless financial management.

## Prerequisites

- PHP 8.x+
- Composer
- Laravel Installer
- Node.js & npm (for frontend)

## Setup

Run the following commands to set up the project:

   ```
   git clone https://github.com/your-username/your-repository.git
   cd your-repository
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   ```

- Update `.env` for database settings:
  - `DB_CONNECTION=mysql`
  - `DB_HOST=127.0.0.1`
  - `DB_PORT=3306`
  - `DB_DATABASE=your_database`
  - `DB_USERNAME=root`
  - `DB_PASSWORD=your_password`

## Build Frontend

Run the following commands:

   ```
   npm run dev / npm run build
   ```

## Start Server & Test

Run the Laravel server:

   ```
   php artisan serve
   ```

   Visit `http://127.0.0.1:8000` in your browser.

**Note:** Sample user account:

```
Admin
   Email: admin@yopmail.com
   Password: password

User
   Email: user@yopmail.com
   Password: password
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
