<?php

namespace Tests\Feature;

use App\Livewire\MenuExplorer;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MenuExplorerTest extends TestCase
{
    use RefreshDatabase;

    private $desiCategory;
    private $bbqCategory;
    private $karahiItem;
    private $kebabItem;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic categories and items
        $this->desiCategory = MenuCategory::create([
            'name' => 'Desi Specialties',
            'slug' => 'desi-specialties',
            'description' => 'Authentic Punjabi taste',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->bbqCategory = MenuCategory::create([
            'name' => 'BBQ Items',
            'slug' => 'bbq-items',
            'description' => 'Sizzling hot grills',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $this->karahiItem = MenuItem::create([
            'category_id' => $this->desiCategory->id,
            'name' => 'Nawabi Chicken Karahi',
            'description' => 'Traditional Lahori Style Karahi',
            'price' => 1200,
            'is_available' => true,
            'is_hero_item' => true,
            'details' => [
                'portion' => 'Serves 2-3 Persons',
                'spice_levels' => ['Mild', 'Medium', 'Nawabi Hot'],
            ],
        ]);

        $this->kebabItem = MenuItem::create([
            'category_id' => $this->bbqCategory->id,
            'name' => 'Sizzling Seekh Kebab',
            'description' => 'Mouth-watering beef seekh kebab',
            'price' => 650,
            'is_available' => true,
            'is_hero_item' => false,
            'details' => [
                'sizes' => [
                    'half' => ['label' => 'Half Plate (4 Pcs)', 'price' => 350],
                    'full' => ['label' => 'Full Plate (8 Pcs)', 'price' => 650],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_render_the_menu_explorer_with_seeded_items()
    {
        Livewire::test(MenuExplorer::class)
            ->assertSee('Nawabi Chicken Karahi')
            ->assertSee('Sizzling Seekh Kebab')
            ->assertSee('Rs. 1,200')
            ->assertSee('Rs. 650');
    }

    /** @test */
    public function it_can_filter_items_by_category()
    {
        Livewire::test(MenuExplorer::class)
            ->set('selectedCategory', 'desi-specialties')
            ->assertSee('Nawabi Chicken Karahi')
            ->assertDontSee('Sizzling Seekh Kebab');

        Livewire::test(MenuExplorer::class)
            ->set('selectedCategory', 'bbq-items')
            ->assertSee('Sizzling Seekh Kebab')
            ->assertDontSee('Nawabi Chicken Karahi');
    }

    /** @test */
    public function it_can_search_menu_items_by_text()
    {
        Livewire::test(MenuExplorer::class)
            ->set('search', 'Seekh')
            ->assertSee('Sizzling Seekh Kebab')
            ->assertDontSee('Nawabi Chicken Karahi');

        Livewire::test(MenuExplorer::class)
            ->set('search', 'Traditional')
            ->assertSee('Nawabi Chicken Karahi')
            ->assertDontSee('Sizzling Seekh Kebab');
    }

    /** @test */
    public function it_shows_appropriate_message_when_no_dishes_found()
    {
        Livewire::test(MenuExplorer::class)
            ->set('search', 'Nonexistent Dish')
            ->assertSee('No Royal Dishes Found');
    }

    /** @test */
    public function it_can_add_item_to_cart()
    {
        Livewire::test(MenuExplorer::class)
            ->call('addToCart', $this->karahiItem->id)
            ->assertSet('cartOpen', true)
            ->assertSee('Nawabi Chicken Karahi')
            ->assertSee('Royal Feast Cart');
    }

    /** @test */
    public function it_can_adjust_cart_quantities()
    {
        $test = Livewire::test(MenuExplorer::class)
            ->call('addToCart', $this->karahiItem->id);
        
        $cart = $test->get('cart');
        $key = array_key_first($cart);

        $test->call('updateQuantity', $key, 3)
            ->assertSee('3')
            ->call('removeFromCart', $key)
            ->assertSet('cart', []);
    }

    /** @test */
    public function it_can_checkout_and_redirect_to_whatsapp()
    {
        $test = Livewire::test(MenuExplorer::class)
            ->call('addToCart', $this->karahiItem->id)
            ->set('customerName', 'Ali Khan')
            ->set('customerPhone', '03118484987')
            ->set('orderType', 'takeaway')
            ->call('checkout');

        $test->assertRedirect(); // Assert redirection to WhatsApp

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Ali Khan',
            'customer_phone' => '03118484987',
            'type' => 'takeaway',
            'status' => 'pending',
            'total' => 1200,
        ]);
    }
}
