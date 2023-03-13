<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    use HasFactory;

    protected $table='tracking_histories';

    protected $fillable = [
        'id',
        'referenceNo',
        'senderOffice',
        'receiverOffice',
        'status',
        'actions',
        'officeName',
        'updated_at',
        'createad_at',
    ];

    public function senderOffice()
    {
        return $this->belongsTo(Offices::class, 'senderOffice');
    }

    public function receiverOffice()
    {
        return $this->belongsTo(Offices::class, 'receiverOffice');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Documents');
    }
}
