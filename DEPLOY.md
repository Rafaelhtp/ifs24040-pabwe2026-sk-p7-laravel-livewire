# Deploy ke Vercel (gratis)

Nama proyek / domain (sesuai modul P7 bagian 3.1):

    ifs24040-pabwe2026-sk-p7-laravel-livewire
    https://ifs24040-pabwe2026-sk-p7-laravel-livewire.vercel.app

Rute (sesuai modul 3.5): /, /login, /register, /stocks, /stocks/{id}, /profile,
/admin/users, /admin/users/{id}/stocks

## 1. Database MySQL gratis (TiDB Cloud Serverless)
1. Daftar di https://tidbcloud.com -> Create Cluster -> Starter (Free).
2. Klik Connect -> pilih "General", catat HOST, PORT (4000), USER, PASSWORD.
3. Buat database: `CREATE DATABASE pabwe_p7_stock;`

## 2. Isi .env LOKAL (sementara, untuk migrasi ke DB cloud)
    DB_CONNECTION=mysql
    DB_HOST=<host tidb>
    DB_PORT=4000
    DB_DATABASE=pabwe_p7_stock
    DB_USERNAME=<user>
    DB_PASSWORD=<password>
    MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt   # Windows: path cacert.pem

Lalu:
    composer install
    php artisan key:generate --show      # salin hasilnya (base64:...) untuk APP_KEY
    php artisan migrate:fresh --seed --force

## 3. Build aset & deploy
    npm install --ignore-scripts
    npm run build
    npm i -g vercel
    vercel login
    vercel link --project ifs24040-pabwe2026-sk-p7-laravel-livewire
    # tambah env (sekali): APP_KEY, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME,
    # DB_PASSWORD, MYSQL_ATTR_SSL_CA, OPENAI_ENDPOINT, OPENAI_KEY, OPENAI_MODEL
    vercel env add APP_KEY production
    vercel --prod

Catatan: public/build harus ada saat `vercel --prod` (CLI mengunggah folder lokal).
