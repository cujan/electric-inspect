# 🔧 Troubleshooting Guide

Common issues and their solutions for the Electrical Inspection Management System.

## 🚨 Application Not Loading

### Symptom: Browser shows "Connection refused" or "Cannot connect"

**Check if containers are running:**
```bash
docker-compose ps
```

**Expected output:** All services should show "Up"

**If containers are down:**
```bash
docker-compose up -d
```

**If still not working:**
```bash
docker-compose down
docker-compose up -d --force-recreate
```

---

## 🗄️ Database Connection Errors

### Symptom: "SQLSTATE[HY000] [2002] Connection refused"

**Solution 1: Restart database**
```bash
docker-compose restart db
```

**Solution 2: Check database is ready**
```bash
docker-compose logs db
```
Wait for: "ready for connections"

**Solution 3: Verify .env settings**
```bash
cat .env | grep DB_
```
Should match:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=electrical_inspection
DB_USERNAME=dbuser
DB_PASSWORD=your_password
```

**Solution 4: Recreate database container**
```bash
docker-compose down
docker-compose up -d db
sleep 10
docker-compose up -d
```

---

## 🔑 Cannot Login / Session Issues

### Symptom: Logged out repeatedly or "CSRF token mismatch"

**Clear all caches:**
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
docker-compose restart
```

**Check session configuration:**
```bash
cat .env | grep SESSION
```

**For production, should be:**
```
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
```

**Recreate session table:**
```bash
docker-compose exec app php artisan session:table
docker-compose exec app php artisan migrate
```

---

## 📁 Permission Errors

### Symptom: "Permission denied" when uploading files

**Fix permissions:**
```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

**Create missing directories:**
```bash
docker-compose exec app mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache
docker-compose exec app chmod -R 775 storage
```

---

## 🌐 Port Already in Use

### Symptom: "bind: address already in use"

**Check what's using port 80:**
```bash
sudo lsof -i :80
```

**Option 1: Stop conflicting service**
```bash
sudo systemctl stop apache2  # or nginx
```

**Option 2: Change port in docker-compose.yml**
Edit `docker-compose.yml`:
```yaml
nginx:
  ports:
    - "8080:80"  # Change to 8080
```

Then access at: `http://your-server-ip:8080`

---

## 📥 Git Pull Issues

### Symptom: "error: Your local changes would be overwritten"

**Option 1: Stash changes**
```bash
git stash
git pull origin main
git stash pop
```

**Option 2: Discard local changes**
```bash
git reset --hard
git pull origin main
```

**Option 3: Create backup and reset**
```bash
./backup.sh
git reset --hard origin/main
git pull origin main
```

---

## 🐳 Docker Container Issues

### Symptom: Container keeps restarting

**Check logs:**
```bash
docker-compose logs app
```

**Common causes:**

1. **Database not ready:** Wait 15 seconds after `docker-compose up -d`

2. **Permission issues:** Run permission fix commands

3. **Missing .env:** Ensure `.env` file exists

4. **Port conflicts:** Change ports in docker-compose.yml

---

## 💾 Backup/Restore Issues

### Backup fails

**Check disk space:**
```bash
df -h
```

**Ensure backups directory exists:**
```bash
mkdir -p backups
chmod 755 backups
```

### Restore fails

**For database restore:**
```bash
# Get correct credentials
DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)
DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)

# Restore
cat backups/db_backup_YYYYMMDD_HHMMSS.sql | docker-compose exec -T db mysql -u root -p${DB_PASSWORD} ${DB_DATABASE}
```

---

## 🔄 Update Script Fails

### After update, site is broken

**Rollback to previous version:**
```bash
git log --oneline  # Find previous commit
git reset --hard COMMIT_HASH
docker-compose down
docker-compose up -d --build
```

**Or restore from backup:**
```bash
./backup.sh  # If not already done
# Then restore database and files
```

---

## 📊 Charts/Calendar Not Loading

### Symptom: Calendar or charts show blank

**Check browser console for errors (F12)**

**If HTTPS error in production:**
Update `.env`:
```
APP_URL=https://your-domain.com
SESSION_SECURE_COOKIE=true
```

**Clear cache:**
```bash
docker-compose exec app php artisan config:cache
docker-compose restart
```

**Check AppServiceProvider is forcing HTTPS:**
```bash
cat app/Providers/AppServiceProvider.php | grep forceScheme
```

---

## 📧 Email Notifications Not Sending

### Check mail configuration:

```bash
cat .env | grep MAIL
```

**Test email:**
```bash
docker-compose exec app php artisan tinker
```
Then run:
```php
Mail::raw('Test email', function($message) {
    $message->to('test@example.com')->subject('Test');
});
```

**Common fixes:**
- Verify SMTP credentials
- Check firewall allows outbound port 587/465
- Use correct MAIL_ENCRYPTION (tls/ssl)

---

## 🔍 Debugging Tips

### Enable debug mode temporarily

Edit `.env`:
```
APP_DEBUG=true
LOG_LEVEL=debug
```

**Remember to disable in production:**
```
APP_DEBUG=false
LOG_LEVEL=error
```

### View detailed logs

```bash
# Application logs
docker-compose logs -f app

# All logs
docker-compose logs -f

# Last 50 lines
docker-compose logs --tail=50 app

# Laravel logs
docker-compose exec app tail -f storage/logs/laravel.log
```

### Access container for debugging

```bash
# Access app container
docker-compose exec app bash

# Check PHP version
php -v

# Check Laravel version
php artisan --version

# List routes
php artisan route:list

# Check database connection
php artisan tinker
# Then: DB::connection()->getPdo();
```

---

## 🆘 Nuclear Option (Start Fresh)

**⚠️ WARNING: This deletes ALL data!**

```bash
# Backup first!
./backup.sh

# Stop everything
docker-compose down -v

# Remove containers and volumes
docker system prune -a --volumes

# Start fresh
./first-time-setup.sh
```

---

## 📞 Still Need Help?

If none of these solutions work:

1. **Check logs carefully:**
   ```bash
   docker-compose logs > debug.log
   ```

2. **Gather information:**
   - Docker version: `docker --version`
   - Compose version: `docker-compose --version`
   - OS: `cat /etc/os-release`
   - Error messages from browser console (F12)

3. **Contact support** with:
   - Steps you tried
   - Error messages
   - Log files
   - System information

**Support Email:** your-support-email@example.com

---

## 🔗 Related Documentation

- [Deployment Instructions](DEPLOYMENT_INSTRUCTIONS.md)
- [Quick Start](QUICK_START.md)
- [README](README.md)
