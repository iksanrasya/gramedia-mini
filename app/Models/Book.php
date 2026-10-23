<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['cover', 'title', 'price', 'description', 'language', 'publisher', 'writer',
    'release_date', 'page_of_book', 'category_id', 'book_category_id'])]

class Book extends Model
{
    // nama tunggal karena book_categories berperan sebagai one dalam relasi one to many, sehingga nama fungsi menggunakan
    // nama tunggal (tanpa akhiran s/es/ies).
    public function bookCategory(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class, 'category_id');
    }

    public function bookOrders(): HasMany
    {
        return $this->hasMany(CheckoutBook::class);
    }

    public function bookReviews(): HasMany
    {
        return $this->hasMany(SubscriptionPackageBook::class);
    }
}
