<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSE1_0KHw1sIPkNMFmqjzHW_sTigFpRePrsaw&s" width="400" alt="Laravel Logo"></a></p>



## About Manajemen Proyek The Connect


## Menjalankan Project


#### Clone Project Ini

```bash
git clone https://github.com/theconnectdev/THECONNECT-PROJECT-MANAJEMEN.git projectmanajemen
```

```bash
cd projectmanajemen
```

#### Setup .env
```env
APP_NAME=
APP_ENV=
APP_KEY=
APP_DEBUG=true
APP_URL=

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=
# APP_MAINTENANCE_STORE=

# PHP_CLI_SERVER_WORKERS=

BCRYPT_ROUNDS=

LOG_CHANNEL=
LOG_STACK=
LOG_DEPRECATIONS_CHANNEL=
LOG_LEVEL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=
SESSION_LIFETIME=
SESSION_ENCRYPT=
SESSION_PATH=
SESSION_DOMAIN=

BROADCAST_CONNECTION=
FILESYSTEM_DISK=local
QUEUE_CONNECTION=

CACHE_STORE=
# CACHE_PREFIX=

MEMCACHED_HOST=

REDIS_CLIENT=
REDIS_HOST=
REDIS_PASSWORD=
REDIS_PORT=

MAIL_MAILER=
MAIL_SCHEME=
MAIL_HOST=
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=

VITE_APP_NAME="${APP_NAME}"

REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"

HOST_WEBSOCKET=
```

#### Melakukan Migration
```bash
php artisan migrate
```

#### Melakukan Insert Fitur Menu Cms Yang Sudah Di Buat ** Wajib
```bash
php artisan developer:menu-cms
```

#### Melakukan Pembuatan Akun Users Admin Di Command Line
```bash
php artisan developer:create-admin --email=email@example.com --password=user123
```

#### Melakukan Pembuatan Akun Users Developer Di Command Line
```bash
php artisan developer:create-developer --email=developer@example.com --password=developer123
```

### Projek Dijalankan Ada 3 (Server, Queue, Reverb Websocket)

#### Menjalankan Reverb Websocket

**DEFAULT PORT 8080**
```bash
php artisan reverb:start
```

#### Menjalankan Queue
```bash
php artisan queue:work
```

#### Menjalankan Server
**Default Port 8000**
```bash
php artisan serv --port 3000
```

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
