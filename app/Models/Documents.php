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
        'senderOffice_id',
        'receiverOffice_id',
        'docType',
        'updated_at',
        'createad_at',
        'email'
    ];

    // public function office()
    // {
    //     return $this->hasOne(Offices::class);
    // }

    // public function docType()
    // {
    //     return $this->belongsTo(DocumentType::class);
    // }
}
