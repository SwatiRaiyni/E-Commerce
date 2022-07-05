<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;

class indexController extends Controller
{
    public function index(){
        //get featured products with 4 chunks
        $featured = Product::where('is_featured',1)->where('status',1)->count();
        $featureditem = Product::where('is_featured',1)->where('status',1)->get()->toArray();
        $featureditemchunk = array_chunk($featureditem,4);
        //get latest products
        $getproduct = Product::orderBy('id','Desc')->limit(6)->where('status',1)->get()->toArray();
        $page_name = "index";
        return view('fronted.index')->with(['page_name'=>$page_name,'featured'=>$featured,'featureditemchunk'=>$featureditemchunk,'getproduct'=>$getproduct]);
    }
    public function addsubemail(Request $res){
        if($res->ajax()){
            $data = $res->all();
            $count = NewsletterSubscriber::where('email',$data['email'])->count();
            if($count > 0 ){
                return "exists";
            }else{
                //add email in table
                $data1 = new NewsletterSubscriber();
                $data1->email = $data['email'];
                $data1->status = 1;
                $data1->save();
                return "save";
            }
        }
    }
}
