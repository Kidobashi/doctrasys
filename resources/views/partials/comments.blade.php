<style>

.spinner{
    display: block;
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
    padding: 2px;
}
</style>
<div class="comment">
    @guest
        <div class="m-3 justify-content-center">
            <a href="{{ url('/login')}}">Sign in to add comment</a>
        </div>
    @endguest
    @auth
    <form class="from-prevent-multiple-submits" action="{{ $data->referenceNo }}/comment" method="post">
        @csrf
        <input type="text" name="author" value="{{ Auth::user()->name }}" style="display: none;" required/>
        <?php
            $parts = explode(' ', Auth::user()->name);
            $initials = strtoupper($parts[0][0] . $parts[count($parts) - 1][0]);
        ?>
        <span class="bg-gray-300 p-3"><strong>{{ $initials }}</strong></span>
        <div><input placeholder="Write a comment..." name="text" class="mt-1 py-2 px-3 block w-100 border-gray-400 rounded shadow-sm" required></div>
        <button class="from-prevent-multiple-submits" type="submit">Post Comment</button>
    </form>
    @endauth
</div>

<script type="text/javascript">
    (function(){
    $('.from-prevent-multiple-submits').on('submit', function(){
        $('.from-prevent-multiple-submits').attr('disabled','true');
        $('.spinner').show();
    })
    })();
</script>





