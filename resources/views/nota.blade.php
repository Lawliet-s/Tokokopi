<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota - Tokokopi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: #FEF3C7;
        }
        .screen-only {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn {
            padding: 12px 32px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: system-ui, sans-serif;
            transition: all 0.3s ease;
        }
        .btn-print {
            background: linear-gradient(135deg, #78350F, #451A03);
            color: white;
        }
        .btn-print:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(120,53,15,0.3); }
        .btn-print:active { transform: translateY(0); }
        .btn-back {
            background: white;
            color: #78350F;
            border: 2px solid #78350F;
        }
        .btn-back:hover { background: #FEF3C7; transform: translateY(-2px); }
        .nota {
            width: 300px;
            background: white;
            padding: 24px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            animation: fade-up 0.5s ease-out;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px dashed #78350F;
        }
        .header h1 {
            font-family: 'Courier New', monospace;
            font-size: 22px;
            color: #451A03;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        .header p { font-size: 12px; color: #92400E; margin-top: 4px; }
        .items { margin-bottom: 12px; }
        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 13px;
            color: #451A03;
        }
        .item-detail { font-size: 11px; color: #92400E; margin: -2px 0 8px 12px; }
        .divider { border-top: 1px dashed #451A03; margin: 10px 0; }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            color: #451A03;
        }
        .footer {
            text-align: center;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px dashed #451A03;
            font-size: 12px;
            color: #92400E;
        }
        .footer span { font-size: 16px; }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media print {
            body { padding: 0; background: white; }
            .screen-only { display: none; }
            .nota { box-shadow: none; border: none; border-radius: 0; padding: 16px; animation: none; }
            .header h1 { color: black; }
            .header p { color: #555; }
            .item { color: black; }
            .item-detail { color: #555; }
            .total-row { color: black; }
            .footer { color: #555; }
            .header { border-bottom-color: #333; }
            .divider { border-top-color: #333; }
            .footer { border-top-color: #333; }
            @page { margin: 10mm; }
        }
    </style>
</head>
<body>
    <div class="nota">
        <div class="header">
            <h1>☕ Tokokopi</h1>
            <p>{{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="items">
            @foreach ($cart as $item)
                <div class="item">
                    <span>{{ $item['nama_kopi'] }}</span>
                    <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="item-detail">{{ $item['qty'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
            @endforeach
        </div>

        <div class="divider"></div>

        <div class="total-row">
            <span>Total</span>
            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="footer">
            <span>☕</span><br>
            Terima kasih telah berkunjung!
        </div>
    </div>

    <div class="screen-only">
        <button class="btn btn-print" onclick="window.print()">Cetak Nota</button>
        <button class="btn btn-back" onclick="window.location.href='/'">Kembali ke Kasir</button>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
