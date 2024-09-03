<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Pagination\Paginator;
use Yajra\DataTables\DataTables;

class ReviewController extends Controller
{
    private string $routeResourceName = 'reviews';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Review::select('reviews.*','products.product_name','users.name')
            ->leftjoin('products','products.id','=','reviews.product')
            ->leftjoin('users','users.user_id','=','reviews.user')
            ->orderBy('reviews.id','desc')->paginate(10)->withQueryString();
        // dd($data);
        return inertia()->render('Review/Index', [
            'data' => $data,
            'title' => 'Reviews Management',
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
    public function create($id)
    {
        

        if (Session::has('user_id')) {
            $product = Product::where('id', $id)->first();
            
            return Inertia::render('Reviews', ['product' => $product]);
        } else {
            return Inertia::render('UserLogin');
        }

        // return view('public.reviews.create-review',['product'=>$product]);
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
            'title' => 'required',
            'review' => 'required',
            'star' => 'required',
        ]);
        $insert = new Review();
        $insert->product = $request->product;
        $insert->user = $request->user;
        $insert->title = $request->title;
        $insert->desc = $request->review;
        $insert->rating = $request->star;
        $save = $insert->save();
        if ($save) {
            return redirect('my-reviews');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $review = Review::select(['reviews.*','products.product_name','users.name'])
                    ->leftJoin('products','products.id','=','reviews.product')
                    ->leftJoin('users','users.user_id','=','reviews.user')
                    ->where('reviews.id',$request->view)
                    ->first();
        return back()->with('review' ,$review);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::select(['reviews.*','products.product_name','users.name'])
                    ->leftJoin('products','products.id','=','reviews.product')
                    ->leftJoin('users','users.user_id','=','reviews.user')
                    ->where('reviews.id',$id)
                    ->first();

        return inertia()->render('Review/Create', [
            'title' => 'Edit Review',
            'edit' => true,
            'item' => $review,
            'breadcrumb' => ['Dashboard' => 'admin.dashboard', 'Review' => 'admin.reviews.index'],
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
        $review = Review::where(['id'=>$id])->update([
            'title'=>$request->input('title'),
            'desc'=>$request->input('desc'),
            'hide_by_admin'=>$request->input('status'),
        ]);
        return to_route('admin.'.$this->routeResourceName.'.index')->with('success', 'Review Updated Successfuly!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $destroy = Review::where(['id'=>$request->delete])->delete();
        return back()->with('success', 'Review deleted successfully!!.');
    }


    public function approveReview(Request $request){
        $id = $request->approve;
        $update = Review::where('id', $id)->update([
            'approved' => '1'
        ]);
        return back()->with('success', 'Review Approved successfully!!.');
    }
}
