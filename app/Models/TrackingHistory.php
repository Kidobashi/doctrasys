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
        'prev_receiver',
        'prev_Sender',
        'updated_at',
        'createad_at',
    ];
}
