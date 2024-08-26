<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Attrvalue;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

class AttrvaluesController extends Controller
{
    private string $routeResourceName = 'attribute-values';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Attrvalue::select('attrvalues.*','attributes.title')->when($request->name, fn(Builder $builder, $name) => $builder->where('value', 'like', "%{$name}%")->orWhere('title', 'like', "%{$name}%"))
                                ->leftjoin('attributes','attrvalues.attribute','=','attributes.id')
                                ->orderBy('id','desc')->paginate(10)->withQueryString();
        return inertia()->render('AttrValue/Index', [
            'data' => $data,
            'title' => 'AttrValue Management',
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
        $attribute = Attribute::select('attributes.*')->get();
        return inertia()->render('AttrValue/Create', [
            'title' => 'Create Attrvalue',
            'edit' => false,
            'attribute' => $attribute,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
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
            'attribute'=>'required',
            'value'=>['required',Rule::unique('attrvalues','value')->where(function($query) use ($request){ return $query->where('attribute', '=', $request->attribute);})],
        ]);

        $attrvalue = new Attrvalue();
        $attrvalue->attribute = $request->input('attribute');
        $attrvalue->value = $request->input('value');
        $result = $attrvalue->save();
        return to_route('admin.'.$this->routeResourceName.'.index')->with('success', 'Attrvalue Created Successfuly!.');
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
        $attrvalue = Attrvalue::where(['id'=>$id])->first();
        $attribute = Attribute::select('*')->get();
        return inertia()->render('AttrValue/Create', [
            'title' => 'Edit Attrvalue',
            'edit' => true,
            'item' => $attrvalue,
            'attribute' => $attribute,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
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
            'attribute'=>'required',
            'value'=>['required',Rule::unique('attrvalues','value')->where(function($query) use ($request){ return $query->where('attribute', '=', $request->attribute)->where('id','!=',$request->attrvalue_id);})],
        ]);

        $attrvalue = Attrvalue::where(['id'=>$id])->update([
            'attribute'=>$request->input('attribute'),
            'value'=>$request->input('value'),
        ]);
        return to_route('admin.'.$this->routeResourceName.'.index')->with('success', 'Attrvalue Updated Successfuly!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $destroy = Attrvalue::where(['id'=>$id])->delete();
        return back()->with('success', 'Attrvalue deleted successfully.');
    }
}
