<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $table='documents';

    protected $fillable = [
        'id',
        'referenceNo',
        'senderName',
        'receiverName',
        'senderOffice',
        'receiverOffice',
        'updated_at',
        'createad_at'
    ];
}
