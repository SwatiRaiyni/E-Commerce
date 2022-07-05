<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }
    public function categories(){
        Session::put('page','category');
        $data = Category::with(['section','parentcategory'])->get();//dd($data);
        $data = json_decode(json_encode($data));
        return view('backend.categorymanagement.categories')->with(['data'=>$data]);
    }
    public function updatecategory(Request $res){
        if($res->ajax()){
            $data = $res->all();
           // dd($data);
           if($data['status'] == "Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           Category::where('id',$data['category_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }
    public function addeditcategory(Request $res,$id=null){

        if($id == ""){
            //Add Category
            $title="Add Category";
            $category = new Category();
            $categorydata = array();
            $getcategory = array();
            $msg = "Category added Successfully";
        }else{
            //Edit Category
            $title="Edit Category";
            $categorydata = Category::where('id',$id)->first();//dd($categorydata);
            $categorydata = json_decode(json_encode($categorydata),true);// dd($categorydata);
            $getcategory = Category::with('subcategory')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getcategory = json_decode(json_encode($getcategory),true);
           //sdd($getcategory);
           $category = Category::find($id);
           $msg = "Category Updated Successfully";
        }
        if($res->isMethod('post')){
            $data = $res->all();//dd($data);
            if($id == ""){
            $res->validate([
                'category_name'=>'required',
                'url'=>'required',
                'category_image'=>'required',
                'section_id'=>'required'
            ]);
            }else{
                $res->validate([
                    'category_name'=>'required',
                    'url'=>'required',
                    'section_id'=>'required'
                ]);
            }

            if($res->hasfile('category_image')){
                Storage::disk('public')->delete('images/category_images/'.$category->category_image);
                $image = $res->file('category_image');
                $destination_path = 'public/images/category_images';
                $img = $category->category_image = uniqid().$image->getClientOriginalName();
                $path = $res->file('category_image')->storeAs($destination_path, $img);
            }
            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name= $data['category_name'];
            if($data['category_discount'] != ""){
                $category->category_discount = $data['category_discount'];
            }else{
                $category->category_discount = 0;
            }
            if($data['description'] != ""){
            $category->description = $data['description'];
            }else{
                $category->description = "";
            }

            if($data['meta_title'] != ""){
                $category->meta_title = $data['meta_title'];
            }else{
                $category->meta_title = "";
            }
            if($data['meta_description'] != ""){
                $category->meta_description = $data['meta_description'];
            }else{
                $category->meta_description = "";
            }
            if($data['meta_keywords'] != ""){
                $category->meta_keywords = $data['meta_keywords'];
            }else{
                $category->meta_keywords = "";
            }
            $category->url = $data['url'];
            $category->status = 1;
            $category->save();
            $res->session()->flash('status',$msg);
            return redirect('admin/categories');

        }
        $section = Section::get();
        return view('backend.categorymanagement.add_edit_categories')->with(['section'=>$section ,'title'=>$title,'categorydata'=>$categorydata,'getcategory'=>$getcategory]);
    }

    public function appendcategorylevel(Request $res){
        if($res->ajax()){
            $data = $res->all();
            $category = Category::with('subcategory')->where(['section_id'=>$data['section_id'],'parent_id' => 0,'status'=>1])->get();
           // echo'<pre>';print_r($category);die;
            $category = json_decode(json_encode($category),true);
            return view('backend.categorymanagement.category_level')->with(['category'=>$category]);
        }
    }

    public function deletecategory(Request $res){
        $data = Category::find($res->id);
        Storage::disk('public')->delete('images/category_images/'.$data->category_image);
        $data->delete();
        $res->session()->flash('status1','Category has been deleted Successfully');
        return redirect()->back();
    }

}
