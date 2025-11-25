# ⚡ Electrical Inspection Management System

A comprehensive Laravel-based system for managing electrical equipment inspections, customers, and inspection records with multi-tenancy support.

## 🌟 Features

- **Customer Management**: Track companies, contacts, and locations
- **Equipment Inventory**: Manage electrical equipment with custom types and parameters
- **Inspection Scheduling**: Schedule and track inspections with reminders
- **Dynamic Forms**: Equipment-type-specific inspection parameters
- **PDF/Excel Export**: Generate professional inspection reports
- **Multi-tenancy**: Organization-based data isolation
- **Role-based Access**: Super Admin, Organization Admin, and Technician roles
- **Notifications**: Email and in-app notifications for upcoming inspections
- **Calendar View**: Visual scheduling interface
- **Dashboard Analytics**: Charts and statistics
- **Dark Mode Support**: User-friendly interface with dark theme

## 🚀 Quick Start

See [QUICK_START.md](QUICK_START.md) for simple deployment steps.

For detailed deployment instructions, see [DEPLOYMENT_INSTRUCTIONS.md](DEPLOYMENT_INSTRUCTIONS.md).

## 📋 Prerequisites

- Docker & Docker Compose
- Git
- Linux Server

## 💻 Technology Stack

- **Backend**: Laravel 12 (PHP 8.3)
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL 8.0
- **Server**: Nginx + PHP-FPM
- **Containerization**: Docker

## 🛠️ Development

### Local Development Setup

```bash
# Clone repository
git clone https://github.com/yourusername/electric-app.git
cd electric-app

# Copy environment file
cp .env.example .env

# Install dependencies
composer install

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Start development server
php artisan serve
```

### Using Docker (Recommended)

```bash
# First time setup
./first-time-setup.sh

# Daily development
docker-compose up -d
```

## 📦 Deployment

### Production Deployment

1. Clone repository on server
2. Configure `.env` file
3. Run `./first-time-setup.sh`
4. Access via browser

### Updates

```bash
# Quick update
./update.sh

# Full rebuild
./deploy.sh
```

### Backup

```bash
# Create backup
./backup.sh
```

## 📚 Documentation

- [Quick Start Guide](QUICK_START.md) - Get started in 10 minutes
- [Deployment Instructions](DEPLOYMENT_INSTRUCTIONS.md) - Complete deployment guide
- [Project Instructions](CLAUDE.md) - Development guidelines

## 🔒 Security

- Multi-tenant data isolation
- Role-based access control
- Secure authentication (Laravel Breeze)
- HTTPS support (via SSL certificates)
- CSRF protection
- XSS prevention
- SQL injection protection

## 🤝 Contributing

This is a private project. For authorized contributors:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

Proprietary - All rights reserved

## 📞 Support

For technical support or questions:
- Email: your-support-email@example.com
- Documentation: See DEPLOYMENT_INSTRUCTIONS.md

## 🎯 Roadmap

### Version 1.0 ✅
- Core CRUD operations
- PDF/Excel export
- Basic multi-tenancy

### Version 1.1 (Planned)
- Multi-language support (Slovak)
- Advanced reporting
- Mobile app integration

### Version 2.0 (Future)
- Offline inspection mode
- QR code equipment tagging
- Advanced analytics

## 👥 Credits

Developed for electrical inspection management.

Built with Laravel, Tailwind CSS, and Alpine.js.

---

**Version:** 1.0.0
**Last Updated:** November 2025
