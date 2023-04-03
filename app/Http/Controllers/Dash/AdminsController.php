<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Manage\BaseController;
use Validator, Auth, Artisan, Hash, File, Crypt;

use App\Http\Resources\Dash\UsersResource;

class AdminsController extends Controller
{
    use \App\Http\Controllers\ApiResponseTrait;

    /*
     * Add new Admin to database
     */
    public function addAdmin(Request $request)
    {
        $lang = $request->header('lang');
        $user = Auth::user();

        $validateAdmin = $this->validateAdmin($request);
        if (isset($validateAdmin)) {
            return $validateAdmin;
        }

        $Admin = new User();
        $Admin->name = $request->name;
        $Admin->email = $request->email;
        $Admin->password = Hash::make($request->password);
        $Admin->type = 2;
        $Admin->save();
        $Admin['token'] = null;

        $msg = $lang == 'ar' ? 'تم اضافة الادمن بنجاح' : 'Admin added successfully';
        return $this->apiResponseData(new UsersResource($Admin), $msg);
    }

    /*
     * Edit admin
    */
    public function editAdmin(Request $request, $AdminId)
    {
        $lang = $request->header('lang');

        $Admin = User::find($AdminId);
        $check = $this->not_found($Admin, 'الادمن', 'Admin', $lang);
        if (isset($check)) {
            return $check;
        }

        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم الادمن' : "Admin name is required",
            'password.required' => $lang == 'ar' ? 'من فضلك ادخل كلمة السر' : "password is required",
            'password.confirmed' => $lang == 'ar' ? 'كلمتا السر غير متطابقتان' : "The password confirmation does not match",
            'password.min' => $lang == 'ar' ? 'كلمة السر يجب ان لا تقل عن 6 احرف' : "The password must be at least 6 character",
            'email.required' => $lang == 'ar' ? 'من فضلك ادخل البريد الالكتروني' : "email is required",
            'email.unique' => $lang == 'ar' ? 'هذا البريد الالكتروني موجود لدينا بالفعل' : "email is already taken",
            'email.regex' => $lang == 'ar' ? 'من فضلك ادخل بريد الكتروني صالح' : 'The email must be a valid email address',
        ];
        $validator = Validator::make($input, [
            'name' => 'required',
            'password' => 'bail|confirmed|min:6',
            'email' => 'bail|required|unique:users,email,' . $AdminId . '|regex:/(.+)@(.+)\.(.+)/i',
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 400);
        }

        $Admin->name = $request->name;
        $Admin->email = $request->email;
        if ($request->password) {
            $Admin->password = Hash::make($request->password);
        }
        $Admin->save();
        $Admin['token'] = null;

        $msg = $lang == 'ar' ? 'تم تعديل الادمن بنجاح' : 'Admin edited successfully';
        return $this->apiResponseData(new UsersResource($Admin), $msg);
    }


    /*
     * get All product for Auth shop
     */
    public function allAdmins(Request $request)
    {
        $user = Auth::user();
        $Admins = User::where('type', 2)->orderBy('id', 'desc')->get();
        foreach ($Admins as $row) {
            $row['token'] = null;
        }
        return $this->apiResponseData(UsersResource::collection($Admins), 'success');
    }


    /*
     * Show single Admin
     */
    public function singleAdmin(Request $request, $AdminId)
    {
        $lang = $request->header('lang');
        $Admin = User::find($AdminId);
        $check = $this->not_found($Admin, 'الادمن', 'Admin', $lang);
        if (isset($check)) {
            return $check;
        }
        $Admin['token'] = null;
        $msg = $lang == 'ar' ? 'تمت العملية بنجاح' : 'success';
        return $this->apiResponseData($Admin, $msg);
    }

    /*
     * Delete Admin ..
     */

    public function deleteAdmin(Request $request, $AdminId)
    {
        $lang = $request->header('lang');

        $firstAdmin = User::where('type', 2)->first();

        $Admin = User::where('id', $AdminId)->where('id', '!=', $firstAdmin->id)->first();
        $check = $this->not_found($Admin, 'الادمن', 'Admin', $lang);
        if (isset($check)) {
            return $check;
        }

        $Admin->delete();

        $msg = $lang == 'ar' ? 'تم حذف الادمن بنجاح' : 'Admin Deleted successfully';
        return $this->apiResponseMessage(1, $msg, 200);
    }


    /*
     * @pram $request
     * @return Error message or check if cateogry is null
     */

    private function validateAdmin($request)
    {
        $lang = $request->header('lang');
        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم الادمن' : "Admin name is required",
            'password.required' => $lang == 'ar' ? 'من فضلك ادخل كلمة السر' : "password is required",
            'password.confirmed' => $lang == 'ar' ? 'كلمتا السر غير متطابقتان' : "The password confirmation does not match",
            'password.min' => $lang == 'ar' ? 'كلمة السر يجب ان لا تقل عن 6 احرف' : "The password must be at least 6 character",
            'email.required' => $lang == 'ar' ? 'من فضلك ادخل البريد الالكتروني' : "email is required",
            'email.unique' => $lang == 'ar' ? 'هذا البريد الالكتروني موجود لدينا بالفعل' : "email is already taken",
            'email.regex' => $lang == 'ar' ? 'من فضلك ادخل بريد الكتروني صالح' : 'The email must be a valid email address',
        ];
        $validator = Validator::make($input, [
            'name' => 'required',
            'password' => 'bail|required|confirmed|min:6',
            'email' => 'bail|required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 400);
        }

    }

}
