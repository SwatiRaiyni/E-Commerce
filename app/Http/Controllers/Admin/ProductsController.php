<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Section;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }
    public function products(){
        Session::put('page','product');
        $data = Product::with(['category','section'])->get();
        return view('backend.productmanagement.products')->with(['data'=>$data]);
    }
    public function updateproduct(Request $res){
        if($res->ajax()){
            $data = $res->all();
           // dd($data);
           if($data['status'] == "Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           Product::where('id',$data['product_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }
    public function deleteproduct(Request $res){
        $data = Product::find($res->id);
        Storage::disk('public')->delete('images/products_images/'.$data->main_image);
        $data->delete();
        $res->session()->flash('status1','Products has been deleted Successfully');
        return redirect()->back();
    }

    public function addeditproduct(Request $res,$id=null){

        if($id == ""){
            //Add product
            $title="Add Products";
            $product = new Product();
            $productdata = array();
            $msg = "Product added Successfully";
        }else{
            //Edit product
            $title="Edit Product";
            $productdata = Product::find($id);
            $product = Product::find($id);
            $msg = "Product Updated Successfully";
        }
        $category = Section::with('categories')->get();//dd($category);

        if($res->isMethod('post')){
            $data = $res->all();//dd($data);
            if($id == ""){
            $res->validate([
                    'category_id'=>'required',
                    'product_name'=>'required',
                    'product_code'=>'required|regex:/^[\w-]*$/',
                    'product_price'=>'required|numeric',
                    'product_color'=>'required',
                    'main_image'=>'required'
                ]);
            }else{
                $res->validate([
                    'category_id'=>'required',
                    'product_name'=>'required',
                    'product_code'=>'required|regex:/^[\w-]*$/',
                    'product_price'=>'required|numeric',
                    'product_color'=>'required'
                ]);
            }
            $categorydetails = Category::find($data['category_id']);//dd($categorydetails);
            $product->section_id = $categorydetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name= $data['product_name'];
            $product->product_code= $data['product_code'];
            $product->product_color= $data['product_color'];
            $product->product_price= $data['product_price'];
            if($data['product_discount'] != ""){
                $product->product_discount = $data['product_discount'];
            }else{
                $product->product_discount = 0;
            }
            if($data['description'] != ""){
                $product->description = $data['description'];
            }else{
                $product->description = "";
            }

            if($res->hasfile('main_image')){
                Storage::disk('public')->delete('images/products_images/'.$product->main_image);
                $image = $res->file('main_image');
                $destination_path = 'public/images/products_images';
                $img = $product->main_image = uniqid().$image->getClientOriginalName();
                $path = $res->file('main_image')->storeAs($destination_path, $img);
            }

            if($data['meta_title'] != ""){
                $product->meta_title = $data['meta_title'];
            }else{
                $product->meta_title = "";
            }
            if($data['meta_description'] != ""){
                $product->meta_description = $data['meta_description'];
            }else{
                $product->meta_description = "";
            }
            if($data['meta_keywords'] != ""){
                $product->meta_keywords = $data['meta_keywords'];
            }else{
                $product->meta_keywords = "";
            }
            if(empty($data['is_featured'])){
                $is_featured = 0;
            }else{
                $is_featured = 1;
            }
            $product->is_featured = $is_featured;

            $product->status = 1;
            $product->save();
            $res->session()->flash('status',$msg);
            return redirect('admin/products');

        }
        $section = Product::get();
        return view('backend.productmanagement.add_edit_products')->with(['productdata'=>$productdata,'category'=>$category,'title'=>$title]);
    }

    public function addattribute(Request $res,$id){
        if($res->isMethod('post')){
            $data = $res->all();
            //dd($data);
            foreach($data['code'] as $key=>$val){
                if(!empty($val)){
                    //code alredy exist
                    $code = ProductAttribute::where(['code'=>$val])->count();
                    if($code > 0){
                        return redirect()->back()->with('status1','code already exists! ');
                    }

                    //size already exist
                    $size = ProductAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($size > 0){
                        return redirect()->back()->with('status1','size already exists! ');
                    }
                    $attribute = new ProductAttribute();
                    $attribute->product_id = $id;
                    $attribute->code = $val;
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->size = $data['size'][$key];
                    $attribute->status = 1;
                    $attribute->save();

                }
            }
            return redirect()->back()->with('status','Atrribute added successfully');
        }
        $productdata = Product::with('attributes')->find($id);
        $title = "product Attributes";
        return view('backend.productmanagement.add_attribute')->with(['productdata'=>$productdata , 'title'=>$title]);
    }

    function editattribute(Request $res,$id){
        if($res->isMethod('post')){
            $data = $res->all();
            foreach($data['attrId'] as $key=>$val){
                if(!empty($val)){
                    ProductAttribute::where('id',$data['attrId'][$key])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);

                }
            }
            return redirect()->back()->with('status','Atrribute updated successfully');
        }
    }

    function updateattributestatus(Request $res){
        if($res->ajax()){
            $data = $res->all();
           // dd($data);
           if($data['status'] == "Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           ProductAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function deleteattribute(Request $res){
        $data = ProductAttribute::find($res->id);
        $data->delete();
        $res->session()->flash('status1','Products Attribute has been deleted Successfully');
        return redirect()->back();
    }


}

