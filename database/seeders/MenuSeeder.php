<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds for NFC (Nawabi Food Corner).
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        MenuItem::truncate();
        MenuCategory::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Special Flavours Pizza
        $specialPizza = MenuCategory::create([
            'name' => 'Special Flavours Pizza',
            'slug' => 'special-flavours-pizza',
            'description' => 'Royal gourmet pizzas baked with signature sauces, lavish toppings, and golden melted cheese.',
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $specialPizza->id,
            'name' => 'Special Nawabi Pizza',
            'description' => 'Our crown jewel pizza loaded with spiced chicken, sausages, bell peppers, olives, mushrooms, and signature Nawabi cream sauce.',
            'price' => 880.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'is_hero_item' => true,
            'details' => [
                'sizes' => [
                    'small' => ['price' => 520.00, 'label' => 'Small'],
                    'medium' => ['price' => 880.00, 'label' => 'Medium'],
                    'large' => ['price' => 1350.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $specialPizza->id,
            'name' => 'Malai Boti Pizza',
            'description' => 'Creamy charcoal-grilled malai boti chicken chunks, white garlic cream sauce, onions, and loaded mozzarella.',
            'price' => 880.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 520.00, 'label' => 'Small'],
                    'medium' => ['price' => 880.00, 'label' => 'Medium'],
                    'large' => ['price' => 1350.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $specialPizza->id,
            'name' => 'Super Supreme',
            'description' => 'Fully loaded with chicken tikka, smoked sausages, black olives, fresh mushrooms, sweetcorn, and double cheese.',
            'price' => 880.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 520.00, 'label' => 'Small'],
                    'medium' => ['price' => 880.00, 'label' => 'Medium'],
                    'large' => ['price' => 1350.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $specialPizza->id,
            'name' => 'Bonfire Pizza',
            'description' => 'Smoky BBQ chicken chunks, sweet jalapenos, red onions, and hot signature bonfire BBQ drizzle.',
            'price' => 880.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 520.00, 'label' => 'Small'],
                    'medium' => ['price' => 880.00, 'label' => 'Medium'],
                    'large' => ['price' => 1350.00, 'label' => 'Large'],
                ]
            ],
        ]);

        // 2. Traditional Flavours Pizza
        $tradPizza = MenuCategory::create([
            'name' => 'Traditional Flavours Pizza',
            'slug' => 'traditional-flavours-pizza',
            'description' => 'Timeless classic pizza recipes prepared with authentic spices and rich mozzarella.',
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $tradPizza->id,
            'name' => 'Chicken Tikka',
            'description' => 'Traditional spiced chicken tikka cubes, red onions, bell peppers, and warm melted gold mozzarella.',
            'price' => 850.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 480.00, 'label' => 'Small'],
                    'medium' => ['price' => 850.00, 'label' => 'Medium'],
                    'large' => ['price' => 1280.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $tradPizza->id,
            'name' => 'Chicken Fajita',
            'description' => 'Mexican-style fajita chicken strips, sweet green bell peppers, onions, and rich mozzarella.',
            'price' => 850.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 480.00, 'label' => 'Small'],
                    'medium' => ['price' => 850.00, 'label' => 'Medium'],
                    'large' => ['price' => 1280.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $tradPizza->id,
            'name' => 'Hot N Spicy',
            'description' => 'Spicy peri-peri chicken chunks, fiery hot jalapenos, red onions, and hot chili drizzle.',
            'price' => 850.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 480.00, 'label' => 'Small'],
                    'medium' => ['price' => 850.00, 'label' => 'Medium'],
                    'large' => ['price' => 1280.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $tradPizza->id,
            'name' => 'Cheese Lover',
            'description' => 'Only cheese & sauce! Fresh herb tomato marinara smothered in a double thick layer of pure mozzarella.',
            'price' => 850.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 480.00, 'label' => 'Small'],
                    'medium' => ['price' => 850.00, 'label' => 'Medium'],
                    'large' => ['price' => 1280.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $tradPizza->id,
            'name' => 'Veggie Lover',
            'description' => 'Fresh garden bell peppers, onions, juicy mushrooms, black olives, sweetcorn, and mozzarella.',
            'price' => 850.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 480.00, 'label' => 'Small'],
                    'medium' => ['price' => 850.00, 'label' => 'Medium'],
                    'large' => ['price' => 1280.00, 'label' => 'Large'],
                ]
            ],
        ]);

        // 3. Stuff and Crown Pizza
        $stuffCrown = MenuCategory::create([
            'name' => 'Stuff and Crown Pizza',
            'slug' => 'stuff-crown-pizza',
            'description' => 'Artisanal stuffed crusts and majestic crown pockets loaded with gourmet surprises.',
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $stuffCrown->id,
            'name' => 'Behari Kabab Pizza',
            'description' => 'Smoky tender behari kabab pieces layered over stuffed crust with rich BBQ notes and cheese.',
            'price' => 1100.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'medium' => ['price' => 1100.00, 'label' => 'Medium'],
                    'large' => ['price' => 1550.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $stuffCrown->id,
            'name' => 'Kabab Stuffed Crust',
            'description' => 'Outer pizza crust stuffed with succulent spiced seekh kabab and topped with chicken chunks.',
            'price' => 1100.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'medium' => ['price' => 1100.00, 'label' => 'Medium'],
                    'large' => ['price' => 1550.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $stuffCrown->id,
            'name' => 'Chicken & Cheese Stuffed Crust',
            'description' => 'Crust folded and stuffed with minced seasoned chicken and cheddar cheese string.',
            'price' => 1100.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'details' => [
                'sizes' => [
                    'medium' => ['price' => 1100.00, 'label' => 'Medium'],
                    'large' => ['price' => 1550.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $stuffCrown->id,
            'name' => 'Crown Crust Special',
            'description' => 'Majestic crown pizza design with royal cheese stuffed crown pockets and supreme toppings.',
            'price' => 1100.00,
            'image_path' => 'images/dishes/tikka_pizza.jpg',
            'is_hero_item' => true,
            'details' => [
                'sizes' => [
                    'medium' => ['price' => 1100.00, 'label' => 'Medium'],
                    'large' => ['price' => 1550.00, 'label' => 'Large'],
                ]
            ],
        ]);

        // 4. Special Platter
        $platter = MenuCategory::create([
            'name' => 'Special Platter',
            'slug' => 'special-platter',
            'description' => 'All-in-one feast combo packed with savory finger foods, wings, fries, and drinks.',
            'sort_order' => 4,
        ]);

        MenuItem::create([
            'category_id' => $platter->id,
            'name' => 'Special Platter',
            'description' => '4 Pcs Spring roll, 6 Pcs oven Baked wing, Crispy Fries, Secret Dip sauce, and 500 ml Chilled Drink.',
            'price' => 1199.00,
            'image_path' => 'images/dishes/malai_boti.jpg',
            'is_hero_item' => true,
        ]);

        // 5. Doners
        $doners = MenuCategory::create([
            'name' => 'Doners',
            'slug' => 'doners',
            'description' => 'Authentic Turkish-style baked pita bread pockets packed with tender meats, salads, and secret sauces.',
            'sort_order' => 5,
        ]);

        MenuItem::create([
            'category_id' => $doners->id,
            'name' => 'Chicken Doner',
            'description' => 'Warm baked pita pocket loaded with shredded roasted chicken, crisp iceberg, and garlic mayo.',
            'price' => 350.00,
            'is_hero_item' => true,
        ]);

        MenuItem::create([
            'category_id' => $doners->id,
            'name' => 'Cheese Doner',
            'description' => 'Chicken doner layered with melted cheddar cheese slice, garlic sauce, and crisp greens.',
            'price' => 400.00,
        ]);

        MenuItem::create([
            'category_id' => $doners->id,
            'name' => 'Kabab Doner',
            'description' => 'Juicy grilled kabab pieces tucked inside warm doner bread with spicy mint chutney and mayo.',
            'price' => 420.00,
        ]);

        MenuItem::create([
            'category_id' => $doners->id,
            'name' => 'Malai Boti Doner',
            'description' => 'Creamy smoked malai boti chicken chunks wrapped in doner bread with velvety white sauce.',
            'price' => 380.00,
        ]);

        MenuItem::create([
            'category_id' => $doners->id,
            'name' => 'BBQ Doner',
            'description' => 'Smoky BBQ glazed chicken doner with sauteed onions and tangy BBQ sauce.',
            'price' => 410.00,
        ]);

        // 6. Appetizers
        $appetizers = MenuCategory::create([
            'name' => 'Appetizers',
            'slug' => 'appetizers',
            'description' => 'Crispy wings, golden nuggets, and finger foods to kickstart your meal.',
            'sort_order' => 6,
        ]);

        MenuItem::create([
            'category_id' => $appetizers->id,
            'name' => 'Oven Baked Wings (5 Pcs)',
            'description' => 'Five tender chicken wings marinated in herbs and slow baked in the oven.',
            'price' => 300.00,
        ]);

        MenuItem::create([
            'category_id' => $appetizers->id,
            'name' => 'Oven Baked Wings (10 Pcs)',
            'description' => 'Ten pieces of juicy oven-baked wings served with special dipping sauce.',
            'price' => 600.00,
        ]);

        MenuItem::create([
            'category_id' => $appetizers->id,
            'name' => 'Nuggets (5 Pcs)',
            'description' => 'Five golden, crispy battered chicken nuggets with garlic dip.',
            'price' => 250.00,
        ]);

        MenuItem::create([
            'category_id' => $appetizers->id,
            'name' => 'Nuggets (10 Pcs)',
            'description' => 'Ten pieces of crispy chicken nuggets served hot with ketchup and mayo.',
            'price' => 480.00,
        ]);

        MenuItem::create([
            'category_id' => $appetizers->id,
            'name' => 'Hot Wings (5 Pcs)',
            'description' => 'Five crispy fried hot chicken wings tossed in fiery chili seasoning.',
            'price' => 300.00,
        ]);

        MenuItem::create([
            'category_id' => $appetizers->id,
            'name' => 'Hot Wings (10 Pcs)',
            'description' => 'Ten pieces of spicy, crunchy hot wings served with cooling dip.',
            'price' => 600.00,
        ]);

        // 7. Spin Rolls
        $spinRolls = MenuCategory::create([
            'name' => 'Spin Rolls',
            'slug' => 'spin-rolls',
            'description' => 'Flaky baked pastry rolls filled with seasoned fillings and melted cheese.',
            'sort_order' => 7,
        ]);

        MenuItem::create([
            'category_id' => $spinRolls->id,
            'name' => 'Spin Rolls (4 Pcs)',
            'description' => 'Four pieces of baked dough rolls packed with savory chicken and mozzarella.',
            'price' => 550.00,
        ]);

        MenuItem::create([
            'category_id' => $spinRolls->id,
            'name' => 'Behari Rolls (4 Pcs)',
            'description' => 'Four crispy spin rolls filled with smoky spiced behari chicken and onions.',
            'price' => 580.00,
        ]);

        MenuItem::create([
            'category_id' => $spinRolls->id,
            'name' => 'Mexican Rolls (4 Pcs)',
            'description' => 'Four zesty Mexican-spiced chicken rolls with salsa seasoning and cheese.',
            'price' => 599.00,
        ]);

        // 8. Burgers
        $burgers = MenuCategory::create([
            'name' => 'Burgers',
            'slug' => 'burgers',
            'description' => 'Juicy handcrafted patties and crispy zinger fillets between toasted buns.',
            'sort_order' => 8,
        ]);

        MenuItem::create([
            'category_id' => $burgers->id,
            'name' => 'Petty Burger',
            'description' => 'Classic grilled chicken patty burger with fresh lettuce, onions, and mayo.',
            'price' => 280.00,
            'image_path' => 'images/dishes/beef_burger.jpg',
        ]);

        MenuItem::create([
            'category_id' => $burgers->id,
            'name' => 'Zinger Burger',
            'description' => 'Signature crispy crunchy fried chicken fillet topped with creamy mayo and lettuce.',
            'price' => 350.00,
            'image_path' => 'images/dishes/beef_burger.jpg',
            'is_hero_item' => true,
        ]);

        MenuItem::create([
            'category_id' => $burgers->id,
            'name' => 'Chapli Petty Burger',
            'description' => 'Spiced authentic chapli chicken patty with mint chutney and fresh salad.',
            'price' => 300.00,
            'image_path' => 'images/dishes/beef_burger.jpg',
        ]);

        // 9. Fries
        $fries = MenuCategory::create([
            'name' => 'Fries',
            'slug' => 'fries',
            'description' => 'Crispy golden potato fries seasoned to perfection and loaded with toppings.',
            'sort_order' => 9,
        ]);

        MenuItem::create([
            'category_id' => $fries->id,
            'name' => 'Mayo Fries',
            'description' => 'Crisp golden french fries drizzled with creamy garlic mayonnaise.',
            'price' => 350.00,
        ]);

        MenuItem::create([
            'category_id' => $fries->id,
            'name' => 'Cheesy Mayo Fries',
            'description' => 'Crispy french fries drenched in rich melted cheddar cheese sauce and garlic mayo.',
            'price' => 450.00,
        ]);

        MenuItem::create([
            'category_id' => $fries->id,
            'name' => 'Loaded Fries',
            'description' => 'Fries fully loaded with crispy chicken chunks, jalapenos, cheese sauce, and mayo drizzle.',
            'price' => 650.00,
            'is_hero_item' => true,
        ]);

        // 10. Shawarma and Paratha Roll
        $shawarma = MenuCategory::create([
            'name' => 'Shawarma and Paratha Roll',
            'slug' => 'shawarma-paratha-roll',
            'description' => 'Street-style warm pita wraps and crispy flaky paratha rolls.',
            'sort_order' => 10,
        ]);

        MenuItem::create([
            'category_id' => $shawarma->id,
            'name' => 'Chicken Shawarma',
            'description' => 'Shredded seasoned chicken wrapped in warm pita bread with garlic mayo and pickles.',
            'price' => 220.00,
        ]);

        MenuItem::create([
            'category_id' => $shawarma->id,
            'name' => 'Zinger Shawarma',
            'description' => 'Crispy fried zinger strips wrapped in soft pita with spicy chili garlic dressing.',
            'price' => 290.00,
        ]);

        MenuItem::create([
            'category_id' => $shawarma->id,
            'name' => 'Chicken Paratha',
            'description' => 'Spiced shredded chicken rolled in a hot, flaky lachha paratha.',
            'price' => 290.00,
        ]);

        MenuItem::create([
            'category_id' => $shawarma->id,
            'name' => 'Zinger Paratha',
            'description' => 'Crispy zinger fillet wrapped inside a buttery, crisp paratha with secret sauce.',
            'price' => 370.00,
            'is_hero_item' => true,
        ]);

        // 11. Pasta
        $pasta = MenuCategory::create([
            'name' => 'Pasta',
            'slug' => 'pasta',
            'description' => 'Italian penne pasta cooked in creamy sauces, seasoned chicken, and melted cheese.',
            'sort_order' => 11,
        ]);

        MenuItem::create([
            'category_id' => $pasta->id,
            'name' => 'Creamy Pasta',
            'description' => 'Penne pasta tossed in velvety garlic white cream sauce, chicken chunks, and Italian herbs.',
            'price' => 400.00,
            'image_path' => 'images/dishes/chowmein.jpg',
            'details' => [
                'sizes' => [
                    'small' => ['price' => 400.00, 'label' => 'Small'],
                    'large' => ['price' => 600.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $pasta->id,
            'name' => 'Crunchy Pasta',
            'description' => 'Creamy baked penne pasta topped with crispy crunchy zinger bites and bubbling mozzarella.',
            'price' => 450.00,
            'image_path' => 'images/dishes/chowmein.jpg',
            'is_hero_item' => true,
            'details' => [
                'sizes' => [
                    'small' => ['price' => 450.00, 'label' => 'Small'],
                    'large' => ['price' => 680.00, 'label' => 'Large'],
                ]
            ],
        ]);

        // 12. Sandwiches
        $sandwiches = MenuCategory::create([
            'name' => 'Sandwiches',
            'slug' => 'sandwiches',
            'description' => 'Toasted club sandwiches packed with flavorful meats, cheese, and crunchy veggies.',
            'sort_order' => 12,
        ]);

        MenuItem::create([
            'category_id' => $sandwiches->id,
            'name' => 'Maxican Sandwich',
            'description' => 'Toasted multi-layer sandwich loaded with Mexican fajita chicken, cheese, and spicy salsa dressing.',
            'price' => 550.00,
        ]);

        MenuItem::create([
            'category_id' => $sandwiches->id,
            'name' => 'Malai Boti Sandwich',
            'description' => 'Smoky, velvety malai boti chicken filling inside toasted bread with garlic mayonnaise.',
            'price' => 580.00,
        ]);

        MenuItem::create([
            'category_id' => $sandwiches->id,
            'name' => 'Hot / Spicy Sandwich',
            'description' => 'Spicy grilled chicken sandwich with jalapenos, spicy dressing, and golden fries.',
            'price' => 580.00,
        ]);

        // 13. Beverages
        $beverages = MenuCategory::create([
            'name' => 'Beverages',
            'slug' => 'beverages',
            'description' => 'Refreshing chilled sodas and pure mineral water.',
            'sort_order' => 13,
        ]);

        MenuItem::create([
            'category_id' => $beverages->id,
            'name' => 'Soft Drink 300ML',
            'description' => 'Chilled 300ml carbonated soft drink (Pepsi / Coke / 7Up / Sprite / Dew).',
            'price' => 80.00,
        ]);

        MenuItem::create([
            'category_id' => $beverages->id,
            'name' => 'Soft Drink 500ML',
            'description' => 'Chilled 500ml beverage bottle.',
            'price' => 110.00,
        ]);

        MenuItem::create([
            'category_id' => $beverages->id,
            'name' => 'Soft Drink 1 Ltr',
            'description' => 'Chilled 1 Litre soft drink bottle.',
            'price' => 150.00,
        ]);

        MenuItem::create([
            'category_id' => $beverages->id,
            'name' => 'Soft Drink 1.5 Ltr',
            'description' => 'Chilled 1.5 Litre family soft drink bottle.',
            'price' => 190.00,
        ]);

        MenuItem::create([
            'category_id' => $beverages->id,
            'name' => 'Water Small',
            'description' => 'Pure 500ml bottled mineral drinking water.',
            'price' => 60.00,
        ]);

        MenuItem::create([
            'category_id' => $beverages->id,
            'name' => 'Water Large',
            'description' => 'Pure 1.5L bottled mineral drinking water.',
            'price' => 120.00,
        ]);

        // 14. Adds On
        $addsOn = MenuCategory::create([
            'name' => 'Adds On',
            'slug' => 'adds-on',
            'description' => 'Extra toppings, dips, and sides to customize your order.',
            'sort_order' => 14,
        ]);

        MenuItem::create([
            'category_id' => $addsOn->id,
            'name' => 'Extra Topping Chkn/Cheese',
            'description' => 'Additional topping of spiced chicken or melted mozzarella cheese.',
            'price' => 100.00,
            'details' => [
                'sizes' => [
                    'small' => ['price' => 100.00, 'label' => 'Small'],
                    'medium' => ['price' => 150.00, 'label' => 'Medium'],
                    'large' => ['price' => 250.00, 'label' => 'Large'],
                ]
            ],
        ]);

        MenuItem::create([
            'category_id' => $addsOn->id,
            'name' => 'Garlic Sauce',
            'description' => 'Extra tub of creamy garlic mayo sauce.',
            'price' => 70.00,
        ]);

        MenuItem::create([
            'category_id' => $addsOn->id,
            'name' => 'Dip Sauce',
            'description' => 'Extra tub of signature dipping sauce.',
            'price' => 70.00,
        ]);

        MenuItem::create([
            'category_id' => $addsOn->id,
            'name' => 'Cheese Slice',
            'description' => 'Extra melted cheddar cheese slice.',
            'price' => 70.00,
        ]);

        // 15. Pizza Buster Deals (Deals 1 to 21)
        $pizzaDeals = MenuCategory::create([
            'name' => 'Pizza Buster Deals',
            'slug' => 'pizza-buster-deals',
            'description' => 'Super value combo deals packed with pizzas, burgers, wings, nuggets, and drinks.',
            'sort_order' => 15,
        ]);

        $pizzaDealsList = [
            ['name' => 'Deal no 1', 'desc' => 'Small Pizza, 5 Nuggets, 300ml Drink', 'price' => 800.00],
            ['name' => 'Deal no 2', 'desc' => 'Small Pizza, 5 Wings, 300ml Drink', 'price' => 850.00],
            ['name' => 'Deal no 3', 'desc' => 'Small Pizza, 2 Zngr Burger, 500ml Drink', 'price' => 1270.00],
            ['name' => 'Deal no 4', 'desc' => 'Small Pizza, Creamy Pasta-H, 500ml Drink', 'price' => 990.00],
            ['name' => 'Deal no 5', 'desc' => 'Small Pizza, 2 Doner, 500ml Drink', 'price' => 1270.00],
            ['name' => 'Deal no 6', 'desc' => 'Medium Pizza, 10 Hot Wings, 1-Ltr Drink', 'price' => 1550.00],
            ['name' => 'Deal no 7', 'desc' => 'Medium Pizza, 10 Nuggets, 1-Ltr Drink', 'price' => 1470.00],
            ['name' => 'Deal no 8', 'desc' => 'Medium Pizza, Creamy Pasta-H, 1-Ltr Drink', 'price' => 1370.00],
            ['name' => 'Deal no 9', 'desc' => 'Medium Pizza, 3 Zngr Burger, 1-Ltr Drink', 'price' => 1990.00],
            ['name' => 'Deal no 10', 'desc' => 'Medium Pizza, 4-Pcs Spin Roll, 1-Ltr Drink', 'price' => 1520.00],
            ['name' => 'Deal no 11', 'desc' => 'Large Pizza, 10 Hot Wings, 1.5 Ltr Drink', 'price' => 2050.00],
            ['name' => 'Deal no 12', 'desc' => 'Large Pizza, 10 Nuggets, 1.5 Ltr Drink', 'price' => 1950.00],
            ['name' => 'Deal no 13', 'desc' => 'Large Pizza, Creamy Pasta, 1.5 Ltr Drink', 'price' => 2050.00],
            ['name' => 'Deal no 14', 'desc' => 'Large Pizza, 4 Zngr Burger, 1.5 Ltr Drink', 'price' => 2799.00],
            ['name' => 'Deal no 15', 'desc' => 'Large Pizza, 6-Pcs Spin Roll, 1.5 Ltr Drink', 'price' => 2250.00],
            ['name' => 'Deal no 16', 'desc' => '2 Small Pizza, 1 Ltr Drink', 'price' => 1140.00],
            ['name' => 'Deal no 17', 'desc' => '2 Medium Pizza, 1 Ltr Drink', 'price' => 1800.00],
            ['name' => 'Deal no 18', 'desc' => '2 Large Pizza, 1.5 Ltr Drink', 'price' => 2750.00],
            ['name' => 'Deal no 19', 'desc' => '20 Pcs Wings, 1.5 Ltr Drink', 'price' => 1330.00],
            ['name' => 'Deal no 20', 'desc' => '5 Zngr Burger, 1.5 Ltr Drink', 'price' => 1850.00],
            ['name' => 'Deal no 21', 'desc' => '10 Zngr Burger, 1.5 Ltr Drink', 'price' => 3500.00],
        ];

        foreach ($pizzaDealsList as $d) {
            MenuItem::create([
                'category_id' => $pizzaDeals->id,
                'name' => $d['name'],
                'description' => $d['desc'],
                'price' => $d['price'],
                'image_path' => 'images/dishes/tikka_pizza.jpg',
            ]);
        }

        // 16. Doner Deals (Deals 22 to 33)
        $donerDeals = MenuCategory::create([
            'name' => 'Doner Deals',
            'slug' => 'doner-deals',
            'description' => 'Irresistible value combos for doner lovers with fries and chilled drinks.',
            'sort_order' => 16,
        ]);

        $donerDealsList = [
            ['name' => 'Deal no 22', 'desc' => '1-Chiken Doner, Fries, 0.5 Ltr Drink', 'price' => 570.00],
            ['name' => 'Deal no 23', 'desc' => '2-Chiken Doner, Fries, 0.5 Ltr Drink', 'price' => 880.00],
            ['name' => 'Deal no 24', 'desc' => '3-Chiken Doner, Fries, 1 Ltr Drink', 'price' => 1320.00],
            ['name' => 'Deal no 25', 'desc' => '4-Chiken Doner, Fries, 1.5 Ltr Drink', 'price' => 1520.00],
            ['name' => 'Deal no 26', 'desc' => '2-Cheese Doner, Fries, 0.5 Ltr Drink', 'price' => 870.00],
            ['name' => 'Deal no 27', 'desc' => '4-Cheese Doner, Fries, 1 Ltr Drink', 'price' => 1680.00],
            ['name' => 'Deal no 28', 'desc' => '2-Malai Doner, 2- BBQ Doner, 1.5 Ltr Drink', 'price' => 1680.00],
            ['name' => 'Deal no 29', 'desc' => '2-Cheese Doner, 2- Malai Doner, 1.5 Ltr Drink', 'price' => 1680.00],
            ['name' => 'Deal no 30', 'desc' => '6 Doner Any, 1.5 Ltr Drink', 'price' => 2650.00],
            ['name' => 'Deal no 31', 'desc' => '8 Doner Any, 1.5 Ltr Drink', 'price' => 3480.00],
            ['name' => 'Deal no 32', 'desc' => '10 Doner Any, 2-1.5 Ltr Drink', 'price' => 4380.00],
            ['name' => 'Deal no 33', 'desc' => '12 Doner Any, 2-1.5 Ltr Drink', 'price' => 5220.00],
        ];

        foreach ($donerDealsList as $d) {
            MenuItem::create([
                'category_id' => $donerDeals->id,
                'name' => $d['name'],
                'description' => $d['desc'],
                'price' => $d['price'],
            ]);
        }

        // 17. Birthday Deals
        $birthdayDeals = MenuCategory::create([
            'name' => 'Birthday Deals',
            'slug' => 'birthday-deals',
            'description' => 'Grand party feast packages complete with pizzas, wings, zinger burgers, fries, drinks, and a birthday cake!',
            'sort_order' => 17,
        ]);

        MenuItem::create([
            'category_id' => $birthdayDeals->id,
            'name' => 'Birthday Deal 1',
            'description' => 'Large Pizza, 10 Pcs Wings, 2 Zngr Burger, Large Fries, 2x 1.5 Ltr Drinks, and 1 Pound Birthday Cake!',
            'price' => 3350.00,
            'is_hero_item' => true,
        ]);

        MenuItem::create([
            'category_id' => $birthdayDeals->id,
            'name' => 'Birthday Deal 2',
            'description' => 'Large Pizza, Medium Pizza, 10 Pcs Wings, 2 Zngr Burger, Family Fries, 2x 1.5 Ltr Drinks, and 1 Pound Birthday Cake!',
            'price' => 4450.00,
            'is_hero_item' => true,
        ]);
    }
}
