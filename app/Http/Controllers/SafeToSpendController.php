<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Bill;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SafeToSpendController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');

        // 1. Total Saldo Bersih Seluruhnya (Pemasukan - Pengeluaran)
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // 2. Tagihan Belum Dibayar (Sewa Kos, Listrik, Wi-Fi, dll)
        $unpaidBills = Bill::where('user_id', $userId)->where('status', 'unpaid')->sum('amount');

        // 3. Sisa Uang Bebas yang BISA Dipakai untuk Makan & Harian
        $availableMoney = max(0, $netBalance - $unpaidBills);

        // 4. Hitung Rata-rata Pengeluaran Harian Nyata (30 Hari Terakhir)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $totalExpenseLast30Days = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->where('transaction_date', '>=', $thirtyDaysAgo)
            ->sum('amount');

        // Menghindari pembagian dengan nol jika belum ada transaksi pengeluaran
        $dailyAverageExpense = $totalExpenseLast30Days > 0 ? ($totalExpenseLast30Days / 30) : 0;

        // 5. KALKULASI UTAMA: Berapa Hari Uang Ini Cukup?
        $daysMoneyWillLast = $dailyAverageExpense > 0 ? floor($availableMoney / $dailyAverageExpense) : 0;
        $projectedEndDate = $dailyAverageExpense > 0 ? Carbon::now()->addDays($daysMoneyWillLast)->format('d M Y') : 'Tidak Terbatas';

        // 6. Hitung Jatah Aman Per Hari Sampai Akhir Bulan
        $daysInMonth = $now->daysInMonth;
        $dayNow = $now->day;
        $remainingDaysInMonth = max(1, ($daysInMonth - $dayNow + 1));
        $safeDailyBudget = $availableMoney > 0 ? ($availableMoney / $remainingDaysInMonth) : 0;

        return view('safetospend.index', compact(
            'netBalance',
            'unpaidBills',
            'availableMoney',
            'dailyAverageExpense',
            'daysMoneyWillLast',
            'projectedEndDate',
            'remainingDaysInMonth',
            'safeDailyBudget'
        ));
    }
}