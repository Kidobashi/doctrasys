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
                        <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Name" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Sender Office</label>
                            <select class="form-control" id="assignedOffice" name="assignedOffice">
                                <option value="" selected disabled>Select Office
                                    @foreach ($offices as $row)
                                    <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Receiver Office</label>
                            <select class="form-control" id="assignedOffice" name="assignedOffice">
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
