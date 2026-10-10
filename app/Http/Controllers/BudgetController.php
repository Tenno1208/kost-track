<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $budgets = Budget::where('user_id', $userId)
            ->where('month', $month)
            ->with('category')
            ->get();

        $categories = Category::where('type', 'expense')->get();

        // Hitung pengeluaran aktual per kategori pada bulan tersebut
        $expenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', Carbon::parse($month)->year)
            ->whereMonth('transaction_date', Carbon::parse($month)->month)
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        return view('budgets.index', compact('budgets', 'categories', 'month', 'expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string|size:7',
        ]);

        Budget::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'month' => $request->month,
            ],
            [
                'amount' => $request->amount,
            ]
        );

        return redirect()->route('budgets.index', ['month' => $request->month])->with('success', 'Anggaran berhasil disimpan!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();
        return back()->with('success', 'Anggaran berhasil dihapus!');
    }
}