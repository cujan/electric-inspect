# 🚀 Deployment Instructions - Electrical Inspection Management System

This guide will help you deploy the application on your intranet Linux server using Docker.

## 📋 Prerequisites

Your server must have the following installed:
- **Docker** (version 20.10 or higher)
- **Docker Compose** (version 2.0 or higher)
- **Git**

### Installing Prerequisites (if needed)

```bash
# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Install Git (if not already installed)
sudo apt-get update
sudo apt-get install git -y
```

---

## 🎯 First Time Setup

### Step 1: Clone the Repository

```bash
# Navigate to your web directory
cd /var/www

# Clone the repository (replace with your actual GitHub URL)
git clone https://github.com/hichamcc/electric-inspect
cd electric-app
```

### Step 2: Configure Environment

```bash
# Copy the example environment file
cp .env.example .env

# Edit the configuration file
nano .env
```

**Required Settings to Update:**

```env
# Application
APP_NAME="Electrical Inspection System"
APP_URL=http://your-server-ip-or-domain

# Database
DB_DATABASE=electrical_inspection
DB_USERNAME=dbuser
DB_PASSWORD=YourStrongPasswordHere

# Session (for production)
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true

# Mail Configuration (optional, for notifications)
MAIL_MAILER=smtp
MAIL_HOST=your-mail-server
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
```

Save the file: Press `Ctrl + X`, then `Y`, then `Enter`

### Step 3: Run First-Time Setup

```bash
# Make the script executable (if not already)
chmod +x first-time-setup.sh

# Run the setup
./first-time-setup.sh
```

This script will:
- Build Docker containers
- Generate application key
- Run database migrations
- Ask if you want to seed sample data
- Set up file permissions
- Cache configurations



### Step 4: Access the Application

Open your web browser and navigate to:
- `http://your-server-ip`
- or `http://localhost` (if on the server itself)

**Default Login (if you seeded the database):**
- Email: `admin@example.com`
- Password: `password`

**⚠️ IMPORTANT:** Change the default password immediately after first login!

---

## 🔄 Updating the Application

When new updates are available from GitHub:

### Quick Update (recommended)

```bash
cd /var/www/electric-app
./update.sh
```

This will:
- Pull latest code from GitHub
- Run database migrations
- Clear and refresh caches
- Restart containers



### Full Rebuild (if experiencing issues)

```bash
cd /var/www/electric-app
./deploy.sh
```

This does a complete rebuild of all containers.



---

## 💾 Backing Up Your Data

### Creating a Backup

```bash
cd /var/www/electric-app
./backup.sh
```

Backups are saved to `./backups/` directory with timestamp:
- `db_backup_YYYYMMDD_HHMMSS.sql` - Database
- `storage_backup_YYYYMMDD_HHMMSS.tar.gz` - Uploaded files

### Restoring from Backup

**Restore Database:**
```bash
cd /var/www/electric-app
cat backups/db_backup_YYYYMMDD_HHMMSS.sql | docker-compose exec -T db mysql -u root -p$DB_PASSWORD $DB_DATABASE
```

**Restore Files:**
```bash
cd /var/www/electric-app
tar -xzf backups/storage_backup_YYYYMMDD_HHMMSS.tar.gz
```

---

## 🔧 Common Operations

### View Application Logs

```bash
# View all logs
docker-compose logs

# View only app logs
docker-compose logs app

# Follow logs in real-time
docker-compose logs -f app
```

### Check Container Status

```bash
docker-compose ps
```

All containers should show "Up" status.

### Restart Containers

```bash
# Restart all
docker-compose restart

# Restart specific container
docker-compose restart app
docker-compose restart nginx
docker-compose restart db
```

### Stop Application

```bash
docker-compose down
```

### Start Application (after stopping)

```bash
docker-compose up -d
```

### Access Container Shell

```bash
# Access application container
docker-compose exec app bash

# Access database
docker-compose exec db mysql -u root -p
```

