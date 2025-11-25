#!/bin/bash

BACKUP_DIR="./backups"
DATE=$(date +%Y%m%d_%H%M%S)

echo "=============================================="
echo "💾 Backup - Electrical Inspection App"
echo "=============================================="
echo ""

# Create backup directory
mkdir -p $BACKUP_DIR

# Get database credentials from .env
DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)

echo "📊 Step 1/2: Backing up database..."
docker-compose exec -T db mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > $BACKUP_DIR/db_backup_$DATE.sql

if [ $? -eq 0 ]; then
    echo "   ✅ Database backup created: $BACKUP_DIR/db_backup_$DATE.sql"
else
    echo "   ❌ Database backup failed!"
    exit 1
fi

echo ""
echo "📁 Step 2/2: Backing up uploaded files..."
tar -czf $BACKUP_DIR/storage_backup_$DATE.tar.gz storage/app/public 2>/dev/null

if [ $? -eq 0 ]; then
    echo "   ✅ Files backup created: $BACKUP_DIR/storage_backup_$DATE.tar.gz"
else
    echo "   ⚠️  Files backup completed with warnings (may be empty)"
fi

echo ""
echo "=============================================="
echo "✅ Backup Complete!"
echo "=============================================="
echo ""
echo "📦 Backup files created:"
echo "   Database: $BACKUP_DIR/db_backup_$DATE.sql"
echo "   Files:    $BACKUP_DIR/storage_backup_$DATE.tar.gz"
echo ""
echo "💡 To restore database:"
echo "   cat $BACKUP_DIR/db_backup_$DATE.sql | docker-compose exec -T db mysql -u root -p\$DB_PASSWORD \$DB_DATABASE"
echo ""
echo "💡 To restore files:"
echo "   tar -xzf $BACKUP_DIR/storage_backup_$DATE.tar.gz"
echo ""
