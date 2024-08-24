<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function cleanUpFiles()
    {
        $filesInDatabase = DB::table('books')->pluck('file')->toArray();

        $filesInStorage = array_map('basename', Storage::disk('public')->files('book_files'));

        $fileFullPath = [];
        foreach($filesInStorage as $file){
            array_push($fileFullPath, 'book_files/' . $file);
        }

        $filesToDelete = array_diff($fileFullPath, $filesInDatabase);

        foreach ($filesToDelete as $file) {
            Storage::disk('public')->delete($file);
        }

        return redirect('/')->with('status', 'Cleanup complete. Removed ' . count($filesToDelete) . ' files.');
    }

    public function cleanUpImages()
    {
        $filesInDatabase = DB::table('books')->pluck('image')->toArray();

        $filesInStorage = array_map('basename', Storage::disk('public')->files('book_images'));

        $fileFullPath = [];
        foreach ($filesInStorage as $file) {
            array_push($fileFullPath, 'book_images/' . $file);
        }

        $filesToDelete = array_diff($fileFullPath, $filesInDatabase);

        foreach ($filesToDelete as $file) {
            Storage::disk('public')->delete($file);
        }

        return redirect('/')->with('status', 'Cleanup complete. Removed ' . count($filesToDelete) . ' files.');
    }
}
