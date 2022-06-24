<form action="forwarded/{{ $doc->referenceNo }}" method="post">
    @csrf
    <label for="">Forward to:</label>
        <div class="mb-3">
            <input type="text" class="form-control" name="receiverName" id="name" value="{{ $doc->receiverName }}"aria-label="Name" aria-describedby="name">
            @error('receiverName')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>
    <button type="submit">Submit</button>
</form>
