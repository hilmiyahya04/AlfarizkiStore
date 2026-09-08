<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    private function getCartItems()
    {
        if (Auth::check()) {
            $items = CartItem::where('user_id', Auth::id())->with(['product', 'variant'])->get();
            $cart = [];

            foreach ($items as $item) {
                if ($item->product) {
                    $key = $item->product_id . '_' . $item->product_variant_id;
                    $cart[$key] = [
                        "id" => $item->product_id,
                        "variant_id" => $item->product_variant_id,
                        "name" => $item->product->productName,
                        "price" => $item->product->productPrice,
                        "image" => $item->product->productImage1 ?? null,
                        "size" => $item->variant?->size,
                        "color" => $item->variant?->color,
                        "quantity" => $item->quantity,
                    ];
                }
            }
            return $cart;
        }

        return json_decode(request()->cookie('guest_cart'), true) ?? [];
    }

    private function saveCartItems($cart)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            CartItem::where('user_id', $userId)->delete();
            foreach ($cart as $productId => $item) {
                CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $item['id'],
                    'product_variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        } else {
            Cookie::queue('guest_cart', json_encode($cart), 60 * 24 * 7);
        }
    }

    public function index()
    {
        $cart = $this->getCartItems();

        $lastAddress = null;
        if (Auth::check()) {
            $lastAddress = \App\Models\orders::where('userId', Auth::id())
                ->latest()
                ->first();
        }

        // Ambil semua produk untuk dirender di Blade
    $products = \App\Models\product::all();

    // Kirim $products ke view
    return view('cart', compact('cart', 'lastAddress', 'products'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $variantId = $request->product_variant_id;

        // FIX: ambil qty dari input, minimal 1
        $qty = (int) $request->input('quantity', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        $cart = $this->getCartItems();
        $key = $id . '_' . $variantId;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty; // FIX: tambah sesuai qty, bukan selalu +1
        } else {
            $cart[$key] = [
                "id"         => $product->id,
                "variant_id" => $variantId,
                "name"       => $product->productName,
                "price"      => $product->productPrice,
                "image"      => $product->productImage1 ?? null,
                "quantity"   => $qty, // FIX: pakai qty, bukan hardcode 1
            ];
        }

        $this->saveCartItems($cart);

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Produk berhasil ditambahkan ke keranjang.'
            ]);
        }

        if ($request->has('redirect_to_cart') || $request->input('redirect_to') === 'cart') {
            return redirect()->route('cart.index')
                ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        }

        return redirect()->back()
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function remove($id)
    {
        $parts = explode('_', $id, 2);
        $productId = $parts[0];
        $variantId = (isset($parts[1]) && $parts[1] !== '') ? $parts[1] : null;

        if (Auth::check()) {
            $query = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId);

            if ($variantId === null) {
                $query->whereNull('product_variant_id');
            } else {
                $query->where('product_variant_id', $variantId);
            }

            $query->delete();
        } else {
            $cart = $this->getCartItems();

            if (isset($cart[$id])) {
                unset($cart[$id]);
                $this->saveCartItems($cart);
            }
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus');
    }

    public function increase($id)
    {
        $cart = $this->getCartItems();

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            $this->saveCartItems($cart);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function decrease($id)
    {
        $cart = $this->getCartItems();

        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
            $this->saveCartItems($cart);
        }

        return response()->json([
            'success' => true
        ]);
    }
}