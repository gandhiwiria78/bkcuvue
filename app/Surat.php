<?php

namespace App;

use illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity; 

class Surat extends Model
{
    use Dataviewer ,LogsActivity, SoftDeletes;

    // nama tabel yang ada di database
    protected $table = 'surat_keluar';
    protected $dates = ['deleted_at'];

    // Model tabel yang ada. 
    protected static $logFillable = true;

    // aturan untuk mengisi data
    public static $rules = [
       'no_surat' => 'required',
       'id_pengelola' => 'required',
       'kode'=> 'required',
       'perihal'=> 'required',
       'tujuan'=> 'required',
    ];

    public static $rulesBoking = [
        'no_surat' => 'required',
        'id_pengelola' => 'required',
     ];
    
    protected $fillable = [
        //tabel kolom yang bisa di isi
        'id_pengelola','jenis','no_surat','kode','tanggal','tujuan','perihal','status','jenis'
    ];

    protected $allowedFilters = [
       // tabel yang difilter
       'no_surat','kode','jenis','tanggal','tujuan','perihal','created_at','updated_at','status','jenis'
    ];

    protected $orderable = [
       // tabel yang bisa order
       'no_surat','kode','jenis','no_surat','tujuan','perihal','tanggal','created_at','updated_at','status'
    ];

    public static function initialize(){
        //ini adalah  data seting awal data 
        return [
            'id_pengelola'=>0,'no_surat'=>'','kode'=>'','tanggal'=>'','tujuan'=>'','perihal'=>'','status'=>0,'jenis'=>''
        ];
    }
    
    public function Pengelola()
    {
        //belongTo ke  id pengurus untuk mendapat nama jabatan
        return $this->belongsTo('App\Pengelola','id_pengelola','id');
    }


}
