# ⚡ Quick Start Guide

## 🚀 First Time Setup (10 minutes)

### 1. Clone the Project
```bash
cd /var/www
git clone https://github.com/hichamcc/electric-inspect
cd electric-app
```

### 2. Configure Settings
```bash
cp .env.example .env
nano .env
```
Update these lines:
```
APP_URL=http://YOUR_SERVER_IP
DB_PASSWORD=ChooseStrongPassword
```
Save: `Ctrl+X`, then `Y`, then `Enter`

### 3. Run Setup
```bash
./first-time-setup.sh
```
Answer `y` when asked about sample data.

### 4. Open in Browser
```
http://YOUR_SERVER_IP
```
Login: `admin@example.com` / `password`

---

## 🔄 Daily Operations

### Get Latest Updates
```bash
cd /var/www/electric-app
./update.sh
```

### Create Backup
```bash
cd /var/www/electric-app
./backup.sh
```

### Check if Running
```bash
docker-compose ps
```

### View Logs
```bash
docker-compose logs -f app
```

### Restart Application
```bash
docker-compose restart
```

---

## ⚠️ If Something Goes Wrong

### App is down?
```bash
docker-compose up -d
```

### Can't login?
```bash
docker-compose restart
```

### Need to start fresh?
```bash
docker-compose down
docker-compose up -d
```

### Still not working?
```bash
./deploy.sh
```

---

## 📞 Need Help?

1. Check the logs: `docker-compose logs`
2. Read full guide: `DEPLOYMENT_INSTRUCTIONS.md`

---


