<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Midtrans\Config;
use Midtrans\Snap;

class MakePaymentController extends Controller
{
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        $this->_configureMidtrans();
    }

    public function _configureMidtrans()
    {
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }

    public function index()
    {
        $products = Product::all();

        return view('transaction.make.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric',
            'product' => 'required',
        ]);

        $find_number = Customer::where('number', $request->get('number'))->first();

        if (!$find_number) {
            return redirect()->route('dashboard.transaction.make.index')->with('error_query', 'Customer Number Not Found');
        }

        $product = Product::find($request->get('product'));

        $code = rand();

        $snap_transaction = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => $product->price,
            ],
            'item_details' => [
                [
                    'price' => $product->price,
                    'quantity' => 1,
                    'name' => $product->name,
                ],
            ],
            'customer_details' => [
                'name' => Auth::user()->name,
                'email' =>  Auth::user()->email,
                'phone' =>  Auth::user()->phone,
            ]
        ];

        $token = Snap::getSnapToken($snap_transaction);

        $post = Transaction::create([
            'code' => $token,
            'product_id' => $product->id,
            'user_id' => Auth::user()->id,
            'total' => $product->price,
            'status' => 'unpaid',
        ]);

        if ($post) {
            return redirect()->route('dashboard.transaction.history.index')->with('success', 'Payment Created!');
        } else {
            return back();
        }
    }
}
