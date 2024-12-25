<form action="{{ route('book.upload') }}"  method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="books_file">
    <input type="submit" value="submit">
</form>
