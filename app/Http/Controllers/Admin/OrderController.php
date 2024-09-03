<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Color;
use App\Models\Attrvalue;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\OrderProducts;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    private string $routeResourceName = 'orders';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Order::select(['orders.*', 'payments.id as payment_id', 'payments.pay_method', 'payments.pay_status', DB::raw('DATE_FORMAT(orders.created_at, "%d-%m-%Y") as formatted_created'),'users.name','users.email','users.phone','users.address','users.city','users.state','products.product_name','products.unit_price','products.thumbnail_img','products.shipping_days'
                    ,\DB::raw("GROUP_CONCAT(products.id SEPARATOR '|||') as p_id"),\DB::raw("GROUP_CONCAT(order_products.product_delivery SEPARATOR ',') as delivery")])
            ->leftjoin('order_products','order_products.order_id','=','orders.id')
            ->leftjoin('products','products.id','=','order_products.product_id')
            ->leftjoin('users','orders.user','=','users.user_id')
            ->leftjoin('payments','orders.pay_id','=','payments.id')
            ->when(
                $request->pay_status !== null,
                fn (Builder $builder) => $builder->when(
                    $request->pay_status,
                    fn (Builder $builder) => $builder->where('pay_status', '=', 1),
                    fn (Builder $builder) => $builder->where('pay_status', '=', 0)
                )
            )
            ->groupBy('orders.id')
            ->orderBy('id','desc')
            ->paginate(8)->withQueryString();
        return inertia()->render('Order/Index', [
            'data' => $data,
            'title' => 'Orders Management',
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            'filters' => (object) $request->all(),
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeDelivery(Request $request){
        $order_id = $request->post('order_id');
        $product_id = $request->post('product_id');
        $qty = $request->qty;
        Product::where('id',$product_id)->decrement('quantity',$qty);
        
        $order = OrderProducts::where('order_id',$order_id)->where('product_id',$product_id)->update([
            'product_delivery' => '1',
        ]);

        return back()->with('success', 'Order Delivery Successfully!');
    }

    public function view_order(Request $request,$id)
    {
        $products = OrderProducts::select(['order_products.*','products.shipping_days','products.product_name','products.thumbnail_img'])
                    ->leftJoin('products','products.id','=','order_products.product_id')
                    ->where('order_id',$id)->get();

        $attributes = Attribute::select('*')->get();
        $attrvalues = Attrvalue::select(['attrvalues.*','attributes.title'])
                    ->leftjoin('attributes','attributes.id','=','attrvalues.attribute')
                    ->get();
        $color = Color::select(['colors.*'])->get();

        $order = Order::select([ 'orders.*', DB::raw('DATE_FORMAT(orders.created_at, "%d-%m-%Y") as formatted_created')])->find($request->id);

        return inertia()->render('Order/View', [
            'products' => $products,
            'order' => $order,
            'attributes' => $attributes,
            'attrvalues' => $attrvalues,
            'colors' => $color,
            'title' => 'View Order Detail',
            'breadcrumb' => ['Dashboard' => 'admin.dashboard', 'Orders' => 'admin.orders.index'],
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

}
