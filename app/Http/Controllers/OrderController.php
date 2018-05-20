<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('orders.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'delivery_time' => 'required|date_format:d/m/Y H:i',
        ]);

        $order = new Order;
        if (Auth::check()) $order->user_id = Auth::id();
        $order->status = 'pending';
        $order->customer_name = $request->input('customer_name');
        $order->customer_address = $request->input('customer_address');
        $order->customer_phone = $request->input('customer_phone');
        $order->delivery_time = Carbon::createFromFormat('d/m/Y H:i', $request->input('delivery_time'));
        $order->shipping_fee = $request->input('shipping_fee');
        $order->payment_method = $request->input('payment_method');
        $order->subtotal = \Cart::subtotal();
        $order->total = $request->input('total');
        $order->save();

        foreach(\Cart::content() as $row)
        {
            $productId = $row->id;
            $quantity = $row->qty;
            $productOption = ProductOption::where('key', 'size')
                ->where('value', $row->options->size)
                ->get(['id'])
                ->first();
            $optionId = $productOption['id'];
            $order->products()->attach($productId, ['product_option' => $optionId, 'quantity' => $quantity]);
        }

        \Cart::destroy();
        return redirect()->back()->with('status', 'Đặt Hàng Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
