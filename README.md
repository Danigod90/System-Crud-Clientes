# System CRUD Clients

A web application built with Laravel to manage clients. This project allows you to create, read, update and delete clients from a database.

## Technologies Used

- PHP 8.4
- Laravel 12
- MySQL
- Docker
- Bootstrap 5

## Features

- List all clients
- Create new clients
- Edit existing clients
- View client details
- Delete clients
- Form validation
- Success messages

## Installation

1. Clone the repository
```bash
git clone https://github.com/Danigod90/System-Crud-Clientes.git
```

2. Install dependencies
```bash
composer install
```

3. Copy the environment file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations
```bash
php artisan migrate
```

6. Start the server
```bash
./vendor/bin/sail up
```

7. Visit http://localhost in your browser

## Author

Daniel Maidana - [@Danigod90](https://github.com/Danigod90)
