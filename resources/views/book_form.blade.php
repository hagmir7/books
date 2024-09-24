<!-- resources/views/book_form.blade.php -->
<form action="{{ route('books.remove') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="slugs">Book Slugs (one per line):</label>
        <textarea name="slugs" id="slugs" rows="10" class="form-control"
            placeholder="Enter book slugs here, one per line..."></textarea>
    </div>
    <button type="submit" class="btn btn-danger">Remove Books</button>
</form>
