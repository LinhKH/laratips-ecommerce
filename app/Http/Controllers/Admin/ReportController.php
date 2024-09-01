<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    private string $routeResourceName = 'product_sale';
    public function product_sale(Request $request)
    {
        $data = Product::with('category')->select(['products.*', 'order_products.product_id', \DB::raw("SUM(order_products.product_qty) as total_id")])
                ->leftjoin('order_products', 'order_products.product_id', '=', 'products.id');
                
        if ($request->category && $request->category != 'all') {
            $categoryIDs = get_category_children($request->category);
            $data->whereIn('category', $categoryIDs);
        }
        if ($request->name) {
            $data->where('product_name','like', "%{$request->name}%");
        }

        $data = $data->groupBy('products.id')->orderBy('total_id', 'desc')->paginate(10)->withQueryString();

        return inertia()->render('Report/Index', [
            'data' => $data,
            'title' => 'Products Sole Report',
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            'filters' => (object) $request->all(),
            'routeResourceName' => $this->routeResourceName,
        ]);

    }

    public function product_stock(Request $request)
    {
        $data = Product::with('category')->select('id','product_name','category', 'quantity', 'thumbnail_img')->orderBy('id', 'desc');
        if ($request->category && $request->category != 'all') {
            $categoryIDs = get_category_children($request->category);
            $data->whereIn('category', $categoryIDs)->orderBy('id', 'desc');
        } 
        if ($request->name) {
            $data->where('product_name','like', "%{$request->name}%");
        }
        $data = $data->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return inertia()->render('ReportStock/Index', [
            'data' => $data,
            'title' => 'Product Stock Report',
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            'filters' => (object) $request->all(),
            'routeResourceName' => 'product_stock',
        ]);
    }
}
