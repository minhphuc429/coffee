<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*Cart::add('192ao12', 'Product 1', 1, 9.99);
        Cart::add('1239ad0', 'Product 2', 2, 5.95, ['size' => 'large']);
        Cart::store('minhphuc429@gmail.com');*/
        $carts = Cart::content();
        //print_r($carts);die;

        return view('orders.cart', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Cart::add('1', 'Classic Phin Freeze', 1, 49000);
        // Cart::destroy();
        // Cart::store('minhphuc429@gmail.com');
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
        $order = new Order;

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

    public function InsertShoppingCartItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric'
        ]);

        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);
        Cart::add($productId, $product->name, 1, $product->price); // TODO: product size

        return response()->json(['message' => 'Insert ShoppingCart Item success']);
    }

    public function LoadCartItem()
    {

    }

    public function completion()
    {
        return view('orders.completion');
    }
}
