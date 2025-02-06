<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    use HasFactory;

    protected $connection = 'office';

    protected $table = 'rapats';

    protected $dates = [
        'tanggal_rapat',
    ];

    protected $primaryKey = 'Unit';
}
