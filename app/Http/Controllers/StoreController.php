<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $brands = Brand::all();

        $query = Product::where('is_active', true)->with(['category', 'brand']);

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        if ($request->has('shape') && $request->shape != '') {
            $query->where('frame_shape', $request->shape);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%"));
        }

        $products = $query->latest()->get();
        $featuredProducts = Product::where('is_active', true)->where('is_featured', true)->take(4)->get();

        return view('store.index', compact('categories', 'brands', 'products', 'featuredProducts'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->with(['category', 'brand'])->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();

        return view('store.show', compact('product', 'relatedProducts'));
    }

    public function bookAppointment(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Appointment::create([
            'patient_name' => $validated['patient_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'appointment_date' => $validated['appointment_date'],
            'time_slot' => $validated['time_slot'],
            'reason' => $validated['reason'] ?? 'Examen de la vista completo',
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        return back()->with('success', '¡Cita de examen visual agendada con éxito! Un optometrista te confirmará por teléfono.');
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $totalAmount = $product->price * $validated['quantity'];

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'shipping_address' => $validated['shipping_address'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'paid',
            'notes' => $validated['notes'],
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'unit_price' => $product->price,
            'total_price' => $totalAmount,
        ]);

        // Reduce stock
        $product->decrement('stock', $validated['quantity']);

        return back()->with('success', "¡Gracias por tu compra! Tu pedido #{$order->order_number} ha sido procesado correctamente.");
    }
}
