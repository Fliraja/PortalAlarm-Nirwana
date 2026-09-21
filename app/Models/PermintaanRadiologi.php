<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanRadiologi extends Model
{
    protected $connection = 'khanza';

    protected $table = 'permintaan_radiologi';

    protected $primaryKey = 'noorder';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
