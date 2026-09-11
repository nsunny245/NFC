<div class="py-6 text-stone-800 relative">
    
    <!-- Floating Cart Button -->
    @if(count($cart) > 0 && !$cartOpen)
        <div class="fixed bottom-6 right-6 z-40 animate-bounce">
            <button 
                wire:click="toggleCart"
                class="flex items-center gap-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-4 px-6 rounded-full font-bold shadow-[0_10px_25px_rgba(220,38,38,0.4)] hover:shadow-[0_15px_30px_rgba(220,38,38,0.6)] transition-all duration-300 cursor-pointer border-2 border-white"
            >
                <span class="relative">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-yellow-400 text-stone-900 text-xs w-5 h-5 rounded-full flex items-center justify-center border border-white font-extrabold shadow-sm">
                        {{ collect($cart)->sum('quantity') }}
                    </span>
                </span>
                <span class="text-sm uppercase tracking-wider font-extrabold">Royal Cart</span>
            </button>
        </div>
    @endif

    <!-- Category Navigation & Search -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search bar -->
        <div class="mb-10 max-w-md mx-auto relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="Search pizzas, burgers, doners, deals..." 
                class="w-full bg-white border-2 border-amber-300 rounded-full py-3.5 pl-12 pr-4 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all duration-300 shadow-md shadow-amber-900/5 text-sm font-medium"
            />
        </div>

        <!-- Categories Tabs -->
        <div class="flex flex-wrap justify-center gap-2.5 mb-12">
            <button 
                wire:click="selectCategory('all')"
                class="px-5 py-2.5 rounded-full text-xs font-extrabold uppercase tracking-wider transition-all duration-300 cursor-pointer {{ $selectedCategory === 'all' ? 'bg-amber-500 text-white shadow-md shadow-amber-500/30 scale-105 border-2 border-amber-500' : 'bg-white border-2 border-amber-200/80 hover:border-amber-400 text-stone-700 hover:text-amber-800 shadow-xs' }}"
            >
                🔥 All Items
            </button>
            @foreach($categories as $category)
                <button 
                    wire:click="selectCategory('{{ $category->slug }}')"
                    class="px-5 py-2.5 rounded-full text-xs font-extrabold uppercase tracking-wider transition-all duration-300 cursor-pointer {{ $selectedCategory === $category->slug ? 'bg-amber-500 text-white shadow-md shadow-amber-500/30 scale-105 border-2 border-amber-500' : 'bg-white border-2 border-amber-200/80 hover:border-amber-400 text-stone-700 hover:text-amber-800 shadow-xs' }}"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($menuItems as $item)
                <div class="bg-white rounded-3xl overflow-hidden border-2 border-amber-200/80 hover:border-amber-400 transition-all duration-300 flex flex-col group hover:-translate-y-1.5 shadow-lg shadow-amber-900/5 hover:shadow-2xl hover:shadow-amber-900/10">
                    
                    <!-- Dish Picture Section -->
                    <div class="h-48 md:h-52 w-full overflow-hidden relative bg-amber-50">
                        @if($item->image_path)
                            <img 
                                src="{{ asset($item->image_path) }}" 
                                alt="{{ $item->name }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            >
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-amber-100 to-amber-200/60 flex items-center justify-center">
                                <span class="text-5xl group-hover:scale-110 transition-transform">
                                    @if(str_contains(strtolower($item->name), 'pizza')) 🍕
                                    @elseif(str_contains(strtolower($item->name), 'burger')) 🍔
                                    @elseif(str_contains(strtolower($item->name), 'fries')) 🍟
                                    @elseif(str_contains(strtolower($item->name), 'wing') || str_contains(strtolower($item->name), 'nugget')) 🍗
                                    @elseif(str_contains(strtolower($item->name), 'doner') || str_contains(strtolower($item->name), 'shawarma') || str_contains(strtolower($item->name), 'roll')) 🌯
                                    @elseif(str_contains(strtolower($item->name), 'pasta')) 🍝
                                    @elseif(str_contains(strtolower($item->name), 'sandwich')) 🥪
                                    @elseif(str_contains(strtolower($item->name), 'drink') || str_contains(strtolower($item->name), 'water')) 🥤
                                    @else 👑
                                    @endif
                                </span>
                            </div>
                        @endif
                        
                        <!-- Floating Badge -->
                        @if($item->is_hero_item)
                            <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-extrabold uppercase px-3 py-1 rounded-full shadow-md tracking-wider">
                                Chef Special ⭐
                            </span>
                        @endif
                    </div>

                    <!-- Delicate Separation Line -->
                    <div class="h-[2px] w-full bg-gradient-to-r from-amber-200 via-amber-400 to-red-400"></div>
                    
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Heading & Price -->
                            <div class="flex justify-between items-start gap-3 mb-2">
                                <h3 class="text-xl font-heading tracking-wide text-stone-900 group-hover:text-red-600 transition-colors duration-300 leading-snug">
                                    {{ $item->name }}
                                </h3>
                                <span class="text-base font-extrabold text-red-600 bg-red-50 px-3 py-1 rounded-xl border border-red-200 shrink-0">
                                    Rs. {{ number_format($item->price, 0) }}
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="text-xs text-stone-600 leading-relaxed mb-4 font-sans font-medium line-clamp-2">
                                {{ $item->description }}
                            </p>

                            <!-- Dynamic portion configurations -->
                            @if(isset($item->details['sizes']) && is_array($item->details['sizes']))
                                <div class="mb-4 text-xs bg-amber-50/80 border border-amber-200 p-3 rounded-2xl">
                                    <label class="block text-amber-900 font-bold mb-1.5 uppercase tracking-wider text-[10px]">Select Portion Size:</label>
                                    <select 
                                        wire:model="selectedSizes.{{ $item->id }}"
                                        class="w-full bg-white border border-amber-300 rounded-xl py-1.5 px-3 text-stone-800 text-xs focus:outline-none focus:border-amber-500 font-semibold cursor-pointer shadow-xs"
                                    >
                                        @foreach($item->details['sizes'] as $sizeKey => $size)
                                            <option value="{{ $sizeKey }}">{{ $size['label'] }} (Rs. {{ number_format($size['price'], 0) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif(isset($item->details['portion']))
                                <div class="mb-4 text-xs bg-amber-50/80 border border-amber-200 p-2.5 rounded-xl flex items-center gap-2">
                                    <span class="text-amber-700">📦</span>
                                    <span class="text-stone-700 font-bold">{{ $item->details['portion'] }}</span>
                                </div>
                            @endif

                            <!-- Dynamic Spice Levels -->
                            @if(isset($item->details['spice_levels']) && is_array($item->details['spice_levels']))
                                <div class="mb-4 text-xs bg-amber-50/80 border border-amber-200 p-3 rounded-2xl">
                                    <label class="block text-amber-900 font-bold mb-1.5 uppercase tracking-wider text-[10px]">Spice Level:</label>
                                    <select 
                                        wire:model="selectedSpices.{{ $item->id }}"
                                        class="w-full bg-white border border-amber-300 rounded-xl py-1.5 px-3 text-stone-800 text-xs focus:outline-none focus:border-amber-500 font-semibold cursor-pointer shadow-xs"
                                    >
                                        @foreach($item->details['spice_levels'] as $spice)
                                            <option value="{{ $spice }}">🔥 {{ $spice }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <!-- Order Action Buttons -->
                        <div class="pt-4 border-t border-amber-100 flex gap-2 mt-2">
                            <button 
                                wire:click="addToCart({{ $item->id }})"
                                class="w-full inline-flex justify-center items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2.5 px-4 rounded-xl text-xs font-extrabold uppercase tracking-wider transition-all duration-300 shadow-md shadow-red-600/20 hover:shadow-lg hover:shadow-red-600/35 hover:-translate-y-0.5 cursor-pointer"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Royal Cart
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-3xl border-2 border-amber-200 p-8 shadow-sm">
                    <span class="text-4xl block mb-2">🍽️</span>
                    <h3 class="text-xl font-heading text-stone-900">No Royal Dishes Found</h3>
                    <p class="mt-1 text-sm text-stone-500">Try searching for another dish or choosing a different category.</p>
                </div>
            @endforelse
        </div>

        <!-- Load More Action -->
        @if($totalItems > $perPage)
            <div class="flex justify-center mt-12">
                <button 
                    wire:click="loadMore"
                    wire:loading.attr="disabled"
                    class="relative group inline-flex items-center gap-2.5 bg-white border-2 border-amber-400 hover:bg-amber-500 hover:text-white text-stone-800 py-3.5 px-10 rounded-full font-extrabold uppercase tracking-widest text-xs transition-all duration-300 shadow-md shadow-amber-900/5 hover:shadow-xl hover:-translate-y-0.5 cursor-pointer"
                >
                    <!-- Loading Spinner -->
                    <span wire:loading wire:target="loadMore" class="animate-spin h-4 w-4 border-2 border-red-600 border-t-transparent rounded-full"></span>
                    
                    <span wire:loading.remove wire:target="loadMore" class="group-hover:rotate-12 transition-transform duration-300">🍕</span>
                    <span>Load More Royal Menu Dishes</span>
                </button>
            </div>
        @endif
    </div>

    <!-- CART DRAWER (LIGHT THEME) -->
    @if($cartOpen)
        <div class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div class="absolute inset-0 overflow-hidden">
                <!-- Backdrop glassmorphism -->
                <div wire:click="toggleCart" class="absolute inset-0 bg-stone-900/50 backdrop-blur-xs transition-opacity" aria-hidden="true"></div>

                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col bg-white border-l-2 border-amber-300 shadow-2xl text-stone-800">
                            
                            <!-- Header -->
                            <div class="px-6 py-5 border-b border-amber-200 flex items-center justify-between bg-amber-50">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">👑</span>
                                    <h2 class="text-xl font-heading tracking-wider text-stone-900">Royal Feast Cart</h2>
                                </div>
                                <button wire:click="toggleCart" class="text-stone-500 hover:text-red-600 p-2 transition-colors cursor-pointer">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Content / Cart Items -->
                            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-3.5">
                                @forelse($cart as $key => $item)
                                    <div class="bg-amber-50/60 p-4 rounded-2xl border border-amber-200 flex items-center justify-between gap-4 shadow-xs">
                                        <div class="flex-1">
                                            <h4 class="font-heading tracking-wide text-stone-900 text-lg leading-tight">{{ $item['name'] }}</h4>
                                            <div class="flex flex-wrap gap-1.5 mt-1">
                                                @if($item['size_label'])
                                                    <span class="px-2 py-0.5 text-[10px] bg-white border border-amber-300 rounded text-amber-900 font-bold">
                                                        {{ $item['size_label'] }}
                                                    </span>
                                                @endif
                                                @if($item['spice'])
                                                    <span class="px-2 py-0.5 text-[10px] bg-red-100 border border-red-300 rounded text-red-700 font-bold">
                                                        🔥 {{ $item['spice'] }}
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm font-extrabold text-red-600 mt-2">
                                                Rs. {{ number_format($item['price'], 0) }}
                                            </p>
                                        </div>
                                        
                                        <!-- Quantity Adjustment & Delete -->
                                        <div class="flex flex-col items-end gap-2.5">
                                            <!-- Actions -->
                                            <button wire:click="removeFromCart('{{ $key }}')" class="text-stone-400 hover:text-red-600 transition-colors cursor-pointer" title="Remove Item">
                                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            
                                            <!-- Quantity Toggler -->
                                            <div class="flex items-center bg-white border-2 border-amber-300 rounded-xl overflow-hidden shadow-xs">
                                                <button 
                                                    wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})" 
                                                    class="px-2.5 py-1 hover:bg-amber-100 text-stone-700 hover:text-stone-900 transition-colors font-bold cursor-pointer"
                                                >-</button>
                                                <span class="px-3 text-xs font-extrabold text-stone-900">{{ $item['quantity'] }}</span>
                                                <button 
                                                    wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})" 
                                                    class="px-2.5 py-1 hover:bg-amber-100 text-stone-700 hover:text-stone-900 transition-colors font-bold cursor-pointer"
                                                >+</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="h-full flex flex-col items-center justify-center text-center py-20">
                                        <span class="text-5xl block mb-3">🍽️</span>
                                        <h3 class="text-xl font-heading text-stone-900 mb-1">Your Cart is Empty</h3>
                                        <p class="text-xs text-stone-500 max-w-xs">Explore the delicious dishes in our menu and add them to your cart!</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Footer / Totals and checkout -->
                            @if(count($cart) > 0)
                                <div class="bg-amber-50/80 px-6 py-5 border-t border-amber-200 space-y-4">
                                    <div class="flex items-center justify-between text-base font-bold">
                                        <span class="text-stone-700">Subtotal</span>
                                        <span class="text-2xl font-extrabold text-red-600">Rs. {{ number_format($this->getSubtotal(), 0) }}</span>
                                    </div>
                                    <p class="text-[11px] text-stone-500">Free delivery across Okara. Delivery details confirmed on checkout.</p>
                                    <div class="grid grid-cols-2 gap-2.5">
                                        <button 
                                            wire:click="clearCart"
                                            class="w-full bg-white border-2 border-stone-300 hover:border-red-400 text-stone-700 hover:text-red-600 font-bold py-3 px-4 rounded-2xl text-xs uppercase tracking-wider transition-all duration-300 cursor-pointer text-center"
                                        >
                                            Clear Cart
                                        </button>
                                        <button 
                                            wire:click="openCheckout"
                                            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-extrabold py-3 px-4 rounded-2xl text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-green-600/30 hover:shadow-lg cursor-pointer text-center"
                                        >
                                            Order Checkout
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- CHECKOUT MODAL POPUP (LIGHT THEME) -->
    @if($checkoutOpen)
        <div class="fixed inset-0 z-55 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div wire:click="closeCheckout" class="fixed inset-0 bg-stone-900/60 backdrop-blur-xs transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel content -->
                <div class="relative inline-block transform overflow-hidden rounded-3xl bg-white border-2 border-amber-300 text-left align-middle shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    
                    <!-- Header -->
                    <div class="bg-amber-50 px-6 py-4 border-b border-amber-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">👑</span>
                            <h3 class="text-xl font-heading tracking-wider text-stone-900" id="modal-title">
                                Complete Your Royal Order
                            </h3>
                        </div>
                        <button wire:click="closeCheckout" class="text-stone-400 hover:text-red-600 p-1.5 transition-colors cursor-pointer">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Fields -->
                    <form wire:submit.prevent="checkout" class="px-6 py-6 space-y-4">
                        
                        <!-- Customer Name -->
                        <div>
                            <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1">Your Name *</label>
                            <input 
                                wire:model="customerName" 
                                type="text" 
                                placeholder="Enter your full name" 
                                class="w-full bg-stone-50 border @error('customerName') border-red-500 @else border-stone-300 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-amber-500 font-medium text-sm"
                            />
                            @error('customerName')
                                <p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Phone -->
                        <div>
                            <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1">Contact Mobile Number *</label>
                            <input 
                                wire:model="customerPhone" 
                                type="text" 
                                placeholder="e.g. 03118484987" 
                                class="w-full bg-stone-50 border @error('customerPhone') border-red-500 @else border-stone-300 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-amber-500 font-medium text-sm"
                            />
                            @error('customerPhone')
                                <p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Type Select -->
                        <div>
                            <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1">Order Type *</label>
                            <select 
                                wire:model.live="orderType" 
                                class="w-full bg-stone-50 border border-stone-300 rounded-xl py-2.5 px-3 text-stone-800 focus:outline-none focus:border-amber-500 font-medium text-sm cursor-pointer"
                            >
                                <option value="delivery">🛵 Home Delivery (Okara City - Free Delivery)</option>
                                <option value="takeaway">🛍️ Takeaway (Pick Up from Akbar Road)</option>
                                <option value="dine_in">🍽️ Dine-In (Table at the Restaurant)</option>
                            </select>
                            @error('orderType')
                                <p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address Input (only if orderType is delivery) -->
                        @if($orderType === 'delivery')
                            <div class="animate-fadeIn">
                                <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1">Delivery Address in Okara *</label>
                                <textarea 
                                    wire:model="customerAddress" 
                                    rows="2"
                                    placeholder="House/Street, Colony or Landmark in Okara" 
                                    class="w-full bg-stone-50 border @error('customerAddress') border-red-500 @else border-stone-300 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-amber-500 font-medium text-sm"
                                ></textarea>
                                @error('customerAddress')
                                    <p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Special Notes -->
                        <div>
                            <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1">Special Instructions (Optional)</label>
                            <textarea 
                                wire:model="specialNotes" 
                                rows="2"
                                placeholder="Spice preferences, extra napkins, etc." 
                                class="w-full bg-stone-50 border border-stone-300 rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-amber-500 font-medium text-sm"
                            ></textarea>
                        </div>

                        <!-- Order Summary Mini Card -->
                        <div class="bg-amber-50/70 p-4 rounded-2xl border border-amber-200 space-y-1.5 text-xs text-stone-700">
                            <div class="flex justify-between font-bold text-stone-900 text-sm border-b border-amber-200 pb-1.5 mb-1">
                                <span>Order Summary</span>
                                <span class="text-red-600 font-extrabold">Rs. {{ number_format($this->getSubtotal(), 0) }}</span>
                            </div>
                            @foreach($cart as $item)
                                <div class="flex justify-between">
                                    <span>{{ $item['name'] }} @if($item['size_label']) ({{ $item['size_label'] }}) @endif x{{ $item['quantity'] }}</span>
                                    <span class="font-bold">Rs. {{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 border-t border-stone-200 flex justify-end gap-3">
                            <button 
                                type="button" 
                                wire:click="closeCheckout"
                                class="px-5 py-2.5 rounded-xl border border-stone-300 hover:bg-stone-100 text-stone-700 text-xs font-bold uppercase tracking-wider transition-all duration-300 cursor-pointer"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-extrabold rounded-xl text-xs uppercase tracking-wider transition-all duration-300 shadow-md shadow-green-600/30 hover:shadow-lg cursor-pointer flex items-center gap-2"
                            >
                                <svg class="h-4.5 w-4.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.517 2.266 2.27 3.51 5.284 3.508 8.49-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.27-5.466l.374.223c1.6.952 3.79 1.453 6.022 1.454 5.928 0 10.75-4.82 10.756-10.757.002-2.877-1.116-5.582-3.149-7.619C18.257 1.814 15.557.7 12.7.7 6.772.7 1.95 5.52 1.944 11.459c-.002 2.112.553 4.177 1.609 5.972l.243.415-1.061 3.873 3.968-1.042zM17.447 14.3c-.3-.15-1.782-.88-2.057-.98-.275-.1-.475-.15-.675.15-.2.3-.775.98-.95 1.18-.175.2-.35.225-.65.075-.3-.15-1.264-.467-2.407-1.485-.89-.795-1.49-1.777-1.665-2.077-.175-.3-.018-.462.13-.61.135-.135.3-.35.45-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.625-.925-2.225-.244-.589-.493-.509-.675-.518-.175-.009-.375-.01-.575-.01-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5 0 1.475 1.075 2.9 1.225 3.1.15.2 2.11 3.22 5.11 4.52.714.31 1.272.495 1.708.634.717.228 1.368.196 1.884.119.575-.085 1.78-.727 2.03-1.43.25-.702.25-1.3.175-1.43-.075-.13-.275-.205-.575-.355z"/>
                                </svg>
                                Send Order on WhatsApp
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif

</div>

</div>
