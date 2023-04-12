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
        'user_id',
        'senderOffice_id',
        'receiverOffice_id',
        'docType',
        'updated_at',
        'createad_at',
        'email'
    ];

    public function senderOffice()
    {
        return $this->belongsTo(Offices::class,  'senderOffice_id');
    }

    public function receiverOffice()
    {
        return $this->belongsTo(Offices::class,  'receiverOffice_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class,  'docType');
    }


    // public function office()
    // {
    //     return $this->hasOne(Offices::class);
    // }

    // public function docType()
    // {
    //     return $this->belongsTo(DocumentType::class);
    // }
}
