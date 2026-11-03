<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = BookCategory::query();

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.book-categories.edit', $row->id);
                    $destroyUrl = route('admin.book-categories.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <form action="'.$destroyUrl.'" method="POST" class="d-inline">
                    '.$csrf.'
                    '.$method.'
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus Data
                    ini?\')">Hapus</button>
                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.book-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.book-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('book_categories', 'name')],
        ]);
        BookCategory::create($validateData);

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, BookCategory $category): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'in:price_asc,price_desc,newest'],
        ]);
        $query = trim($validated['q'] ?? '');
        $sort = $validated['sort'] ?? 'newest';

        [$sortColumn, $sortDirection] = match ($sort) {
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            default => ['created_at', 'desc'],
        };

        $books = $category->books()
            ->when($query !== '', function ($books) use ($query) {
                $books->where(function ($books) use ($query) {
                    $books->where('title', 'like', '%'.$query.'%')
                        ->orWhere('writer', 'like', '%'.$query.'%');
                });
            })
            ->orderBy($sortColumn, $sortDirection)
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('categories.show', compact('category', 'books', 'query', 'sort'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bookCategory = BookCategory::findorfail($id);

        return view('admin.book-categories.edit', compact('bookCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bookCategory = BookCategory::findOrFail($id);

        $validateData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('book_categories', 'name')->ignore($bookCategory->id),
            ],
        ]);
        $bookCategory->update($validateData);

        return redirect()->route('admin.book-categories.index')->with('success', 'kategori buku berhasil di ubah ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $bookCategory = BookCategory::findOrFail($id);
        $bookCategory->delete();

        return redirect()->route('admin.book-categories.index')->with('success', 'kategori buku berhasil di ubah ');
    }
}
