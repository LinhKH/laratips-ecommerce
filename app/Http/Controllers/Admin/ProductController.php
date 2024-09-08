<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Attrvalue;
use App\Models\Attribute;
use App\Models\Color;
use App\Models\Attribute_value;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    private string $routeResourceName = 'products';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::with('category')->latest()
        ->when($request->name, fn(Builder $builder, $name) => $builder->where('product_name', 'like', "%{$name}%"))
        ->when($request->brand, fn(Builder $builder, $brand) => $builder->where('brand', '=', $brand))
        ->when(
            $request->today_deal !== null,
            fn (Builder $builder) => $builder->when(
                $request->today_deal,
                fn (Builder $builder) => $builder->where('today_deal', '=', 1),
                fn (Builder $builder) => $builder->where('today_deal', '=', 0)
            )
        )
        ->orderBy('id', 'desc')->paginate(8);
        $brands = Brand::where('status',1)->get(['id','brand_name']);
        return inertia()->render('Product/Index', [
            'data' => $data,
            'brands' => $brands,
            'title' => 'Products Management',
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
        $tax = Tax::all();
        $category = Category::where('parent_category', 0)
                    ->with('childrenCategories')
                    ->get();
        $brand = Brand::all();
        $attrvalues = Attrvalue::select(['attrvalues.*', 'attributes.title'])
                    ->leftjoin('attributes', 'attributes.id', '=', 'attrvalues.attribute')
                    ->get();
        $attribute = Attribute::select(['attributes.*'])
                        ->get();
        $colors = Color::select(['colors.*'])->get();
        return inertia()->render('Product/Create', [
            'title' => 'Add Product',
            'edit' => false,
            'tax' => $tax,
            'category' => $category,
            'brand' => $brand,
            'attrvalues' => $attrvalues,
            'attribute' => $attribute,
            'colors' => $colors,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard', 'Products List' => 'admin.products.index'],
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {

        $request->validate([
            'product_name' => 'required',
            'category' => 'required',
            'tags' => 'required',
            'unit_price'=>'required',
            'quantity' => 'required',
            'shipping_charges' => 'required',
            'brand'=>'required',
            'thumbnail_img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'min_qty' => 'required',
            // 'barcode'=>'required',
            // 'tax' => 'required',
            // 'product_status'=>'required','attributes' => 'required|array',
            'attributes.*.id' => 'required|distinct'
        ],[
            'attributes.*.id.distinct' => 'Thuộc tính không được trùng nhau',
        ]);

        

        if ($request->thumbnail_img) {
            $image = $request->thumbnail_img->getClientOriginalName();
            $request->thumbnail_img->move(public_path('products'), $image);
        } else {
            $image = '';
        }

        $gallery = [];
        if ($request->hasfile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $name = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('products'), $name);
                $gallery[] = $name;
            }
        }
        if ($request->refundable) {
            $refundable = 1;
        } else {
            $refundable = 0;
        }

        if ($request->today_deal) {
            $today_deal = 1;
        } else {
            $today_deal = 0;
        }

        // $slug = str_replace(array('_', ' ',), '-', strtolower($request->input("product_name")));
        $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input('product_name')));

        $products = new Product();
        $products->thumbnail_img = $image;
        $products->gallery_img = implode(',', $gallery);
        $products->product_name = $request->input('product_name');
        $products->category = $request->input('category')['id'];
        $products->brand = $request->input('brand');
        $products->unit = $request->input('unit');
        // $products->min_qty = $request->input('min_qty');
         if ($request->tags) {
            $products->tags = implode(',', $request->input('tags'));
        }
        $products->refundable = $refundable;
        if ($request->color) {
            $products->colors = implode(',', $request->input('color'));
        }
        $startDatetimes = date('m/d/Y', strtotime($request->datetimes[0]));
        $endDatetimes = date('m/d/Y', strtotime($request->datetimes[1]));
        $flash_date_range = $startDatetimes . ' - ' . $endDatetimes;

        $products->unit_price = $request->input('unit_price');
        $products->taxable_price = $request->input('unit_price');
        $products->quantity = $request->input('quantity');
        $products->date_range = $flash_date_range;
        $products->discount = $request->input('discount');
        $products->discount_type = $request->input('discount_type');
        $products->description = htmlspecialchars($request->input('description'));
        $products->meta_title = $meta_title;
        $products->meta_desc = $request->input('meta_desc');
        $products->today_deal = $today_deal;
        $products->shipping_charges = $request->input('shipping_charges');
        $products->shipping_days = $request->input('shipping_days');
        $products->status = $request->input('product_status');
        $result = $products->save();

        if ($request->attributes) {
            $arrAttributes = $request->input('attributes');
            $datasave = [];
            for ($i = 0; $i < count($arrAttributes); $i++) {
                $datasave = [
                    'attribute_id' => $arrAttributes[$i]['id'],
                    'attrvalues' => implode(',', \Arr::pluck($arrAttributes[$i]['value'], 'id') ),
                    'product_id' => $products->id
                ];
                Attribute_value::insert($datasave);
            }
        }
        return to_route('admin.' . $this->routeResourceName . '.index')->with('success', 'Product Created Successfuly!.');
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
        $products = Product::where(['id' => $id])->first()->toArray();
        // $tax = Tax::all();
        $category = Category::where('parent_category', 0)
            ->with('childrenCategories')
            ->get();
        $brand = Brand::all();
        $colors = Color::select(['colors.*'])->get();
        $attrvalues = Attrvalue::select(['attrvalues.*', 'attributes.title'])
            ->leftjoin('attributes', 'attributes.id', '=', 'attrvalues.attribute')
            ->get();

        $attribute = Attribute::select(['attributes.*'])
            ->get();
        $attribute_values = Attribute_value::where(['product_id' => $id])->get();

        $products['attributes'] = [];
        $products['category'] = Category::where('id', $products['category'])->get()->toArray();

        if ($products['colors']) {
            $products['color'] = Color::whereIn('id', explode(',', $products['colors']))->get()->toArray();
        }

        if (!empty($attribute_values)) {
            foreach ($attribute_values as $attribute_value) {
                // dd(Attrvalue::whereIn('id', explode(",", $attribute_value->attrvalues))->get()->toArray());
                $products['attributes'][] = [
                    'id' => $attribute_value->attribute_id,
                    'value' => Attrvalue::whereIn('id', explode(",", $attribute_value->attrvalues))->get()->toArray(),
                ];
            }
        }

        return inertia()->render('Product/Create', [
            'title' => 'Edit Product',
            'edit' => true,
            'item' => $products,
            // 'tax' => $tax,
            'category' => $category,
            'brand' => $brand,
            'attrvalues' => $attrvalues,
            'attribute' => $attribute,
            'attribute_values' => $attribute_values,
            'colors' => $colors,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard', 'Products List' => 'admin.products.index'],
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
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'product_name' => 'required',
            'category' => 'required',
            'tags' => 'required',
            'unit_price'=>'required',
            'quantity' => 'required',
            'shipping_charges' => 'required',
            'brand'=>'required',
            'attributes.*.id' => 'required|distinct'
        ],[
            'attributes.*.id.distinct' => 'Thuộc tính không được trùng nhau',
        ]);

        if ($request->thumbnail_img != '') {
            $path = public_path() . '/products/';
            //code for remove old file
            if ($request->old_img != '' && $request->old_img != null) {
                $file_old = $path . $request->old_img;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->thumbnail_img;
            $image = $request->thumbnail_img->getClientOriginalName();
            $file->move($path, $image);
        } else {
            $image = $request->old_img;
        }

        $gallery = [];
        if ($request->hasfile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $name = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('products'), $name);
                $gallery[] = $name;
            }
        }
        
        $gallery = Arr::collapse([$gallery,$request->old_gallery]);
        
        if ($request->refundable) {
            $refundable = 1;
        } else {
            $refundable = 0;
        }

        if ($request->today_deal) {
            $today_deal = 1;
        } else {
            $today_deal = 0;
        }

        if ($request->meta_title != '') {
            $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input('meta_title')));
        } else {
            $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input('product_name')));
        }

        if ($request->color) {
            $arrColors = [];
            foreach ($request->color as $key => $color) {
                $arrColors[] = $color['id'];
            }

            $colors = implode(',', $arrColors);
        } else {
            $colors = '';
        }

        $flash_date_range = null;
        if ($request->datetimes) {
            $startDatetimes = date('m/d/Y', strtotime($request->datetimes[0]));
            $endDatetimes = date('m/d/Y', strtotime($request->datetimes[1]));
            $flash_date_range = $startDatetimes . ' - ' . $endDatetimes;
        }

        $products = Product::where(['id' => $id])->update([
            'thumbnail_img' => $image,
            'gallery_img' => implode(',', $gallery),
            'product_name' => $request->input('product_name'),
            'category' => $request->input('category')[0]['id'],
            'brand' => $request->input('brand'),
            'unit' => $request->input('unit'),
            'min_qty' => $request->input('min_qty'),
            'tags' => implode(',', $request->input('tags')),
            'refundable' => $refundable,
            'colors' => $colors,
            'unit_price' => $request->input('unit_price'),
            'taxable_price' => $request->input('unit_price'),
            'quantity' => $request->input('quantity'),
            'date_range' => $flash_date_range,
            'discount' => $request->input('discount'),
            'discount_type' => $request->input('discount_type'),
            'description' => $request->input('description'),
            'meta_title' => $meta_title,
            'meta_desc' => $request->input('meta_desc'),
            'status' => $request->input('product_status'),
            // 'show_quantity' => $show_qty,
            'today_deal' => $today_deal,
            'shipping_charges' => $request->input('shipping_charges'),
            'shipping_days' => $request->input('shipping_days')
        ]);

        if (!empty($request->input('attributes'))) {

            $arrAttributes = $request->input('attributes');

            DB::table('attributes_values')->where('product_id', '=', $id)->delete();
            $datasave = [];
            for ($i = 0; $i < count($arrAttributes); $i++) {
                $datasave[] = [
                    'attribute_id' => $arrAttributes[$i]['id'],
                    'attrvalues' => implode(',', \Arr::pluck($arrAttributes[$i]['value'], 'id') ),
                    'product_id' => $id
                ];
            }
            Attribute_value::insert($datasave);
        } else {
            DB::table('attributes_values')->where('product_id','=', $id)->delete();
        }

        return to_route('admin.'.$this->routeResourceName.'.index')->with('success', 'Product Updated Successfuly!.');
    }

    public function deleteImage($id, $image)
    {
        $product = Product::findOrFail($id);
        $gallery = array_filter(explode(',', $product->gallery_img));

        if (file_exists(public_path('products/' . $image))) {
            unlink(public_path('products/') . $image);
        }

        if (($key = array_search($image, $gallery)) !== false) {
            unset($gallery[$key]);
        }
        
        $product->gallery_img = implode(',', $gallery);
        $product->save();

        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) :\Illuminate\Http\RedirectResponse
    {
        $destroy = Product::where(['id' => $id])->delete();
        return back()->with('success', 'Product deleted successfully!!.');
    }

    public function get_attrvalue(Request $request)
    {
        if ($request->input()) {
            $attribute = $request->attribute;

            $attrvalues = Attrvalue::where(['attribute' => $attribute])->get();

            $output = '<option disabled value="">Select Attribute Value</option>';
            if (!empty($attrvalues)) {
                foreach ($attrvalues as $row) {
                    $output .= '<option value="' . $row['id'] . '">' . $row['value'] . '</option>';
                }
            } else {
                $output = '<option disabled selected value=">No Attribute Value Found</option>';
            }
            return $output;
        }
    }
}
