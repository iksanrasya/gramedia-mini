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
}
