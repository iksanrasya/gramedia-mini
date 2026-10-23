<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Book::with('bookCategory');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function ($data) {
                    return '<img src="'.e($data->cover).'" width="100" class="s-block ms-auto" />';
                })
                ->editColumn('price', function ($data) {
                    return 'Rp '.number_format($data->price, 0, ',', '.');
                })
                ->addColumn('category_name', function ($data) {
                    return $data->bookCategory ? $data->bookCategory->name : '';
                })
                ->addColumn('action', function ($data) {
                    $btnDetail = '
                        <button type="button" class="btn btn-info btn-sm btn-detail" id="btn-detail"
                            data-cover="'.e(asset($data->cover)).'"
                            data-title="'.e($data->title).'"
                            data-category="'.e($data->bookCategory?->name ?? '').'"
                            data-price="'.e($data->price).'"
                            data-writer="'.e($data->writer).'"
                            data-publisher="'.e($data->publisher).'"
                            data-language="'.e($data->language).'"
                            data-page-of-book="'.e($data->page_of_book).'"
                            data-release-date="'.e(date('d M Y', strtotime($data->release_date))).'"
                            data-description="' .htmlspecialchars($data->description ?? '').'"
                        >Detail</button>';

                    $btnEdit = '<a href="'.route('admin.books.edit', $data->id).'" class="btn btn-primary"><i class="bi bi-pencil"></i>Edit</a>';
                    $btnDelete = '<form method="POST" action="'.route('admin.books.destroy', $data->id).'">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger"> Hapus </button>'.'</form>';

                    return '<div class="d-flex gap-2">'.$btnEdit.$btnDelete.$btnDetail.'</div>';
                })
                ->rawColumns(['coverImg', 'action'])
                ->toJson();
        }

        return view('admin.books.index');
    }

    public function create()
    {
        $bookCategories = BookCategory::all();

        return view('admin.books.create', compact('bookCategories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'category_id' => $request->input('category_id', $request->input('book_category_id')),
        ]);

        $validatedData = $request->validate([
            // mimes : menentukan jenis file yang boleh diupload
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => ['required', 'string', 'min:3'],
            'writer' => ['required', 'string', 'min:3'],
            'publisher' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'numeric'],
            'language' => ['required'],
            'category_id' => ['required', 'exists:book_categories,id'],
            'description' => ['nullable'], // boleh kosong, karena quilljs bisa menghasilkan string kosong
        ]);

        // proses penyiapan file
        if ($request->file('cover')) {
            $cover = $request->file('cover'); // ambil file gambar
            // rename nama gambar
            $name = time().'-'.$cover->getClientOriginalName();
            // simpan gambar ke folder storage/app/public/covers
            // putFiles('nama_folder', filenya, 'nama_file')
            Storage::disk('public')->putFileAs('covers', $cover, $name);
            // simpan alamat penyiampanan gambar ke data validasi diatas untuk dikirim ke db
            $validatedData['cover'] = Storage::url('covers/'.$name);
        }
        // simpan data ke database
        Book::create($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'berhasil membuat data buku baru');
    }

    public function show(Book $book)
    {
        //
    }

    public function edit(Book $book)
    {
        $bookCategory = Bookcategory::all();
        return view('admin.books.edit', compact('book','bookCategory'));
    }

    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Ubah menjadi nullable
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'language' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'writer' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'integer'],
            'category_id' => ['required', 'exists:book_categories,id'],
        ]);
 
        // Handle file upload jika ada gambar sampul baru yang diunggah
        if ($request->hasFile('cover')) {
            // 1. Hapus cover lama dari storage jika ada
            if ($book->cover) {
                // Ambil nama file asli dari URL (contoh: "/storage/covers/123_file.jpg" -> "covers/123_file.jpg")
                $oldImagePath = str_replace('/storage/', '', $book->cover);
 
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
 
            // 2. Simpan cover baru
            $coverImage = $request->file('cover');
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
 
            Storage::disk('public')->putFileAs('covers', $coverImage, $coverImageName);
 
            // 3. Set path URL cover baru ke array data yang divalidasi
            $validatedData['cover'] = Storage::url('covers/' . $coverImageName);
        }
 
        // Update data buku
        $book->update($validatedData);
 
        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
 
    }

    public function destroy(Book $book)
    {
        //
    }
}
