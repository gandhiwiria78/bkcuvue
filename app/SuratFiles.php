<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuratFiles extends Model
{
    //
    protected $table = 'surat_files';
    protected static $logFillable = true;
    //

    public function hasSurat()
    {
        return $this->hasMany('App\Surat','id','id');
    }

    public function hasSuratmasuk()
    {
        return $this->hasMany('App\SuratMasuk','id','id');
    }
}
