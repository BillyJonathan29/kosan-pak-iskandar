<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Kwitansi Pembayaran - <?= htmlspecialchars($invoiceData['order_id']) ?></title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px
        }

        .company {
            font-size: 18px;
            font-weight: 700
        }

        .meta {
            margin-top: 10px;
            font-size: 12px;
        }

        .section {
            margin: 20px 0
        }

        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px
        }

        .right {
            text-align: right
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company">Kosan Pak Iskandar</div>
        <div class="meta">Kwitansi Pembayaran</div>
    </div>

    <div>
        <strong>Penyewa:</strong> <?= htmlspecialchars($invoiceData['tenant_name']) ?><br>
        <strong>Email:</strong> <?= htmlspecialchars($invoiceData['tenant_email']) ?><br>
        <strong>Telepon:</strong> <?= htmlspecialchars($invoiceData['tenant_phone']) ?><br>
        <strong>No. Order:</strong> <?= htmlspecialchars($invoiceData['order_id']) ?><br>
        <strong>Bulan Tagihan:</strong> <?= htmlspecialchars($invoiceData['billing_month']) ?>
    </div>

    <div class="section">
        <table class="table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Biaya sewa kamar <?= htmlspecialchars($invoiceData['room_number']) ?> - Bulan ke-<?= htmlspecialchars($invoiceData['billing_month']) ?></td>
                    <td class="right"><?= number_format($invoiceData['amount'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="right"><strong><?= number_format($invoiceData['amount'], 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <small>Terbayar: <?= $invoiceData['payment_status'] === 'paid' ? 'YA' : 'BELUM' ?> | Tanggal Bayar: <?= $invoiceData['paid_at'] ?? '-' ?></small>
    </div>

    <div class="section" style="margin-top:40px;">
        <div style="width:50%; float:right; text-align:center">
            <div>Kuningan, <?= date('d M Y') ?></div>
            <div style="margin-top:60px">(_________________________)</div>
            <div>Admin Kosan</div>
        </div>
    </div>
</body>

</html>