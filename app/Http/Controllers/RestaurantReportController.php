<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Expense;
use App\Models\InventoryItem;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\StaffMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantReportController extends Controller
{
    /**
     * Export report data as Excel-friendly CSV with UTF-8 BOM.
     */
    public function exportCsv(Request $request, string $type): mixed
    {
        $range = $request->query('range', 'all');
        $data = $this->getReportData($type, $range);

        $filename = "nawabi-dera-{$type}-report-" . ($range !== 'all' ? "{$range}-" : '') . now()->format('Y-m-d') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM so Microsoft Excel renders Urdu/English characters correctly
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write Header
            fputcsv($file, $data['columns']);

            // Write Rows
            foreach ($data['rows'] as $row) {
                fputcsv($file, $row);
            }

            // Write Summary / Totals if available
            if (!empty($data['summaries'])) {
                fputcsv($file, []);
                fputcsv($file, ['--- EXECUTIVE AUDIT SUMMARY ---']);
                foreach ($data['summaries'] as $label => $val) {
                    fputcsv($file, [$label, $val]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export report data as JSON.
     */
    public function exportJson(Request $request, string $type): mixed
    {
        $range = $request->query('range', 'all');
        $data = $this->getReportData($type, $range);

        $filename = "nawabi-dera-{$type}-report-" . now()->format('Y-m-d') . ".json";

        return response()->json([
            'meta' => [
                'restaurant' => 'Nawabi Dera Royal Food Corner, Okara',
                'report_type' => $type,
                'title' => $data['title'],
                'time_range' => $range,
                'generated_at' => now()->toIso8601String(),
                'total_records' => count($data['rows']),
            ],
            'summaries' => $data['summaries'] ?? [],
            'data' => $data['records'] ?? $data['rows'],
        ], 200, [
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Render printable executive PDF / HTML report view with letterhead & print trigger.
     */
    public function printReport(Request $request, string $type): mixed
    {
        $range = $request->query('range', 'all');
        $data = $this->getReportData($type, $range);

        return view('reports.print-layout', [
            'report' => $data,
            'range' => $range,
            'type' => $type,
            'generatedAt' => now()->format('F d, Y • h:i A'),
        ]);
    }

    /**
     * Build report dataset for specified report type and date range.
     */
    public function getReportData(string $type, string $range = 'all'): array
    {
        $dates = $this->resolveDateConstraints($range);
        $start = $dates['start'];
        $end = $dates['end'];

        switch ($type) {
            case 'sales':
                return $this->getSalesReportData($start, $end, $range);
            case 'inventory':
                return $this->getInventoryReportData();
            case 'expenses':
                return $this->getExpensesReportData($start, $end, $range);
            case 'menu_performance':
                return $this->getMenuPerformanceReportData($start, $end, $range);
            case 'reservations':
                return $this->getReservationsReportData($start, $end, $range);
            case 'equipment':
                return $this->getEquipmentReportData();
            case 'staff_payroll':
                return $this->getStaffPayrollReportData();
            case 'cashier_till':
                return $this->getCashierTillReportData($start, $end, $range);
            default:
                return $this->getSalesReportData($start, $end, $range);
        }
    }

    protected function resolveDateConstraints(string $range): array
    {
        $now = Carbon::now('Asia/Karachi');

        if ($range === 'today') {
            return ['start' => Carbon::today('Asia/Karachi')->startOfDay(), 'end' => $now->endOfDay()];
        } elseif ($range === 'yesterday') {
            return ['start' => Carbon::yesterday('Asia/Karachi')->startOfDay(), 'end' => Carbon::yesterday('Asia/Karachi')->endOfDay()];
        } elseif ($range === 'week') {
            return ['start' => Carbon::now('Asia/Karachi')->subDays(6)->startOfDay(), 'end' => $now->endOfDay()];
        } elseif ($range === 'month') {
            return ['start' => Carbon::now('Asia/Karachi')->startOfMonth(), 'end' => $now->endOfDay()];
        }

        return ['start' => Carbon::create(2020, 1, 1), 'end' => $now->endOfDay()];
    }

    // 1. Sales Report
    protected function getSalesReportData($start, $end, $range): array
    {
        $query = Order::query()->with('items.menuItem');
        if ($range !== 'all') {
            $query->whereBetween('created_at', [$start, $end]);
        }
        $orders = $query->orderByDesc('created_at')->get();

        $rows = [];
        $rawRecords = [];
        $totalSales = 0;
        $totalTax = 0;
        $totalDiscount = 0;

        foreach ($orders as $order) {
            $totalSales += (float) $order->total;
            $totalTax += (float) $order->tax;
            $totalDiscount += (float) $order->discount;

            $rows[] = [
                $order->id,
                $order->order_number,
                $order->created_at ? $order->created_at->format('Y-m-d') : '',
                $order->created_at ? $order->created_at->format('h:i A') : '',
                ucfirst($order->type),
                $order->table_number ? "Table {$order->table_number}" : '—',
                $order->customer_name ?: 'Walk-in Guest',
                $order->customer_phone ?: '—',
                $order->status,
                number_format((float)$order->subtotal, 2, '.', ''),
                number_format((float)$order->tax, 2, '.', ''),
                number_format((float)$order->discount, 2, '.', ''),
                number_format((float)$order->total, 2, '.', ''),
                ucfirst($order->payment_status ?? 'unpaid'),
                ucfirst($order->payment_method ?? 'cash'),
            ];

            $rawRecords[] = $order->toArray();
        }

        return [
            'title' => 'Executive Sales & Revenue Report',
            'description' => 'Comprehensive financial transactions, channel sales, GST tax audit, and payment settlements.',
            'columns' => [
                'ID', 'Order #', 'Date', 'Time', 'Type', 'Table', 'Customer Name', 'Contact Phone',
                'Status', 'Subtotal (Rs)', 'GST Tax (Rs)', 'Discount (Rs)', 'Grand Total (Rs)',
                'Payment Status', 'Payment Method'
            ],
            'rows' => $rows,
            'records' => $rawRecords,
            'summaries' => [
                'Total Orders Count' => count($rows),
                'Gross Revenue (PKR)' => 'Rs. ' . number_format($totalSales, 2),
                'Total GST Collected (PKR)' => 'Rs. ' . number_format($totalTax, 2),
                'Total Privileged Discounts (PKR)' => 'Rs. ' . number_format($totalDiscount, 2),
                'Average Order Ticket (PKR)' => count($rows) > 0 ? 'Rs. ' . number_format($totalSales / count($rows), 2) : 'Rs. 0.00',
            ],
        ];
    }

    // 2. Inventory & Raw Material Demand Report
    protected function getInventoryReportData(): array
    {
        $items = InventoryItem::orderBy('category')->orderBy('name')->get();
        $rows = [];
        $totalValuation = 0;
        $lowStockCount = 0;

        foreach ($items as $item) {
            $val = (float) $item->quantity * (float) $item->unit_cost;
            $totalValuation += $val;
            $isLow = $item->quantity <= $item->minimum_qty;
            if ($isLow) $lowStockCount++;

            $rows[] = [
                $item->id,
                $item->name,
                $item->sku,
                ucfirst($item->category),
                number_format((float)$item->quantity, 2, '.', ''),
                $item->unit,
                number_format((float)$item->minimum_qty, 2, '.', ''),
                $isLow ? 'LOW STOCK ALERT' : 'Healthy',
                number_format((float)$item->unit_cost, 2, '.', ''),
                number_format($val, 2, '.', ''),
                $item->supplier_name ?: 'Local Wholesale Market',
                $item->last_restocked_at ? $item->last_restocked_at->format('Y-m-d H:i') : 'Never',
            ];
        }

        return [
            'title' => 'Raw Material Demand & Stock Inventory Report',
            'description' => 'Real-time raw ingredient assets, in-store capital valuation, and Mandi replenishment thresholds.',
            'columns' => [
                'ID', 'Item Name', 'SKU', 'Category', 'Current In-Stock', 'Unit',
                'Alert Threshold', 'Health Status', 'Unit Cost (Rs)', 'Total Value (Rs)',
                'Preferred Supplier', 'Last Restocked Date'
            ],
            'rows' => $rows,
            'records' => $items->toArray(),
            'summaries' => [
                'Total Raw Material Stock Items' => count($rows),
                'Total Store Capital Valuation' => 'Rs. ' . number_format($totalValuation, 2),
                'Critical Low Stock Items' => $lowStockCount,
            ],
        ];
    }

    // 3. Expenses Report
    protected function getExpensesReportData($start, $end, $range): array
    {
        $query = Expense::query();
        if ($range !== 'all') {
            $query->whereBetween('expense_date', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
        }
        $expenses = $query->orderByDesc('expense_date')->get();

        $rows = [];
        $total = 0;
        $procurementTotal = 0;

        foreach ($expenses as $e) {
            $total += (float) $e->amount;
            if ($e->category === 'inventory_procurement') $procurementTotal += (float) $e->amount;

            $rows[] = [
                $e->id,
                $e->expense_date ? $e->expense_date->format('Y-m-d') : '',
                ucfirst(str_replace('_', ' ', $e->category)),
                $e->recipient,
                $e->invoice_number ?: 'N/A',
                number_format((float)$e->amount, 2, '.', ''),
                $e->description ?: '',
            ];
        }

        return [
            'title' => 'Operational Expenses & Procurement Ledger',
            'description' => 'Complete expenditure audit covering raw stock procurement, utility bills, rent, and payroll.',
            'columns' => ['ID', 'Date', 'Expense Category', 'Paid To (Recipient)', 'Invoice / Voucher #', 'Amount (Rs)', 'Description / Remarks'],
            'rows' => $rows,
            'records' => $expenses->toArray(),
            'summaries' => [
                'Total Expense Records' => count($rows),
                'Total Expenditure (PKR)' => 'Rs. ' . number_format($total, 2),
                'Raw Material Procurement Spend' => 'Rs. ' . number_format($procurementTotal, 2),
                'Operating Overheads' => 'Rs. ' . number_format($total - $procurementTotal, 2),
            ],
        ];
    }

    // 4. Menu Dishes Performance Report
    protected function getMenuPerformanceReportData($start, $end, $range): array
    {
        $dishes = MenuItem::with('category')->get();
        $rows = [];
        $totalQty = 0;
        $totalRevenue = 0;

        foreach ($dishes as $dish) {
            $oiQuery = OrderItem::where('menu_item_id', $dish->id);
            if ($range !== 'all') {
                $oiQuery->whereBetween('created_at', [$start, $end]);
            }
            $soldQty = (int) $oiQuery->sum('quantity');
            $revenue = (float) $oiQuery->sum('total_price');

            $totalQty += $soldQty;
            $totalRevenue += $revenue;

            $rows[] = [
                $dish->id,
                $dish->name,
                $dish->category?->name ?? 'General',
                number_format((float)$dish->price, 2, '.', ''),
                $dish->is_available ? 'In Stock' : 'Unavailable',
                $soldQty,
                number_format($revenue, 2, '.', ''),
            ];
        }

        usort($rows, fn ($a, $b) => $b[5] <=> $a[5]); // Sort by popularity

        return [
            'title' => 'Dishes & Culinary Performance Report',
            'description' => 'Menu engineering analysis detailing dish sales velocity, popularity ranking, and revenue yield.',
            'columns' => ['ID', 'Dish Title', 'Category', 'Base Price (Rs)', 'In-Stock Status', 'Quantity Sold', 'Gross Revenue (Rs)'],
            'rows' => $rows,
            'records' => $rows,
            'summaries' => [
                'Total Dishes on Menu' => count($dishes),
                'Total Portions Sold' => number_format($totalQty) . ' portions',
                'Total Menu Revenue' => 'Rs. ' . number_format($totalRevenue, 2),
            ],
        ];
    }

    // 5. Table Reservations Report
    protected function getReservationsReportData($start, $end, $range): array
    {
        $query = Reservation::query();
        if ($range !== 'all') {
            $query->whereBetween('reservation_time', [$start, $end]);
        }
        $reservations = $query->orderByDesc('reservation_time')->get();

        $rows = [];
        $totalGuests = 0;

        foreach ($reservations as $r) {
            $totalGuests += (int) $r->guest_count;

            $rows[] = [
                $r->id,
                $r->guest_name,
                $r->guest_phone,
                $r->guest_email ?: '—',
                $r->reservation_time ? $r->reservation_time->format('Y-m-d H:i') : '',
                $r->guest_count,
                $r->table_number ? "Table {$r->table_number}" : 'Unassigned',
                ucfirst($r->status),
                $r->special_requests ?: 'Standard',
                $r->created_at ? $r->created_at->format('Y-m-d') : '',
            ];
        }

        return [
            'title' => 'Dining Reservations & Table Booking Report',
            'description' => 'Guest booking logs, seating layout assignments, party sizes, and customer special dining preferences.',
            'columns' => ['ID', 'Guest Name', 'Phone', 'Email', 'Scheduled Time', 'Guests', 'Table', 'Status', 'Special Requests', 'Booked On'],
            'rows' => $rows,
            'records' => $reservations->toArray(),
            'summaries' => [
                'Total Bookings' => count($rows),
                'Total Guests Accommodated' => $totalGuests,
            ],
        ];
    }

    // 6. Master Equipment Registry Report (All 149 Items)
    protected function getEquipmentReportData(): array
    {
        $equipment = Equipment::orderBy('name')->get();
        $rows = [];
        $totalUnits = 0;
        $totalVal = 0;

        foreach ($equipment as $eq) {
            $qty = (int) ($eq->quantity ?: 1);
            $totalUnits += $qty;
            $cost = (float) $eq->purchase_cost;
            $totalVal += $cost;

            $rows[] = [
                $eq->id,
                $eq->name,
                $qty,
                ucfirst(str_replace('_', ' ', $eq->category)),
                $eq->serial_number ?: "ND-EQ-{$eq->id}",
                ucfirst($eq->functional_status),
                number_format($cost, 2, '.', ''),
                $eq->purchase_date ? $eq->purchase_date->format('Y-m-d') : '2025-06-01',
                $eq->notes ?: 'Okara Master Equipment',
            ];
        }

        return [
            'title' => 'Restaurant Master Equipment & Asset Audit',
            'description' => 'Comprehensive inventory of all 149 physical assets, kitchen cookware, dining furniture, and HVAC systems.',
            'columns' => ['ID', 'Equipment Name', 'Count / Qty', 'Category', 'Asset Serial #', 'Operational Status', 'Est. Value (Rs)', 'Commission Date', 'Notes'],
            'rows' => $rows,
            'records' => $equipment->toArray(),
            'summaries' => [
                'Total Unique Asset Types' => count($equipment),
                'Total Physical Equipment Count' => number_format($totalUnits) . ' units',
                'Total Asset Valuation (PKR)' => 'Rs. ' . number_format($totalVal, 2),
            ],
        ];
    }

    // 7. Staff & Payroll Report
    protected function getStaffPayrollReportData(): array
    {
        $staff = StaffMember::orderBy('role_designation')->orderBy('full_name')->get();
        $rows = [];
        $totalPayroll = 0;

        foreach ($staff as $s) {
            $salary = (float) $s->salary;
            $totalPayroll += $salary;

            $rows[] = [
                $s->id,
                $s->full_name,
                $s->phone,
                $s->email ?: '—',
                ucfirst($s->role_designation),
                number_format($salary, 2, '.', ''),
                ucfirst($s->status),
                $s->hire_date ? $s->hire_date->format('Y-m-d') : '',
            ];
        }

        return [
            'title' => 'Staff Profiles & Payroll Commitment Report',
            'description' => 'Employee roster, organizational designations, fixed salary liabilities, and system user linkage.',
            'columns' => ['ID', 'Staff Name', 'Phone', 'Email', 'Designation', 'Fixed Monthly Salary (Rs)', 'Status', 'Hire Date'],
            'rows' => $rows,
            'records' => $staff->toArray(),
            'summaries' => [
                'Total Staff Members' => count($staff),
                'Total Monthly Payroll Liability' => 'Rs. ' . number_format($totalPayroll, 2),
            ],
        ];
    }

    // 8. Cashier Till & Terminal Reconciliation Report
    protected function getCashierTillReportData($start, $end, $range): array
    {
        $terminals = User::where('is_active', true)
            ->where(function ($q) {
                $q->whereNotNull('terminal_code')
                  ->orWhere('role', 'cashier');
            })
            ->get();

        $rows = [];
        $totalCash = 0;
        $totalDigital = 0;

        foreach ($terminals as $t) {
            $oQuery = Order::where('payment_status', 'paid');
            if ($range !== 'all') {
                $oQuery->whereBetween('created_at', [$start, $end]);
            }
            $tCash = (float) (clone $oQuery)->where(fn ($q) => $q->where('payment_method', 'cash')->orWhereNull('payment_method'))->sum('total');
            $tDigital = (float) (clone $oQuery)->whereIn('payment_method', ['card', 'online', 'jazzcash', 'easypaisa'])->sum('total');

            $totalCash += $tCash;
            $totalDigital += $tDigital;

            $rows[] = [
                $t->terminal_code ?: "POS-0{$t->id}",
                $t->name,
                $t->email,
                ucfirst($t->role),
                number_format($tCash, 2, '.', ''),
                number_format($tDigital, 2, '.', ''),
                number_format($tCash + $tDigital, 2, '.', ''),
            ];
        }

        return [
            'title' => 'Cashier Till & Terminal Reconciliation Report',
            'description' => 'Shift drawer balancing, cash in hand auditing, and digital card/mobile wallet settlement.',
            'columns' => ['Terminal ID', 'Cashier Name', 'Login Email', 'Role', 'Cash Collected (Rs)', 'Digital / Card (Rs)', 'Total Collections (Rs)'],
            'rows' => $rows,
            'records' => $rows,
            'summaries' => [
                'Total Cash in Drawers' => 'Rs. ' . number_format($totalCash, 2),
                'Total Digital Card Settlements' => 'Rs. ' . number_format($totalDigital, 2),
                'Total Till Collections' => 'Rs. ' . number_format($totalCash + $totalDigital, 2),
            ],
        ];
    }
}
