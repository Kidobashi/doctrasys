<form action="forwarded/{{ $doc->referenceNo }}" method="post">
    @csrf
    <label for="">Forward to:</label>
        <div class="mb-3">
            <input type="text" class="form-control" name="receiverName" id="name" value="{{ $doc->receiverName }}"aria-label="Name" aria-describedby="name">
            @error('receiverName')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Sender Office</label>
            <input type="text" value="{{ $officeN->officeName }}" disabled> Current Office Receiver
            <select class="form-control" id="assignedOffice" name="receiverOffice">
                <option value="" selected disabled>Select Office
                    @foreach ($offices as $row)
                    <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                </option>
                @endforeach
            </select>
        </div>
    <button type="submit">Submit</button>
</form>
