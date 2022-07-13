<h2>Comments</h2>

<div class="justify-content-center">
    {{-- <form action="{{ $data->referenceNo }}/comment" method="post"> --}}
        @csrf
        <label for="author" class="text-sm font-medium text-gray-700">Author</label>
        <input type="text" name="author" class="mt-1 py-2 px-3 block w-100 border-gray-400 rounded shadow" required/>
        <label for="author" class="mt-2 text-sm font-medium text-gray-700">Comment</label>
        <textarea name="text" class="mt-1 py-2 px-3 block w-100 border-gray-400 rounded shadow-sm" required></textarea>
        <button type="submit">Post Comment</button>
    </form>
</div>


