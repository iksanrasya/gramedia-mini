<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

// #[Table('book_categories')]
// properti di atas digunakan untuk menentukan nama tabel di database yang penamaannya tidak sesuai dengan konversi penamaan
// tabel di laravel (jamak). Namun, karena nama tabek book_categories sudah sesuai dengan konversi penamaan tabel di laravel,
// maka properti di atas tidak perlu digunakan.

#[Fillable(['name'])]

class BookCategory extends Model {
    // nama jamak (menggunakan akhiran s/es/ies) karena book_categories berperan sebagai many dalam relasi one to many,
    // sehingga nama fungsi menggunakan nama jamak (menggunakan akhiran s/es/ies).
    public function books(): HasMany {
        return $this->hasMany(Book::class, 'category_id');
    }
}
