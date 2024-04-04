<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $visibleColumns = session()->get('visible_columns', []);
        $tableName = (new Post())->getTable();
        $allColumns = Schema::getColumnListing($tableName);
        return view('post.index',['data'=>$posts, 'visibleColumns' => $visibleColumns,'allColumns'=>$allColumns ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create') ;
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
            'firstname' => 'required',
            'email' => 'required|email',
            'mobile' => ['required', 'min:10', 'max:10'],
            'pincode' => ['required'],
        ]);
        Post::create([
            'firstname' => $request->firstname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'pincode' => $request->pincode
        ]);
       

        return redirect('/')->with('success', 'Post created successfully!');
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw'); 
        $start = $request->get('start');
        $length = $request->get('length'); 
        $order = $request->get('order');
        $columns = $request->get('columns'); 
        $searchable = $request->get('search')['value']; 
        $query = Post::select('*'); 
        if ($searchable) {
        $query->where(function ($q) use ($searchable) {
            $q->where('firstname', 'like', "%$searchable%")
            ->orWhere('id', 'like', "%$searchable%");
     
        });
        }

        if (isset($order)) {
        $orderByColumn = $columns[$order[0]['column']]['data']; 
        $orderByDirection = $order[0]['dir']; 
        $query->orderBy($orderByColumn, $orderByDirection);
        }

        $data = $query->skip($start)->take($length)->get();
        $recordsTotal = Post::count(); 
        $recordsFiltered = $recordsTotal;

        return response()->json([
        'draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(!$post){
            return redirect('/')->with('success', 'Data is not available!');
        }else{
            return view('post.edit',['data'=>$post]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        //
    }
}
