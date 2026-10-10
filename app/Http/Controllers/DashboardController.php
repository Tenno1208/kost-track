<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalIncomeAll = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpenseAll = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncomeAll - $totalExpenseAll;

        $monthlyIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $monthlyExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        $recentTransactions = Transaction::where('user_id', $userId)
            ->with('category')
            ->latest('transaction_date')
            ->take(5)
            ->get();

        $expensesByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $categoryLabels = $expensesByCategory->pluck('category.name');
        $categoryTotals = $expensesByCategory->pluck('total');
        $categoryColors = $expensesByCategory->pluck('category.color');

        return view('dashboard', compact(
            'balance',
            'monthlyIncome',
            'monthlyExpense',
            'recentTransactions',
            'categoryLabels',
            'categoryTotals',
            'categoryColors'
        ));
    }
}