<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    use HasFactory;

    protected $table='offices';

    protected $fillable = [
        'id',
        'senderOffice',
        'receiverOffice',
        'officeName',
    ];

    public function documents()
    {
        return $this->hasMany('App\Models\Documents', 'office_id');
    }

    public function sentTrackingHistories()
    {
        return $this->hasMany(TrackingHistory::class, 'senderOffice');
    }

    public function receivedTrackingHistories()
    {
        return $this->hasMany(TrackingHistory::class, 'receiverOffice');
    }
}
