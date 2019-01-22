<?php

namespace App\Http\Controllers;

use Auth;
use App\Cu;
use App\Tp;
use Response;
use App\Aktivis;
use App\ProdukCu;
use App\MitraOrang;
use App\MitraLembaga;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    
  public function download_file($filename)
  {
    $destinationPath = public_path() . "/files/";
    $file= $destinationPath . $filename;

    return Response::download($file);
  }

  public function countOrganisasi()
  {
    $user = Auth::user();

    $countCu = '';
    $countTp = '';
    $countProdukCu = '';
    $countAktivis = '';
    $countMitraOrang = '';
    $countMitraLembaga = '';

    if($user->can['index_cu']){
      $countCu = Cu::count();
    }
    if($user->can['index_tp']){
      if($user->id_cu == 0){
        $countTp = Tp::count();
      }else{
        $countTp = Tp::where('id_cu', $user->id_cu)->count();
      }
    }
    if($user->can['index_produk_cu']){
      if($user->id_cu == 0){
        $countProdukCu = ProdukCu::count();
      }else{
        $countProdukCu = ProdukCu::where('id_cu', $user->id_cu)->count();
      }
    }
    if($user->can['index_aktivis']){
      $id = $user->id_cu;
      
      if($user->id_cu == 0){
        $countAktivis = Aktivis::count();
      }else{
        $countAktivis = Aktivis::with('pekerjaan_aktif.cu')
        ->whereHas('pekerjaan', function($query) use ($id){
          $query->where('tipe','1')->where('id_tempat',$id)
          ->where(function($q){
            $q->where('selesai',null)->orWhere('selesai','>',date('Y-m-d'));
          });
        })->count();
      } 
    }
    if($user->can['index_mitra_orang']){
      $countMitraOrang = MitraOrang::count();
    }
    if($user->can['index_mitra_lembaga']){
      $countMitraLembaga = MitraLembaga::count();
    }

    return response()
			->json([
					'countCu' => $countCu,
					'countTp' => $countTp,
					'countProdukCu' => $countProdukCu,
					'countAktivis' => $countAktivis,
					'countMitraOrang' => $countMitraOrang,
					'countMitraLembaga' => $countMitraLembaga,
			]);
  }
  
}