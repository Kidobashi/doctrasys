
@extends('templates.user')
@section('content')
<form action="forwarded/{{ $doc->referenceNo }}" method="post">
    @csrf
    <div class="col-lg-10 float-end">
    <label for="">Forward to:</label>
        <div class="mb-3">
            <input type="text" class="form-control" name="receiverName" id="name" value="{{ $doc->receiverName }}"aria-label="Name" aria-describedby="name">
            @error('receiverName')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Current Office Receiver</label>
            <input class="form-control" type="text" value="{{ $officeN->officeName }}" disabled>
            <label for="">Forward Office</label>
            <select class="form-control" id="assignedOffice" name="receiverOffice">
                <option value="" selected disabled>Select Office
                    @foreach ($offices as $row)
                    <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                </option>
                @endforeach
            </select>

            <input class="form-control "type="text" style="display: none;" name='action' value="2">
        </div>
    <button type="submit">Submit</button>
    </div>
</form>
@endsection
