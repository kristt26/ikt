<?php
namespace Config;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
   require SYSTEMPATH . 'Config/Routes.php';
}
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('login', 'Auth::index');
$routes->post('login/check', 'Auth::check');
$routes->post('login/set', 'Auth::setRole');
$routes->get('confirm', 'Auth::confirm');
$routes->get('logout', 'Auth::logout');
$routes->get('send', 'Email::sendEmail');
$routes->get('check_session', 'Auth::check_session');
$routes->post('change_pass', 'Auth::change_password');
$routes->get('/', 'Home::index');
$routes->group('gereja', ['filter' => 'all_auth'], function ($routes) {
   $routes->get('read', 'Gereja::read');
   $routes->post('post', 'Gereja::post');
});
/*
 * --------------------------------------------------------------------
 * Super Admin
 * --------------------------------------------------------------------
 */
/*
 * --------------------------------------------------------------------
 * End Super Admin
 * --------------------------------------------------------------------
 */
/*
 * --------------------------------------------------------------------
 * Admin Gereja
 * --------------------------------------------------------------------
 */
$routes->group('home', ['filter' => 'all_auth'], function ($routes) {
   $routes->get('', 'Home::index');
   $routes->get('read', 'Home::read');
   $routes->get('get_layanan', 'Home::getLayanan');
   $routes->get('cekkk', 'Home::cekKK');
});
$routes->group('anggota', ['filter' => 'auth'], function ($routes) {
   $routes->get('', 'Admin\Anggota::index');
   $routes->get('ultah', 'Admin\Anggota::ultah');
   $routes->get('readultah', 'Admin\Anggota::getUltah');
   $routes->get('add/(:any)', 'Admin\Anggota::add/$1');
   $routes->get('edit/(:any)', 'Admin\Anggota::edit/$1');
   $routes->get('getid/(:any)', 'Admin\Anggota::getId/$1');
   $routes->get('get_by_id/(:any)', 'Admin\Anggota::getById/$1');
   $routes->get('read', 'Admin\Anggota::read');
   $routes->post('post', 'Admin\Anggota::post');
   $routes->put('put', 'Admin\Anggota::put');
   $routes->delete('delete/(:any)', 'Admin\Anggota::delete/$1');
   $routes->get('layak_sidi', 'Admin\Anggota::layak_sidi');
   $routes->get('layak_baptis', 'Admin\Anggota::layak_baptis');
   $routes->get('golongan_darah', 'Admin\Anggota::getGolonganDarah');
});
$routes->group('keluarga', ['filter' => 'auth'], function ($routes) {
   $routes->get('', 'Admin\Keluarga::index');
   $routes->get('read', 'Admin\Keluarga::read');
   $routes->post('post', 'Admin\Keluarga::post');
   $routes->put('put', 'Admin\Keluarga::put');
   $routes->delete('delete/(:any)', 'Admin\Keluarga::delete/$1');
   $routes->get('detail/(:any)', 'Admin\Keluarga::detail/$1');
   $routes->get('getdetail/(:any)', 'Admin\Keluarga::getDetail/$1');
   $routes->get('get_by_id/(:any)', 'Admin\Keluarga::getById/$1');
   $routes->get('cetak/(:any)', 'Admin\Keluarga::cetak/$1');
   $routes->get('cetakall', 'Admin\Keluarga::cetak_all');
   $routes->post('pecah', 'Admin\Keluarga::pecah');
});
$routes->group('laporan', ['filter' => 'auth'], function ($routes) {
   $routes->get('', 'Admin\Laporan::index');
   $routes->get('layak_baptis', 'Admin\Laporan::layak_baptis');
   $routes->get('layak_sidi', 'Admin\Laporan::layak_sidi');
   $routes->get('print', 'Admin\Laporan::print');
   $routes->get('excel', 'Admin\Laporan::excel');
   $routes->get('anggota_jemaat', 'Admin\Laporan::anggota_jemaat');
   $routes->post('get_anggota', 'Admin\Laporan::getDataJemaat');
   $routes->get('cetak_anggota', 'Admin\Laporan::anggota_excel');
   $routes->get('golongan_darah_excel', 'Admin\Laporan::golongan_darah_excel');
   $routes->get('lansia', 'Admin\Laporan::lansia');
   $routes->get('meninggal', 'Admin\Laporan::meninggal');
   $routes->get('meninggal_excel', 'Admin\Laporan::meninggal_excel');
   $routes->get('pindah', 'Admin\Laporan::pindah');
   $routes->get('pindah_excel', 'Admin\Laporan::pindah_excel');
   $routes->get('unsur', 'Admin\Laporan::unsur');
   $routes->post('get_kepala_keluarga', 'Admin\Laporan::get_kepala_keluarga');
});
$routes->group('kerukunan', ['filter' => 'auth'], function ($routes) {
   $routes->get('', 'Admin\Kerukunan::index');
   $routes->get('read', 'Admin\Kerukunan::read');
   $routes->post('post', 'Admin\Kerukunan::post');
   $routes->put('put', 'Admin\Kerukunan::put');
   $routes->delete('delete/(:any)', 'Admin\Kerukunan::delete/$1');
});

$routes->group('wilayah', ['filter' => 'auth'], function ($routes) {
   $routes->get('', 'Admin\Wilayah::index');
   $routes->get('read', 'Admin\Wilayah::read');
   $routes->post('post', 'Admin\Wilayah::post');
   $routes->put('put', 'Admin\Wilayah::put');
   $routes->delete('delete/(:any)', 'Admin\Wilayah::delete/$1');
});
/*
 * --------------------------------------------------------------------
 * End Admin Gereja
 * --------------------------------------------------------------------
 */
/*
 * --------------------------------------------------------------------
 * Jemaat
 * --------------------------------------------------------------------
 */
/*
 * --------------------------------------------------------------------
 * End Jemaat
 * --------------------------------------------------------------------
 */
$routes->group('api/v1', function ($routes) {
   $routes->group('wijk', function ($routes) {
      $routes->get('store', 'Api\Wijk::store');
      $routes->get('show/(:any)', 'Api\Wijk::show/$1');
      $routes->post('create', 'Api\Wijk::create');
      $routes->put('update/(:any)', 'Api\Wijk::update/$1');
      $routes->put('delete/(:any)', 'Api\Wijk::delete/$1');
   });
   $routes->group('anggota', function ($routes) {
      $routes->get('store', 'Api\Anggota::store');
      $routes->get('show/(:any)', 'Api\Anggota::show/$1');
      $routes->post('create', 'Api\Anggota::create');
      $routes->put('update/(:any)', 'Api\Anggota::update/$1');
      $routes->put('delete/(:any)', 'Api\Anggota::delete/$1');
   });
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
   require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
