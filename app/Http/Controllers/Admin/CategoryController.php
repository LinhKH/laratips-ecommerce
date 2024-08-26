<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CategoryController extends Controller
{
    private string $routeResourceName = 'category';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Category::with(['categories', 'childrenCategories'])->select(['categories.*', 't2.category_name as parent_name'])
            ->leftJoin('categories as t2', 't2.id', '=', 'categories.parent_category')
            ->orderBy('id', 'desc');
        if ($request->name) {
            $data->where('categories.category_name', 'like', "%{$request->name}%");
        }
        if ($request->parentId) {
            $data->where('categories.parent_category', $request->parentId);
        }
        $data = $data->paginate(10)->withQueryString();
        return inertia()->render('Category/Index', [
            'data' => $data,
            'title' => 'Categories Management',
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            'filters' => (object) $request->all(),
            'routeResourceName' => $this->routeResourceName,
            'rootCategories' => Category::where('parent_category', 0)->get(['id', 'category_name'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.category.create',['category'=>$category,'attributes'=>$attributes]);
        return inertia()->render('Category/Create', [
            'title' => 'Create Category',
            'edit' => false,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard'],
            'routeResourceName' => $this->routeResourceName,
            'attributes' => Attribute::get(['id','title'])->toArray(),
            'category' => Category::with('childrenCategories')->where('parent_category', 0)->get(['id', 'category_name'])
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
            'parentId' => ['bail', 'nullable', 'integer'],
            'name' => ['bail', 'required', 'string', 'max:255'],
            'meta_desc' => ['bail', 'required', 'string', 'max:255'],
            'meta_title' => ['bail', 'required', 'string', 'max:255'],
        ]);
        $check_exist = Category::where('category_name', $request->name)->where('parent_category', '0')->first();
        if ($check_exist) {
            // return 'Category Name is Already Exists.';
            return back()->with('error', "Category Name is Already Exists.");
        }
        if ($request->img) {
            $image = $request->img->getClientOriginalName();
            $request->img->move(public_path('category'), $image);
        }

        $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input("name")));

        $category = new Category();
        if ($request->img) {
            $category->category_icon = $image;
        }
        if ($request->order) {
            $category->order = $request->order;
        }
        if ($request->parent != "0") {
            $category->parent_category = $request->parent;

            $parent = Category::find($request->parent);
            $category->level = $parent->level + 1;
        }
        $category->category_name = $request->name;
        $category->parent_category = $request->parent;
        if ($request->meta_title != '') {
            $category->meta_title = $request->meta_title;
        } else {
            $category->meta_title = $meta_title;
        }
        $category->meta_desc = $request->meta_desc;
        // $category->category_slug = $slug;
        if ($request->cat_attributes) {
            $arrId = \Arr::pluck($request->cat_attributes,'id');
            $category->filter_attr = implode(',', $arrId);
        }

        $category->status = $request->status ? 1 : 0;

        $result = $category->save();

        return redirect()->route("admin.{$this->routeResourceName}.index")->with('success', 'Category created successfully.');
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
        $category = Category::where(['id' => $id])->first();
        if ($category->filter_attr) {
            $arrId = explode(',', $category->filter_attr);
            $category->filter_attr = Attribute::whereIn('id', $arrId)->get(['id','title']);
        }
        $categories = Category::where('parent_category', 0)
            ->with('childrenCategories')
            ->get();
        $attributes = Attribute::get();

        return inertia()->render('Category/Create', [
            'edit' => true,
            'title' => 'Edit Category',
            'item' => $category,
            'categories' => $categories,
            'attributes' => $attributes,
            'routeResourceName' => $this->routeResourceName,
            'category' => Category::with('childrenCategories')->where('parent_category', 0)->where('id', '!=', $id)->get(['id', 'category_name'])
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
            'parentId' => ['bail', 'nullable', 'integer'],
            'name' => ['bail','required','string','max:255'],
            'meta_desc' => ['bail','required','string','max:255'],
            'meta_title' => ['bail','required','string','max:255'],
        ]);

        $check_exist = Category::where('category_name', $request->name)->where('parent_category', '0')->where('id', '!=', $id)->first();
        if ($check_exist) {
            return back()->with('error', "Category Name is Already Exists.");
        }

        //update Brand Image
        if ($request->img != '') {
            $path = public_path() . '/category/';
            //code for remove old file
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

        if ($request->meta_title != '') {
            $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input('meta_title')));
        } else {
            $meta_title = str_replace(array('_', ' ',), '-', strtolower($request->input('name')));
        }

        $category = Category::FindOrFail($id);

        $category->category_name = $request->name;
        // $category->parent_category = $request->parent;

        $previous_level = $category->level;

        if ($request->parent != "0") {
            $category->parent_category = $request->parent;

            $parent = Category::find($request->parent);
            $category->level = $parent->level + 1;
        } else {
            $category->parent_category = 0;
            $category->level = 0;
        }

        if ($category->level > $previous_level) {
            // return 'gr';
            $this->move_level_down($category->id);
        } elseif ($category->level < $previous_level) {
            // return 'lr';
            $this->move_level_up($category->id);
        }

        $category->meta_title = $meta_title;
        $category->meta_desc = $request->meta_desc;

        if (isset($request->cat_attributes)) {
            $arrId = \Arr::pluck($request->cat_attributes,'id');
            $category->filter_attr = implode(',', $arrId);
        }
        $category->status = $request->status ? 1 : 0;
        $update = $category->save();

        return redirect()->route("admin.{$this->routeResourceName}.index")->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id):\Illuminate\Http\RedirectResponse
    {
        $child = Category::where('parent_category', $id)->count();
        $check = Product::where('category', $id)->count();
        // return $child;
        if ($child == 0 && $check == 0) {
            $destroy = Category::where(['id' => $id])->delete();
            return back()->with('success', 'Category deleted successfully.');
        } else {
            return back()->with('error', "You won't Delete this (This Category have children categories or used in Products.)");
        }
    }

    public function move_level_up($id)
    {
        $children = Category::select('id')->where('parent_category', $id)->orderBy('order', 'desc')->pluck('id');
        if (count($children) > 0) {
            foreach ($children as $value) {
                $category = Category::find($value);
                $category->level -= 1;
                $category->save();
                $this->move_level_up($value);
            }
        }
    }

    public function move_level_down($id)
    {
        $children = Category::select('id')->where('parent_category', $id)->orderBy('order', 'desc')->pluck('id');
        if (count($children) > 0) {
            foreach ($children as $value) {
                $category = Category::find($value);
                $category->level += 1;
                $category->save();
                $this->move_level_down($value);
            }
        }
    }
}
