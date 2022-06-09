@extends('templates.user')
@section('content')
<div>
    <div class="card card-body blur shadow-blur mx-4 mt-n6">
        <div class="row gx-4">
            <h1>Add Document</h1>
                <form method="POST" action="#">
                    @csrf
                    <!-- Name -->
                    <form role="form text-left" method="POST" action="/register">
                        @csrf
                        <label for="">Sender Name</label>
                        <div class="mb-3">
                        <input type="text" class="form-control" name="senderName" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->name }}"disabled>
                        @error('senderName')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                        </div>

                        <label for="">Receiver Name</label>
                        <div class="mb-3">
                        <input type="text" class="form-control" name="receiverName" id="name" aria-label="Name" aria-describedby="name">
                        @error('receiverName')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Sender Office</label>
                            <select class="form-control" id="assignedOffice" name="senderOffice">
                                <option value="" selected disabled>Select Office
                                    @foreach ($offices as $row)
                                    <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Receiver Office</label>
                            <select class="form-control" id="assignedOffice" name="receiverOffice">
                                <option value="" selected disabled>Select Office
                                    @foreach ($offices as $row)
                                    <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                <input id="genBtn" type="submit" value="Submit" onclick=alertMsg()>

                @if(session('message'))
                    <div class="alert alert-success">{{session('message')}}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
