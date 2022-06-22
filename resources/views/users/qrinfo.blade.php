<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Reference No.</th>
            <th scope="col">Sender</th>
            <th scope="col">From Office</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$data->referenceNo}}</td>
            <td>{{$data->senderName}}</td>
            <td>{{$data->officeName}}</td>
          </tr>
        </tbody>
      </table>
      <img src="{{ asset('qrcodes/qr'.$data->referenceNo.'.png') }}" alt="tag">
      <form action="">
          <Label>Options</Label>
          <a href="">Forward</a>
          <a href="">Receive</a>
      </form>
</body>
</html>
