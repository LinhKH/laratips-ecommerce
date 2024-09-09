<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PayerInfo;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\Input;
use Redirect;
use URL;
use App\Models\UserWallet;
use App\Models\Wallet_Transactions;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\PaymentData;
use App\Models\Users;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Attribute;
use Yajra\DataTables\DataTables;
use Razorpay\Api\Api;
use Exception;
use Inertia\Inertia;
use App\PaymentGateway\Paypal;


class PaymentController extends Controller
{

    public function payWithCod($amt, Request $request)
    {
        Session::put('order', $request->input());
        Session::put('amount', $amt);

        $store = $this->yb_store_ordering(['id' => 'cod'.rand(100000,999999), 'payment_type' => 'cod']);
        if ($store == '1') {
            return redirect('checkout/payment/success')->with('payment_success', 'COD payment successful');
        }
    }

    public function payWithpaypalCustomize($amt, Request $request)
    {
        Session::put('order', $request->input());
        Session::put('amount', $amt);

        $paypal = new Paypal();
        return $paypal->checkout();
    }

    public function paypalSuccess(Request $request)
    {
        $paypal = new Paypal();

        $response = $paypal->capturePaymentOrder($request->token);
        $response['payment_type'] = 'paypal';

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $store = $this->yb_store_ordering($response);
            if ($store == '1') {
                return redirect('checkout/payment/success')->with('payment_success', $response['status']);
            }
        } else {
            return redirect('checkout/payment/failed')->with('payment_error', $response['error']);
        }
    }

    public function yb_store_ordering($response)
    {
        DB::beginTransaction();
        try {
            $request = session()->get('order');
            $payment = new PaymentData();
            $payment->amount = Session::get('amount');
            $payment->txn_id = $response['id'];
            $payment->pay_method = $response['payment_type'];
            $payment->pay_status = $response['payment_type'] == 'paypal' ? 1 : 0;
            $payment->save();
            $user_id = session()->get('user_id');
            if (Session::has('checkout')) {
                $user_products = Product::select('products.*', 'id as product_id')->where('id', $request['product_id'])->get();
                // return $request;
            } else {
                $user_products = Cart::select(['cart.*', 'products.taxable_price'])
                ->leftJoin('products', 'products.id', '=', 'cart.product_id')
                ->where('product_user', $user_id)
                    ->get();
            }

            $product_count = 0;
            $product_qty = 0;
            if (Session::has('checkout')) {
                $product_count = 1;
                $product_qty = 1;
            } else {
                foreach ($user_products as $product) {
                    $product_count++;
                    $product_qty = $product_qty + $product->qty;
                }
            }

            $order = new Order();
            $order->user = $user_id;
            $order->order_address = $request['address'];
            $order->products = $product_count;
            $order->qty = $product_qty;
            $order->pay_id = $payment->id;
            $order->amount = Session::get('amount');
            $order->save();

            $buy_not_from_cart = Session::get('checkout'); // have 'checkout' then buy not from cart, else buy from cart

            $attributeArray = array_map('strtolower', Attribute::pluck('title')->toArray());

            foreach ($user_products as $product) {
                $price = get_product_price($product->product_id);      
                $product->discount = $price->old_price - $price->new_price;    
                $product->discount_percent = $price->discount; 

                $attrvalues = '';
                $color = '';
                if ($request && !empty($buy_not_from_cart)) {
                    $attr_array = [];
                    foreach ($request as $key => $value) {
                        if (in_array($key, $attributeArray)) {
                            $attr_key = Attribute::where('title', ucfirst($key))->pluck('id')->first();
                            array_push($attr_array, "{$attr_key}:{$value}");
                        } elseif ($key == 'color') {
                            $color = $value;
                        }
                    }
                    $attrvalues = implode(',', $attr_array);
                } else {
                    $color = $product->color;
                    $attrvalues = $product->attrvalues;
                }

                if (!$product->qty) {
                    $product->qty = 1;
                }

                $order_products = new OrderProducts();
                $order_products->order_id = $order->id;
                $order_products->product_id = $product->product_id;
                $order_products->product_qty = $product->qty;
                $order_products->product_color = $color;
                $order_products->product_attr = $attrvalues;
                $order_products->product_amount = (int) $product->taxable_price - $product->discount;
                $order_products->product_delivery = 0;
                $saveOrderProduct = $order_products->save();
                if (!Session::has('checkout')) {
                    DB::table('cart')->where('product_user', $user_id)->where('product_id', $product->product_id)->delete();
                }
            }

            DB::commit();
            Session::forget('paypal_payment_id');
            Session::forget('amount');

            session()->flash('success', 'Order Confirmed Successfully');
            return $saveOrderProduct;
        } catch (\Exception $e) {
            DB::rollback();
            logger('error', $e->getMessage());
        }
        
    }

    public function paymentSuccess()
    {
        return Inertia::render('Success');
    }
    public function paymentCancel()
    {
        return Inertia::render('Cancel');
        // return abort('404');
    }

    public function success()
    {
        if (Session::has('order')) {
            Session::forget('order');
            Session::forget('checkout');
            return Inertia::render('Success');
        } else {
            return abort('404');
        }
    }
}
