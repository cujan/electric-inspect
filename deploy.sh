#!/bin/bash

echo "=============================================="
echo "🚀 Deploying Electrical Inspection App"
echo "=============================================="
echo ""

# Pull latest code
echo "📥 Step 1/7: Pulling latest changes from GitHub..."
git pull origin main

if [ $? -ne 0 ]; then
    echo "❌ Git pull failed. Please check your connection and try again."
    exit 1
fi

# Stop containers
echo ""
echo "🛑 Step 2/7: Stopping containers..."
docker-compose down

# Build and start containers
echo ""
echo "🏗️  Step 3/7: Building and starting containers..."
docker-compose up -d --build

# Wait for database to be ready
echo ""
echo "⏳ Step 4/7: Waiting for database to be ready..."
sleep 10

# Run migrations
echo ""
echo "📊 Step 5/7: Running database migrations..."
docker-compose exec -T app php artisan migrate --force

# Clear and cache
echo ""
echo "🧹 Step 6/7: Clearing and caching configurations..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

# Set permissions
echo ""
echo "🔐 Step 7/7: Setting permissions..."
docker-compose exec -T app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker-compose exec -T app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo ""
echo "=============================================="
echo "✅ Deployment Complete!"
echo "=============================================="
echo ""
echo "🌐 Application is running at http://localhost"
echo ""
echo "📊 Check container status: docker-compose ps"
echo "📋 View logs: docker-compose logs -f app"
echo ""
