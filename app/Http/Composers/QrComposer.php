<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrComposer
{
    public function compose(View $view)
    {
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        $stringVal = strval($number);

        $senderOffice = Auth::user()->assignedOffice;

        if($senderOffice < 10) {
            $extraZero = '0';
            $refNo = "$prefix$extraZero$senderOffice$stringVal";
        } else {
            $refNo = "$prefix$senderOffice$stringVal";
        }

        $view->with('refNo', $refNo);
    }

}
