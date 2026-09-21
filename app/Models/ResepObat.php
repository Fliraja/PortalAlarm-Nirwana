<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    protected $connection = 'khanza';

    protected $table = 'resep_obat';

    protected $primaryKey = 'no_resep';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}
