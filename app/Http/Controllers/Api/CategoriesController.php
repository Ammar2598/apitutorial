<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\GeneralTrait;

class CategoriesController extends Controller
{
    //
    use GeneralTrait;
    public function index()
    { 
        
            $categories = Category::select('id','name_'.app()->getLocale() .' as name')->get();

            // return response()->json([
            //     'success'=>true, 
            //     'message'=>'string',
            //     'data'=> $categories
            // ]);
            return $this->returnData('categories',$categories,'successfull');
        
    }
    public function getCategoryById(Request $request){
        $category = Category::select('id','name_'.app()->getLocale() .' as name')->find($request->id);
        if(!$category){
         return  $this->returnError('001','هذا القسم غير موجود');
        }
        return $this->returnData('category',$category,'successfull');
    
    }

    public function changeStatus(Request $request)
    {
       Category::where('id',$request->id)->update(['active'=>$request->active ]);
       return $this->returnSuccessMessage('تم تغيير الحاله بنجاح');
    }
}
 


