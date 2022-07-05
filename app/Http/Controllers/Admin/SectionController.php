<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }
    public function section(){
        Session::put('page','section');
        $data = Section::all();
        return view('backend.sectionmanagement.section')->with(['data'=>$data]);
    }
    public function updatesection(Request $res){
        if($res->ajax()){
            $data = $res->all();
           // dd($data);
           if($data['status'] == "Active"){
               $status = 0;
           }else{
               $status = 1;
           }
           Section::where('id',$data['section_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }

}
