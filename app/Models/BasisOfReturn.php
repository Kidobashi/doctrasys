<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasisOfReturn extends Model
{
    use HasFactory;

    protected $table='basis_of_returns';

    protected $fillable = [
        'lacking_doc_id',
        'others',
        'primary_reason_of_return',
        'referenceNumbers',
    ];

}
