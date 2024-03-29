<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryReasonOfReturn extends Model
{
    use HasFactory;

    protected $table='primary_reason_of_returns';

    

    public function basisOfReturn()
    {
        return $this->belongsTo(BasisOfReturn::class);
    }
}
