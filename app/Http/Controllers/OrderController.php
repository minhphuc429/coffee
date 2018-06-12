<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelOrder;
use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrder;
use App\Mail\OrderProcessing;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\User;
use Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
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
        $count = Cart::count();

        return view('orders.create', compact('categories', 'products', 'count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        $order = new Order;
        if (Auth::check()) $order->user_id = Auth::id();
        $order->customer_name = $request->input('customer_name');
        $order->customer_email = $request->input('customer_email');
        $order->customer_address = $request->input('customer_address');
        $order->customer_phone = $request->input('customer_phone');
        $order->delivery_time = Carbon::createFromFormat('d/m/Y H:i', $request->input('delivery_time'));
        $order->shipping_fee = $request->input('shipping_fee');
        $order->payment_method = $request->input('payment_method');
        $order->subtotal = \Cart::subtotal();
        $order->total = $request->input('total');
        $order->save();

        foreach (\Cart::content() as $row) {
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

        if (Auth::check())
            Mail::to(Auth::user()->email)->queue(new OrderProcessing(Auth::user()->name, $order));
        else
            Mail::to($order->customer_email)->queue(new OrderProcessing($order->customer_name, $order));

        return redirect()->back()->with('status', 'Đặt Hàng Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $deliver_id = $order->deliver_id;
        if ($deliver_id)
            $deliver = User::findOrFail($deliver_id, ['name', 'phone']);

        return view('orders.show', compact('order', 'deliver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $deliver_id = $order->deliver_id;
        $delivers = User::whereHas('roles', function ($q) {
            $q->where('name', 'deliver');
        })->get(['id', 'name']);
        $status = Order::getPossibleStatuses();
        return view('orders.edit', compact('order', 'deliver_id', 'delivers', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrder $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        if ($request->input('deliver_id') !== 0) $order->deliver_id = $request->input('deliver_id');
        $order->update();
        return redirect()->back()->with('status', 'Cập Nhật Đơn Hàng Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json();
    }

    /**
     * Display order history.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderHistory()
    {
        if (Auth::check()) { // TODO: only user of order
            $user_id = Auth::id();
            $orders = Order::where('user_id', $user_id)->get();

            return view('orders.history', compact('orders'));
        }
    }

    /**
     * Display order detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderDetail(int $id)
    {
        if (Auth::check()) { // TODO: only user of order
            $order = Order::findOrFail($id)->first();

            return view('orders.detail', compact('order'));
        }
    }

    /**
     * Cancel order.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(CancelOrder $request)
    {
        $order_id = $request->input('order_id');
        $order = Order::findOrFail($order_id); // TODO: only user of order
        $order->status = 'cancelled';
        $order->update();

        return redirect()->back()->with('status', 'Hủy Đơn Hàng Thành Công');
    }
}
