<?php

namespace App\Filament\Pos\Pages;

use App\Models\MenuItem;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Expense;
use App\Models\PosSetting;
use App\Models\User;
use Filament\Pages\Page;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class POSDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string $view = 'filament.pos.pages.p-o-s-dashboard';

    protected static string $layout = 'filament-panels::components.layout.base';

    protected static ?string $title = 'Interactive Cashier POS Dashboard';

    public static function getRoutePath(): string
    {
        return '/';
    }

    // CLIENT-APPROVED SPA SCREENS: 'setup', 'menu', 'payment', 'confirmation'
    public $posScreen = 'menu';
    public $notificationsOpen = false;

    // Catalog & Filters
    public $search = '';
    public $selectedCategoryId = null;
    
    // Cart Data
    public $cart = [];
    public $subtotal = 0;
    public $taxRate = 16.00; // 16% GST
    public $taxAmount = 0;
    public $discountAmount = 0;
    public $serviceCharge = 0;
    public $total = 0;

    // Dynamic Admin Financial Settings
    public $isVatEnabled = true;
    public $vatLabel = 'GST Tax (16%)';
    public $isServiceFeeEnabled = false;
    public $serviceFeeRate = 5.00;
    public $isCardEnabled = true;
    public $cardFeeRate = 0.00;
    public $cardTerminalName = 'Bank POS / Cards';

    // Order Specifications
    public $orderType = 'dine_in'; // 'dine_in', 'takeaway', 'delivery'
    public $selectedTable = null;
    public $customerName = '';
    public $customerPhone = '';
    public $customerAddress = '';
    public $riderName = '';
    public $customerType = 'regular'; // 'regular', 'vip', 'staff'
    public $specialNotes = '';
    
    // Payment Page States
    public $paymentMethod = 'cash'; // 'cash', 'card', 'easypaisa', 'jazzcash', 'bank'
    public $cashReceived = 0;
    public $changeAmount = 0;
    public $isPaymentModalOpen = false;
    public $transactionRef = '';

    // Active Order Reference
    public $activeOrderId = null;
    public $activeOrderNumber = null;
    public $kotVersion = 1;
    public $isKOTCorrected = false;
    public $kotCancellationItems = [];

    // Shift Register till parameters
    public $isShiftOpen = false;
    public $openingCash = 0;
    public $countedCash = 0;
    public $expectedCash = 0;
    public $drawerSales = 0;
    public $isShiftModalOpen = false;

    // Shift Detailed Reconciliation & Payment Breakdown
    public $shiftTotalSales = 0;
    public $shiftCashSales = 0;
    public $shiftTenderedCash = 0;
    public $shiftChangeReturned = 0;
    public $shiftCardSales = 0;
    public $shiftBankSales = 0;
    public $shiftJazzCashSales = 0;
    public $shiftEasyPaisaSales = 0;
    public $shiftTotalOrdersCount = 0;
    public $shiftExpensesTotal = 0;
    public $shiftExpensesList = [];
    public $isShiftPrintModalOpen = false;
    public $shiftClosingReportData = [];

    // Custom overlay sheets
    public $ongoingOrdersModalOpen = false;
    public $kitchenStatusModalOpen = false;
    public $seatingModalOpen = false;
    public $portionSelectionModalOpen = false;
    public $portionModalItemId = null;
    public $menuPage = 1;

    // Table inspection
    public $inspectedTableId = null;
    public $inspectedTableOrder = null;

    // Print Receipt States
    public $isReceiptModalOpen = false;
    public $receiptType = 'bill'; // 'kot', 'bill', 'rider', 'kot_correction'
    public $printedOrder = null;

    // Direct Expense Ledger Modal States
    public bool $isExpenseModalOpen = false;
    public string $expenseCategory = 'utility';
    public $expenseAmount = '';
    public string $expenseDate = '';
    public string $expenseRecipient = '';
    public string $expenseInvoiceNumber = '';
    public string $expenseDescription = '';
    public string $expensePaidFrom = 'cash_drawer';

    public function getCurrentBusinessDayDate(): string
    {
        $now = now();
        // Timing starts from 12:00 PM (noon) and closes at 1:00 AM (next morning or late night).
        // Any time before 12:00 PM (noon) belongs to the previous business day's register.
        if ($now->hour < 12) {
            return $now->copy()->subDay()->format('Y-m-d');
        }
        return $now->format('Y-m-d');
    }

    public function getBusinessDayRange(): array
    {
        $businessDay = $this->getCurrentBusinessDayDate();
        $start = \Carbon\Carbon::parse($businessDay . ' 12:00:00');
        $end = $start->copy()->addDay();
        return [$start, $end];
    }

    public function mount(): void
    {
        $this->refreshPosSettings();

        $businessDay = $this->getCurrentBusinessDayDate();
        $this->isShiftOpen = session()->get('pos_shift_open_' . $businessDay, false);
        $this->openingCash = session()->get('pos_opening_cash_' . $businessDay, 0);
        
        if ($this->isShiftOpen) {
            $this->calculateExpectedCash();
        }
    }

    public function refreshPosSettings(): void
    {
        $this->isVatEnabled = PosSetting::isVatEnabled();
        $this->taxRate = PosSetting::getVatPercentage();
        $this->vatLabel = (string)PosSetting::get('vat_label', 'GST Tax (16%)');

        $this->isServiceFeeEnabled = PosSetting::isServiceFeeEnabled();
        $this->serviceFeeRate = PosSetting::getServiceFeePercentage();

        $this->isCardEnabled = PosSetting::isCardPaymentEnabled();
        $this->cardFeeRate = PosSetting::getCardFeePercentage();
        $this->cardTerminalName = (string)PosSetting::get('card_terminal_name', 'Bank POS / Cards');
    }

    /**
     * Open the Shift Management / Close Shift modal.
     */
    public function openCloseShiftModal(): void
    {
        $this->calculateExpectedCash();
        $this->countedCash = $this->expectedCash;
        $this->isShiftModalOpen = true;
    }

    public function openNewShiftModal(): void
    {
        $this->isShiftModalOpen = true;
    }

    public function cancelShiftModal(): void
    {
        $this->isShiftModalOpen = false;
    }

    /**
     * Start the daily cashier shift.
     */
    public function openShift(): void
    {
        $businessDay = $this->getCurrentBusinessDayDate();
        session()->put('pos_shift_open_' . $businessDay, true);
        session()->put('pos_opening_cash_' . $businessDay, (float)$this->openingCash);
        
        $this->isShiftOpen = true;
        $this->isShiftModalOpen = false;
        
        $this->calculateExpectedCash();

        \Filament\Notifications\Notification::make()
            ->title('POS Shift Registered 🟢')
            ->body('Shift initialized with starting balance: Rs. ' . number_format($this->openingCash))
            ->success()
            ->send();
    }

    /**
     * Close the register till shift.
     */
    public function closeShift(): void
    {
        $businessDay = $this->getCurrentBusinessDayDate();
        $this->calculateExpectedCash();
        $discrepancy = (float)$this->countedCash - (float)$this->expectedCash;

        session()->forget(['pos_shift_open_' . $businessDay, 'pos_opening_cash_' . $businessDay]);
        
        $this->isShiftOpen = false;
        $this->isShiftModalOpen = false;

        // Open Shift Closing Report modal for thermal printing
        $this->isShiftPrintModalOpen = true;

        \Filament\Notifications\Notification::make()
            ->title('POS Shift Closed Successfully 🔒')
            ->body("Shift Gross Sales: Rs. " . number_format($this->shiftTotalSales) . " | Counted Cash: Rs. " . number_format($this->countedCash) . " | Variance: Rs. " . number_format($discrepancy))
            ->warning()
            ->send();
    }

    /**
     * Trigger shift closing report thermal print modal
     */
    public function printShiftClosingReport(): void
    {
        $this->calculateExpectedCash();
        $this->isShiftPrintModalOpen = true;
    }

    public function closeShiftPrintModal(): void
    {
        $this->isShiftPrintModalOpen = false;
    }

    public function updatedCountedCash(): void
    {
        $this->calculateExpectedCash();
    }

    /**
     * Recalculate sales ledger with complete payment methods & change breakdown.
     */
    public function calculateExpectedCash(): void
    {
        list($start, $end) = $this->getBusinessDayRange();

        $orders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $this->shiftTotalOrdersCount = $orders->count();
        $this->shiftTotalSales = (float) $orders->sum('total');

        // Cash Payments & Change Breakdown
        $cashOrders = $orders->filter(fn($o) => in_array($o->payment_method, ['cash', null, '']));
        $this->shiftCashSales = (float) $cashOrders->sum('total');
        $this->shiftTenderedCash = (float) $cashOrders->sum(fn($o) => $o->cash_received ?: $o->total);
        $this->shiftChangeReturned = (float) $cashOrders->sum(fn($o) => $o->change_returned ?: max(0, (float)$o->cash_received - (float)$o->total));

        // Digital & Bank breakdown
        $this->shiftCardSales = (float) $orders->where('payment_method', 'card')->sum('total');
        $this->shiftBankSales = (float) $orders->where('payment_method', 'bank')->sum('total');
        $this->shiftJazzCashSales = (float) $orders->where('payment_method', 'jazzcash')->sum('total');
        $this->shiftEasyPaisaSales = (float) $orders->where('payment_method', 'easypaisa')->sum('total');

        // Expenses during shift
        $expenses = Expense::whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])->get();
        $this->shiftExpensesTotal = (float) $expenses->sum('amount');
        $this->shiftExpensesList = $expenses->map(function($e) {
            return [
                'id' => $e->id,
                'category' => $e->category,
                'recipient' => $e->recipient,
                'amount' => (float)$e->amount,
                'description' => $e->description,
                'invoice_number' => $e->invoice_number,
                'time' => $e->created_at ? $e->created_at->format('h:i A') : '',
            ];
        })->toArray();

        $this->drawerSales = $this->shiftTotalSales;

        // Physical Drawer Expected Cash:
        // Starting Float + Net Cash Sales received - Expenses paid out from drawer
        $this->expectedCash = (float)$this->openingCash + $this->shiftCashSales - $this->shiftExpensesTotal;
        if ($this->expectedCash < 0) {
            $this->expectedCash = 0;
        }

        // Package report data for thermal print slip
        $this->shiftClosingReportData = [
            'cashierName' => auth()->user()?->name ?? 'Cashier',
            'businessDate' => $this->getCurrentBusinessDayDate(),
            'closedAt' => now()->format('M d, Y h:i A'),
            'openingCash' => (float)$this->openingCash,
            'totalSales' => $this->shiftTotalSales,
            'totalOrders' => $this->shiftTotalOrdersCount,
            'cashSales' => $this->shiftCashSales,
            'tenderedCash' => $this->shiftTenderedCash,
            'changeReturned' => $this->shiftChangeReturned,
            'cardSales' => $this->shiftCardSales,
            'bankSales' => $this->shiftBankSales,
            'jazzCashSales' => $this->shiftJazzCashSales,
            'easyPaisaSales' => $this->shiftEasyPaisaSales,
            'expensesTotal' => $this->shiftExpensesTotal,
            'expensesList' => $this->shiftExpensesList,
            'expectedCash' => $this->expectedCash,
            'countedCash' => (float)$this->countedCash,
            'discrepancy' => (float)$this->countedCash - (float)$this->expectedCash,
        ];
    }

    /**
     * Open Direct Expense Ledger Modal
     */
    public function openExpenseModal(): void
    {
        $this->expenseDate = now()->format('Y-m-d');
        $this->expenseCategory = 'utility';
        $this->expenseAmount = '';
        $this->expenseRecipient = '';
        $this->expenseInvoiceNumber = '';
        $this->expenseDescription = '';
        $this->expensePaidFrom = 'cash_drawer';
        $this->isExpenseModalOpen = true;
    }

    /**
     * Close Expense Modal
     */
    public function closeExpenseModal(): void
    {
        $this->isExpenseModalOpen = false;
    }

    /**
     * Validate and save expense record directly to Royal Back-Office Expenses Ledger
     */
    public function saveExpense(): void
    {
        $this->validate([
            'expenseCategory' => 'required|string|in:utility,rent,marketing,salaries,maintenance,other',
            'expenseAmount' => 'required|numeric|min:1',
            'expenseDate' => 'required|date',
            'expenseRecipient' => 'required|string|max:255',
            'expenseInvoiceNumber' => 'nullable|string|max:255',
            'expenseDescription' => 'nullable|string|max:1000',
        ], [
            'expenseCategory.required' => 'Please select an expense category.',
            'expenseAmount.required' => 'Please enter the expense amount.',
            'expenseAmount.numeric' => 'The expense amount must be a number.',
            'expenseAmount.min' => 'The expense amount must be at least Rs. 1.',
            'expenseDate.required' => 'Please select the expense date.',
            'expenseRecipient.required' => 'Please enter the payee or recipient name.',
        ]);

        $prefixNote = $this->expensePaidFrom === 'cash_drawer' ? '[POS Drawer Cash Out] ' : '[External / Owner Funds] ';
        $fullDescription = trim($prefixNote . ($this->expenseDescription ?: ''));

        $expense = Expense::create([
            'category' => $this->expenseCategory,
            'amount' => (float)$this->expenseAmount,
            'expense_date' => $this->expenseDate,
            'recipient' => $this->expenseRecipient,
            'invoice_number' => $this->expenseInvoiceNumber ?: null,
            'description' => $fullDescription,
        ]);

        // Recalculate shift expected cash balance
        $this->calculateExpectedCash();

        $this->isExpenseModalOpen = false;

        $categoryLabels = [
            'utility' => 'Utilities (Power/Gas/Water)',
            'rent' => 'Property Rent',
            'marketing' => 'Marketing & Ads',
            'salaries' => 'Staff Payroll / Bonus',
            'maintenance' => 'Repairs & Maintenance',
            'other' => 'Other Overhead Expenses',
        ];
        $categoryName = $categoryLabels[$expense->category] ?? ucwords(str_replace('_', ' ', $expense->category));

        \Filament\Notifications\Notification::make()
            ->title('Expense Voucher Recorded Successfully 🧾')
            ->body("Rs. " . number_format($expense->amount) . " logged under " . $categoryName . " to " . $expense->recipient . ". Synced to Admin Ledger.")
            ->success()
            ->send();
    }

    /**
     * Setup order type selector inside Screen 'setup'
     */
    public function selectOrderSetupType(string $type): void
    {
        $this->orderType = $type;
        $this->selectedTable = null;
    }

    /**
     * Complete Step 1 Setup and proceed to Step 2 Menu.
     */
    public function proceedToMenuCatalog(): void
    {
        if ($this->orderType === 'dine_in' && !$this->selectedTable) {
            \Filament\Notifications\Notification::make()
                ->title('Select Seating Table')
                ->body('Dine-In orders require a table assignment.')
                ->warning()
                ->send();
            return;
        }

        // Advance to Dashboard Menu screen
        $this->posScreen = 'menu';
    }

    /**
     * Set selected category ID for menu filtering.
     */
    public function selectCategory($categoryId = null): void
    {
        $this->selectedCategoryId = $categoryId;
        $this->menuPage = 1;
    }

    /**
     * Listener when the global search debounced input changes.
     */
    public function updatedSearch(): void
    {
        $this->menuPage = 1;
    }

    /**
     * Navigate back to Step 1 setup screen.
     */
    public function backToStep1(): void
    {
        $this->posScreen = 'menu';
    }

    /**
     * Update comment/instructions for a specific cart item.
     */
    public function updateItemComment(string $cartKey, string $comment): void
    {
        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['comment'] = $comment;
        }
    }

    /**
     * Add dish to active bill.
     */
    /**
     * Open portion size selection modal.
     */
    public function openPortionModal(int $itemId): void
    {
        $this->portionModalItemId = $itemId;
        $this->portionSelectionModalOpen = true;
    }

    /**
     * Add dish to active bill.
     */
    public function addToCart(int $itemId, ?string $sizeKey = null): void
    {
        $item = MenuItem::find($itemId);
        if (!$item) return;

        $price = (float)$item->price;
        $name = $item->name;

        if ($sizeKey && isset($item->details['sizes'][$sizeKey])) {
            $sizeData = $item->details['sizes'][$sizeKey];
            $price = (float)($sizeData['price'] ?? $item->price);
            $sizeLabel = $sizeData['label'] ?? ucfirst($sizeKey);
            $name .= " (" . $sizeLabel . ")";
        }

        $cartKey = $itemId . ($sizeKey ? '_' . $sizeKey : '');

        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['quantity']++;
        } else {
            $this->cart[$cartKey] = [
                'id' => $item->id,
                'cart_key' => $cartKey,
                'name' => $name,
                'price' => $price,
                'quantity' => 1,
                'size_key' => $sizeKey,
                'comment' => '',
            ];
        }

        // Auto-close portion selection parameters
        $this->portionSelectionModalOpen = false;
        $this->portionModalItemId = null;

        if ($this->activeOrderId) {
            $this->isKOTCorrected = true;
        }

        $this->recalculateCart();
    }

    /**
     * Update quantity of item in cart.
     */
    public function updateQuantity(string $cartKey, int $qty): void
    {
        if (isset($this->cart[$cartKey])) {
            if ($qty <= 0) {
                if ($this->activeOrderId) {
                    $this->kotCancellationItems[] = [
                        'name' => $this->cart[$cartKey]['name'],
                        'quantity' => $this->cart[$cartKey]['quantity'],
                    ];
                    $this->isKOTCorrected = true;
                }
                unset($this->cart[$cartKey]);
            } else {
                if ($this->activeOrderId && $qty < $this->cart[$cartKey]['quantity']) {
                    $diff = $this->cart[$cartKey]['quantity'] - $qty;
                    $this->kotCancellationItems[] = [
                        'name' => $this->cart[$cartKey]['name'],
                        'quantity' => $diff,
                    ];
                    $this->isKOTCorrected = true;
                }
                $this->cart[$cartKey]['quantity'] = $qty;
            }
        }
        $this->recalculateCart();
    }

    /**
     * Remove item.
     */
    public function removeFromCart(string $cartKey): void
    {
        if (isset($this->cart[$cartKey])) {
            if ($this->activeOrderId) {
                $this->kotCancellationItems[] = [
                    'name' => $this->cart[$cartKey]['name'],
                    'quantity' => $this->cart[$cartKey]['quantity'],
                ];
                $this->isKOTCorrected = true;
            }
            unset($this->cart[$cartKey]);
        }
        $this->recalculateCart();
    }

    /**
     * Recalculate bill sums.
     */
    public function recalculateCart(): void
    {
        $this->refreshPosSettings();

        $this->subtotal = 0;
        foreach ($this->cart as $item) {
            $this->subtotal += $item['price'] * $item['quantity'];
        }

        $this->serviceCharge = ($this->isServiceFeeEnabled && $this->orderType === 'dine_in')
            ? ($this->subtotal * ($this->serviceFeeRate / 100))
            : 0;

        $this->taxAmount = $this->isVatEnabled
            ? ($this->subtotal * ($this->taxRate / 100))
            : 0;
        
        $this->total = $this->subtotal + $this->taxAmount + $this->serviceCharge - (float)$this->discountAmount;
        if ($this->total < 0) $this->total = 0;

        // Dynamic change recalculation if cash received is entered
        $this->recalculateChange();
    }

    /**
     * Dynamically compute cashier drawer change.
     */
    public function recalculateChange(): void
    {
        $cash = (float) $this->cashReceived;
        $this->changeAmount = $cash > $this->total ? ($cash - $this->total) : 0;
    }

    /**
     * Livewire lifecycle hook for cash received input.
     */
    public function updatedCashReceived(): void
    {
        $this->recalculateChange();
    }

    /**
     * Set quick cash received amount.
     */
    public function setQuickCash(float $amount): void
    {
        $this->cashReceived = $amount;
        $this->recalculateChange();
    }

    /**
     * Set payment mode inside payment screen.
     */
    public function selectPaymentMode(string $method): void
    {
        $this->paymentMethod = $method;
        if ($method !== 'cash') {
            // For card/digital, cash received is exactly the bill total
            $this->cashReceived = $this->total;
            $this->changeAmount = 0;
        } else {
            $this->cashReceived = 0;
            $this->changeAmount = 0;
        }
    }

    /**
     * Proceed from Menu catalog to Payment check screen.
     */
    public function proceedToPayment(): void
    {
        if (count($this->cart) === 0) {
            \Filament\Notifications\Notification::make()
                ->title('Cart is empty')
                ->body('Select menu dishes before proceeding to payment.')
                ->warning()
                ->send();
            return;
        }

        if ($this->orderType === 'delivery' && (empty($this->customerPhone) || empty($this->customerAddress))) {
            \Filament\Notifications\Notification::make()
                ->title('Delivery Details Required')
                ->body('Customer phone number and delivery address are compulsory for delivery.')
                ->danger()
                ->send();
            return;
        }

        $this->cashReceived = 0;
        $this->changeAmount = 0;
        $this->paymentMethod = 'cash';
        $this->transactionRef = '';
        
        // Save current state before taking final payments (preserve preparing/ready if already cooking)
        $currentStatus = $this->activeOrderId ? (Order::find($this->activeOrderId)?->status ?? 'pending') : 'pending';
        $this->saveActiveOrder($currentStatus);

        $this->isPaymentModalOpen = true;
    }

    /**
     * Finalize checkout payment, write registers, clear tables, and show invoice prints.
     */
    public function confirmPayment(): void
    {
        // 1. Mark order completed
        $order = $this->saveActiveOrder('completed');
        if ($order) {
            $order->update(['bill_requested' => false]);
            \App\Models\InternalNotification::where('related_id', $order->id)
                ->where('type', 'bill_requested')
                ->update(['is_read' => true]);
        }

        // 2. Keep a reference for confirmation receipts
        $this->printedOrder = $order;
        $this->receiptType = 'bill';

        // 3. Close payment modal and open printed receipt modal immediately!
        $this->isPaymentModalOpen = false;
        $this->isReceiptModalOpen = true;

        \Filament\Notifications\Notification::make()
            ->title('Feast Settle Successful! 👑')
            ->body("Order #{$order->order_number} marked PAID. Receipt generated.")
            ->success()
            ->send();

        // 4. Return to setup page / clear cart to prepare for next guest
        $this->resetPOSCart();
    }

    /**
     * Place order / Dispatch KOT to kitchen.
     */
    public function placeOrder(): void
    {
        if (count($this->cart) === 0) {
            \Filament\Notifications\Notification::make()
                ->title('Cart is empty')
                ->body('Add items to cart before generating KOT.')
                ->warning()
                ->send();
            return;
        }

        if ($this->orderType === 'delivery' && (empty($this->customerPhone) || empty($this->customerAddress))) {
            \Filament\Notifications\Notification::make()
                ->title('Delivery Details Required')
                ->body('Customer phone and address are required for delivery orders.')
                ->danger()
                ->send();
            return;
        }

        $isNewOrder = is_null($this->activeOrderId);
        $order = $this->saveActiveOrder('preparing');

        if ($isNewOrder) {
            $this->kotVersion = 1;
            session()->put("kot_version_{$order->id}", 1);
            
            // Show KOT receipt
            $this->printedOrder = $order;
            $this->receiptType = 'kot';
            $this->isReceiptModalOpen = true;

            \Filament\Notifications\Notification::make()
                ->title('KOT Dispatched to Kitchen 🍳')
                ->body("KOT for Order #{$order->order_number} sent to cooking queue.")
                ->success()
                ->send();
        } else {
            // Cancel and resend updated KOT V2
            $this->cancelAndResendKOT();
        }

        // Return to setup page to prepare for next guest
        $this->resetPOSCart();
    }

    /**
     * Hold / Park the current active order to serve the next customer in queue.
     */
    public function holdOrder(): void
    {
        if (count($this->cart) === 0) {
            \Filament\Notifications\Notification::make()
                ->title('Cart is empty')
                ->body('Cannot hold an empty cart.')
                ->warning()
                ->send();
            return;
        }

        $order = $this->saveActiveOrder('pending');

        \Filament\Notifications\Notification::make()
            ->title("Order #{$order->order_number} Put on Hold ⏸️")
            ->body("Cart parked under Active Orders. You can now serve the next customer.")
            ->success()
            ->send();

        $this->resetPOSCart();
    }

    /**
     * Cancel the previous KOT and dispatch a corrected V2 KOT to the chef.
     */
    public function cancelAndResendKOT(): void
    {
        if (!$this->activeOrderId) return;

        $order = Order::find($this->activeOrderId);
        $order->update(['status' => 'preparing']);
        $this->kotVersion++;
        session()->put("kot_version_{$order->id}", $this->kotVersion);

        // KOT correction overlay KOT
        $this->printedOrder = $order;
        $this->receiptType = 'kot_correction';
        $this->isReceiptModalOpen = true;

        $this->isKOTCorrected = false;

        \Filament\Notifications\Notification::make()
            ->title("KOT V{$this->kotVersion} Dispatched! 🚨")
            ->warning()
            ->send();
    }

    /**
     * Load category lists.
     */
    public function getCategoriesProperty()
    {
        return MenuCategory::all();
    }

    /**
     * Load catalog items.
     */
    public function getMenuItemsProperty()
    {
        $query = MenuItem::where('is_available', true);
        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->skip(($this->menuPage - 1) * 25)->take(25)->get();
    }

    public function getMenuTotalPagesProperty(): int
    {
        $query = MenuItem::where('is_available', true);
        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return (int) ceil($query->count() / 25) ?: 1;
    }

    /**
     * Active Seating tables layout query.
     */
    public function getTablesProperty(): array
    {
        $tablesList = [];
        foreach (\App\Filament\Pages\SeatingMap::SECTIONS as $sectionKey => $section) {
            foreach ($section['tables'] as $table) {
                $activeOrder = Order::where('table_number', $table['id'])
                    ->whereIn('status', ['pending', 'preparing', 'ready'])
                    ->first();

                $tablesList[] = [
                    'id' => $table['id'],
                    'capacity' => $table['capacity'],
                    'section' => $section['name'],
                    'status' => $activeOrder ? 'occupied' : 'vacant',
                    'order' => $activeOrder,
                ];
            }
        }
        return $tablesList;
    }

    /**
     * Ongoing orders tracker.
     */
    public function getOngoingOrdersProperty()
    {
        return Order::where('status', '!=', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Load an active ongoing order back into cart.
     */
    public function loadOngoingOrder(int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $this->activeOrderId = $order->id;
            $this->activeOrderNumber = $order->order_number;
            $this->orderType = $order->type;
            $this->selectedTable = $order->table_number;
            $this->customerName = $order->customer_name ?? '';
            $this->customerPhone = $order->customer_phone ?? '';
            $this->customerAddress = $order->customer_address ?? '';
            $this->riderName = $order->rider_name ?? '';
            $this->discountAmount = $order->discount;
            $this->specialNotes = $order->special_notes ?? '';

            $this->cart = [];
            foreach ($order->items as $item) {
                $sizeKey = null;
                $menuItem = $item->menuItem;
                if ($menuItem && isset($menuItem->details['sizes']) && is_array($menuItem->details['sizes'])) {
                    foreach ($menuItem->details['sizes'] as $sKey => $sVal) {
                        if (abs((float)($sVal['price'] ?? 0) - (float)$item->unit_price) < 0.01) {
                            $sizeKey = $sKey;
                            break;
                        }
                    }
                }

                $cartKey = $item->menu_item_id . ($sizeKey ? '_' . $sizeKey : '');

                $this->cart[$cartKey] = [
                    'id' => $item->menu_item_id,
                    'cart_key' => $cartKey,
                    'name' => ($item->menuItem->name ?? 'Unknown Dish') . ($sizeKey ? " (" . ($menuItem->details['sizes'][$sizeKey]['label'] ?? ucfirst($sizeKey)) . ")" : ''),
                    'price' => (float)$item->unit_price,
                    'quantity' => $item->quantity,
                    'size_key' => $sizeKey,
                    'comment' => $item->notes ?? '',
                ];
            }

            $this->kotVersion = session()->get("kot_version_{$order->id}", 1);
            $this->isKOTCorrected = false;
            $this->kotCancellationItems = [];

            $this->recalculateCart();
            $this->posScreen = 'menu'; // Advance to menu cart editing
            $this->ongoingOrdersModalOpen = false;
            $this->seatingModalOpen = false;
            $this->kitchenStatusModalOpen = false;
            $this->inspectedTableId = null;
            $this->inspectedTableOrder = null;

            \Filament\Notifications\Notification::make()
                ->title("Loaded Feasting Order")
                ->success()
                ->send();
        }
    }

    /**
     * Load active dining table card.
     */
    public function loadTableOrder(string $tableId): void
    {
        $order = Order::where('table_number', $tableId)
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->first();

        if ($order) {
            $this->loadOngoingOrder($order->id);
        } else {
            $this->resetPOSCart();
            $this->orderType = 'dine_in';
            $this->selectedTable = $tableId;
            $this->posScreen = 'menu';
        }

        // Auto-close table seating popup when starting/loading order
        $this->seatingModalOpen = false;
        $this->inspectedTableId = null;
        $this->inspectedTableOrder = null;
    }

    /**
     * Clear POS billing state completely and reset to step 1.
     */
    public function resetPOSCart(): void
    {
        $this->cart = [];
        $this->subtotal = 0;
        $this->taxAmount = 0;
        $this->discountAmount = 0;
        $this->serviceCharge = 0;
        $this->total = 0;
        $this->orderType = 'dine_in';
        $this->selectedTable = null;
        $this->customerName = '';
        $this->customerPhone = '';
        $this->customerAddress = '';
        $this->riderName = '';
        $this->specialNotes = '';
        $this->activeOrderId = null;
        $this->activeOrderNumber = null;
        $this->kotVersion = 1;
        $this->isKOTCorrected = false;
        $this->kotCancellationItems = [];
        $this->paymentMethod = 'cash';
        $this->cashReceived = 0;
        $this->changeAmount = 0;
        
        $this->posScreen = 'menu'; // Back to Menu screen
    }

    /**
     * Print the bill/invoice for the active cart.
     */
    public function printBill(): void
    {
        // If there's an active order, we can load it.
        if ($this->activeOrderId) {
            $order = Order::find($this->activeOrderId);
        } else {
            // If it's a new unsaved cart, we automatically save it as 'pending' first.
            if (count($this->cart) === 0) {
                \Filament\Notifications\Notification::make()
                    ->title("Cart is empty")
                    ->body("Select items to print a bill.")
                    ->warning()
                    ->send();
                return;
            }

            if ($this->orderType === 'delivery' && (empty($this->customerPhone) || empty($this->customerAddress))) {
                \Filament\Notifications\Notification::make()
                    ->title('Delivery Details Required')
                    ->body('Customer phone and delivery address are required for delivery.')
                    ->danger()
                    ->send();
                return;
            }

            $order = $this->saveActiveOrder('pending');
        }

        if ($order) {
            $this->printedOrder = $order;
            $this->receiptType = 'bill';
            $this->isReceiptModalOpen = true;

            \Filament\Notifications\Notification::make()
                ->title("Guest Bill Generated! 🖨️")
                ->body("Invoice statement ready for printing.")
                ->success()
                ->send();
        }
    }

    /**
     * Save cart to DB.
     */
    public function saveActiveOrder(string $status = 'pending'): Order
    {
        $orderNumber = $this->activeOrderNumber ?? 'ND-POS-' . strtoupper(bin2hex(random_bytes(3)));

        // Automatically sync or create database Customer profile record
        if (!empty($this->customerPhone) && !empty($this->customerName)) {
            \App\Models\Customer::updateOrCreate(
                ['phone' => $this->customerPhone],
                [
                    'name' => $this->customerName,
                    'address' => $this->orderType === 'delivery' ? $this->customerAddress : ($this->customerAddress ?: null),
                ]
            );
        }

        $cashReceivedVal = null;
        $changeReturnedVal = null;

        if ($status === 'completed') {
            if ($this->paymentMethod === 'cash') {
                $cashReceivedVal = (float)$this->cashReceived > 0 ? (float)$this->cashReceived : (float)$this->total;
                $changeReturnedVal = $cashReceivedVal > (float)$this->total ? ($cashReceivedVal - (float)$this->total) : 0.00;
            } else {
                $cashReceivedVal = (float)$this->total;
                $changeReturnedVal = 0.00;
            }
        }

        if ($this->activeOrderId) {
            $order = Order::find($this->activeOrderId);
            $order->update([
                'customer_name' => $this->customerName ?: null,
                'customer_phone' => $this->customerPhone ?: null,
                'customer_address' => $this->customerAddress ?: null,
                'rider_name' => $this->orderType === 'delivery' ? ($this->riderName ?: null) : null,
                'subtotal' => $this->subtotal,
                'tax' => $this->taxAmount,
                'discount' => (float)$this->discountAmount,
                'total' => $this->total,
                'status' => $status,
                'type' => $this->orderType,
                'table_number' => $this->selectedTable ?: ($order->table_number ?: ($this->orderType === 'dine_in' ? 'Walk-In / Counter' : null)),
                'payment_status' => $status === 'completed' ? 'paid' : $order->payment_status,
                'payment_method' => $status === 'completed' ? $this->paymentMethod : $order->payment_method,
                'cash_received' => $status === 'completed' ? $cashReceivedVal : $order->cash_received,
                'change_returned' => $status === 'completed' ? $changeReturnedVal : $order->change_returned,
                'transaction_reference' => $status === 'completed' ? ($this->transactionRef ?: null) : $order->transaction_reference,
                'special_notes' => $this->specialNotes ?: null,
            ]);

            $order->items()->delete();
        } else {
            $order = Order::create([
                'user_id' => \Filament\Facades\Filament::auth()->id() ?? Auth::id(),
                'order_number' => $orderNumber,
                'customer_name' => $this->customerName ?: null,
                'customer_phone' => $this->customerPhone ?: null,
                'customer_address' => $this->customerAddress ?: null,
                'rider_name' => $this->orderType === 'delivery' ? ($this->riderName ?: null) : null,
                'subtotal' => $this->subtotal,
                'tax' => $this->taxAmount,
                'discount' => (float)$this->discountAmount,
                'total' => $this->total,
                'status' => $status,
                'type' => $this->orderType,
                'table_number' => $this->selectedTable ?: ($this->orderType === 'dine_in' ? 'Walk-In / Counter' : null),
                'payment_status' => $status === 'completed' ? 'paid' : 'pending',
                'payment_method' => $status === 'completed' ? $this->paymentMethod : null,
                'cash_received' => $status === 'completed' ? $cashReceivedVal : null,
                'change_returned' => $status === 'completed' ? $changeReturnedVal : null,
                'transaction_reference' => $status === 'completed' ? ($this->transactionRef ?: null) : null,
                'special_notes' => $this->specialNotes ?: null,
            ]);
            $this->activeOrderId = $order->id;
            $this->activeOrderNumber = $order->order_number;
        }

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
                'notes' => $item['comment'] ?: null,
            ]);
        }

        if ($status === 'completed') {
            $this->calculateExpectedCash();
        }

        return $order;
    }

    /**
     * Listen for dynamic customer updates by phone.
     */
    public function updatedCustomerPhone(string $value): void
    {
        if (strlen($value) >= 7) {
            $customer = \App\Models\Customer::where('phone', $value)->first();
            if ($customer) {
                $this->customerName = $customer->name;
                $this->customerAddress = $customer->address ?? '';

                \Filament\Notifications\Notification::make()
                    ->title("Customer Profile Loaded! 👑")
                    ->body("Loaded profile for {$customer->name}")
                    ->success()
                    ->send();
            }
        }
    }

    /**
     * Inspect seating table pending order details.
     */
    public function inspectTableOrder(string $tableId): void
    {
        $this->inspectedTableId = $tableId;
        $order = Order::where('table_number', $tableId)
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->first();
        $this->inspectedTableOrder = $order;
    }

    /**
     * Send table pending order KOT to chef.
     */
    public function printTableKOT(): void
    {
        if ($this->inspectedTableOrder) {
            $this->inspectedTableOrder->update(['status' => 'preparing']);
            $this->printedOrder = $this->inspectedTableOrder;
            $this->receiptType = 'kot';
            $this->isReceiptModalOpen = true;

            \Filament\Notifications\Notification::make()
                ->title("Table KOT Dispatched")
                ->body("KOT generated for Table {$this->inspectedTableId}")
                ->success()
                ->send();
        }
    }

    /**
     * Load seating table pending order into main active dynamic cart drawer.
     */
    public function loadTableIntoCart(): void
    {
        if ($this->inspectedTableOrder) {
            $this->loadOngoingOrder($this->inspectedTableOrder->id);
            $this->seatingModalOpen = false;
            $this->inspectedTableId = null;
            $this->inspectedTableOrder = null;
        }
    }

    /**
     * Advance a pending order to the cooking phase in the kitchen queue.
     */
    public function startCooking(int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => 'preparing']);

            \Filament\Notifications\Notification::make()
                ->title("Sent to Kitchen Queue")
                ->body("Order #{$order->order_number} is now in the PREPARING phase.")
                ->success()
                ->send();
        }
    }

    /**
     * Complete cooking phase for an order (Kitchen chef trigger).
     */
    public function completeCooking(int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => 'ready']);

            // Create notification based on order channel
            if ($order->type === 'dine_in') {
                \App\Models\InternalNotification::create([
                    'type' => 'ready_to_serve',
                    'title' => '🍳 Order Ready to Serve!',
                    'message' => "Order #{$order->order_number} for " . ($order->table_number ? "Table {$order->table_number}" : "Dine-In") . " is ready. Serve now!",
                    'notifiable_role' => 'waiter',
                    'related_id' => $order->id,
                ]);
            } elseif ($order->type === 'takeaway') {
                \App\Models\InternalNotification::create([
                    'type' => 'ready_for_pickup',
                    'title' => "🥡 Takeaway Ready for Pickup: #{$order->order_number}",
                    'message' => "Order for " . ($order->customer_name ?: 'Guest') . " is packed & ready at the pickup counter!",
                    'notifiable_role' => 'cashier',
                    'related_id' => $order->id,
                ]);
            } elseif ($order->type === 'delivery') {
                \App\Models\InternalNotification::create([
                    'type' => 'ready_for_delivery',
                    'title' => "🛵 Delivery Ready for Dispatch: #{$order->order_number}",
                    'message' => "Order for " . ($order->customer_name ?: 'Guest') . " is packed! Ready for Rider " . ($order->rider_name ?: 'Assigned') . " (" . ($order->customer_address ?: 'Address') . ").",
                    'notifiable_role' => 'cashier',
                    'related_id' => $order->id,
                ]);
            }

            \Filament\Notifications\Notification::make()
                ->title("Cooking Phase Completed! 🍳")
                ->body("Order #{$order->order_number} marked as READY.")
                ->success()
                ->send();
        }
    }

    /**
     * Re-print KOT ticket for any active cooking order.
     */
    public function reprintKOT(int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $this->printedOrder = $order;
            $this->receiptType = 'kot';
            $this->isReceiptModalOpen = true;

            \Filament\Notifications\Notification::make()
                ->title("Printing KOT Ticket 🍳")
                ->body("KOT Ticket for Order #{$order->order_number} loaded.")
                ->info()
                ->send();
        }
    }

    /**
     * Get unread notifications for POS/Cashier.
     */
    public function getNotificationsProperty()
    {
        return \App\Models\InternalNotification::where('is_read', false)
            ->whereIn('notifiable_role', ['all', 'cashier'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mark standard notification as read.
     */
    public function markNotificationAsRead(int $notificationId): void
    {
        $notification = \App\Models\InternalNotification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
    }

    /**
     * Send order to kitchen KOT (preparing status) and clear notification.
     */
    public function sendKitchenKOT(int $notificationId, int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => 'preparing']);

            // Show KOT receipt preview modal automatically for the chef
            $this->printedOrder = $order;
            $this->receiptType = 'kot';
            $this->isReceiptModalOpen = true;

            \Filament\Notifications\Notification::make()
                ->title("KOT Dispatched to Kitchen! 👨‍🍳")
                ->body("Order #{$order->order_number} is now being prepared in the kitchen.")
                ->success()
                ->send();
        }

        $this->markNotificationAsRead($notificationId);
    }

    public function openKitchenStatusModal(): void
    {
        $this->kitchenStatusModalOpen = true;
    }

    public function closeKitchenStatusModal(): void
    {
        $this->kitchenStatusModalOpen = false;
    }

    public function openOngoingOrdersModal(): void
    {
        $this->ongoingOrdersModalOpen = true;
    }

    public function closeOngoingOrdersModal(): void
    {
        $this->ongoingOrdersModalOpen = false;
    }

    /**
     * Mark order as Ready to Serve and alert waiter/cashier staff.
     */
    public function updateOrderStatusToReady(int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => 'ready']);

            // Create notification for staff based on order channel
            if ($order->type === 'dine_in') {
                \App\Models\InternalNotification::create([
                    'type' => 'ready_to_serve',
                    'title' => '🍳 Order Ready to Serve!',
                    'message' => "Order #{$order->order_number} for " . ($order->table_number ? "Table {$order->table_number}" : ucfirst(str_replace('_', ' ', $order->type))) . " is ready. Serve now!",
                    'notifiable_role' => 'waiter',
                    'related_id' => $order->id,
                ]);
            } elseif ($order->type === 'takeaway') {
                \App\Models\InternalNotification::create([
                    'type' => 'ready_for_pickup',
                    'title' => "🥡 Takeaway Ready for Pickup: #{$order->order_number}",
                    'message' => "Order for " . ($order->customer_name ?: 'Guest') . " is packed & ready at the pickup counter!",
                    'notifiable_role' => 'cashier',
                    'related_id' => $order->id,
                ]);
            } elseif ($order->type === 'delivery') {
                \App\Models\InternalNotification::create([
                    'type' => 'ready_for_delivery',
                    'title' => "🛵 Delivery Ready for Dispatch: #{$order->order_number}",
                    'message' => "Order for " . ($order->customer_name ?: 'Guest') . " is packed! Ready for Rider " . ($order->rider_name ?: 'Assigned') . " (" . ($order->customer_address ?: 'Address') . ").",
                    'notifiable_role' => 'cashier',
                    'related_id' => $order->id,
                ]);
            }

            \Filament\Notifications\Notification::make()
                ->title("Order Ready! 🍳")
                ->body("Status updated to READY for Order #{$order->order_number}.")
                ->success()
                ->send();
        }
    }

    /**
     * Cashier clicks SERVE to alert the assigned waiter to pick up food from counter and serve table.
     */
    public function notifyWaiterToServe(int $orderId): void
    {
        $order = Order::find($orderId);
        if (!$order) {
            return;
        }

        $order->update([
            'status' => 'ready',
            'served_at' => now(),
        ]);

        $waiter = $order->waiter ?? ($order->user && $order->user->role === 'waiter' ? $order->user : null);
        $waiterName = $waiter?->name ?? 'Waiter Staff';
        $tableNum = $order->table_number ?: 'Table';
        $tableDisplay = str_starts_with($tableNum, 'Table') ? $tableNum : "Table {$tableNum}";

        \App\Models\InternalNotification::create([
            'type' => 'ready_to_serve',
            'title' => "🍽️ Serve Food: {$tableDisplay}!",
            'message' => "Order #{$order->order_number} for {$tableDisplay} is ready at counter. {$waiterName}, please serve now!",
            'notifiable_role' => 'waiter',
            'related_id' => $order->id,
        ]);

        \Filament\Notifications\Notification::make()
            ->title("Waiter Alerted to Serve! 🍽️")
            ->body("Dispatched serving notification to {$waiterName} for {$tableDisplay}.")
            ->success()
            ->send();
    }

    /**
     * Direct Settle: Loads order into POS and immediately opens Payment Settlement Modal.
     */
    public function openDirectSettlement(int $orderId): void
    {
        $this->loadOngoingOrder($orderId);
        $this->kitchenStatusModalOpen = false;
        $this->ongoingOrdersModalOpen = false;
        $this->seatingModalOpen = false;
        $this->proceedToPayment();
    }
}
