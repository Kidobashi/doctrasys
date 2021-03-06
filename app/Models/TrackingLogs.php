<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingLogs extends Model
{
    use HasFactory;

    protected $table='tracking_logs';

    protected $fillable = [
        'referenceNo',
        'senderName',
        'receiverName',
        'senderOffice',
        'receiverOffice',
        'action',
        'updated_at',
        'createad_at',
        'prevOffice',
        'prevReceiver',
        'officeName'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('tracking_id');
    }
}
