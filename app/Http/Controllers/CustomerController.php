<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('customer.data.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.data.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric|unique:customers,number',
            'address' => 'required',
        ]);

        $post = Customer::create([
            'name' => $request->get('name'),
            'number' => $request->get('number'),
            'address' => $request->get('address'),
        ]);

        if ($post) {
            return redirect()->route('dashboard.customer.data.index')->with('success', 'Customer Data Created');
        } else {
            return back();
        }
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        return view('customer.data.edit', compact('customer'));
    }

    public function update($id, Request $request)
    {
        $customer = Customer::find($id);

        $request->validate([
            'name' => 'required',
            'number' => "required|numeric|unique:customers,number,$id",
            'address' => 'required',
        ]);

        $update = $customer->update([
            'name' => $request->get('name'),
            'number' => $request->get('number'),
            'address' => $request->get('address'),
        ]);

        if ($update) {
            return redirect()->route('dashboard.customer.data.edit', $customer->id)->with('success', 'Customer Data Updated!');
        } else {
            return back();
        }
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        $delete = $customer->delete();

        if ($delete) {
            return redirect()->route('dashboard.customer.data.index')->with('success', 'Customer Data Deleted!');
        }
    }
}
