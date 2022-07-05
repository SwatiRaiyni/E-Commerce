<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CMSController extends Controller
{

    public function __construct() {
       //dd("yes");
        $this->middleware('auth:admin');
    }
    public function cmsmanagement(){
        //dd("yes");
        Session::put('page','cms');
        $banners = Banner::get()->toArray();
        return view('backend.cmsmanagement.cms')->with(['banners'=>$banners]);
    }
    public function updatecmsstatus(Request $res){
        if($res->ajax()){
            $data = $res->all();
           // dd($data);
           if($data['status'] == "Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }
    public function deletecms(Request $res){
        $data = Banner::find($res->id);
        Storage::disk('public')->delete('images/banner_images/'.$data->image);
        $data->delete();
        $res->session()->flash('status1','banner has been deleted Successfully');
        return redirect()->back();
    }

    public function addeditcms(Request $res,$id=null){
        if($id==""){

            //add banner
            $title = "Add Banner";
            $product = new Banner;

            $productdata = array();
            $msg = "banner added successfully!";
        }else{

            //edit banner
            $title = "Edit Banner";
            $productdata = Banner::find($id);
            $product = Banner::find($id);
            //dd($product);
            $msg = "banner updated successfully!";

        }
        if($res->isMethod('post')){
            $data = $res->all();
            if($id == ""){
                $res->validate([
                        'banner-title'=>'required',
                        'banner-description'=>'required',
                        'image'=>'required',

                    ]);
                }else{
                    $res->validate([
                        'banner-title'=>'required',
                        'banner-description'=>'required',

                    ]);
                }
            $product['banner-title'] = $data['banner-title'];
            $product['banner-description'] = $data['banner-description'];
            $product['status'] = 1;
            if($res->hasfile('image')){
               Storage::disk('public')->delete('images/banner_images/'.$product['image']);
                $image = $res->file('image');
                $destination_path = 'public/images/banner_images';
                $img = $product['image'] = uniqid().$image->getClientOriginalName();
                $path = $res->file('image')->storeAs($destination_path, $img);
            }
            $product->save();
            $res->session()->flash('status',$msg);
            return redirect('admin/cmsmanagement');


         }
        return view("backend.cmsmanagement.add_edit_cms")->with(['title'=>$title,'productdata'=>$productdata]);
    }
}
