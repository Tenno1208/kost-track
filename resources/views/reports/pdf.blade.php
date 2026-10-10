<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan KosTrack</title>
    <style>
        body { font-family: sans-serif; color: #242923; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #174D3A; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; color: #174D3A; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { border: 1px solid #E8E8E1; padding: 8px; text-align: left; }
        .table th { background-color: #F8F7F2; color: #174D3A; }
        .income { color: #174D3A; font-weight: bold; }
        .expense { color: #C65B55; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">KosTrack — Laporan Keuangan Bulanan</div>
        <p>Periode: {{ $selectedMonth }}</p>
    </div>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td><strong>Total Pemasukan:</strong> <span class="income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span></td>
            <td><strong>Total Pengeluaran:</strong> <span class="expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span></td>
            <td><strong>Sisa Kas:</strong> Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Catatan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->category->name ?? '-' }}</td>
                    <td>{{ $trx->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                    <td>{{ $trx->notes ?: '-' }}</td>
                    <td class="{{ $trx->type == 'income' ? 'income' : 'expense' }}">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>