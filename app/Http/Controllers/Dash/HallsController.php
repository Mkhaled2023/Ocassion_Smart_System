<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Manage\BaseController;
use Validator,Auth,Artisan,Hash,File,Crypt;

use App\Models\Dash\Halls;
use App\Http\Resources\Dash\HallsResource;

class HallsController extends Controller
{
    use \App\Http\Controllers\ApiResponseTrait;

    /*
     * Add new Hall to database
     */
    public function addHall(Request $request)
    {
        $lang = $request->header('lang');
        $user = Auth::user();

        $validateHall=$this->validateHall($request);
        if(isset($validateHall)){
            return $validateHall;
        }

        $Hall=new Halls();
        $Hall->name = $request->name;
        $Hall->price =$request->price;
        $Hall->location =$request->location;
        $Hall->Rate =$request->Rate;
        if($request->images){
            $name = BaseController::saveImage('Halls',$request->file('images'));
            $Hall->images = $name;
        }
        if($request->images_profile){
            $name = BaseController::saveImage('Halls',$request->file('images_profile'));
            $Hall->images_profile = $name;
        }
        $Hall->catgoery =$request->catgoery;
        $Hall->save();

        $msg=$lang=='ar' ? 'تم اضافة القاعة بنجاح'  : 'Hall added successfully';
        return $this->apiResponseData(new HallsResource($Hall),$msg);

    }

    /*
     * Edit product
    */
    public function editHall(Request $request,$HallId)
    {
        $lang=$request->header('lang');

        $Hall=Halls::find($HallId);
        $check=$this->not_found($Hall,'القاعة','Hall',$lang);
        if(isset($check)){
            return $check;
        }

        $validateHall=$this->validateHall($request);
        if(isset($validateHall)){
            return $validateHall;
        }

        $Hall->name = $request->name;
        $Hall->price =$request->price;
        $Hall->location =$request->location;
        $Hall->Rate =$request->Rate;
        if($request->images){
            BaseController::deleteFile('Halls',$Hall->images);
            $name = BaseController::saveImage('Halls',$request->file('images'));
            $Hall->images = $name;
        }
        if($request->images_profile){
            BaseController::deleteFile('Halls',$Hall->images_profile);
            $name = BaseController::saveImage('Halls',$request->file('images_profile'));
            $Hall->images_profile = $name;
        }
        $Hall->catgoery =$request->catgoery;
        $Hall->save();

        $msg=$lang=='ar' ? 'تم تعديل القاعة بنجاح'  : 'Hall edited successfully';
        return $this->apiResponseData(new HallsResource($Hall),$msg);
    }


    /*
     * get All product for Auth shop
     */
    public function allHalls(Request $request)
    {
        $user=Auth::user();
        $Halls=Halls::orderBy('id','desc')->get();
        return $this->apiResponseData(HallsResource::collection($Halls),'success');
    }


    /*
     * Show single Hall
     */
    public function singleHall(Request $request,$HallId)
    {
        $lang=$request->header('lang');

        $Hall=Halls::find($HallId);
        $check=$this->not_found($Hall,'القاعة','Hall',$lang);
        if(isset($check)){
            return $check;
        }

        $msg=$lang=='ar' ?'تمت العملية بنجاح' : 'success';
        return $this->apiResponseData($Hall,$msg);
    }

    /*
     * Delete Hall ..
     */

    public function deleteHall(Request $request,$HallId)
    {
        $lang=$request->header('lang');

        $Hall=Halls::where('id',$HallId)->where('id','!=',1)->first();
        $check=$this->not_found($Hall,'القاعة','Hall',$lang);
        if(isset($check)){
            return $check;
        }

        BaseController::deleteFile('Halls',$Hall->images);
        BaseController::deleteFile('Halls',$Hall->images_profile);
        $Hall->delete();

        $msg=$lang=='ar' ? 'تم حذف القاعة بنجاح'  : 'Hall Deleted successfully';
        return $this->apiResponseMessage(1,$msg,200);
    }


    /*
     * @pram $request
     * @return Error message or check if cateogry is null
     */

    private function validateHall($request)
    {
        $lang = $request->header('lang');

        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ?  'من فضلك ادخل اسم القاعة بالعربية' :"Name in arabic is required" ,
            'price.required' => $lang == 'ar' ? 'من فضلك ادخل سعر حجز القاعة' :"Hal reservation price is required"  ,
            'catgoery.required' => $lang == 'ar' ? 'من فضلك ادخل تصنيف القاعة' :"Hall category is required"  ,
        ];

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'catgoery' => 'required',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 400);
        }
    }
}
