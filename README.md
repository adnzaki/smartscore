# Smartscore
Smartscore adalah sebuah sistem informasi yang digunakan untuk mengolah nilai siswa berbasis Kurikulum 2013
untuk tingkat Sekolah Dasar (SD). Aplikasi ini saya jadikan sebagai proyek open-source agar banyak orang yang
dapat mengembangkannya. Proyek ini baru saja dimulai beriringan dengan proyek open-source saya lainnya yang sudah berjalan
yaitu OstiumCMS.<br>
Smartscore adalah sebuah aplikasi web yang dirancang untuk memiliki performa dan antarmuka layaknya aplikasi native. Dibangun dengan konsep Single Page Application (SPA), yaitu aplikasi web yang hanya memiliki satu halaman utama dan tidak memerlukan reload halaman untuk navigasinya, semua aktivitas user hanya ada dalam satu halaman aplikasi tersebut sehingga pengguna tidak seperti sedang menggunakan aplikasi web melainkan aplikasi native. Antarmuka Smartscore dibangun dengan teknologi web terbaru dengan memerhatikan sisi keamanan yang tinggi bagi pengguna.<br>

## Requirements
Smartscore adalah aplikasi yang menggunakan teknologi web terbaru sehingga membutuhkan sistem yang up-to-date untuk menjalankannya. Hal ini dilakukan agar Smartscore dapat memaksimalkan perkembangan teknologi yang ada sehingga dapat  memberikan pengalaman penggunaan yang terbaik serta menghasilkan sebuah program yang <i>highly maintainable</i> bagi kami selaku pengembang. Berikut adalah beberapa kebutuhan minimal sistem agar Smartscore dapat berjalan pada perangkat anda:
- Sistem Operasi : Windows 7 SP2 atau yang lebih tinggi
- Browser versi terbaru untuk Chrome, Firefox, Edge, Opera atau Safari (saat ini belum mendukung Internet Explorer)
- PHP 5.6 atau lebih tinggi (disarankan PHP 7+)
- Node.js versi 6.11.0 atau lebih tinggi

## API Framework
Smartscore menggunakan CodeIgniter sebagai framework untuk membangun Application Programming Interface (API) yang menghubungkan User Interface dengan database MySQL. CodeIgniter digunakan karena memiliki dukungan yang baik untuk database MySQL serta sudah dilengkapi fitur-fitur yang lengkap untuk kebutuhan aplikasi berbasis database MySQL.

## User Interface Framework
Smartscore menggunakan Vue.js sebagai framework untuk membangun antarmuka penggunanya. UI Smartscore dijanlakan melalui server Node.js untuk proses kompilasi kode Javascript yang di-bundle dengan Webpack. Seluruh template Smartscore menggunakan Vue Component untuk mendukung plugin vue-router sebagai engine Single-Page Application.

## Kontribusi
Smartscore dibangun dengan menggunakan 2 framework, yang pertama adalah framework untuk API database MySQL yaitu CodeIgniter versi 3.1.3 saat ini. Framework yang kedua adalah Vue.js untuk membangun user interface. Tracking bug, usulan penambahan fitur dilakukan melalui Issue. Instalasi Smartscore dapat dilakukan dengan cara Clone repositori ini kemudian lakukan setup untuk menjalankan Smartscore via Node.js, lihat langkah-langkahnya [di sini](https://github.com/adnzaki/smartscore/blob/master/ui/README.md). Untuk kontribusi di bagian User Interface, pastikan anda telah memahami cara kerja *Advanced Javascript Application* dengan NPM, ES6 Module, Webpack dan Vue Component.

## Hak Cipta
Smartscore dilisensikan di bawah <a href="https://github.com/adnzaki/smartscore/blob/master/license.txt">Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License</a>, dimana pengguna diperbolehkan mendownload dan menyebarluaskan software ini untuk tujuan non-komersial dan tanpa memodifikasi isi program serta mencantumkan kredit pemilik software. Segala bentuk perubahan pada software ini harus berdasarkan izin dari kami selaku pemegang hak cipta. Segala bentuk penggunaan software yang tidak sesuai dengan aturan yang ada pada lisensi ini dapat dikenakan tindakan tegas yaitu penegakkan hukum atas penyalahgunaan kekayaan intelektual.
