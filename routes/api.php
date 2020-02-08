<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'auth'],function($router){
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/me', 'AuthController@me');
});

Route::group(['middleware'=>'jwt.auth'],function(){
// Route::group(['prefix'=>'v1'],function(){

    // auth
    // Route::get('/userId', 'AuthController@userId');
    // Route::get('/profile', 'AuthController@profile');

    // user
    Route::group(['middleware' => ['permission:index_user']], function () {
        Route::get('/user', 'UserController@index');
        Route::get('/user/indexCu/{id}', 'UserController@indexCu');
        Route::get('/user/count', 'UserController@count');
    });
    Route::group(['middleware' => ['permission:create_user']], function () {
        Route::get('/user/create', 'UserController@create');
        Route::post('/user/store', 'UserController@store');
    }); 
    Route::group(['middleware' => ['permission:update_user']], function () {   
        Route::get('/user/edit/{id}', 'UserController@edit');
        Route::get('/user/editHakAkses/{id}', 'UserController@editHakAkses');
        Route::post('/user/update/{id}', 'UserController@update');
        Route::post('/user/updateFoto/{id}', 'UserController@updateFoto');
        Route::post('/user/updateStatus/{id}', 'UserController@updateStatus');
        Route::post('/user/updateHakAkses/{id}', 'UserController@updateHakAkses'); 
        Route::post('/user/updateResetPassword/{id}', 'UserController@updateResetPassword');
        Route::post('/user/updatePassword/{id}', 'UserController@updatePassword');
    });
    Route::group(['middleware' => ['permission:destroy_user']], function () {
        Route::delete('/user/{id}', 'UserController@destroy');
    });

    //artikel
    Route::group(['middleware' => ['permission:index_artikel']], function () {
        Route::get('/artikel', 'ArtikelController@index');
        Route::get('/artikel/indexCu/{id}', 'ArtikelController@indexCu');
        Route::post('/artikel/upload', 'ArtikelController@upload');
        Route::get('/artikel/count', 'ArtikelController@count');
    });
    Route::group(['middleware' => ['permission:create_artikel']], function () {
        Route::get('/artikel/create', 'ArtikelController@create');
        Route::post('/artikel/store', 'ArtikelController@store');
    });
    Route::group(['middleware' => ['permission:update_artikel']], function () {
        Route::get('/artikel/edit/{id}', 'ArtikelController@edit');
        Route::post('/artikel/update/{id}', 'ArtikelController@update');
        Route::post('/artikel/updateTerbitkan/{id}', 'ArtikelController@updateTerbitkan');
        Route::post('/artikel/updateUtamakan/{id}', 'ArtikelController@updateUtamakan');
    });
    Route::group(['middleware' => ['permission:destroy_artikel']], function () {
        Route::delete('/artikel/{id}', 'ArtikelController@destroy');
    });
    
    //artikel kategori
    Route::group(['middleware' => ['permission:index_artikel_kategori']], function () {
        Route::get('/artikelKategori', 'ArtikelKategoriController@index');
        Route::get('/artikelKategori/get', 'ArtikelKategoriController@get');
        Route::get('/artikelKategori/indexCu/{id}', 'ArtikelKategoriController@indexCu');
        Route::get('/artikelKategori/getCu/{id}', 'ArtikelKategoriController@getCu');
    });
    Route::group(['middleware' => ['permission:create_artikel_kategori']], function () {
        Route::get('/artikelKategori/create', 'ArtikelKategoriController@create');
        Route::post('/artikelKategori/store', 'ArtikelKategoriController@store');
    });
    Route::group(['middleware' => ['permission:update_artikel_kategori']], function () {
        Route::get('/artikelKategori/edit/{id}', 'ArtikelKategoriController@edit');
        Route::post('/artikelKategori/update/{id}', 'ArtikelKategoriController@update');
    });
    Route::group(['middleware' => ['permission:destroy_artikel_kategori']], function () {
        Route::delete('/artikelKategori/{id}', 'ArtikelKategoriController@destroy');
    });

    //artikel penulis
    Route::group(['middleware' => ['permission:index_artikel_penulis']], function () {
        Route::get('/artikelPenulis', 'ArtikelPenulisController@index');
        Route::get('/artikelPenulis/get', 'ArtikelPenulisController@get');
        Route::get('/artikelPenulis/indexCu/{id}', 'ArtikelPenulisController@indexCu');
        Route::get('/artikelPenulis/getCu/{id}', 'ArtikelPenulisController@getCu');
        Route::get('/artikelPenulis/count', 'ArtikelPenulisController@count');
    });
    Route::group(['middleware' => ['permission:create_artikel_penulis']], function () {
        Route::get('/artikelPenulis/create', 'ArtikelPenulisController@create');
        Route::post('/artikelPenulis/store', 'ArtikelPenulisController@store');
    });
    Route::group(['middleware' => ['permission:update_artikel_penulis']], function () {
        Route::get('/artikelPenulis/edit/{id}', 'ArtikelPenulisController@edit');
        Route::post('/artikelPenulis/update/{id}', 'ArtikelPenulisController@update');
    });
    Route::group(['middleware' => ['permission:destroy_artikel_penulis']], function () {
        Route::delete('/artikelPenulis/{id}', 'ArtikelPenulisController@destroy');
    });

    // cu
    Route::get('/cu/getHeader', 'CuController@getHeader');   
    Route::group(['middleware' => ['permission:index_cu']], function () {
        Route::get('/cu', 'CuController@index');
        Route::get('/cu/get', 'CuController@get');  
        Route::get('/cu/getPus/{id}', 'CuController@getPus');
        Route::get('/cu/count', 'CuController@count');
    });
    Route::group(['middleware' => ['permission:create_cu']], function () {
        Route::get('/cu/create', 'CuController@create');
        Route::post('/cu/store', 'CuController@store');
    });
    Route::group(['middleware' => ['permission:update_cu']], function () {
        Route::get('/cu/edit/{id}', 'CuController@edit');
        Route::post('/cu/update/{id}', 'CuController@update');
    });
    Route::group(['middleware' => ['permission:destroy_cu']], function () {
        Route::delete('/cu/{id}', 'CuController@destroy');
    });

    // tp
    Route::get('/tp/getCu/{id}', 'TpController@getCu');
    Route::group(['middleware' => ['permission:index_tp']], function () {
        Route::get('/tp', 'TpController@index');
        Route::get('/tp/get', 'TpController@get');
        Route::get('/tp/indexCu/{id}', 'TpController@indexCu'); 
        Route::get('/tp/count', 'TpController@count');
    });
    Route::group(['middleware' => ['permission:create_tp']], function () {
        Route::get('/tp/create', 'TpController@create');
        Route::post('/tp/store', 'TpController@store');
    });
    Route::group(['middleware' => ['permission:update_tp']], function () {
        Route::get('/tp/edit/{id}', 'TpController@edit');
        Route::post('/tp/update/{id}', 'TpController@update');
    });
    Route::group(['middleware' => ['permission:destroy_tp']], function () {
        Route::delete('/tp/{id}', 'TpController@destroy');
    });

    // produk
    Route::group(['middleware' => ['permission:index_produk_cu']], function () {
        Route::get('/produkcu', 'ProdukCuController@index');
        Route::get('/produkcu/get', 'ProdukCuController@get');
        Route::get('/produkcu/indexCu/{id}', 'ProdukCuController@indexCu'); 
        Route::get('/produkcu/getCu/{id}', 'ProdukCuController@getCu');
        Route::get('/produkcu/count', 'ProdukCuController@count');
    });
    Route::group(['middleware' => ['permission:create_produk_cu']], function () {
        Route::get('/produkcu/create', 'ProdukCuController@create');
        Route::post('/produkcu/store', 'ProdukCuController@store');
    });
    Route::group(['middleware' => ['permission:update_produk_cu']], function () {
        Route::get('/produkcu/edit/{id}', 'ProdukCuController@edit');
        Route::post('/produkcu/update/{id}', 'ProdukCuController@update');
    });
    Route::group(['middleware' => ['permission:destroy_produk_cu']], function () {
        Route::delete('/produkcu/{id}', 'ProdukCuController@destroy');
    });

     // diklatBKCU
    Route::group(['middleware' => ['permission:index_diklat_pus']], function () {
        Route::get('/diklatBKCU', 'DiklatBKCUController@index');
        Route::get('/diklatBKCU/get', 'DiklatBKCUController@get');       
        Route::get('/diklatBKCU/getPus/{id}', 'DiklatBKCUController@getPus');
    });
    Route::group(['middleware' => ['permission:create_diklat_pus']], function () {
        Route::get('/diklatBKCU/create', 'DiklatBKCUController@create');
        Route::post('/diklatBKCU/store', 'DiklatBKCUController@store');
    });
    Route::group(['middleware' => ['permission:update_diklat_pus']], function () {
        Route::get('/diklatBKCU/edit/{id}', 'DiklatBKCUController@edit');
        Route::post('/diklatBKCU/update/{id}', 'DiklatBKCUController@update');
    });
    Route::group(['middleware' => ['permission:destroy_diklat_pus']], function () {
        Route::delete('/diklatBKCU/{id}', 'DiklatBKCUController@destroy');
    });

    // pengelola
    Route::group(['middleware' => ['permission:index_pengelola']], function () {
        Route::get('/pengelola', 'PengelolaController@index');
        Route::get('/pengelola/get', 'PengelolaController@get');
        Route::get('/pengelola/indexCu/{id}', 'PengelolaController@indexCu');         
        Route::get('/pengelola/getCu/{id}', 'PengelolaController@getCu');
        Route::get('/pengelola/count', 'PengelolaController@count');
    });
    Route::group(['middleware' => ['permission:create_pengelola']], function () {
        Route::get('/pengelola/create', 'PengelolaController@create');
        Route::post('/pengelola/store', 'PengelolaController@store');
    });
    Route::group(['middleware' => ['permission:update_pengelola']], function () {
        Route::get('/pengelola/editIdentitas/{id}', 'PengelolaController@editIdentitas');
        Route::post('/pengelola/updateIdentitas/{id}', 'PengelolaController@updateIdentitas');
        Route::get('/pengelola/indexPekerjaan/{id}', 'PengelolaController@indexPekerjaan');
        Route::get('/pengelola/indexPendidikan/{id}', 'PengelolaController@indexPendidikan');
        Route::get('/pengelola/indexAnggotaCu/{id}', 'PengelolaController@indexAnggotaCu');
        Route::get('/pengelola/indexKeluarga/{id}', 'PengelolaController@indexKeluarga');
        Route::get('/pengelola/indexOrganisasi/{id}', 'PengelolaController@indexOrganisasi');
        Route::get('/pengelola/createPekerjaan', 'PengelolaController@createPekerjaan');
        Route::get('/pengelola/createPendidikan', 'PengelolaController@createPendidikan');
        Route::get('/pengelola/createOrganisasi', 'PengelolaController@createOrganisasi');
        Route::get('/pengelola/createKeluarga', 'PengelolaController@createKeluarga');
        Route::get('/pengelola/createAnggotaCu', 'PengelolaController@createAnggotaCu');
        Route::post('/pengelola/savePekerjaan/{id}', 'PengelolaController@savePekerjaan');
        Route::post('/pengelola/savePendidikan/{id}', 'PengelolaController@savePendidikan');
        Route::post('/pengelola/saveOrganisasi/{id}', 'PengelolaController@saveOrganisasi');
        Route::post('/pengelola/saveKeluarga/{id}', 'PengelolaController@saveKeluarga');
        Route::post('/pengelola/saveAnggotaCu/{id}', 'PengelolaController@saveAnggotaCu');
        Route::delete('/pengelola/pekerjaan/{id}', 'PengelolaController@destroyPekerjaan');
        Route::delete('/pengelola/pendidikan/{id}', 'PengelolaController@destroyPendidikan');
        Route::delete('/pengelola/organisasi/{id}', 'PengelolaController@destroyOrganisasi');
        Route::delete('/pengelola/keluarga/{id}', 'PengelolaController@destroyKeluarga');
        Route::delete('/pengelola/anggotaCu/{id}', 'PengelolaController@destroyAnggotaCu');

    });
    Route::group(['middleware' => ['permission:destroy_pengelola']], function () {
        Route::delete('/pengelola/{id}', 'PengelolaController@destroy');
    });

    //laporan cu
    Route::group(['middleware' => ['permission:index_laporan_cu']], function () {
        Route::get('/laporanCu', 'laporanCuController@index');
        Route::get('/laporanCu/indexGerakan', 'laporanCuController@indexGerakan');
        Route::get('/laporanCu/indexCu/{id}', 'laporanCuController@indexCu');
        Route::get('/laporanCu/indexPeriode/{periode}', 'laporanCuController@indexPeriode');
        Route::get('/laporanCu/indexPearls', 'laporanCuController@indexPearls');
        Route::get('/laporanCu/indexPearlsCu/{id}', 'laporanCuController@indexPearlsCu');
        Route::get('/laporanCu/indexPearlsPeriode/{periode}', 'laporanCuController@indexPearlsPeriode');
        Route::get('/laporanCu/getPeriode', 'laporanCuController@getPeriode');
        Route::get('/laporanCu/getPeriodeCu/{id}', 'laporanCuController@getPeriodeCu');
        Route::get('/laporanCu/detail/{id}', 'laporanCuController@detail');
        Route::get('/laporanCu/detailPearls/{id}', 'laporanCuController@detailPearls');
    });
    Route::group(['middleware' => ['permission:create_laporan_cu']], function () {
        Route::get('/laporanCu/create', 'laporanCuController@create');
        Route::post('/laporanCu/store', 'laporanCuController@store');
    });
    Route::group(['middleware' => ['permission:update_laporan_cu']], function () {
        Route::get('/laporanCu/edit/{id}', 'laporanCuController@edit');
        Route::post('/laporanCu/update/{id}', 'laporanCuController@update');
    });
    Route::group(['middleware' => ['permission:destroy_laporan_cu']], function () {
        Route::delete('/laporanCu/{id}', 'laporanCuController@destroy');
    });
    Route::group(['middleware' => ['permission:diskusi_laporan_cu']], function () {
        Route::get('/laporanCuDiskusi/get/{id}', 'laporanCuDiskusiController@get');
        Route::post('/laporanCuDiskusi/store', 'laporanCuDiskusiController@store');
        Route::post('/laporanCuDiskusi/update/{id}', 'laporanCuDiskusiController@update');
        Route::delete('/laporanCuDiskusi/{id}', 'laporanCuDiskusiController@destroy');
    });
    Route::group(['middleware' => ['permission:index_laporan_cu']], function () {
        Route::post('/laporanCu/uploadExcel', 'laporanCuController@uploadExcel');
        Route::post('/laporanCu/uploadExcelAll', 'laporanCuController@uploadExcelAll');
        Route::get('/laporanCu/indexDraft/{id}', 'laporanCuController@indexDraft');
        Route::get('/laporanCu/countDraft', 'laporanCuController@countDraft');
        Route::post('/laporanCu/storeDraftAll', 'laporanCuController@storeDraftAll');
    });

    //laporan tp
    Route::group(['middleware' => ['permission:index_laporan_tp']], function () {
        Route::get('/laporanTp/cu/{id}', 'laporanTpController@index');
        Route::get('/laporanTp/indexTp/{id}', 'laporanTpController@indexTp');
        Route::get('/laporanTp/indexPeriode/{id}/{periode}', 'laporanTpController@indexPeriode');
        Route::get('/laporanTp/indexPearls', 'laporanTpController@indexPearls');
        Route::get('/laporanTp/indexPearlsTp/{id}', 'laporanTpController@indexPearlsTp');
        Route::get('/laporanTp/indexPearlsPeriode/{id}/{periode}', 'laporanTpController@indexPearlsPeriode');
        Route::get('/laporanTp/getPeriode', 'laporanTpController@getPeriode');
        Route::get('/laporanTp/getPeriodeTp/{id}/{periode}', 'laporanTpController@getPeriodeTp');
        Route::get('/laporanTp/listLaporanTp/{cu}/{periode}', 'laporanTpController@listLaporanTp');
        Route::get('/laporanTp/detail/{id}', 'laporanTpController@detail');
        Route::get('/laporanTp/detailPearls/{id}', 'laporanTpController@detailPearls');
    });
    Route::group(['middleware' => ['permission:create_laporan_tp']], function () {
        Route::get('/laporanTp/create', 'laporanTpController@create');
        Route::post('/laporanTp/store', 'laporanTpController@store');
    });
    Route::group(['middleware' => ['permission:update_laporan_tp']], function () {
        Route::get('/laporanTp/edit/{id}', 'laporanTpController@edit');
        Route::post('/laporanTp/update/{id}', 'laporanTpController@update');
    });
    Route::group(['middleware' => ['permission:destroy_laporan_tp']], function () {
        Route::delete('/laporanTp/{id}', 'laporanTpController@destroy');
    });
    Route::group(['middleware' => ['permission:diskusi_laporan_tp']], function () {
        Route::get('/laporanTpDiskusi/get/{id}', 'laporanTpDiskusiController@get');
        Route::post('/laporanTpDiskusi/store', 'laporanTpDiskusiController@store');
        Route::post('/laporanTpDiskusi/update/{id}', 'laporanTpDiskusiController@update');
        Route::delete('/laporanTpDiskusi/{id}', 'laporanTpDiskusiController@destroy');
    });
    Route::group(['middleware' => ['permission:index_laporan_tp']], function () {
        Route::post('/laporanTp/uploadExcel', 'laporanTpController@uploadExcel');
        Route::get('/laporanTp/indexDraft/{id}', 'laporanTpController@indexDraft');
        Route::get('/laporanTp/countDraft', 'laporanTpController@countDraft');
        Route::post('/laporanTp/storeDraftAll', 'laporanTpController@storeDraftAll');
    });

    //surat Keluar 
 
    Route::get('/surat/{id}','suratController@indexSurat');
    Route::get('/surat/create','suratController@create');
    Route::post('/surat/store','suratController@store');
    Route::post('/surat/update/{id}', 'suratController@update');
    Route::get('/surat/keluar/index','suratController@indexSuratKeluar');
    Route::get('/surat/keluar/trance','suratController@indexTranceSuratKeluar');
    Route::delete('/surat/keluar/destroy/{id}','suratController@destroySuratKeluarPermanent');
    Route::delete('/surat/keluar/softdestroy/{id}','suratController@softDestroySuratKeluar');
    Route::post('/surat/keluar/restore/{id}','suratController@restoreSuratKeluar');
    Route::get('/surat/keluar/lastid','suratController@getLastId');

    // surat Masuk
    Route::get ('/surat/masuk/index','suratController@indexSuratMasuk');
    Route::get ('/surat/masuk/trance','suratController@indexTranceSuratMasuk');
    Route::get('/surat/masuk/edit/{id}','suratController@getSuratMasuk');
    Route::post('/surat/masuk/store','suratController@storeSuratMasuk');
    Route::post('/surat/masuk/update/{id}','suratController@updateSuratMasuk');
    Route::delete('/surat/masuk/destroy/{id}','suratController@destroySuratMasukPermanent');
    Route::delete('/surat/masuk/softdestroy/{id}','suratController@softDestroySuratMasuk');
    Route::post('/surat/masuk/restore/{id}','suratController@restoreSuratMasuk');

    
    // surat_files pivot 
    Route::delete('/surat/pivot/{id}','suratController@destroyPivot');
    Route::post('/surat/getFiles/{id}','suratController@getFilesSurat');

    //files 
    Route::get('/files/index','FilesControllerp@index');
    Route::post('/files/store','FilesController@store');
    Route::delete('/files/{id}','FilesController@destroy');
    Route::delete('/files/draft/{id}','FilesController@destroyDraft');

    // puskopdit
    Route::get('/pus', 'PusController@index');
    Route::get('/pus_all', 'PusController@indexAll');
    Route::post('/pus/store', 'PusController@store');
    
    // tempat 
    Route::get('/tempat', 'TempatController@index');
    Route::get('/tempat/get/{id}', 'TempatController@get');
    Route::get('/tempat/create', 'TempatController@create');
    Route::get('/tempat/edit/{id}', 'TempatController@edit');
    Route::post('/tempat/store', 'TempatController@store');
    Route::post('/tempat/update/{id}', 'TempatController@update');
    Route::delete('/tempat/{id}', 'TempatController@destroy');

    //provinces
    Route::get('/provinces', 'ProvincesController@index');
    Route::get('/provinces/get', 'ProvincesController@get');
    Route::get('/provinces/create', 'ProvincesController@create');
    Route::get('/provinces/edit/{id}', 'ProvincesController@edit');
    Route::post('/provinces/store', 'ProvincesController@store');
    Route::post('/provinces/update/{id}', 'ProvincesController@update');
    Route::delete('/provinces/{id}', 'ProvincesController@destroy');

    //regencies
    Route::get('/regencies', 'RegenciesController@index');
    Route::get('/regencies/get', 'RegenciesController@get');
    Route::get('/regencies/indexProvinces/{id}', 'RegenciesController@indexProvinces');
    Route::get('/regencies/getProvinces/{id}', 'RegenciesController@getProvinces');
    Route::get('/regencies/create', 'RegenciesController@create');
    Route::get('/regencies/edit/{id}', 'RegenciesController@edit');
    Route::post('/regencies/store', 'RegenciesController@store');
    Route::post('/regencies/update/{id}', 'RegenciesController@update');
    Route::delete('/regencies/{id}', 'RegenciesController@destroy');

    //districts
    Route::get('/districts', 'DistrictsController@index');
    Route::get('/districts/get', 'DistrictsController@get');
    Route::get('/districts/indexRegencies/{id}', 'DistrictsController@indexRegencies');
    Route::get('/districts/getRegencies/{id}', 'DistrictsController@getRegencies');
    Route::get('/districts/create', 'DistrictsController@create');
    Route::get('/districts/edit/{id}', 'DistrictsController@edit');
    Route::post('/districts/store', 'DistrictsController@store');
    Route::post('/districts/update/{id}', 'DistrictsController@update');
    Route::delete('/districts/{id}', 'DistrictsController@destroy');

    //villages
    Route::get('/villages', 'VillagesController@index');
    Route::get('/villages/get', 'VillagesController@get');
    Route::get('/villages/indexDistricts/{id}', 'VillagesController@indexDistricts');
    Route::get('/villages/getDistricts/{id}', 'VillagesController@getDistricts');
    Route::get('/villages/create', 'VillagesController@create');
    Route::get('/villages/edit/{id}', 'VillagesController@edit');
    Route::post('/villages/store', 'VillagesController@store');
    Route::post('/villages/update/{id}', 'VillagesController@update');
    Route::delete('/villages/{id}', 'VillagesController@destroy');

    // file
    Route::get('download/{filename}','SystemController@download_file');

    // notification
    Route::get('/getNotif', 'SystemController@getNotif');
    Route::get('/getNotifAll', 'SystemController@getNotifAll');
    Route::get('/markNotifRead/{id}', 'SystemController@markNotifRead');
    Route::get('/markAllNotifRead', 'SystemController@markAllNotifRead');
});



