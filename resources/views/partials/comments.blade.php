<h2>Comments</h2>
<style>
    .comment{
        height:
    }
</style>
<div class="comment justify-content-center">
    <form action="{{ $data->referenceNo }}/comment" method="post">
        @csrf
        <input type="text" name="author" value="{{ Auth::user()->name }}" class="mt-1 py-2 px-3 block w-100 border-gray-400 rounded shadow" style="display: none;" required/>
        <label for="author" class="mt-2 text-sm font-medium text-gray-700">Comment</label>
        <textarea name="text" class="mt-1 py-2 px-3 block w-100 border-gray-400 rounded shadow-sm" required></textarea>
        <button type="submit">Post Comment</button>
    </form>
</div>


