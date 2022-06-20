<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrComposer
{
    public function compose(View $view)
    {
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = strval(strftime("%Y"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        $qr =  QrCode::size(100)->generate(url($refNo));

        // QrCode::format('png')->size(100)->generate(url($refNo));

        $view->with('qr', $qr);
    }
}
