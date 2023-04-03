<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Dash\Halls;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Manage\BaseController;
use Validator, Auth, Artisan, Hash, File, Crypt;

use App\Http\Resources\Dash\UsersResource;

class HallManagerController extends Controller
{
    use \App\Http\Controllers\ApiResponseTrait;

    /*
     * Add new HallManager to database
     */
    public function addHallManager(Request $request)
    {
        $lang = $request->header('lang');
        $user = Auth::user();

        $validateHallManager = $this->validateHallManager($request);
        if (isset($validateHallManager)) {
            return $validateHallManager;
        }

        $Hall = Halls::find($request->hall_id);
        $check = $this->not_found($Hall, 'القاعة', 'Hall', $lang);
        if (isset($check)) {
            return $check;
        }

        $HallManager = new User();
        $HallManager->name = $request->name;
        $HallManager->email = $request->email;
        $HallManager->password = Hash::make($request->password);
        $HallManager->type = 3;
        $HallManager->hall_id = $request->hall_id;
        $HallManager->save();
        $HallManager['token'] = null;

        $msg = $lang == 'ar' ? 'تم اضافة مدير القاعة بنجاح' : 'HallManager added successfully';
        return $this->apiResponseData(new UsersResource($HallManager), $msg);
    }

    /*
     * Edit admin
    */
    public function editHallManager(Request $request, $HallManagerId)
    {
        $lang = $request->header('lang');

        $HallManager = User::find($HallManagerId);
        $check = $this->not_found($HallManager, 'مدير القاعة', 'HallManager', $lang);
        if (isset($check)) {
            return $check;
        }

        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم مدير القاعة' : "HallManager name is required",
            'password.required' => $lang == 'ar' ? 'من فضلك ادخل كلمة السر' : "password is required",
            'password.confirmed' => $lang == 'ar' ? 'كلمتا السر غير متطابقتان' : "The password confirmation does not match",
            'password.min' => $lang == 'ar' ? 'كلمة السر يجب ان لا تقل عن 6 احرف' : "The password must be at least 6 character",
            'email.required' => $lang == 'ar' ? 'من فضلك ادخل البريد الالكتروني' : "email is required",
            'email.unique' => $lang == 'ar' ? 'هذا البريد الالكتروني موجود لدينا بالفعل' : "email is already taken",
            'email.regex' => $lang == 'ar' ? 'من فضلك ادخل بريد الكتروني صالح' : 'The email must be a valid email address',
            'hall_id.required' => $lang == 'ar' ? 'من فضلك ادخل القاعة' : 'hall is required',
        ];
        $validator = Validator::make($input, [
            'name' => 'required',
            'password' => 'bail|confirmed|min:6',
            'email' => 'bail|required|unique:users,email,' . $HallManagerId . '|regex:/(.+)@(.+)\.(.+)/i',
            'hall_id' => 'required',
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 400);
        }

        $Hall = Halls::find($request->hall_id);
        $check = $this->not_found($Hall, 'القاعة', 'Hall', $lang);
        if (isset($check)) {
            return $check;
        }

        $HallManager->name = $request->name;
        $HallManager->email = $request->email;
        if ($request->password) {
            $HallManager->password = Hash::make($request->password);
        }
        $HallManager->hall_id = $request->hall_id;
        $HallManager->save();
        $HallManager['token'] = null;

        $msg = $lang == 'ar' ? 'تم تعديل مدير القاعة بنجاح' : 'HallManager edited successfully';
        return $this->apiResponseData(new UsersResource($HallManager), $msg);
    }


    /*
     * get All product for Auth shop
     */
    public function allHallManagers(Request $request)
    {
        $user = Auth::user();
        $HallManager = User::where('type', 3)->orderBy('id', 'desc')->get();
        foreach ($HallManager as $row) {
            $row['token'] = null;
        }
        return $this->apiResponseData(UsersResource::collection($HallManager), 'success');
    }


    /*
     * Show single HallManager
     */
    public function singleHallManager(Request $request, $HallManagerId)
    {
        $lang = $request->header('lang');
        $HallManager = User::find($HallManagerId);
        $check = $this->not_found($HallManager, 'مدير القاعة', 'HallManager', $lang);
        if (isset($check)) {
            return $check;
        }
        $HallManager['token'] = null;
        $msg = $lang == 'ar' ? 'تمت العملية بنجاح' : 'success';
        return $this->apiResponseData($HallManager, $msg);
    }

    /*
     * Delete HallManager ..
     */

    public function deleteHallManager(Request $request, $HallManagerId)
    {
        $lang = $request->header('lang');

        $firstHallManager = User::where('type', 3)->firstOrFail();

        $HallManager = User::where('id', $HallManagerId)->where('id', '!=', $firstHallManager->id)->first();
        $check = $this->not_found($HallManager, 'مدير القاعة', 'HallManager', $lang);
        if (isset($check)) {
            return $check;
        }

        $HallManager->delete();

        $msg = $lang == 'ar' ? 'تم حذف مدير القاعة بنجاح' : 'HallManager Deleted successfully';
        return $this->apiResponseMessage(1, $msg, 200);
    }

    public function hallManagerLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'type' => 3
        ];
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {

            $token = auth::user()->createToken('APPLICATION')->accessToken;
            $data = auth::user();
            return response()->json(['token' => $token, 'message' => 'you are login now', 'data' => $data], 200);

        } else {
            return response()->json(['message' => 'Password or Email  incorrect', 'data' => null], 200);

        }
    }



    /*
     * @pram $request
     * @return Error message or check if cateogry is null
     */

    private function validateHallManager($request)
    {
        $lang = $request->header('lang');
        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم مدير القاعة' : "HallManager name is required",
            'password.required' => $lang == 'ar' ? 'من فضلك ادخل كلمة السر' : "password is required",
            'password.confirmed' => $lang == 'ar' ? 'كلمتا السر غير متطابقتان' : "The password confirmation does not match",
            'password.min' => $lang == 'ar' ? 'كلمة السر يجب ان لا تقل عن 6 احرف' : "The password must be at least 6 character",
            'email.required' => $lang == 'ar' ? 'من فضلك ادخل البريد الالكتروني' : "email is required",
            'email.unique' => $lang == 'ar' ? 'هذا البريد الالكتروني موجود لدينا بالفعل' : "email is already taken",
            'email.regex' => $lang == 'ar' ? 'من فضلك ادخل بريد الكتروني صالح' : 'The email must be a valid email address',
            'hall_id.required' => $lang == 'ar' ? 'من فضلك ادخل القاعة' : 'hall is required',
        ];
        $validator = Validator::make($input, [
            'name' => 'required',
            'password' => 'bail|required|confirmed|min:6',
            'email' => 'bail|required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'hall_id' => 'required',
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 400);
        }

    }

}
