<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    use HasFactory;

    protected $table='offices';

    public function documents()
    {
        return $this->hasMany('App\Models\Document', 'office_id');
    }
}
