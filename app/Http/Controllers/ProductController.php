<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('product.data.index', compact('products'));
    }

    public function create()
    {
        return view('product.data.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
        ]);

        $post = Product::create([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
        ]);

        if ($post) {
            return redirect()->route('dashboard.product.data.index')->with('success', 'Product Data Created');
        } else {
            return back();
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);

        return view('product.data.edit', compact('product'));
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|integer',
        ]);

        $update = $product->update([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
        ]);

        if ($update) {
            return redirect()->route('dashboard.product.data.edit', $product->id)->with('success', 'Product Data Updated!');
        } else {
            return back();
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);

        $delete = $product->delete();

        if ($delete) {
            return redirect()->route('dashboard.product.data.index')->with('success', 'Product Data Deleted!');
        }
    }
}
