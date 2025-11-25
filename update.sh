#!/bin/bash

echo "=============================================="
echo "🔄 Quick Update - Electrical Inspection App"
echo "=============================================="
echo ""

# Pull latest code
echo "📥 Step 1/4: Pulling latest changes..."
git pull origin main

if [ $? -ne 0 ]; then
    echo "❌ Git pull failed. Please check your connection and try again."
    exit 1
fi

# Run migrations
echo ""
echo "📊 Step 2/4: Running database migrations..."
docker-compose exec -T app php artisan migrate --force

# Clear and cache
echo ""
echo "🧹 Step 3/4: Clearing caches..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

# Restart containers (without rebuild)
echo ""
echo "🔄 Step 4/4: Restarting application..."
docker-compose restart app nginx

echo ""
echo "=============================================="
echo "✅ Update Complete!"
echo "=============================================="
echo ""
echo "ℹ️  If you experience issues, run full deployment:"
echo "   ./deploy.sh"
echo ""
