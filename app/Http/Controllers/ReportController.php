<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));

        $date = Carbon::parse($selectedMonth);
        $month = $date->month;
        $year = $date->year;

        // Total Pemasukan & Pengeluaran Bulan Terpilih
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $netSavings = $totalIncome - $totalExpense;

        // Ringkasan Pengeluaran per Kategori
        $categoryBreakdown = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->orderByDesc('total')
            ->get();

        $categoryNames = $categoryBreakdown->pluck('category.name');
        $categoryTotals = $categoryBreakdown->pluck('total');
        $categoryColors = $categoryBreakdown->pluck('category.color');

        return view('reports.index', compact(
            'selectedMonth',
            'totalIncome',
            'totalExpense',
            'netSavings',
            'categoryBreakdown',
            'categoryNames',
            'categoryTotals',
            'categoryColors'
        ));
    }


// Tambahkan di dalam kelas ReportController:
public function exportPdf(Request $request)
{
    $userId = Auth::id();
    $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));

    $date = Carbon::parse($selectedMonth);
    $month = $date->month;
    $year = $date->year;

    $totalIncome = Transaction::where('user_id', $userId)
        ->where('type', 'income')
        ->whereMonth('transaction_date', $month)
        ->whereYear('transaction_date', $year)
        ->sum('amount');

    $totalExpense = Transaction::where('user_id', $userId)
        ->where('type', 'expense')
        ->whereMonth('transaction_date', $month)
        ->whereYear('transaction_date', $year)
        ->sum('amount');

    $transactions = Transaction::where('user_id', $userId)
        ->whereMonth('transaction_date', $month)
        ->whereYear('transaction_date', $year)
        ->with('category')
        ->latest('transaction_date')
        ->get();

    $pdf = Pdf::loadView('reports.pdf', compact('selectedMonth', 'totalIncome', 'totalExpense', 'transactions'));
    
    return $pdf->download('Laporan_KosTrack_' . $selectedMonth . '.pdf');
}
}