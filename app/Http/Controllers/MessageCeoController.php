<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messageceo;
use App\Models\Blog;
use App\Models\BlogCategory;
class MessageCeoController extends Controller
{

    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_messageceo'])->only('index');
        $this->middleware(['permission:update_messageceo'])->only('update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {   $data = Messageceo::find('1');
        return view('backend.investor.messageceo.index',compact('data'));
    }
    public function financialresults(Request $r)
    {   $blog = Blog::select('blogs.id as id','category_id as category_id',
        'title as title','blogs.slug as slug',
        'short_description as short_description',
        'description as description','banner as banner',
        'meta_title as meta_title','meta_img as meta_img',
        'meta_description as meta_description','meta_keywords as meta_keywords',
        'status as status','show as show','blogs.created_at as created_at','blogs.updated_at as updated_at','blogs.deleted_at as deleted_at')->join('blog_categories','blog_categories.id','blogs.category_id')
        ->where('category_name','Financial Results : Key Points')
        ->first();
        $blog_categories = BlogCategory::all();
        return view('backend.investor.financial.edit',compact('blog','blog_categories'));
    }

    public function shareholderreturn(Request $r)
    {   $blog = Blog::select('blogs.id as id','category_id as category_id',
        'title as title','blogs.slug as slug',
        'short_description as short_description',
        'description as description','banner as banner',
        'meta_title as meta_title','meta_img as meta_img',
        'meta_description as meta_description','meta_keywords as meta_keywords',
        'status as status','show as show','blogs.created_at as created_at','blogs.updated_at as updated_at','blogs.deleted_at as deleted_at')->join('blog_categories','blog_categories.id','blogs.category_id')
        ->where('category_name','shareholder')
        ->first();
        $blog_categories = BlogCategory::all();
        return view('backend.investor.shareholder.edit',compact('blog','blog_categories'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blog_system.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

                $slider = new Slider;
                $slider->image = $request->banner;
                $slider->caption = $request->caption;
                $slider->sub_caption = $request->sub_caption;
                $slider->save();
                flash(translate('Slider has been inserted successfully'))->success();
                return redirect('admin/slider');
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

        $slider = Slider::find($id);
        return view('backend.blog_system.sliders.edit', compact('slider'));

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
        $slider = Messageceo::find(base64_decode($id));
        $slider->image = $request->banner;
        $slider->title = $request->title;
        $slider->content = $request->content;
        $slider->save();

        flash(translate('Message CEO has been updated successfully'))->success();
        return redirect()->route('messagefromceo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        if(Slider::destroy($id)){
            //unlink($slider->photo);
            flash(translate('Slider has been deleted successfully'))->success();
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
        return redirect()->route('slider.index');
    }
}
