# Deployment guide

This project can be deployed with Docker Compose using:

- Caddy as the public web server
- PHP-FPM for Laravel
- MySQL as the database

The production URL for this deployment is:

```text
https://margaret.sextobit.net
```

---

## 1. Server requirements

The server needs:

- Docker
- Docker Compose plugin
- Git

On a fresh Debian/Ubuntu VPS:

```bash
sudo apt update
sudo apt install -y git ca-certificates curl

curl -fsSL https://get.docker.com | sudo sh

sudo usermod -aG docker "$USER"
newgrp docker
```

Check Docker:

```bash
docker --version
docker compose version
```

---

## 2. Clone the repository

```bash
mkdir -p ~/apps
cd ~/apps

git clone https://github.com/rous388/margaret_rms.git
cd margaret_rms
```

---

## 3. Create the environment file

Copy the Docker environment example:

```bash
cp .env.docker.example .env
```

Edit it:

```bash
nano .env
```

For this deployment, make sure these values are set:

```env
APP_NAME="MARGARET RMS"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://margaret.sextobit.net

APP_DOMAIN=margaret.sextobit.net

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=margaret
DB_USERNAME=margaret
DB_PASSWORD=change_this_password
MYSQL_ROOT_PASSWORD=change_this_root_password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
FILESYSTEM_DISK=local
```

Change these values before starting the app:

```env
DB_PASSWORD=change_this_password
MYSQL_ROOT_PASSWORD=change_this_root_password
```

The `.env` file contains secrets and must not be committed.

---

## 4. DNS configuration

Create or verify this DNS record:

```text
margaret.sextobit.net    A    YOUR_SERVER_PUBLIC_IP
```

Caddy will automatically request and renew the HTTPS certificate for:

```text
https://margaret.sextobit.net
```

The server firewall must allow:

```text
80/tcp
443/tcp
```

Do not expose MySQL publicly.

---

## 5. Build and start the containers

```bash
docker compose build
docker compose up -d
```

Check the containers:

```bash
docker compose ps
```

Check logs:

```bash
docker compose logs -f caddy
docker compose logs -f app
docker compose logs -f db
```

---

## 6. Generate the Laravel application key

Generate a key:

```bash
docker compose exec app php artisan key:generate --show
```

Copy the generated value and paste it into `.env`:

```env
APP_KEY=base64:PASTE_GENERATED_KEY_HERE
```

Restart the containers:

```bash
docker compose up -d
```

---

## 7. Run database migrations

```bash
docker compose exec app php artisan migrate --force
```

For the test/demo deployment, seed the database:

```bash
docker compose exec app php artisan db:seed --force
```

---

## 8. Create the storage link

```bash
docker compose exec app php artisan storage:link
```

---

## 9. Optimize Laravel for production

```bash
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize
```

---

## 10. Open the app

Open:

```text
https://margaret.sextobit.net
```

---

## 11. Deploy new code changes

From the server:

```bash
cd ~/apps/margaret_rms

git pull

docker compose build
docker compose up -d

docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize
```

---

## 12. Useful commands

Show running containers:

```bash
docker compose ps
```

View all logs:

```bash
docker compose logs -f
```

View Caddy logs:

```bash
docker compose logs -f caddy
```

View Laravel/PHP logs:

```bash
docker compose logs -f app
```

View MySQL logs:

```bash
docker compose logs -f db
```

Enter the Laravel container:

```bash
docker compose exec app sh
```

Run Artisan commands:

```bash
docker compose exec app php artisan route:list
docker compose exec app php artisan migrate:status
```

Clear Laravel caches:

```bash
docker compose exec app php artisan optimize:clear
```

Rebuild everything:

```bash
docker compose build --no-cache
docker compose up -d
```

Stop the app:

```bash
docker compose down
```

Stop the app and delete all volumes, including the database:

```bash
docker compose down -v
```

Only use `docker compose down -v` if you really want to delete the MySQL data.

---

## 13. Database backup

Create a MySQL backup:

```bash
docker compose exec db sh -c 'mysqldump -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' > backup_$(date +%Y%m%d_%H%M%S).sql
```

Restore a backup:

```bash
cat backup_file.sql | docker compose exec -T db sh -c 'mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"'
```

---

## 14. Troubleshooting

### Check if Caddy can reach PHP-FPM

```bash
docker compose logs -f caddy
```

If Caddy shows FastCGI errors, check that the `app` container is running:

```bash
docker compose ps
docker compose logs -f app
```

### Check Laravel errors

```bash
docker compose exec app tail -f storage/logs/laravel.log
```

### Check database connection

```bash
docker compose exec app php artisan migrate:status
```

If the database connection fails, verify these values in `.env`:

```env
DB_HOST=db
DB_PORT=3306
DB_DATABASE=margaret
DB_USERNAME=margaret
DB_PASSWORD=your_password
```

### Regenerate Laravel caches

```bash
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize
```

### Restart only Laravel

```bash
docker compose restart app
```

### Restart only Caddy

```bash
docker compose restart caddy
```

### Restart everything

```bash
docker compose restart
```
