<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    private string $routeResourceName = 'brand';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Brand::latest()->when($request->name, fn(Builder $builder, $name) => $builder->where('brand_name', 'like', "%{$name}%"))->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return inertia()->render('Brand/Index', [
            'data' => $data,
            'title' => 'Quản lý thương hiệu',
            'breadcrumb' => ['Bẳng điều khiển' => 'admin.dashboard'],
            'filters' => (object) $request->all(),
            'category' => Category::with('childrenCategories')->where('parent_category', 0)->get(['id', 'category_name']),
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
        $categories =  Category::with('childrenCategories')->where('parent_category', 0)->get(['id', 'category_name'])->toArray();
        $arrTree = [];
        foreach ($categories as $key => $value) {
            $arrTree[] =  ['id' => $value['id'], 'label' => $value['category_name']];
            if ($value['children_categories']) {
                foreach ($value['children_categories'] as $key1 => $value1) {
                    $arrTree[$key]['children'][] = ['id' => $value1['id'], 'label' => $value1['category_name']];
                    if ($value1['categories']) {
                        foreach ($value1['categories'] as $key2 => $value2) {
                            $arrTree[$key]['children'][$key1]['children'][] = ['id' => $value2['id'], 'label' => $value2['category_name']];
                        }
                    }
                }
            } else {
                $arrTree[] =  ['id' => $value['id'], 'label' => $value['category_name']];
            }
        }

        return inertia()->render('Brand/Create', [
            'title' => 'Tạo thương hiệu',
            'edit' => false,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            // 'category' => $arrTree,
            'category' => $arrTree,
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
        // return $request->input();
        $request->validate([
            'name' => 'required|unique:brands,brand_name',
            // 'brand_img' => 'image|mimes:jpeg,jpg,png,svg|max:2048',
            'brand_cat' => 'required',
        ]);

        if ($request->brand_img) {
            $image = $request->brand_img->getClientOriginalName();
            $request->brand_img->move(public_path('brand'), $image);
        }

        $slug = str_replace(array('_', ' ',), '-', strtolower($request->input("name")));
        $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input("name")));

        $brand = new Brand();
        if ($request->brand_img) {
            $brand->brand_img = $image;
        }
        $brand->brand_name = $request->input('name');

        $brand->brand_subcat = implode(',', $request->input('brand_cat'));
        if ($request->input('meta_title') != '') {
            $brand->meta_title = $request->input('meta_title');
        } else {
            $brand->meta_title = $meta_title;
        }
        $brand->meta_desc = $request->input('meta_desc');
        $brand->brand_slug = $slug;
        $brand->status = $request->input('brand_status') ?? 1;
        $result = $brand->save();
        return to_route('admin.brand.index')->with('success', 'Thương hiệu được tạo thành công.!');
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
        $categories =  Category::with('childrenCategories')->where('parent_category', 0)->get(['id', 'category_name'])->toArray();
        $arrTree = [];
        foreach ($categories as $key => $value) {
            $arrTree[] =  ['id' => $value['id'], 'label' => $value['category_name']];
            if ($value['children_categories']) {
                foreach ($value['children_categories'] as $key1 => $value1) {
                    $arrTree[$key]['children'][] = ['id' => $value1['id'], 'label' => $value1['category_name']];
                    if ($value1['categories']) {
                        foreach ($value1['categories'] as $key2 => $value2) {
                            $arrTree[$key]['children'][$key1]['children'][] = ['id' => $value2['id'], 'label' => $value2['category_name']];
                        }
                    }
                }
            }
        }

        $brand = Brand::where(['id' => $id])->first();
        return inertia()->render('Brand/Create', [
            'title' => 'Chỉnh sửa thương hiệu',
            'edit' => true,
            'item' => $brand,
            'category' => $arrTree,
            'breadcrumb' => ['Bảng điều khiển' => 'admin.dashboard'],
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
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            // 'name' => 'required|unique:brands,brand_name,' .$id. ',id',
            'brand_name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique(Brand::class)->ignore($id ?? null, 'brand_name')],
            'brand_img' => ['nullable', 'max:255'],

        ]);

        //update Brand Image

        if ($request->brand_img != '') {
            $path = public_path() . '/brand/';
            //code for remove old file
            if ($request->old_img != '' && $request->old_img != null) {
                $file_old = $path . $request->old_img;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }

            //upload new file
            $file = $request->brand_img;
            $image = $request->brand_img->getClientOriginalName();
            $file->move($path, $image);
        } else {
            $image = $request->old_img;
        }

        if ($request->slug != '') {
            $slug = str_replace(array('_', ' ',), '-', strtolower($request->input('slug')));
        } else {
            $slug = str_replace(array('_', ' ',), '-', strtolower($request->input('name')));
        }

        if ($request->meta_title != '') {
            $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input('meta_title')));
        } else {
            $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input('name')));
        }

        $brand = Brand::where(['id' => $id])->update([
            'brand_name' => $request->input('name'),
            'brand_img' => $image,
            'brand_subcat' => implode(',', $request->input('brand_cat')),
            'meta_title' => $meta_title,
            'meta_desc' => $request->input('meta_desc'),
            'brand_slug' => $slug,
            'status' => $request->input('brand_status') ?? 1
        ]);
        return to_route('admin.brand.index')->with('success', 'Cập nhật thương hiệu thành công!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $check = Product::where('brand', $id)->count();
        if ($check == '0') {
            $destroy = Brand::where(['id' => $id])->delete();
            return back()->with('success', 'Xóa thương hiệu thành công.!');
        } else {
            return back()->with('error', "Bạn không thể xóa mục này, Màu sắc này đã được sử dụng trong Sản phẩm.");
        }
    }
}
