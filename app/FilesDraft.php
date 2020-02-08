<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilesDraft extends Model
{
    //
    protected $table = 'files_draft';
    protected static $logFillable = true;
}
