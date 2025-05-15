# Invoicing App

[![Build Status](https://github.com/prasadus92/invoicing-app/workflows/PHP%20CI/badge.svg)](https://github.com/prasadus92/invoicing-app/actions)

A modern PHP application for generating and managing invoices in PDF format. This application helps businesses create, manage, and send professional invoices to their clients.

## Features

- Create and manage invoices
- Generate PDF invoices
- Client management
- User authentication and authorization
- Email notifications
- Export to PDF and vCard formats

## Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/prasadus92/invoicing-app.git
   cd invoicing-app
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Create a `.env` file from the example:
   ```bash
   cp .env.example .env
   ```

4. Configure your database settings in the `.env` file:
   ```
   DB_HOST=localhost
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Create the database and run migrations:
   ```bash
   php install.php
   ```

6. Set up your web server to point to the `public` directory

7. Visit your application in the browser and complete the setup process

## Development

- Run tests: `vendor/bin/phpunit`
- Check code style: `vendor/bin/phpcs`
- Fix code style: `vendor/bin/phpcbf`

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE.txt) file for details.

## Author

- Prasad U S - [GitHub Profile](https://github.com/prasadus92)
