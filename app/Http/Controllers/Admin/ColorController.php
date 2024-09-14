<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ColorController extends Controller
{
    private string $routeResourceName = 'colors';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Color::latest()->when($request->name, fn(Builder $builder, $name) => $builder->where('color_name', 'like', "%{$name}%"))->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return inertia()->render('Color/Index', [
            'data' => $data,
            'title' => 'Quản lý màu sấc',
            'breadcrumb' => ['Bảng điều khiển' => 'admin.dashboard'],
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
        return inertia()->render('Color/Create', [
            'title' => 'Tạo màu sắc',
            'edit' => false,
            'breadcrumb' => ['Bảng điều khiển' => 'admin.dashboard'],
            'routeResourceName' => $this->routeResourceName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'color_name' => 'required|unique:colors,color_name',
            'color_code' => 'required'
        ]);

        $color = new Color();
        $color->color_name = $request->input('color_name');
        $color->color_code = $request->input('color_code');
        $color->save();
        return to_route('admin.colors.index')->with('success', 'Màu sắc được tạo thành công!.');
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
        $color = Color::where(['id' => $id])->first();
        return inertia()->render('Color/Create', [
            'title' => 'Chỉnh sửa màu sắc',
            'edit' => true,
            'item' => $color,
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
    public function update(Request $request, $id):\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'color_name' => 'required|unique:colors,color_name,' . $id . ',id',
            'color_code' => 'required'
        ]);

        Color::where(['id' => $id])->update([
            'color_name' => $request->input('color_name'),
            'color_code' => $request->input('color_code'),
        ]);
        return to_route('admin.colors.index')->with('success', 'Màu sắc được cập nhật thành công!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id):\Illuminate\Http\RedirectResponse
    {
        $check = Product::where('colors', 'LIKE', "%{$id}%")->count();
        if ($check == '0') {
            Color::where(['id' => $id])->delete();
            return back()->with('success', 'Màu sắc được xóa thành công.');
        } else {
            return back()->with('error', "Bạn không thể xóa màu sắc này. Nó được sử dụng trong sản phẩm");
        }
    }
}
