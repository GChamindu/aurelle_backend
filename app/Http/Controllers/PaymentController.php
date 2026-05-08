<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function webhook(Request $request)
{
    $orderNumber = $request->input('order_number');
    $status      = $request->input('payment_status'); // paid, failed, pending
    $transaction = $request->input('transaction_id');

    $order = Order::where('order_number', $orderNumber)->first();
    if ($order) {
        $order->payment_status = $status;
        $order->transaction_id = $transaction;
        $order->save();
    }

    // return success to NDB
    return response()->json(['success' => true]);
}
}
