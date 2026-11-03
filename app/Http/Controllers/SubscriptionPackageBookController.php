<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionPackageBook;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPackageBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        // ambil semua book_id yang dikirim dari form (array), looping dan simpan ke tabel subscription_package_books
        $bookIds = $request->book_ids;
        foreach ($bookIds as $bookId) {
            SubscriptionPackageBook::create([
                'subscription_package_id' => $id,
                'book_id' => $bookId,
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke paket langganan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);
        if ($request->ajax()) {
            $books = Book::with('bookCategory');
            $addedBookIds = $subscriptionPackage->subscriptionPackageBook()
                ->pluck('book_id')
                ->all();

            return DataTables::of($books)
                ->addIndexColumn()
                ->editColumn('cover', function ($row) {
                    if ($row->cover) {
                        return '<img src="'.asset($row->cover).'" alt="'.e($row->title).'" class="img-thumbnail" style="max-height: 60px;">';
                    }

                    return '<span class="badge bg-secondary">No Cover</span>';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->bookCategory ? $row->bookCategory->name : '-';
                })
                ->addColumn('checkAdded', function ($row) use ($addedBookIds) {
                    // cek apakah book_id dari row ada dalam array subscriptionPackageBook, jika ada maka buku sudah tertaut dengan paket langganan ini (checkbox dihilangkan)
                    return in_array($row->id, $addedBookIds) ? 'Ya' : 'Tidak';
                })

                ->rawColumns(['cover'])
                ->make(true);
        }

        return view('admin.subscription-packages.books', compact('subscriptionPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPackageBook $subscriptionPackageBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPackageBook $subscriptionPackageBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPackageBook $subscriptionPackageBook)
    {
        //
    }
}
