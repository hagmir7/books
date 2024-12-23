<form action="{{ route('book.upload') }}" method="POST">
    @csrf
    <input type="file" name="books_file">
    <input type="submit" value="submit">
</form>
