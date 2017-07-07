<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Blog, App\BlogCategory;
use Auth, Image;

class BlogController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::with('categories')->get();
        return $blogs->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BlogCategory::pluck('title', 'slug');
        return view('admin.blog.create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Blog::$validationRules, Blog::$validationMessages);
        $blog = new Blog($request->only('title', 'type','text'));
        if( $request->link != ''){
            $blog->link = $request->link;
        }
        $categoriesArray = [];
        $categories = $request->categories;
        foreach($categories as $categoryItem){
            $category = BlogCategory::where('title',$categoryItem)->first();
            if($category == null){
                $slug = str_slug(remove_turkish($categoryItem));
                $category = new BlogCategory([
                    'title' => $categoryItem,
                    'slug' => $slug,
                    'desc' => '',
                    'created_by' => Auth::user()->id
                ]);
                $category->save();
            }
            array_push($categoriesArray, $category->id);
        }
        $blog->author_id = Auth::user()->id;
        $blog->save();
        $blog->slug = str_slug(remove_turkish($blog->title). "-" . $blog->id);

        $blog->categories()->attach($categoriesArray);
        if($request->hasFile('thumb') ){
            $thumb = Image::make($request->file('thumb'))
                ->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save('resources/admin/uploads/blog_images/' . $blog->id . '_thumb.jpg', 80);
            $blog->thumb =  $blog->id . '_thumb.jpg';
        }
        $blog->save();

        return redirect()->route('admin.blog.index');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
