<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\order_items;
use App\Models\orders;
use App\Models\product_order_track_histories;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'street_address' => 'required|string',
            'address_detail' => 'nullable|string',
            'address_label' => 'nullable|string|max:50',
            'payment_method' => 'required|string|in:COD,Transfer Bank',
        ]);

        $cart = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Cart kosong');
        }

        $total = 0;

        foreach ($cart as $item) {
            if ($item->product) {
                $total += $item->product->productPrice * $item->quantity;
            }
        }

        // Simpan id produk pertama di cart, dipakai buat redirect setelah checkout
        $redirectProductId = $cart->first()->product->id ?? null;

        $order = orders::create([
            'userId' => Auth::id(),
            'orderDate' => now(),
            'paymentMethod' => $validated['payment_method'],
            'orderStatus' => 'pending',
            'id_pemesanan' => 'ORD-' . strtoupper(Str::random(8)),
            'total_price' => $total,
            'recipient_name' => $validated['recipient_name'],
            'phone_number' => $validated['phone_number'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'district' => $validated['district'],
            'postal_code' => $validated['postal_code'],
            'street_address' => $validated['street_address'],
            'address_detail' => $validated['address_detail'] ?? null,
            'address_label' => $validated['address_label'] ?? 'Rumah',
        ]);

        foreach ($cart as $item) {
            if (!$item->product) continue;

            order_items::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'product_name' => $item->product->productName,
                'price' => $item->product->productPrice,
                'qty' => $item->quantity,
                'subtotal' => $item->product->productPrice * $item->quantity,
            ]);
        }

        product_order_track_histories::create([
            'orderId' => $order->id,
            'status' => 'pending',
            'keterangan' => 'Pesanan dibuat',
            'tanggal' => now(),
        ]);

        // Kosongkan cart setelah checkout
        CartItem::where('user_id', Auth::id())->delete();

        // Kirim notifikasi ke semua admin
        $this->notifyAdmins($order);

        return redirect()->back()
            ->with('checkout_success', 'Pesanan Anda berhasil dibuat! Admin Toko Alfarizki akan segera memproses pesanan Anda.')
            ->with('checkout_product_id', $redirectProductId);
    }
    // Kirim notifikasi ke semua user yang punya role super_admin
    private function notifyAdmins(orders $order)
    {
        $admins = User::role('super_admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($order));
        }
    }
}