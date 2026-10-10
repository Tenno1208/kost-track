<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::where('user_id', Auth::id())->orderBy('due_date', 'asc')->get();
        return view('bills.index', compact('bills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        Bill::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'unpaid',
        ]);

        return redirect()->route('bills.index')->with('success', 'Tagihan berhasil ditambahkan!');
    }

    public function updateStatus(Bill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $bill->status = $bill->status == 'paid' ? 'unpaid' : 'paid';
        $bill->save();

        return back()->with('success', 'Status tagihan diperbarui!');
    }

    public function destroy(Bill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $bill->delete();
        return back()->with('success', 'Tagihan berhasil dihapus!');
    }
}