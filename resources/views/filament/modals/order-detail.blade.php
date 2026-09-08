<div style="display:flex; flex-direction:column; gap:22px; padding:6px;">

    {{-- =========================
        INFORMASI PESANAN
    ========================== --}}
    @php
        $statusStyle = match(strtolower($order->orderStatus)) {
            'pending'   => 'background:#FEF3C7;color:#B45309;border:1px solid #FCD34D;',
            'processed' => 'background:#DBEAFE;color:#1D4ED8;border:1px solid #93C5FD;',
            'shipped'   => 'background:#E0E7FF;color:#4338CA;border:1px solid #A5B4FC;',
            'completed' => 'background:#DCFCE7;color:#15803D;border:1px solid #86EFAC;',
            'cancelled' => 'background:#FEE2E2;color:#B91C1C;border:1px solid #FCA5A5;',
            default     => 'background:#F3F4F6;color:#4B5563;border:1px solid #D1D5DB;',
        };
    @endphp

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">

        <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:12px;padding:14px;">
            <small style="color:#9CA3AF;">No Pesanan</small>
            <div style="font-weight:bold;">{{ $order->id_pemesanan }}</div>
        </div>

        <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:12px;padding:14px;">
            <small style="color:#9CA3AF;">Tanggal</small>
            <div>{{ \Carbon\Carbon::parse($order->orderDate)->format('d M Y') }}</div>
        </div>

        <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:12px;padding:14px;">
            <small style="color:#9CA3AF;">Pembayaran</small>
            <div>{{ strtoupper($order->paymentMethod) }}</div>
        </div>

        <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:12px;padding:14px;">
            <small style="color:#9CA3AF;">Status</small>

            <div style="margin-top:6px;">
                <span style="padding:5px 12px;border-radius:999px;font-size:12px;font-weight:600;{{ $statusStyle }}">
                    {{ ucfirst($order->orderStatus) }}
                </span>
            </div>

        </div>

    </div>

    {{-- =========================
        PENERIMA
    ========================== --}}

    <div style="border:1px solid #E5E7EB;border-radius:12px;padding:18px;">

        <div style="font-weight:bold;font-size:15px;margin-bottom:10px;">
            👤 Informasi Penerima
        </div>

        <div style="display:grid;grid-template-columns:180px auto;row-gap:8px;">

            <div style="color:#6B7280;">Nama</div>
            <div>{{ $order->recipient_name }}</div>

            <div style="color:#6B7280;">No. Telepon</div>
            <div>{{ $order->phone_number }}</div>

        </div>

    </div>

    {{-- =========================
        ALAMAT
    ========================== --}}

    <div style="border:1px solid #E5E7EB;border-radius:12px;padding:18px;">

        <div style="font-weight:bold;font-size:15px;margin-bottom:10px;">
            📍 Alamat Pengiriman
        </div>

        <div>

            <strong>{{ $order->address_label }}</strong>

            <br><br>

            {{ $order->street_address }}

            @if($order->address_detail)
                <br>{{ $order->address_detail }}
            @endif

            <br>

            {{ $order->district }},
            {{ $order->city }},
            {{ $order->province }}

            <br>

            {{ $order->postal_code }}

        </div>

    </div>

    {{-- =========================
        PRODUK
    ========================== --}}

    <div style="border-radius:12px;overflow:hidden;border:1px solid #E5E7EB;">

        <table style="width:100%;border-collapse:collapse;">

            <thead>

            <tr style="background:#111827;color:white;">

                <th style="padding:12px;text-align:left;">Produk</th>
                <th style="padding:12px;text-align:center;">Qty</th>
                <th style="padding:12px;text-align:right;">Harga</th>
                <th style="padding:12px;text-align:right;">Subtotal</th>

            </tr>

            </thead>

            <tbody>

            @foreach($order->items as $item)

                <tr style="border-bottom:1px solid #F3F4F6;">

                    <td style="padding:14px;">
                        <strong>{{ $item->product_name }}</strong>
                    </td>

                    <td style="text-align:center;">
                        {{ $item->qty }}
                    </td>

                    <td style="text-align:right;padding-right:15px;">
                        Rp {{ number_format($item->price,0,',','.') }}
                    </td>

                    <td style="text-align:right;padding-right:15px;font-weight:bold;">
                        Rp {{ number_format($item->qty * $item->price,0,',','.') }}
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

    {{-- =========================
        RINGKASAN
    ========================== --}}

    <div style="border:1px solid #E5E7EB;border-radius:12px;padding:18px;">

        <div style="font-weight:bold;font-size:15px;margin-bottom:12px;">
            💳 Ringkasan Pembayaran
        </div>

        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->total_price,0,',','.') }}</span>
        </div>

        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
            <span>Ongkos Kirim</span>
            <span>Gratis</span>
        </div>

        <hr style="margin:12px 0;">

        <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:bold;">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_price,0,',','.') }}</span>
        </div>

    </div>

</div>