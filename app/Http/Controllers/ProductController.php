<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
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
            'image' => 'image|max:10240'
        ]);

        $product = new Product;
        $product->category_id = $request->input('category_id');
        $product->name = $request->input('name');
        $product->image = $request->file('image')->store('public/images');
        $product->price = $request->input('price');
        $product->save();

        foreach ($request->input('values') as $key => $value)
            $product->productOptions()->create([
                'key' => 'size',
                'value' => $value,
                'surcharge' => $request->input('surcharges')[$key]
            ]);

        return redirect()->back()->with('status', 'Thêm Sản Phẩm Thành Công');
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
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
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
        $request->validate([
            'image' => 'image|max:10240'
        ]);

        $product = Product::findOrFail($id);
        $product->category_id = $request->input('category_id');
        $product->name = $request->input('name');
        $product->image = $request->file('image')->store('public/images');
        $product->price = $request->input('price');
        $product->save();

        // TODO: cap nhat product_option

        return redirect()->back()->with('status', 'Cập Nhật Sản Phẩm Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        ProductOption::where('product_id', $id)->delete();

        return response()->json();
    }

    public function getProductOption(Request $request)
    {
        return response()->json(ProductOption::where('product_id', $request->input('product_id'))->get());
    }
}
