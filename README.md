# Silverstone Invoice Maker

A self-hosted PHP application for generating professional invoices in PDF format. Features multi-user support, client management, and email integration.

## Features

- Create and manage professional invoices with customizable line items
- Multi-user support with role-based access
- Client management with contact information
- PDF invoice generation with company branding
- Email invoices directly to clients via SMTP
- Dashboard with financial metrics and date range filtering
- Invoice status tracking (Draft, Pending, Paid, Partially Paid)
- Custom currency support
- Company logo and watermark customization
- vCard export for client contacts

## Requirements

- PHP 7.4 or higher (PHP 8.x recommended)
- MySQL 5.7+ or MariaDB 10.3+
- Apache or Nginx web server with PHP support
- PHP Extensions:
  - PDO with MySQL driver (`pdo_mysql`)
  - GD Library (for image processing)
  - mbstring (for multi-byte string support)
  - OpenSSL (for email functionality)

## Installation

### Quick Start

1. Upload the project files to your web server's document root (e.g., `/var/www/html/`)

2. Create a MySQL database for the application:
   ```sql
   CREATE DATABASE invoicing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'invoicing_user'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON invoicing.* TO 'invoicing_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. Set proper file permissions:
   ```bash
   chmod 755 /path/to/invoicing-app
   chmod 777 /path/to/invoicing-app/uploads
   chmod 666 /path/to/invoicing-app/config.php
   ```

4. Open your browser and navigate to `http://yourdomain.com/install.php`

5. Follow the installation wizard to:
   - Configure database connection
   - Create your admin account
   - Complete the setup

6. After installation, remove or secure the installation files (done automatically by the installer)

### Manual Configuration

If the installer cannot create the config file, create `config.php` manually:

```php
<?php
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASSWORD', 'your_database_password');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
?>
```

## Project Structure

```
invoicing-app/
├── config.php              # Database configuration
├── index.php               # Dashboard
├── login.php               # User authentication
├── invoice.php             # Invoice creation/editing
├── client.php              # Client management
├── list_invoices.php       # Invoice listing
├── list_clients.php        # Client listing
├── create_pdf.php          # PDF generation
├── email.php               # Email interface
├── core/                   # Core PHP classes
│   ├── class.database.php
│   ├── class.ManageInvoice.php
│   ├── class.ManageClients.php
│   ├── class.ManageUsers.php
│   └── class.ManageEmails.php
├── libs/                   # AJAX handlers and utilities
├── uploads/                # User uploads (logos, etc.)
├── stylesheets/            # CSS files (Foundation framework)
├── javascripts/            # JavaScript files
├── MPDF54/                 # mPDF library for PDF generation
└── PHPMailer_5.2.1/        # PHPMailer for email
```

## Usage

### Creating an Invoice

1. Log in with your credentials
2. Click "Create Invoice" in the navigation
3. Fill in your company details (saved for future use)
4. Select or create a client
5. Add line items with description, quantity, and unit price
6. Set the invoice status and save
7. Generate PDF or email directly to the client

### Managing Clients

1. Navigate to "Clients" section
2. Add new clients with business details and contact information
3. Clients are available for quick selection when creating invoices

### Email Configuration

Configure SMTP settings in your user profile to enable email functionality:
- SMTP Host
- SMTP Port
- SMTP Username
- SMTP Password
- From Email Address

## Known Issues and Upgrade Path

### Current Limitations

This application includes bundled versions of third-party libraries that are outdated:

| Library | Bundled Version | Latest Version | Notes |
|---------|----------------|----------------|-------|
| mPDF | 5.4 (2012) | 8.x | PDF generation |
| PHPMailer | 5.2.1 (2012) | 6.x | Email functionality |
| Foundation | ~4.x | 6.x | CSS framework |
| jQuery | 1.x | 3.x | JavaScript library |

### Recommended Upgrades

For production use, consider these upgrades:

1. **Add Composer Support**: Install dependencies via Composer for better maintainability
   ```bash
   composer require mpdf/mpdf phpmailer/phpmailer
   ```

2. **Update PHP Code**: Modernize the codebase for PHP 8.x compatibility

3. **Security Enhancements**:
   - Implement CSRF token validation
   - Add prepared statements for all database queries
   - Validate and sanitize file uploads

## Security Considerations

- Change default database credentials before deployment
- Use HTTPS in production
- Regularly backup your database
- Keep PHP and MySQL updated
- Remove installation files after setup (`install.php`, `install1.php`, `install2.php`)
- Set restrictive file permissions on `config.php` after installation

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE.txt](LICENSE.txt) file for details.

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues for bugs and feature requests.

## Support

For issues and questions, please open an issue on the GitHub repository.
