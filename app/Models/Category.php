<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table = "category";
    public function subcategory(){
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }
    public function section(){
        return $this->belongsTo('App\Models\Section','section_id')->select('id','name');
    }
    public function parentcategory(){
        return $this->belongsTo('App\Models\Category','parent_id')->select('id','category_name');
    }
    public static function categorydetails($url){
        $categorydetail = Category::select('id','category_name','url','description','parent_id')->with('subcategory')->where('url',$url)->first()->toArray();
        if($categorydetail['parent_id'] == 0){
            //main
            $breadcrumbs = '<a href="'.url($categorydetail['url']).'">'.$categorydetail['category_name'].'</a>';
        }else{
            //mail and subcategory
            $parent = Category::select('category_name','url')->where('id',$categorydetail['parent_id'])->first()->toArray();
            $breadcrumbs = '<a href="'.url($parent['url']).'">'.$parent['category_name'].'</a> <span class="divider">/</span>&nbsp;<a href="'.url($categorydetail['url']).'">'.$categorydetail['category_name'].'</a>';
        }
        $catId = array();
        $catId[] = $categorydetail['id'];

        foreach($categorydetail['subcategory'] as $key=>$subcat){
            $catId[] = $subcat['id'];
        }
        return array('catId'=>$catId,'categorydetail'=>$categorydetail,'breadcrumbs'=>$breadcrumbs);
    }
}
