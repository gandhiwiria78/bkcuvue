<?php

namespace App;

use illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity; 
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
  
    use Dataviewer ,LogsActivity, SoftDeletes;

    // nama tabel yang ada di database
    protected $table = 'surat_masuk';
    protected $dates = ['deleted_at'];

    // Model tabel yang ada.
    protected static $logFillable = true;

    // aturan untuk mengisi data
    public static $rules = [
        'kode'=> 'required',
        'perihal'=> 'required',
        'tujuan'=> 'required',
        'pengirim'=>'required',
        'penerima'=>'required',
        'terima_melalui'=>'required'
     ];

     protected $fillable = [
         // tabel kolom yang bisa di isi
         'kode','tujuan','perihal','status','pengirim','penerima','terima_melalui'
     ];
 
     protected $allowedFilters = [
        // tabel yang difilter
        'kode','jenis','tujuan','perihal','created_at','updated_at','status','pengirim','penerima','keterangan','terima_melalui'
     ];
 
     protected $orderable = [
        // tabel yang bisa order
       'kode','tujuan','perihal','created_at','updated_at','status','pengirim','penerima','terima_melalui'
     ];

     public static function initialize(){
         // ini adalah  data seting awal data
         return [
            'kode'=>'','tujuan'=>'','perihal'=>'','status'=>'','pengirim'=>'','penerima'=>'','keterangan'=>''
         ];
     }
     
     public static function files(){
         
     }
}