---

## 🐛 Troubleshooting

### Application not accessible

**Check containers are running:**
```bash
docker-compose ps
```

**Check logs for errors:**
```bash
docker-compose logs app
docker-compose logs nginx
```

**Restart all containers:**
```bash
docker-compose restart
```

### Database connection error

**Restart database:**
```bash
docker-compose restart db
```

**Check database logs:**
```bash
docker-compose logs db
```

**Verify credentials in .env match docker-compose.yml**

### Permission errors

**Fix storage permissions:**
```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

### Port already in use

If port 80 is already in use, edit `docker-compose.yml`:
```yaml
nginx:
  ports:
    - "8080:80"  # Change 80 to 8080 or another free port
```

Then access at: `http://your-server-ip:8080`

### Git pull fails

**If you have local changes:**
```bash
# Stash your changes
git stash

# Pull updates
git pull origin main

# Reapply your changes
git stash pop
```

### Clear everything and start fresh

**⚠️ WARNING: This will delete all data!**
```bash
docker-compose down -v
rm -rf storage/app/* storage/framework/cache/* storage/framework/sessions/* storage/framework/views/* storage/logs/*
./first-time-setup.sh
```

---

## 🔒 Security Recommendations

1. **Change default passwords** immediately after first login
2. **Restrict firewall**: Only allow necessary ports (80, 443)
3. **Regular backups**: Set up automated daily backups
4. **Keep updated**: Run `./update.sh` regularly
5. **Monitor logs**: Check `docker-compose logs` for suspicious activity
6. **Use HTTPS**: Set up SSL certificates (see HTTPS section below)

---

## 🔐 Setting Up HTTPS (Optional but Recommended)

### Option 1: Using Let's Encrypt (Free SSL)

```bash
# Install certbot
sudo apt-get install certbot

# Get certificate
sudo certbot certonly --standalone -d your-domain.com

# Copy certificates to docker directory
sudo cp /etc/letsencrypt/live/your-domain.com/fullchain.pem docker/ssl/
sudo cp /etc/letsencrypt/live/your-domain.com/privkey.pem docker/ssl/
```

### Option 2: Using Your Own Certificates

Place your SSL certificate files in `docker/ssl/`:
- `certificate.crt`
- `private.key`

### Update Nginx Configuration

Edit `docker/nginx/default.conf` to add HTTPS:

```nginx
server {
    listen 443 ssl http2;
    server_name your-domain.com;

    ssl_certificate /etc/nginx/ssl/fullchain.pem;
    ssl_certificate_key /etc/nginx/ssl/privkey.pem;

    # ... rest of configuration
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}
```

### Update .env

```env
APP_URL=https://your-domain.com
SESSION_SECURE_COOKIE=true
```

### Restart

```bash
docker-compose restart nginx
```

---

## 📊 Performance Optimization

### For Production Use

Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

### Enable Opcache

Already enabled in Dockerfile by default.

### Database Optimization

```bash
# Optimize tables
docker-compose exec db mysqlcheck -u root -p --optimize --all-databases
```

---

## 📞 Support

For technical issues or questions:
- Check logs: `docker-compose logs`
- Review this documentation
- Contact: your-support-email@example.com

---

## 📝 Maintenance Schedule (Recommended)

- **Daily**: Automated backups
- **Weekly**: Check logs for errors
- **Monthly**: Update application (`./update.sh`)
- **Quarterly**: Full security review

---

## 🎓 Useful Commands Reference

| Action | Command |
|--------|---------|
| First setup | `./first-time-setup.sh` |
| Update app | `./update.sh` |
| Full rebuild | `./deploy.sh` |
| Backup | `./backup.sh` |
| View logs | `docker-compose logs -f` |
| Check status | `docker-compose ps` |
| Restart | `docker-compose restart` |
| Stop | `docker-compose down` |
| Start | `docker-compose up -d` |

---

**Version:** 1.0
**Last Updated:** 2025-11-24
