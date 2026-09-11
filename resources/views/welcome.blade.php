<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NFC - Nawabi Food Corner | Royal Taste, Every Bite</title>

        <!-- Dynamic Asset Compilation via Vite (Tailwind v4) -->
        @vite(['resources/css/app.css'])
        
        <!-- Livewire Styles (Handled automatically, but registered safely) -->
        @livewireStyles
    </head>
    <body class="bg-food-pattern text-stone-800 antialiased select-none font-sans overflow-x-hidden min-h-screen">

        <!-- STICKY GLASSMORPHIC LIGHT NAVBAR -->
        <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-amber-200/80 px-4 lg:px-8 py-3 transition-all duration-300 shadow-sm">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                
                <!-- Brand Title / Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo_circular.png') }}" alt="NFC Nawabi Food Corner Logo" class="h-11 md:h-13 w-auto object-contain rounded-full border-2 border-amber-400 bg-white p-0.5 shadow-md shadow-amber-500/10 group-hover:scale-105 group-hover:border-red-500 transition-all duration-300">
                    <div class="flex flex-col justify-center leading-none">
                        <span class="text-xl md:text-2xl font-heading tracking-widest text-amber-900 group-hover:text-red-600 transition-colors duration-300">
                            NAWABI FOOD CORNER
                        </span>
                        <span class="text-[10px] text-red-600 uppercase tracking-wider font-extrabold mt-0.5">
                            NFC • Okara Branch
                        </span>
                    </div>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-6 text-xs lg:text-sm font-bold tracking-wider uppercase text-stone-700">
                    <a href="#about" class="hover:text-amber-600 transition-colors duration-300">About Us</a>
                    <a href="#menu" class="hover:text-amber-600 transition-colors duration-300">Menu & Deals</a>
                    <a href="#reserve" class="hover:text-amber-600 transition-colors duration-300">Book Table</a>
                    <a href="#contact" class="hover:text-amber-600 transition-colors duration-300">Contact & Location</a>
                </div>

                <!-- Call to Action -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <a 
                        href="tel:03118484987" 
                        class="hidden sm:inline-flex items-center gap-1.5 text-xs font-extrabold text-amber-950 bg-amber-100/90 border border-amber-300 px-3.5 py-2 rounded-xl hover:bg-amber-400 hover:text-white transition-all duration-300 cursor-pointer shadow-xs"
                    >
                        📞 0311-8484987
                    </a>
                    <a 
                        href="/admin" 
                        class="bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider shadow-md shadow-red-600/20 hover:shadow-lg hover:shadow-red-600/40 transition-all duration-300 cursor-pointer"
                    >
                        Portal Login
                    </a>
                </div>

            </div>
        </nav>

        <!-- HERO SECTION WITH LIGHT WARM BACKGROUND & FLOATING FOOD ELEMENTS -->
        <header class="relative py-16 md:py-28 flex items-center justify-center overflow-hidden border-b border-amber-200/60">
            <!-- Glowing Sunburst Backdrop Circles -->
            <div class="absolute top-1/4 left-1/6 w-96 h-96 bg-amber-300/20 rounded-full blur-[90px] pointer-events-none"></div>
            <div class="absolute bottom-1/4 right-1/6 w-96 h-96 bg-red-400/15 rounded-full blur-[90px] pointer-events-none"></div>

            <!-- FLOATING FAST FOOD DECORATIONS -->
            <!-- Floating Pizza Slice (Top Left) -->
            <div class="hidden lg:flex absolute top-12 left-10 xl:left-20 flex-col items-center animate-float-slow-left pointer-events-none z-0">
                <div class="w-16 h-16 xl:w-20 xl:h-20 bg-white/90 rounded-2xl shadow-xl shadow-amber-900/10 border-2 border-amber-200 flex items-center justify-center text-3xl xl:text-4xl">
                    🍕
                </div>
                <span class="mt-1 text-[10px] font-extrabold uppercase tracking-widest bg-amber-500 text-white px-2 py-0.5 rounded-full shadow-xs">Pizza</span>
            </div>

            <!-- Floating Zinger Burger (Top Right) -->
            <div class="hidden lg:flex absolute top-16 right-10 xl:right-24 flex-col items-center animate-float-slow-right pointer-events-none z-0">
                <div class="w-16 h-16 xl:w-20 xl:h-20 bg-white/90 rounded-2xl shadow-xl shadow-amber-900/10 border-2 border-amber-200 flex items-center justify-center text-3xl xl:text-4xl">
                    🍔
                </div>
                <span class="mt-1 text-[10px] font-extrabold uppercase tracking-widest bg-red-600 text-white px-2 py-0.5 rounded-full shadow-xs">Burger</span>
            </div>

            <!-- Floating Fries (Bottom Left) -->
            <div class="hidden md:flex absolute bottom-8 left-8 xl:left-24 flex-col items-center animate-food-bounce pointer-events-none z-0">
                <div class="w-14 h-14 xl:w-16 xl:h-16 bg-white/90 rounded-2xl shadow-lg shadow-amber-900/10 border-2 border-amber-200 flex items-center justify-center text-2xl xl:text-3xl">
                    🍟
                </div>
                <span class="mt-1 text-[9px] font-extrabold uppercase tracking-widest bg-yellow-500 text-stone-900 px-2 py-0.5 rounded-full shadow-xs">Fries</span>
            </div>

            <!-- Floating Chicken Drumstick (Bottom Right) -->
            <div class="hidden md:flex absolute bottom-10 right-8 xl:right-28 flex-col items-center animate-float-slow-rotate pointer-events-none z-0">
                <div class="w-14 h-14 xl:w-16 xl:h-16 bg-white/90 rounded-2xl shadow-lg shadow-amber-900/10 border-2 border-amber-200 flex items-center justify-center text-2xl xl:text-3xl">
                    🍗
                </div>
                <span class="mt-1 text-[9px] font-extrabold uppercase tracking-widest bg-amber-600 text-white px-2 py-0.5 rounded-full shadow-xs">Wings</span>
            </div>

            <!-- Floating Shawarma / Doner Wrap (Center Left) -->
            <div class="hidden xl:flex absolute top-1/2 -translate-y-1/2 left-6 flex-col items-center animate-float-slow-rotate pointer-events-none z-0">
                <div class="w-14 h-14 bg-white/90 rounded-2xl shadow-lg shadow-amber-900/10 border-2 border-amber-200 flex items-center justify-center text-2xl">
                    🌯
                </div>
                <span class="mt-1 text-[9px] font-extrabold uppercase tracking-widest bg-amber-700 text-white px-2 py-0.5 rounded-full shadow-xs">Doner</span>
            </div>

            <!-- Floating Cold Drink (Center Right) -->
            <div class="hidden xl:flex absolute top-1/2 -translate-y-1/2 right-6 flex-col items-center animate-float-slow-left pointer-events-none z-0">
                <div class="w-14 h-14 bg-white/90 rounded-2xl shadow-lg shadow-amber-900/10 border-2 border-amber-200 flex items-center justify-center text-2xl">
                    🥤
                </div>
                <span class="mt-1 text-[9px] font-extrabold uppercase tracking-widest bg-cyan-600 text-white px-2 py-0.5 rounded-full shadow-xs">Drinks</span>
            </div>

            <div class="max-w-4xl mx-auto text-center px-4 relative z-10">
                
                <!-- Free Delivery & Welcome Badges -->
                <div class="flex flex-wrap justify-center items-center gap-3 mb-6">
                    <div class="inline-flex items-center gap-2 bg-red-100 border border-red-300 px-4 py-1.5 rounded-full shadow-xs">
                        <span class="text-base">🛵</span>
                        <span class="text-xs font-extrabold text-red-600 uppercase tracking-wider">Free Home Delivery</span>
                    </div>
                    <div class="inline-flex bg-amber-100 border border-amber-300 px-4 py-1.5 rounded-full shadow-xs">
                        <p class="font-urdu text-sm md:text-base text-amber-900 font-bold tracking-wide leading-relaxed">
                            آؤ خوشیاں بانٹیں، لذیذ کھانا کھائیں! 👑
                        </p>
                    </div>
                </div>

                <!-- Royal Brand Logo Banner -->
                <div class="flex justify-center mb-5">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-amber-400/30 rounded-full blur-xl group-hover:bg-amber-400/50 transition-all duration-500 scale-95 pointer-events-none"></div>
                        <img 
                            src="{{ asset('images/logo_circular.png') }}" 
                            alt="NFC Nawabi Food Corner Emblem" 
                            class="h-32 w-32 md:h-44 md:w-44 rounded-full relative z-10 border-4 border-amber-400 shadow-2xl shadow-amber-900/15 group-hover:scale-105 group-hover:border-red-500 transition-all duration-500 bg-white p-1 object-contain"
                        >
                    </div>
                </div>

                <!-- Brand Main Title -->
                <h1 class="text-4xl sm:text-6xl md:text-7xl font-heading text-stone-900 tracking-widest mb-2">
                    NAWABI FOOD CORNER
                </h1>
                
                <!-- Slogan with Red & Gold Badge Banner -->
                <div class="inline-block bg-gradient-to-r from-red-600 via-amber-500 to-red-600 text-white font-extrabold uppercase tracking-[0.25em] text-sm md:text-xl py-1.5 px-6 rounded-full shadow-md mb-4 font-sans">
                    Royal Taste, Every Bite
                </div>

                <!-- Small Tag -->
                <p class="text-sm md:text-base text-stone-600 max-w-2xl mx-auto mb-8 leading-relaxed font-sans font-medium">
                    Okara's favorite destination for Special Flavours Pizza, Stuffed & Crown Crusts, Turkish Doners, Crispy Zinger Burgers, Wings, Platters, Spin Rolls, Pasta, and 33+ Value Mega Deals!
                </p>

                <!-- Contact phone pills -->
                <div class="flex flex-wrap justify-center items-center gap-2.5 mb-8 text-xs font-extrabold">
                    <a href="tel:03118484987" class="bg-white border-2 border-amber-300 text-stone-800 hover:border-red-500 hover:text-red-600 px-4 py-2 rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                        📞 0311-8484987
                    </a>
                    <a href="tel:03398484987" class="bg-white border-2 border-amber-300 text-stone-800 hover:border-red-500 hover:text-red-600 px-4 py-2 rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                        📞 0339-8484987
                    </a>
                    <span class="bg-amber-100/80 border-2 border-amber-300 text-amber-950 px-4 py-2 rounded-xl shadow-xs flex items-center gap-1.5">
                        📍 Akbar Road Near Rahman Garden, Okara
                    </span>
                </div>

                <!-- Hero Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a 
                        href="#menu" 
                        class="w-full sm:w-auto bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold uppercase tracking-wider px-8 py-3.5 rounded-2xl shadow-lg shadow-red-600/25 hover:shadow-xl hover:shadow-red-600/40 transition-all duration-300 hover:-translate-y-0.5 cursor-pointer text-center text-sm"
                    >
                        🍕 Explore Menu & Deals
                    </a>
                    <a 
                        href="#reserve" 
                        class="w-full sm:w-auto bg-white border-2 border-amber-400 hover:bg-amber-500 hover:text-white text-stone-800 font-bold uppercase tracking-wider px-8 py-3.5 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 cursor-pointer text-center text-sm shadow-md shadow-amber-900/5"
                    >
                        🪑 Book A Table
                    </a>
                </div>
            </div>
        </header>

        <!-- BRAND VALUE HIGHLIGHTS IN LIGHT THEME -->
        <section id="about" class="py-16 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    
                    <!-- Value 1 -->
                    <div class="bg-white border-2 border-amber-200/80 p-6 rounded-3xl text-center group hover:border-amber-400 hover:shadow-xl transition-all duration-300 shadow-md shadow-amber-900/5">
                        <div class="w-14 h-14 mx-auto mb-3 bg-amber-100 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                            👑
                        </div>
                        <h4 class="text-lg font-heading tracking-wider text-stone-900 mb-1">Royal Taste</h4>
                        <p class="text-xs text-stone-600 leading-relaxed font-sans">
                            Handcrafted pizzas, gourmet burgers, and secret spiced wings made fresh on order.
                        </p>
                    </div>

                    <!-- Value 2 -->
                    <div class="bg-white border-2 border-amber-200/80 p-6 rounded-3xl text-center group hover:border-amber-400 hover:shadow-xl transition-all duration-300 shadow-md shadow-amber-900/5">
                        <div class="w-14 h-14 mx-auto mb-3 bg-red-100 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                            🛵
                        </div>
                        <h4 class="text-lg font-heading tracking-wider text-stone-900 mb-1">Fast & Free Delivery</h4>
                        <p class="text-xs text-stone-600 leading-relaxed font-sans">
                            Hot, piping-fresh food delivered swiftly right to your doorstep anywhere in Okara.
                        </p>
                    </div>

                    <!-- Value 3 -->
                    <div class="bg-white border-2 border-amber-200/80 p-6 rounded-3xl text-center group hover:border-amber-400 hover:shadow-xl transition-all duration-300 shadow-md shadow-amber-900/5">
                        <div class="w-14 h-14 mx-auto mb-3 bg-yellow-100 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                            🔥
                        </div>
                        <h4 class="text-lg font-heading tracking-wider text-stone-900 mb-1">Mega Buster Deals</h4>
                        <p class="text-xs text-stone-600 leading-relaxed font-sans">
                            33+ special combos and mega deals designed for single diners, couples, and grand parties.
                        </p>
                    </div>

                    <!-- Value 4 -->
                    <div class="bg-white border-2 border-amber-200/80 p-6 rounded-3xl text-center group hover:border-amber-400 hover:shadow-xl transition-all duration-300 shadow-md shadow-amber-900/5">
                        <div class="w-14 h-14 mx-auto mb-3 bg-green-100 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                            ❤️
                        </div>
                        <h4 class="text-lg font-heading tracking-wider text-stone-900 mb-1">Family Ambience</h4>
                        <p class="text-xs text-stone-600 leading-relaxed font-sans">
                            Clean, comfortable, and air-conditioned dining halls perfect for family gatherings.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- DYNAMIC MENU SEARCH & EXPLORER (LIGHT THEME) -->
        <section id="menu" class="relative scroll-mt-16 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 bg-amber-100 border border-amber-300 px-4 py-1 rounded-full mb-3">
                    <span class="text-xs font-bold text-amber-800 uppercase tracking-widest">🍕 Live Ordering System</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-heading tracking-widest text-stone-900 mb-2">
                    Our Fast Food & Royal Menu
                </h2>
                <p class="text-sm md:text-base text-stone-600 max-w-xl mx-auto mb-6 font-sans">
                    Explore all 17 categories, customize your portion sizes, and order instantly with express WhatsApp checkout!
                </p>
            </div>
            
            <!-- Embedded Livewire menu explorer -->
            <livewire:menu-explorer />
        </section>

        <!-- TABLE RESERVATION FORM (LIGHT THEME) -->
        <section id="reserve" class="py-16 relative scroll-mt-16">
            <!-- Embedded Livewire reservation engine -->
            <livewire:reservation-form />
        </section>

        <!-- CONTACT, HOURS & MAP SECTION -->
        <section id="contact" class="py-16 relative scroll-mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    <!-- Text Details Card -->
                    <div class="bg-white border-2 border-amber-200 p-8 md:p-10 rounded-3xl shadow-xl shadow-amber-900/5 flex flex-col justify-center">
                        <div class="inline-flex items-center gap-2 bg-red-100 border border-red-300 px-3 py-1 rounded-full mb-3 w-fit">
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">📍 Dine-In & Takeaway</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-heading tracking-widest text-stone-900 mb-2">
                            Nawabi Food Corner Okara
                        </h2>
                        <p class="text-sm text-stone-600 leading-relaxed mb-6 font-sans">
                            Drop by with your friends and family or call our order desks for hot food deliveries across Okara city.
                        </p>

                        <div class="space-y-5 font-sans">
                            <!-- Address detail -->
                            <div class="flex items-start gap-3.5">
                                <span class="text-2xl bg-amber-100 p-2 rounded-xl text-amber-800">📍</span>
                                <div>
                                    <h5 class="text-xs font-extrabold text-stone-900 uppercase tracking-wider">Branch Address</h5>
                                    <p class="text-sm text-stone-700 mt-0.5 font-medium">Akbar Road Near Rahman Garden, Okara, Punjab, Pakistan.</p>
                                </div>
                            </div>

                            <!-- Phone order desk -->
                            <div class="flex items-start gap-3.5">
                                <span class="text-2xl bg-red-100 p-2 rounded-xl text-red-600">📞</span>
                                <div>
                                    <h5 class="text-xs font-extrabold text-stone-900 uppercase tracking-wider">Order Desks (Free Fast Delivery)</h5>
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        <a href="tel:03118484987" class="text-xs font-bold text-stone-900 bg-amber-50 border border-amber-300 hover:bg-amber-400 hover:text-white px-3 py-1.5 rounded-lg transition-colors">📞 0311-8484987</a>
                                        <a href="tel:03398484987" class="text-xs font-bold text-stone-900 bg-amber-50 border border-amber-300 hover:bg-amber-400 hover:text-white px-3 py-1.5 rounded-lg transition-colors">📞 0339-8484987</a>
                                        <a href="tel:03112233570" class="text-xs font-bold text-red-700 bg-red-50 border border-red-300 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded-lg transition-colors">⚠️ Complaint: 0311-2233570</a>
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp direct order -->
                            <div class="flex items-start gap-3.5">
                                <span class="text-2xl bg-green-100 p-2 rounded-xl text-green-600">💬</span>
                                <div>
                                    <h5 class="text-xs font-extrabold text-stone-900 uppercase tracking-wider">Direct WhatsApp</h5>
                                    <a href="https://wa.me/923118484987" target="_blank" class="inline-flex items-center gap-1 text-sm font-bold text-green-700 hover:text-green-800 mt-0.5">
                                        Chat & Order on WhatsApp: 0311-8484987 &rarr;
                                    </a>
                                </div>
                            </div>

                            <!-- Opening Hours -->
                            <div class="flex items-start gap-3.5">
                                <span class="text-2xl bg-yellow-100 p-2 rounded-xl text-yellow-800">🕒</span>
                                <div>
                                    <h5 class="text-xs font-extrabold text-stone-900 uppercase tracking-wider">Service Hours</h5>
                                    <p class="text-sm text-stone-700 mt-0.5">Monday - Sunday: 12:00 PM - 02:00 AM (Daily Non-Stop)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Frame in Warm Light Theme -->
                    <div class="rounded-3xl overflow-hidden border-2 border-amber-200 bg-white shadow-xl shadow-amber-900/5 aspect-square sm:aspect-video lg:aspect-auto flex flex-col items-center justify-center p-8 text-center">
                        <div class="w-16 h-16 bg-amber-100 rounded-3xl flex items-center justify-center text-3xl mb-3 shadow-xs">
                            🗺️
                        </div>
                        <h4 class="text-2xl font-heading text-stone-900 mb-1">NFC Food Corner Okara</h4>
                        <p class="text-xs text-stone-600 max-w-sm mb-5 font-sans">
                            Located conveniently on Akbar Road Near Rahman Garden, Okara.
                        </p>
                        <a 
                            href="https://maps.google.com/?q=Akbar+Road+Okara" 
                            target="_blank"
                            class="inline-flex items-center gap-2 text-xs font-extrabold text-white bg-amber-600 hover:bg-amber-700 px-6 py-3 rounded-2xl transition-all duration-300 cursor-pointer uppercase tracking-wider shadow-md shadow-amber-600/20"
                        >
                            Open Google Maps Direction
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- SYSTEM FOOTER IN WARM LIGHT THEME -->
        <footer class="py-12 bg-white border-t border-amber-200 font-sans">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <div class="flex flex-col items-center mb-4">
                    <img src="{{ asset('images/logo_circular.png') }}" alt="NFC Logo" class="h-16 w-auto mb-2 object-contain rounded-full border-2 border-amber-400 bg-white p-0.5 shadow-sm">
                    <p class="text-2xl font-heading tracking-widest text-stone-900">NAWABI FOOD CORNER</p>
                    <span class="text-xs font-bold text-red-600 tracking-widest uppercase">ROYAL TASTE, EVERY BITE</span>
                </div>
                <p class="font-urdu text-sm text-amber-900 font-bold mb-5">آؤ خوشیاں بانٹیں، لذیذ کھانا کھائیں! 👑</p>
                
                <div class="flex justify-center flex-wrap gap-6 mb-8 text-xs font-bold text-stone-600 uppercase tracking-wider">
                    <a href="#about" class="hover:text-amber-600 transition-colors duration-300">About Us</a>
                    <a href="#menu" class="hover:text-amber-600 transition-colors duration-300">Menu & Deals</a>
                    <a href="#reserve" class="hover:text-amber-600 transition-colors duration-300">Book Seat</a>
                    <a href="#contact" class="hover:text-amber-600 transition-colors duration-300">Contact Us</a>
                </div>
                
                <div class="border-t border-amber-100 pt-5 mt-5">
                    <p class="text-xs text-stone-500 mb-2">
                        &copy; {{ date('Y') }} NFC - Nawabi Food Corner Okara. All Rights Reserved.
                    </p>
                    <p class="text-xs text-stone-600 font-medium">
                        Software designed and developed by <span class="font-bold text-stone-800">MNS Technologies and consultant</span> | <a href="tel:03476824180" class="text-amber-700 hover:text-amber-800 font-mono font-bold">0347-6824180</a>
                    </p>
                </div>
            </div>
        </footer>

        <!-- Livewire Scripts (Handled automatically, registered safely) -->
        @livewireScripts
    </body>
</html>
