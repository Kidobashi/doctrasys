
<?
    $last = DB::table('documents')->latest('id')->first();

    $identity = $last->id + 1;
    $number = sprintf('%04d', $identity);
    $prefix = strval(strftime("%Y"));
    $stringVal = strval($number);
    $refNo = "$prefix$stringVal";

    $rq = QrCode::size(100)->generate(url($refNo));
?>
<h1>HIIII from partials qrcode</h1>
{{ $rq }}
