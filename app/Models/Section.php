<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
class Section extends Model
{
    use HasFactory;
    public $table = "section";
    public static function sections(){
        $getsection = Section::with('categories')->where('status',1)->get();
        $getsection = json_decode(json_encode($getsection),true);
        return $getsection;
        //dd($getsection);
    }
    public function categories(){
        return $this->hasMany('App\Models\Category','section_id')->where(['parent_id'=>'ROOT','status'=>1])->with('subcategory');
    }
}
