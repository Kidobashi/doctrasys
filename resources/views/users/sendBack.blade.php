{{-- @extends('templates.user')
@section('content')
<style>
.container {
    position: relative;
        top: 120px;
        height: 100%;
}
</style>
<form action="send-back/{{ $doc->referenceNo }}" method="post">
    @csrf
    <div class="container col-lg-10">
    <label for=""></label>
        <div class="mb-3">
            <input class="form-control "type="text" style="display: none;" name='status' value="3">
        </div>
    <button type="submit">Confirm</button>
    </div>
</form>
@endsection
 --}}
