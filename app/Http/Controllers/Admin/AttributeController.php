<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Attribute_value;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

class AttributeController extends Controller
{
    private string $routeResourceName = 'attribute';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Attribute::select('*')->when($request->name, fn(Builder $builder, $name) => $builder->where('title', 'like', "%{$name}%"))->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return inertia()->render('Attribute/Index', [
            'data' => $data,
            'title' => 'Quản lý thuộc tính',
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
        return inertia()->render('Attribute/Create', [
            'title' => 'Tạo thuộc tính',
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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:attributes,name',
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->input('name');
        $result = $attribute->save();
        return to_route('admin.attribute.index')->with('success', 'Attribute Created Successfuly!.');
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
        $attribute = Attribute::where(['id' => $id])->first();
        return inertia()->render('Attribute/Create', [
            'title' => 'Chỉnh sửa thuộc tính',
            'edit' => true,
            'item' => $attribute,
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
            'name' => 'required|unique:attributes,name,' . $id . ',id',
        ]);

        $attribute = Attribute::where(['id' => $id])->update([
            'name' => $request->input('name'),
        ]);
        return to_route('admin.attribute.index')->with('success', 'Thuộc tính cập nhật thành công!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $check = Attribute_value::where('attribute_id', $id)->count('product_id');
        if ($check == '0') {
            $destroy = Attribute::where(['id' => $id])->delete();
            return back()->with('success', 'Attribute deleted successfully.');
        } else {
            return back()->with('error', "You don't delete this, This color is used in Products Table");
        }
    }
}
