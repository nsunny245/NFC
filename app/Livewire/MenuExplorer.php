<?php

namespace App\Livewire;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;

class MenuExplorer extends Component
{
    public $search = '';
    public $selectedCategory = 'all';
    public $perPage = 6; // Dynamic pagination (2 rows on 3-column layout by default)

    // Shopping Cart state
    public $cart = [];
    public $cartOpen = false;

    // Selected options per item id
    public $selectedSizes = [];
    public $selectedSpices = [];

    // Checkout Form state
    public $checkoutOpen = false;
    public $customerName = '';
    public $customerPhone = '';
    public $customerAddress = '';
    public $orderType = 'takeaway';
    public $specialNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => 'all'],
    ];

    public function mount()
    {
        $this->cart = session()->get('royal_cart', []);
    }

    public function selectCategory($slug)
    {
        $this->selectedCategory = $slug;
        $this->perPage = 6; // Reset page limit on category change
    }

    public function updatedSearch()
    {
        $this->perPage = 6; // Reset page limit on search keypress
    }

    public function loadMore()
    {
        $this->perPage += 6; // Load next 2 rows of items
    }

    public function saveCart()
    {
        session()->put('royal_cart', $this->cart);
    }

    public function addToCart($itemId)
    {
        $item = MenuItem::find($itemId);
        if (!$item) {
            return;
        }

        // Get selected portion/size
        $size = $this->selectedSizes[$itemId] ?? null;
        if (!$size && isset($item->details['sizes']) && is_array($item->details['sizes'])) {
            $size = array_key_first($item->details['sizes']);
        }

        // Get selected spice level
        $spice = $this->selectedSpices[$itemId] ?? null;
        if (!$spice && isset($item->details['spice_levels']) && is_array($item->details['spice_levels'])) {
            $spice = $item->details['spice_levels'][0];
        }

        // Determine price
        $price = $item->price;
        if ($size && isset($item->details['sizes'][$size]['price'])) {
            $price = $item->details['sizes'][$size]['price'];
        }

        // Formulate cart line item key
        $key = $item->id . '_' . ($size ?? '') . '_' . ($spice ?? '');

        if (isset($this->cart[$key])) {
            $this->cart[$key]['quantity']++;
        } else {
            $this->cart[$key] = [
                'item_id' => $item->id,
                'name' => $item->name,
                'size' => $size,
                'size_label' => $size ? ($item->details['sizes'][$size]['label'] ?? $size) : null,
                'spice' => $spice,
                'price' => (float) $price,
                'quantity' => 1,
            ];
        }

        $this->saveCart();
        $this->cartOpen = true; // Automatically open cart drawer
    }

    public function updateQuantity($key, $qty)
    {
        if (isset($this->cart[$key])) {
            $qty = (int) $qty;
            if ($qty <= 0) {
                unset($this->cart[$key]);
            } else {
                $this->cart[$key]['quantity'] = $qty;
            }
            $this->saveCart();
        }
    }

    public function removeFromCart($key)
    {
        if (isset($this->cart[$key])) {
            unset($this->cart[$key]);
            $this->saveCart();
        }
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->saveCart();
    }

    public function getSubtotal()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function toggleCart()
    {
        $this->cartOpen = !$this->cartOpen;
    }

    public function openCheckout()
    {
        $this->checkoutOpen = true;
    }

    public function closeCheckout()
    {
        $this->checkoutOpen = false;
    }

    public function checkout()
    {
        $this->validate([
            'customerName' => 'required|min:3',
            'customerPhone' => 'required|min:10',
            'orderType' => 'required|in:dine_in,takeaway,delivery',
            'customerAddress' => 'required_if:orderType,delivery',
        ], [
            'customerName.required' => 'Please provide your Royal name.',
            'customerName.min' => 'Royal name must be at least 3 letters.',
            'customerPhone.required' => 'A phone number is required for updates.',
            'customerPhone.min' => 'Please enter a valid phone number.',
            'customerAddress.required_if' => 'Please provide a delivery address.',
        ]);

        if (empty($this->cart)) {
            $this->addError('cart', 'Your Royal Cart is empty.');
            return;
        }

        $subtotal = $this->getSubtotal();
        $orderNumber = 'ND-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

        // Create the order in database
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'customer_address' => $this->orderType === 'delivery' ? $this->customerAddress : null,
            'subtotal' => $subtotal,
            'tax' => 0.00,
            'discount' => 0.00,
            'total' => $subtotal,
            'status' => 'pending',
            'type' => $this->orderType,
            'special_notes' => $this->specialNotes,
        ]);

        // Create the individual order items
        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        // Create an internal notification for Admin and Cashier
        \App\Models\InternalNotification::create([
            'type' => 'online_order',
            'title' => '🚨 New Online Order #' . $order->order_number,
            'message' => "Placed by {$order->customer_name} ({$order->customer_phone}). Total: Rs. " . number_format($order->total, 0),
            'notifiable_role' => 'all',
            'related_id' => $order->id,
        ]);

        // Format the Royal WhatsApp Message
        $message = "👑 *NFC - NAWABI FOOD CORNER* 👑\n";
        $message .= "--------------------------------------\n";
        $message .= "*Order Number:* " . $orderNumber . "\n";
        $message .= "*Type:* " . ucfirst(str_replace('_', ' ', $this->orderType)) . "\n";
        $message .= "*Customer:* " . $this->customerName . "\n";
        $message .= "*Phone:* " . $this->customerPhone . "\n";
        if ($this->orderType === 'delivery') {
            $message .= "*Delivery Address:* " . $this->customerAddress . "\n";
        }
        if ($this->specialNotes) {
            $message .= "*Special Notes:* " . $this->specialNotes . "\n";
        }
        $message .= "--------------------------------------\n";
        $message .= "*ORDERED ITEMS:*\n";

        foreach ($this->cart as $item) {
            $details = [];
            if ($item['size_label']) {
                $details[] = $item['size_label'];
            }
            if ($item['spice']) {
                $details[] = "Spice: " . $item['spice'];
            }
            $detailStr = !empty($details) ? " (" . implode(', ', $details) . ")" : "";
            $message .= "- " . $item['name'] . $detailStr . " x" . $item['quantity'] . " = Rs. " . number_format($item['price'] * $item['quantity'], 0) . "\n";
        }

        $message .= "--------------------------------------\n";
        $message .= "*Grand Total: Rs. " . number_format($subtotal, 0) . "*\n";
        $message .= "--------------------------------------\n";
        $message .= "Thank you for choosing NFC (Nawabi Food Corner) Okara! Please confirm my order.";

        // Clear the session cart
        $this->clearCart();

        // Reset state
        $this->checkoutOpen = false;
        $this->cartOpen = false;

        // Redirect to WhatsApp chat URL
        $waUrl = "https://wa.me/923118484987?text=" . urlencode($message);

        return $this->redirect($waUrl);
    }

    public function render()
    {
        $categories = MenuCategory::where('is_active', true)->orderBy('sort_order')->get();

        $query = MenuItem::with('category')->where('is_available', true);

        if ($this->selectedCategory !== 'all') {
            $category = MenuCategory::where('slug', $this->selectedCategory)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if (!empty($this->search)) {
            $searchString = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchString) {
                $q->where('name', 'like', $searchString)
                  ->orWhere('description', 'like', $searchString);
            });
        }

        $totalItems = $query->count();
        $menuItems = $query->take($this->perPage)->get();

        return view('livewire.menu-explorer', [
            'categories' => $categories,
            'menuItems' => $menuItems,
            'totalItems' => $totalItems,
        ]);
    }
}
