#!/bin/bash

echo "=============================================="
echo "🎉 Electrical Inspection App - First Time Setup"
echo "=============================================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file from example..."
    cp .env.example .env
    echo ""
    echo "⚠️  IMPORTANT: Please edit .env file with your settings:"
    echo "   - Set APP_URL to your server address"
    echo "   - Set database credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD)"
    echo "   - Review other settings as needed"
    echo ""
    echo "After editing .env, run this script again:"
    echo "   ./first-time-setup.sh"
    echo ""
    exit 1
fi

echo "🏗️  Building Docker containers (this may take a few minutes)..."
docker-compose up -d --build

echo ""
echo "⏳ Waiting for database to be ready (15 seconds)..."
sleep 15

echo ""
echo "🔑 Generating application key..."
docker-compose exec -T app php artisan key:generate --force

echo ""
echo "📊 Running database migrations..."
docker-compose exec -T app php artisan migrate --force

echo ""
read -p "📦 Do you want to seed the database with sample data? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🌱 Seeding database..."
    docker-compose exec -T app php artisan db:seed --force
fi

echo ""
echo "🔗 Creating storage symlink..."
docker-compose exec -T app php artisan storage:link

echo ""
echo "🔐 Setting file permissions..."
docker-compose exec -T app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker-compose exec -T app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo ""
echo "🧹 Clearing and caching configurations..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

echo ""
echo "=============================================="
echo "✅ Setup Complete!"
echo "=============================================="
echo ""
echo "🌐 Your application is now running!"
echo ""
echo "Access it at: http://localhost"
echo "              (or your server IP address)"
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "📧 Default login credentials:"
    echo "   Email: admin@example.com"
    echo "   Password: password"
    echo ""
fi
echo "⚠️  Important Next Steps:"
echo "   1. Change all default passwords"
echo "   2. Update APP_URL in .env to your actual domain/IP"
echo "   3. Set up SSL certificates if needed (in docker/ssl/)"
echo "   4. Configure email settings in .env"
echo ""
echo "📚 For updates, run: ./update.sh"
echo "💾 For backups, run: ./backup.sh"
echo ""
