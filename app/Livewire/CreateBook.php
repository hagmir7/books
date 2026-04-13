<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBook extends Component
{
    use WithFileUploads;

    // Book fields
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|image|max:2048')]
    public $image;

    #[Validate('required|string|max:500')]
    public string $description = '';

    #[Validate('required|string')]
    public string $body = '';

    #[Validate('required|file|mimes:pdf|max:51200')]
    public $file;

    #[Validate('required|string|max:20')]
    public string $isbn = '';

    // Author fields
    public string $authorSearch = '';
    public ?int $author_id = null;
    public string $selectedAuthorName = '';
    public array $authorResults = [];
    public bool $showAuthorDropdown = false;

    // Category fields
    public string $categorySearch = '';
    public ?int $book_category_id = null;
    public string $selectedCategoryName = '';
    public array $categoryResults = [];
    public bool $showCategoryDropdown = false;

    // PDF info
    public ?int $pdfPages = null;
    public ?string $pdfSize = null;

    // UI state
    public bool $saving = false;

    public function updatedAuthorSearch(): void
    {
        $this->author_id = null;
        $this->selectedAuthorName = '';

        if (strlen($this->authorSearch) >= 2) {
            $this->authorResults = Author::where('full_name', 'like', '%' . $this->authorSearch . '%')
                ->limit(10)
                ->get()
                ->map(fn($a) => ['id' => $a->id, 'name' => $a->full_name])
                ->toArray();
            $this->showAuthorDropdown = true;
        } else {
            $this->authorResults = [];
            $this->showAuthorDropdown = false;
        }
    }

    public function selectAuthor(int $id, string $name): void
    {
        $this->author_id = $id;
        $this->selectedAuthorName = $name;
        $this->authorSearch = $name;
        $this->showAuthorDropdown = false;
        $this->authorResults = [];
    }

    public function clearAuthor(): void
    {
        $this->author_id = null;
        $this->selectedAuthorName = '';
        $this->authorSearch = '';
        $this->showAuthorDropdown = false;
        $this->authorResults = [];
    }

    public function updatedCategorySearch(): void
    {
        $this->book_category_id = null;
        $this->selectedCategoryName = '';

        if (strlen($this->categorySearch) >= 2) {
            $this->categoryResults = BookCategory::where('name', 'like', '%' . $this->categorySearch . '%')
                ->limit(10)
                ->get()
                ->map(fn($c) => ['id' => $c->id, 'name' => $c->name])
                ->toArray();
            $this->showCategoryDropdown = true;
        } else {
            $this->categoryResults = [];
            $this->showCategoryDropdown = false;
        }
    }

    public function selectCategory(int $id, string $name): void
    {
        $this->book_category_id = $id;
        $this->selectedCategoryName = $name;
        $this->categorySearch = $name;
        $this->showCategoryDropdown = false;
        $this->categoryResults = [];
    }

    public function clearCategory(): void
    {
        $this->book_category_id = null;
        $this->selectedCategoryName = '';
        $this->categorySearch = '';
        $this->showCategoryDropdown = false;
        $this->categoryResults = [];
    }

    public function updatedFile(): void
    {
        $this->validateOnly('file');
        $this->extractPdfInfo();
    }

    private function extractPdfInfo(): void
    {
        if (!$this->file) {
            return;
        }

        $path = $this->file->getRealPath();

        // Get file size formatted
        $bytes = filesize($path);
        if ($bytes >= 1048576) {
            $this->pdfSize = round($bytes / 1048576, 2) . ' MB';
        } else {
            $this->pdfSize = round($bytes / 1024, 2) . ' KB';
        }

        // Get page count from PDF
        $this->pdfPages = $this->getPdfPageCount($path);
    }

    private function getPdfPageCount(string $path): ?int
    {
        try {
            $content = file_get_contents($path);

            // Method 1: FPDI if available
            if (class_exists(\setasign\Fpdi\Fpdi::class)) {
                $pdf = new \setasign\Fpdi\Fpdi();
                return $pdf->setSourceFile($path);
            }

            // Method 2: Smalot PDF Parser if available
            if (class_exists(\Smalot\PdfParser\Parser::class)) {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($path);
                return count($pdf->getPages());
            }

            // Method 3: Regex fallback — count /Type /Page (not /Pages)
            preg_match_all('/\/Type\s*\/Page[^s]/i', $content, $matches);
            $count = count($matches[0]);

            if ($count === 0) {
                // Alternative regex
                preg_match('/\/N\s+(\d+)/', $content, $nMatches);
                if (!empty($nMatches[1])) {
                    return (int) $nMatches[1];
                }
            }

            return $count > 0 ? $count : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function resolveAuthorId(): int
    {
        if ($this->author_id) {
            return $this->author_id;
        }

        $name = trim($this->authorSearch);

        if (empty($name)) {
            $this->addError('authorSearch', 'Author is required.');
            throw new \Exception('Author is required.');
        }

        // Create new author
        $author = Author::create([
            'full_name' => $name,
            'slug' => Str::slug($name),
        ]);

        return $author->id;
    }

    private function resolveCategoryId(): int
    {
        if ($this->book_category_id) {
            return $this->book_category_id;
        }

        $name = trim($this->categorySearch);

        if (empty($name)) {
            $this->addError('categorySearch', 'Category is required.');
            throw new \Exception('Category is required.');
        }

        // Create new category
        $category = BookCategory::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);

        return $category->id;
    }

    public function save(): void
    {
        $this->validate();

        if (empty($this->authorSearch)) {
            $this->addError('authorSearch', 'Author is required.');
            return;
        }

        if (empty($this->categorySearch)) {
            $this->addError('categorySearch', 'Category is required.');
            return;
        }

        $this->saving = true;

        try {
            $authorId = $this->resolveAuthorId();
            $categoryId = $this->resolveCategoryId();

            // Store files
            $imagePath = $this->image?->store('books/images', 'public');
            $filePath = $this->file->store('books/files', 'public');

            Book::create([
                'name'             => $this->name,
                'title'            => $this->name,
                'slug'             => Str::slug($this->name),
                'user_id'          => auth()->id(),
                'author_id'        => $authorId,
                'book_category_id' => $categoryId,
                'language_id'      => app('site')->language_id,
                'site_id'          => app('site')->id,
                'image'            => $imagePath,
                'description'      => $this->description,
                'body'             => $this->body,
                'file'             => $filePath,
                'isbn'             => $this->isbn,
                'pages'            => $this->pdfPages,
                'size'             => $this->pdfSize,
                'is_public'        => false,
                'verified'         => true,
            ]);

            session()->flash('success', 'Book created successfully!');
            $this->redirect(route('books.index'));
        } catch (\Exception $e) {
            $this->saving = false;
            if (!$this->getErrorBag()->has('authorSearch') && !$this->getErrorBag()->has('categorySearch')) {
                session()->flash('error', 'Failed to create book: ' . $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.create-book');
    }
}
