<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanLab extends Model
{
    protected $connection = 'khanza';

    protected $table = 'permintaan_lab';

    protected $primaryKey = 'noorder';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
