<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrComposer
{
    public function compose(View $view)
    {
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        $qr = QrCode::format('png')->size('200')->merge('../public/images/cmulogo.png')->generate(url('qrinfo/'.$refNo));
        $qr = base64_encode($qr);

        $view->with('qr', $qr)->with('refNo', $refNo);
    }
}
