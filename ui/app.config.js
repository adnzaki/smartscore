/**
 * Smartscore
 * Aplikasi Pengolahan Nilai Siswa berbasis Kurikulum 2013 untuk tingkat Sekolah Dasar (SD)
 *
 * @copyright   Copyright (c) 2017, Adnan Zaki
 * @license     Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International Public License | https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode
 * @author      Adnan Zaki
 * @link        http://wolestech.com
 * @version     1.0.0
 */

 /**
  * Smartscore Configuration
  * Modul ini adalah tempat dimana pengguna menyimpan pengaturan
  * utama aplikasi yang nantinya digunakan oleh semua modul front-end Smartscore
  * Pengguna wajib mendefinisikan pengaturan ini agar aplikasi dapat berjalan dengan baik
  *
  * @author     Adnan Zaki
  * @package    Configuration
  * @type       Interface
  */

export const ssconfig = {
    // URL untuk menuju alamat utama API Smartscore
    // untuk mengisi nilai ini, anda harus mengetahui alamat
    // web server anda
    apiUrl: 'http://'+window.location.hostname+':72/smartscore/api/',

    // URL halaman login
    loginUrl: 'http://'+window.location.host+'/',

    // nama key dari cookie yang akan disimpan oleh browser
    cookieName: 'ss_session',

    // masa kadaluarsa cookie dalam satuan menit
    // hanya berlaku jika user tidak melakukan aktifitas apapun
    // dalam rentang waktu tersebut
    cookieExp: 120,

    // halaman utama aplikasi
    // digunakan oleh modul autentikasi ketika login berhasil
    // nilai ini diambil dari bagian URL setelah ... smartscore.html#/
    mainPage: 'dashboard',

    // theme switcher adalah tombol untuk menampilkan
    // pilihan tema bagi pengguna 
    // set nilai ke true apabila ingin menampilkan
    // atau false jika ingin menyembunyikan
    themeSwitcher: false,
}

// update url aplikasi...
$.ajax({
    url: `${ssconfig.apiUrl}AuthController/updateSetting/${window.location.host}`,
    type: 'POST',
    data: window.location.host,
    success: () => {
        console.info('Smartscore App settings updated.')
    }
})
