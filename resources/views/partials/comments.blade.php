<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prevent Multiple Form Submit Example</title>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Bootsgrap CSS file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="multiple-form-submit-prevent.css">

    <!-- Bootstrap & jQuery file -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link to your Javascript file -->
    <script src="multiple-form-submit-prevent.js"></script>
</head>
<body>

<style>
.spinner{
    display: none;
}
.comment {
    width: 100%;
}
.comment span {
    float: left;
    margin-right: 8px;
    background: #ccc;
    border-radius: 100%;
}
.comment div {
    overflow: hidden;
}
.comment div input {
    width: 100%;
    border-radius: 30px;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    display: block
}

button{
    margin-top: 2px;
    border-radius: 3px;
    background-color: #04426E;
    color: white;
    pading: 2px;
}
</style>
<div class="comment">
    <form class="from-prevent-multiple-submits" action="{{ $data->referenceNo }}/comment" method="post">
        @csrf
        <input type="text" name="author" value="{{ Auth::user()->name }}" style="display: none;" required/>
        <?php
            $parts = explode(' ', Auth::user()->name);
            $initials = strtoupper($parts[0][0] . $parts[count($parts) - 1][0]);
        ?>
        <span class="bg-gray-300 p-3"><strong>{{ $initials }}</strong></span>
        <div><input placeholder="Write a comment..." name="text" class="mt-1 py-2 px-3 block w-100 border-gray-400 rounded shadow-sm" required></div>
        <button class="from-prevent-multiple-submits" type="submit"><i class="fas fa-spinner spinner"></i> Post Comment</button>
    </form>
</div>

<script type="text/javascript">
    (function(){
    $('.from-prevent-multiple-submits').on('submit', function(){
        $('.from-prevent-multiple-submits').attr('disabled','true');
        $('.spinner').show();
    })
    })();
</script>
</body>
</html>




