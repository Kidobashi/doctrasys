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
        @foreach ($data as $dat)
            <td>{{$dat->referenceNo}}</td>
            <td>{{$dat->senderName}}</td>
            <td>{{$dat->officeName}}</td>
        @endforeach
          </tr>
        </tbody>
      </table>
</body>
</html>
