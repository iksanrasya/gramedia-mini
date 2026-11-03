<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Checkout;
use App\Models\CheckoutBook;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApplicationBehaviorTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_seeder_creates_an_admin_and_can_be_repeated(): void
    {
        $this->seed(AdminSeeder::class);
        $this->seed(AdminSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);
    }

    public function test_registration_creates_a_non_admin_user_with_a_hashed_password(): void
    {
        $this->post(route('register.store'), [
            'name' => 'New Reader',
            'email' => 'reader@example.com',
            'password' => 'secret123',
        ])->assertRedirect(route('login'));

        $user = User::where('email', 'reader@example.com')->firstOrFail();

        $this->assertSame('user', $user->role);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_logout_clears_the_authenticated_session(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_category_can_be_created_and_duplicate_names_are_rejected(): void
    {
        $this->actingAs($this->admin());

        $this->post(route('admin.book-categories.store'), ['name' => 'Fiksi'])
            ->assertRedirect(route('admin.book-categories.index'));

        $this->from(route('admin.book-categories.create'))
            ->post(route('admin.book-categories.store'), ['name' => 'Fiksi'])
            ->assertRedirect(route('admin.book-categories.create'))
            ->assertSessionHasErrors('name');
    }

    public function test_guest_can_open_a_category_and_only_see_its_books(): void
    {
        $category = BookCategory::create(['name' => 'Fiksi']);
        $otherCategory = BookCategory::create(['name' => 'Sejarah']);
        Book::create([
            'cover' => 'fiction.jpg',
            'title' => 'Novel Fiksi',
            'price' => 50000,
            'language' => 'id',
            'publisher' => 'Penerbit',
            'writer' => 'Penulis',
            'release_date' => '2026-01-01',
            'page_of_book' => 100,
            'category_id' => $category->id,
        ]);
        Book::create([
            'cover' => 'history.jpg',
            'title' => 'Buku Sejarah',
            'price' => 50000,
            'language' => 'id',
            'publisher' => 'Penerbit',
            'writer' => 'Sejarawan',
            'release_date' => '2026-01-01',
            'page_of_book' => 100,
            'category_id' => $otherCategory->id,
        ]);

        $this->get(route('categories.show', $category))
            ->assertOk()
            ->assertViewIs('categories.show')
            ->assertSee('Novel Fiksi')
            ->assertDontSee('Buku Sejarah');
    }

    public function test_homepage_shows_only_the_three_newest_subscription_packages_with_database_values(): void
    {
        $packages = [
            ['name_package' => 'Paket Terlama', 'description' => 'Deskripsi lama', 'color' => '#111111', 'price' => 10000, 'created_at' => '2026-01-01 00:00:00'],
            ['name_package' => 'Paket Terbaru 3', 'description' => 'Deskripsi tiga', 'color' => '#333333', 'price' => 30000, 'created_at' => '2026-02-01 00:00:00'],
            ['name_package' => 'Paket Terbaru 2', 'description' => 'Deskripsi dua', 'color' => '#222222', 'price' => 20000, 'created_at' => '2026-03-01 00:00:00'],
            ['name_package' => 'Paket Terbaru 1', 'description' => 'Deskripsi satu', 'color' => '#abcdef', 'price' => 40000, 'created_at' => '2026-04-01 00:00:00'],
        ];

        foreach ($packages as $packageData) {
            $createdAt = $packageData['created_at'];
            unset($packageData['created_at']);

            SubscriptionPackage::create($packageData)
                ->forceFill(['created_at' => $createdAt])
                ->save();
        }

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder(['Paket Terbaru 1', 'Paket Terbaru 2', 'Paket Terbaru 3'], false)
            ->assertDontSee('Paket Terlama')
            ->assertSee('Deskripsi satu')
            ->assertSee('Rp 40.000')
            ->assertSee('style="background-color: #abcdef;"', false);
    }

    public function test_category_search_matches_book_title_or_writer_only_in_the_selected_category(): void
    {
        $category = BookCategory::create(['name' => 'Fiksi']);
        $otherCategory = BookCategory::create(['name' => 'Sejarah']);
        $this->createBookInCategory($category, 'Target Novel', 'Penulis biasa', 50000, '2026-01-01 00:00:00');
        $this->createBookInCategory($category, 'Karya biasa', 'Target Writer', 30000, '2026-02-01 00:00:00');
        $this->createBookInCategory($category, 'Buku lain', 'Penulis lain', 20000, '2026-03-01 00:00:00');
        $this->createBookInCategory($otherCategory, 'Target Sejarah', 'Penulis luar', 10000, '2026-04-01 00:00:00');

        $this->get(route('categories.show', ['category' => $category, 'q' => 'Target']))
            ->assertOk()
            ->assertSee('Kategori: "Fiksi"', false)
            ->assertSee('Target Novel')
            ->assertSee('Target Writer')
            ->assertDontSee('Buku lain')
            ->assertDontSee('Target Sejarah');
    }

    public function test_category_books_can_be_sorted_by_price_or_creation_date(): void
    {
        $category = BookCategory::create(['name' => 'Fiksi']);
        $this->createBookInCategory($category, 'Buku Termurah', 'Penulis A', 10000, '2026-01-01 00:00:00');
        $this->createBookInCategory($category, 'Buku Tengah', 'Penulis B', 20000, '2026-02-01 00:00:00');
        $this->createBookInCategory($category, 'Buku Termahal', 'Penulis C', 30000, '2026-03-01 00:00:00');

        $this->get(route('categories.show', ['category' => $category, 'sort' => 'price_asc']))
            ->assertOk()
            ->assertSeeInOrder(['Buku Termurah', 'Buku Tengah', 'Buku Termahal']);

        $this->get(route('categories.show', ['category' => $category, 'sort' => 'price_desc']))
            ->assertOk()
            ->assertSeeInOrder(['Buku Termahal', 'Buku Tengah', 'Buku Termurah']);

        $this->get(route('categories.show', ['category' => $category, 'sort' => 'newest']))
            ->assertOk()
            ->assertSeeInOrder(['Buku Termahal', 'Buku Tengah', 'Buku Termurah']);
    }

    public function test_category_books_reject_unknown_sort_options(): void
    {
        $category = BookCategory::create(['name' => 'Fiksi']);

        $this->from(route('categories.show', $category))
            ->get(route('categories.show', ['category' => $category, 'sort' => 'title asc']))
            ->assertRedirect(route('categories.show', $category))
            ->assertSessionHasErrors('sort');
    }

    public function test_category_update_allows_its_current_name_but_rejects_another_category_name(): void
    {
        $this->actingAs($this->admin());

        $category = BookCategory::create(['name' => 'Fiksi']);
        $otherCategory = BookCategory::create(['name' => 'Sejarah']);

        $this->put(route('admin.book-categories.update', $category), ['name' => 'Fiksi'])
            ->assertRedirect(route('admin.book-categories.index'));

        $this->from(route('admin.book-categories.edit', $otherCategory))
            ->put(route('admin.book-categories.update', $otherCategory), ['name' => 'Fiksi'])
            ->assertRedirect(route('admin.book-categories.edit', $otherCategory))
            ->assertSessionHasErrors('name');
    }

    public function test_subscription_package_can_be_created_without_a_description(): void
    {
        $this->actingAs($this->admin());

        $this->post(route('admin.subscription-packages.store'), [
            'name_package' => 'Fiction',
            'price' => 49000,
            'color' => '#aabbcc',
        ])->assertRedirect(route('admin.subscription-packages.index'));

        $this->assertDatabaseHas('subscription_packages', [
            'name_package' => 'Fiction',
            'description' => null,
        ]);
    }

    public function test_subscription_package_table_returns_the_column_names_used_by_the_view(): void
    {
        $this->actingAs($this->admin());
        SubscriptionPackage::create([
            'name_package' => 'Fiction',
            'price' => 49000,
            'color' => '#aabbcc',
            'description' => 'Fiction books',
        ]);

        $this->get(route('admin.subscription-packages.index'), [
            'X-Requested-With' => 'XMLHttpRequest',
        ])->assertOk()
            ->assertJsonPath('data.0.name_package', 'Fiction')
            ->assertJsonPath('data.0.price', 49000)
            ->assertJsonPath('data.0.description', 'Fiction books');
    }

    public function test_book_table_includes_escaped_details_for_the_modal(): void
    {
        $this->actingAs($this->admin());
        $category = BookCategory::create(['name' => 'Fiksi']);
        Book::create([
            'cover' => 'cover.jpg" onerror="alert(\'xss\')',
            'title' => 'Novel "Besar"',
            'price' => 50000,
            'description' => '<script>alert("xss")</script>',
            'language' => 'id',
            'publisher' => 'Penerbit',
            'writer' => 'Penulis',
            'release_date' => '2026-01-01',
            'page_of_book' => 100,
            'category_id' => $category->id,
        ]);

        $this->get(route('admin.books.index'))
            ->assertOk()
            ->assertSee("btn.attr('data-page-of-book')", false)
            ->assertSee("btn.attr('data-release-date')", false);

        $response = $this->get(route('admin.books.index'), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();
        $action = $response->json('data.0.action');
        $coverImage = $response->json('data.0.coverImg');
        $this->assertStringContainsString('data-title="Novel &quot;Besar&quot;"', $action);
        $this->assertStringContainsString('data-page-of-book="100"', $action);
        $this->assertStringContainsString('data-release-date="01 Jan 2026"', $action);
        $this->assertStringContainsString('data-description="&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;"', $action);
        $this->assertStringNotContainsString('<script>alert("xss")</script>', $action);
        $this->assertStringContainsString('src="cover.jpg&quot; onerror=&quot;alert(&#039;xss&#039;)"', $coverImage);
        $this->assertStringNotContainsString('onerror="alert(\'xss\')"', $coverImage);
    }

    public function test_active_subscription_uses_the_expiry_date_on_the_join_table(): void
    {
        $user = User::factory()->create();
        $package = SubscriptionPackage::create([
            'name_package' => 'Fiction',
            'price' => 49000,
            'color' => '#aabbcc',
        ]);

        $user->subscriptions()->attach($package, [
            'expired_date' => now()->toDateString(),
        ]);

        $this->assertTrue($user->fresh()->activeSubscription()->is($package));
        $this->assertTrue($user->fresh()->isSubscribed());
    }

    public function test_book_and_checkout_models_use_their_migration_foreign_keys(): void
    {
        $user = User::factory()->create();
        $category = BookCategory::create(['name' => 'Fiksi']);
        $book = Book::create([
            'cover' => 'cover.jpg',
            'title' => 'Novel',
            'price' => 50000,
            'language' => 'id',
            'publisher' => 'Penerbit',
            'writer' => 'Penulis',
            'release_date' => '2026-01-01',
            'page_of_book' => 100,
            'category_id' => $category->id,
        ]);
        $checkout = Checkout::create([
            'user_id' => $user->id,
            'payment_method' => 'virtual_account',
            'total_book' => 1,
            'total_book_price' => 50000,
            'total_price' => 50000,
            'status' => 'pending',
        ]);
        $checkoutBook = CheckoutBook::create([
            'checkout_id' => $checkout->id,
            'book_id' => $book->id,
            'total_book' => 1,
        ]);

        $this->assertTrue($book->bookCategory->is($category));
        $this->assertTrue($checkoutBook->checkout->is($checkout));
    }

    private function admin(): User
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        return $admin;
    }

    private function createBookInCategory(
        BookCategory $category,
        string $title,
        string $writer,
        int $price,
        string $createdAt
    ): Book {
        $book = Book::create([
            'cover' => 'cover.jpg',
            'title' => $title,
            'price' => $price,
            'language' => 'id',
            'publisher' => 'Penerbit',
            'writer' => $writer,
            'release_date' => '2026-01-01',
            'page_of_book' => 100,
            'category_id' => $category->id,
        ]);

        $book->forceFill(['created_at' => $createdAt])->save();

        return $book;
    }
}
