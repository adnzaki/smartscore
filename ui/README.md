# Smartscore User Interface

> Source code di dalam folder ini merupakan user interface aplikasi Smartscore.
> Untuk bisa menjalankan Smartscore, silakan lakukan beberapa langkah di bawah ini

## Application Config
- Buka file `app.config.js` di dalam folder ini
- Sesuaikan alamat URL API Smartscore dengan web server Apache anda

## Build Setup
- Buka command prompt, lalu masuk ke direktori ```ui```
- Contoh ``` cd xampp\htdocs\smartscore\ui ```
- Kemudian ketikkan perintah di bawah ini

``` bash
# install dependencies
npm install

# jalankan aplikasi menggunakan webpack-dev-server
# aplikasi akan berjalan di localhost:8080
# untuk menjalankan aplikasi dalam mode development, ketikkan perintah berikut:
> npm run dev
# untuk melakukan build aplikasi dengan minifikasi kode, ketikkan perintah:
> npm run build
# untuk menjalankan aplikasi dalam mode production dengan minifikasi kode:
> npm run ss-start
```

Catatan:<br>
Saat ini aplikasi belum mendapatkan berjalan pada mode production via `npm run ss-start` karena perbedaan konfigurasi
pada versi Node.js dan NPM saat ini, silakan gunakan mode development.