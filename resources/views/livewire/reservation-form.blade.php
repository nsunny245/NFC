<div class="w-full max-w-2xl mx-auto px-4">
    <div class="bg-white border-2 border-amber-300 p-8 md:p-10 rounded-3xl shadow-2xl shadow-amber-900/10">
        
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-2 bg-amber-100 border border-amber-300 px-3.5 py-1 rounded-full mb-2">
                <span class="text-xs font-bold text-amber-900 uppercase tracking-widest">🪑 Table Booking</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-heading tracking-wider text-stone-900 mb-1">
                Reserve A Royal Table
            </h2>
            <p class="text-xs md:text-sm text-stone-600 font-sans">
                Experience exceptional fast food dining & warm hospitality at NFC - Nawabi Food Corner Okara.
            </p>
        </div>

        @if($successMessage)
            <div class="mb-8 p-5 bg-green-50 border-2 border-green-300 rounded-2xl flex gap-3 text-green-800">
                <svg class="h-6 w-6 shrink-0 mt-0.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-xs md:text-sm font-semibold">
                    {{ $successMessage }}
                </div>
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-5 font-sans">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Guest Name -->
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1.5">Full Name *</label>
                    <input 
                        wire:model="guest_name" 
                        type="text" 
                        placeholder="e.g. Muhammad Ali"
                        class="w-full bg-stone-50 border @error('guest_name') border-red-500 focus:border-red-500 @else border-stone-300 focus:border-amber-500 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none text-sm font-medium transition-all"
                    />
                    @error('guest_name') 
                        <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Guest Phone -->
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1.5">Mobile Number *</label>
                    <input 
                        wire:model="guest_phone" 
                        type="text" 
                        placeholder="0311-8484987"
                        class="w-full bg-stone-50 border @error('guest_phone') border-red-500 focus:border-red-500 @else border-stone-300 focus:border-amber-500 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none text-sm font-medium transition-all"
                    />
                    @error('guest_phone') 
                        <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Guest Email -->
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1.5">Email Address (Optional)</label>
                    <input 
                        wire:model="guest_email" 
                        type="email" 
                        placeholder="yourname@example.com"
                        class="w-full bg-stone-50 border @error('guest_email') border-red-500 focus:border-red-500 @else border-stone-300 focus:border-amber-500 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none text-sm font-medium transition-all"
                    />
                    @error('guest_email') 
                        <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Guest Count -->
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1.5">Number of Guests *</label>
                    <select 
                        wire:model="guest_count" 
                        class="w-full bg-stone-50 border @error('guest_count') border-red-500 focus:border-red-500 @else border-stone-300 focus:border-amber-500 @enderror rounded-xl py-2.5 px-3 text-stone-800 text-sm font-medium focus:outline-none cursor-pointer"
                    >
                        @for($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                        @endfor
                        <option value="25">20-25 (Large Family)</option>
                        <option value="30">25-30 (Party / Celebration)</option>
                    </select>
                    @error('guest_count') 
                        <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Reservation Date -->
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1.5">Reservation Date *</label>
                    <input 
                        wire:model="reservation_date" 
                        type="date" 
                        class="w-full bg-stone-50 border @error('reservation_date') border-red-500 focus:border-red-500 @else border-stone-300 focus:border-amber-500 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 text-sm font-medium focus:outline-none transition-all"
                    />
                    @error('reservation_date') 
                        <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Reservation Time -->
                <div>
                    <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1.5">Dining Time *</label>
                    <input 
                        wire:model="reservation_time" 
                        type="time" 
                        class="w-full bg-stone-50 border @error('reservation_time') border-red-500 focus:border-red-500 @else border-stone-300 focus:border-amber-500 @enderror rounded-xl py-2.5 px-3.5 text-stone-800 text-sm font-medium focus:outline-none transition-all"
                    />
                    @error('reservation_time') 
                        <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

            </div>

            <!-- Special Requests -->
            <div>
                <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider mb-1.5">Special Requests / Preferences</label>
                <textarea 
                    wire:model="special_requests" 
                    rows="2" 
                    placeholder="e.g. Birthday celebrations, quiet family corner, high chair for kids..."
                    class="w-full bg-stone-50 border border-stone-300 rounded-xl py-2.5 px-3.5 text-stone-800 placeholder-stone-400 focus:outline-none focus:border-amber-500 text-sm font-medium transition-all resize-none"
                ></textarea>
                @error('special_requests') 
                    <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full inline-flex justify-center items-center gap-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-3.5 px-6 rounded-2xl text-xs font-extrabold uppercase tracking-wider transition-all duration-300 shadow-lg shadow-red-600/25 hover:shadow-xl hover:shadow-red-600/40 hover:-translate-y-0.5 disabled:opacity-50 disabled:translate-y-0 cursor-pointer"
                >
                    <span wire:loading.remove wire:target="submit">🪑 Confirm Table Reservation</span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Securing Reservation...
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>
