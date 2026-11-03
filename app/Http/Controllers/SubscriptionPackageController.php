<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = SubscriptionPackage::query();

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.subscription-packages.edit', $row->id);
                    $destroyUrl = route('admin.subscription-packages.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    $books = route('admin.subscription-packages-books', $row->id);

                    return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <form action="'.$destroyUrl.'" method="POST" class="d-inline">
                    '.$csrf.'
                    '.$method.'
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus Data
                    ini?\')">Hapus</button>
                    </form>
                    <a href="'.$books.'" class="btn btn-sm btn-info">Books</a>
                ';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.subscription-packages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name_package' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'color' => ['required', 'regex:/\A#[0-9A-Fa-f]{6}\z/'],
            'description' => ['nullable', 'string'],
        ]);

        SubscriptionPackage::create([
            'name_package' => $request->name_package,
            'price' => $request->price,
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SubscriptionPackage $subscriptionPackage): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
        ]);
        $query = trim($validated['q'] ?? '');

        $packageBooks = $subscriptionPackage->subscriptionPackageBook()
            ->with('book')
            ->when($query !== '', function ($packageBooks) use ($query) {
                $packageBooks->whereHas('book', function ($books) use ($query) {
                    $books->where('title', 'like', '%'.$query.'%');
                });
            })
            ->get();

        return view('subscription-packages.show', compact('subscriptionPackage', 'packageBooks', 'query'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        return view('admin.subscription-packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_package' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'color' => ['required', 'regex:/\A#[0-9A-Fa-f]{6}\z/'],
            'description' => ['nullable', 'string'],
        ]);

        $package = SubscriptionPackage::findOrFail($id);

        $package->update([
            'name_package' => $request->name_package,
            'price' => $request->price,
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $package = SubscriptionPackage::findOrFail($id);

        $package->delete();

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
