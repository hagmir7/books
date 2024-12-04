<!-- resources/views/book_form.blade.php -->
<form action="{{ route('books.remove') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="slugs">{{ __("Book Slugs (one per line)") }}:</label>
        <textarea name="slugs" id="slugs" rows="10" class="form-control"
            placeholder="{{ __("Enter book slugs here, one per line...") }}"></textarea>
    </div>
    <button type="submit" class="btn btn-danger">{{ __("Remove Books") }}</button>
</form>
