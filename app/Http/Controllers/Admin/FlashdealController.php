<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FlashDeal;
use App\Models\FlashProduct;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FlashdealController extends Controller
{
    private string $routeResourceName = 'flash-deals';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = FlashDeal::latest()->when($request->name, fn(Builder $builder, $name) => $builder->where('flash_title', 'like', "%{$name}%"))->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return inertia()->render('Flashdeal/Index', [
            'data' => $data,
            'title' => 'FlashDeal Management',
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
        $allProducts = Product::select(['id', 'product_name', 'thumbnail_img', 'discount', 'discount_type', 'taxable_price'])->get();
        return inertia()->render('Flashdeal/Create', [
            'title' => 'Add Flash Deals',
            'edit' => false,
            'allProducts' => $allProducts,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard', 'Flash Deals' => 'admin.flash-deals.index'],
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'datetimes' => 'required',
            'products' => 'required',
            'flash_status' => 'required',
        ]);

        if ($request->img) {
            $image = $request->img->getClientOriginalName();
            $request->img->move(public_path('flash-deals'), $image);
        } else {
            $image = '';
        }
        // note: Be careful with grammar H:i A and h:i A
        // dd($request->datetimes);
        $startDatetimes = date('m/d/Y', strtotime($request->datetimes[0]));
        $endDatetimes = date('m/d/Y', strtotime($request->datetimes[1]));
        $flash_date_range = $startDatetimes . ' - ' . $endDatetimes;

        $flash = new FlashDeal();
        $flash->flash_title = $request->input('title');
        $flash->flash_image = $image;
        $flash->flash_date_range = $flash_date_range;
        // $flash->flash_slug = $slug;
        $flash->status = $request->input('flash_status');
        $result = $flash->save();

        if ($request->products) {
            $datasave = [];
            foreach ($request->products as $value) {
                $datasave[] = [
                    'deals_id' => $flash->id,
                    'product_id' => $value['id'],
                    'product_discount' => $value['discount'],
                    'product_discount_type' => $value['discount_type'],
                ];
            }
            FlashProduct::insert($datasave);
        }

        return to_route('admin.' . $this->routeResourceName . '.index')->with('success', 'Attrvalue Created Successfuly!.');
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
        $allProducts = Product::select(['id', 'product_name', 'thumbnail_img', 'discount', 'discount_type', 'taxable_price'])->get();
        $flash_deal = FlashDeal::select(['flash_deals.*', \DB::raw('GROUP_CONCAT(flash_products.product_id) as f_products')])->where(['flash_deals.id' => $id])
            ->leftJoin('flash_products', 'flash_products.deals_id', '=', 'flash_deals.id')
            ->groupBy('flash_deals.id')
            ->first();

        $flash_products = FlashProduct::select(['products.id','flash_products.product_discount','flash_products.product_discount_type', 'products.product_name', 'products.taxable_price', 'products.thumbnail_img'])
            ->leftjoin('products', 'products.id', '=', 'flash_products.product_id')
            ->where(['deals_id' => $id])->get();

        return inertia()->render('Flashdeal/Create', [
            'title' => 'Edit Flash Deals',
            'edit' => true,
            'allProducts' => $allProducts,
            'item' => $flash_deal,
            'flash_products' => $flash_products,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard', 'Flash Deals' => 'admin.flash-deals.index'],
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) : \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'datetimes' => 'required',
            // 'products' => 'required',
            'flash_status' => 'required',
        ]);

        if ($request->img != '') {
            $path = public_path() . '/flash-deals/';
            if ($request->old_img != '' && $request->old_img != null) {
                $file_old = $path . $request->old_img;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }

            //upload new file
            $file = $request->img;
            $image = $request->img->getClientOriginalName();
            $file->move($path, $image);
        } else {
            $image = $request->old_img;
        }
        // dd($request->products);
        $startDatetimes = date('m/d/Y', strtotime($request->datetimes[0]));
        $endDatetimes = date('m/d/Y', strtotime($request->datetimes[1]));
        $flash_date_range = $startDatetimes . ' - ' . $endDatetimes;
        $flash = FlashDeal::where(['id' => $id])->update([
            'flash_title' => $request->input('title'),
            'flash_image' => $image,
            'flash_date_range' => $flash_date_range,
            'status' => $request->input('flash_status'),
        ]);
        
        if (!empty($request->input('products'))) {
            if ($request->flash_id) {
                $flash_id = $request->input('flash_id');
                DB::table('flash_products')->where('deals_id', $flash_id)->delete();
            }
            $datasave = [];
            foreach ($request->products as $value) {
                $datasave[] = [
                    'deals_id' => $id,
                    'product_id' => $value['id'],
                    'product_discount' => $value['product_discount'],
                    'product_discount_type' => $value['product_discount_type'],
                ];
            }
            // dd($datasave);
            FlashProduct::insert($datasave);
        } else {
            if ($request->flash_id) {
                $flash_id = $request->input('flash_id');
                DB::table('flash_products')->where('deals_id', $flash_id)->delete();
            }
        }

        return to_route('admin.'.$this->routeResourceName.'.index')->with('success', 'Flash Deals Created Successfuly!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = FlashDeal::where(['id' => $id])->delete();
        FlashProduct::where(['deals_id' => $id])->delete();
        return back()->with('success', 'Deal And Product deleted successfully!!.');
    }

    public function get_flash(Request $request)
    {
        if ($request->input()) {
            $product_id = $request->flash;

            $products = Product::whereIn('id', $product_id)->get();

            $output = '';
            if (!empty($products)) {
                foreach ($products as $row) {
                    $output .= '<tr id="prd' . $row->id . '">
                        <td>
                            <img src="' . asset("products/" . $row->thumbnail_img) . '" width="80px">
                        </td>
                        <td>
                            <input type="hidden" class="form-control" name="product_id" value="' . $row->id . '">
                            <span><b>Product Name :</b> ' . $row->product_name . '</span><br>
                            <span><b>Product Price :</b> ' . $row->taxable_price . '</span>
                        </td>
                        <td>
                            <span><b>Discount :</b></span>
                            <input type="number" class="form-control" name="discount[]" placeholder="Discount" value="0" required>
                        </td>
                        <td>
                            <span><b>Discount Type :</b></span>
                            <select class="form-control" name="discount_type[]" required>
                                <option value="flat" selected>Flat</option>
                                <option value="percent">Percent</option>
                            </select>
                        </td>
                    </tr>';
                }
            } else {
                $output .= '<option disabled selected value=">No Attribute Value Found</option>';
            }
            return $output;
        }
    }

    public function get_flash_edit(Request $request)
    {
        if ($request->input()) {

            $product_id = $request->products;

            $flash_id = $request->flash;

            if (!empty($product_id)) {
                $products = Product::whereIn('id', $product_id)->get();
            } else {
                $products = '';
            }

            // if(!empty($product_id)){
            //     $flash_products = FlashProduct::whereIn('product_id',$product_id)->where('deals_id',$flash_id)->get();
            // }else{
            //     $flash_products = '';
            // }

            $output = '';
            if (!empty($products)) {
                foreach ($products as $row) {
                    $discount = '';
                    $flash_products = FlashProduct::where('product_id', $row->id)->where('deals_id', $flash_id)->first();
                    // if(isset($flash_products[$key])){
                    if (!empty($flash_products)) {
                        $discount = $flash_products->product_discount;
                    }
                    // }
                    $output .= '<tr id="prd' . $row->id . '">
                        <td>
                            <img src="' . asset("products/" . $row->thumbnail_img) . '" width="80px">
                        </td>
                        <td>
                            <input type="hidden" class="form-control" name="product_id" value="' . $row->id . '">
                            <span><b>Product Name :</b> ' . $row->product_name . '</span><br>
                            <span><b>Product Price :</b> ' . $row->taxable_price . '</span>
                        </td>
                        <td>
                            <span><b>Discount :</b></span>
                            <input type="number" class="form-control" name="discount[]" value="' . $discount . '" placeholder="Discount">
                        </td>
                        <td>
                            <span><b>Discount Type :</b></span>
                            <select class="form-control" name="discount_type[]" id="">
                                <option value="flat">Flat</option>
                                <option value="percent">Percent</option>
                            </select>
                        </td>
                    </tr>';
                }
            } else {
                $output .= '<option disabled selected value=">No Products Found</option>';
            }
            return $output;
        }
    }
}
