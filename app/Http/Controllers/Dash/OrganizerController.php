<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Dash\OrganizePlans;
use App\Models\Dash\Organizers;
use Illuminate\Http\Request;
use App\Http\Controllers\Manage\BaseController;
use Validator, Auth, Artisan, Hash, File, Crypt;

use App\Http\Resources\Dash\OrganizerResource;

class OrganizerController extends Controller
{
    use \App\Http\Controllers\ApiResponseTrait;

    /*
     * Add new Organizer to database
     */
    public function addOrganizer(Request $request)
    {
        $lang = $request->header('lang');
        $user = Auth::user();

        $validateOrganizer = $this->validateOrganizer($request);
        if (isset($validateOrganizer)) {
            return $validateOrganizer;
        }

        $Organizer = new Organizers();
        $Organizer->name = $request->name;
        $Organizer->about = $request->about;
        if ($request->image) {
            $name = BaseController::saveImage('Organizers', $request->file('image'));
            $Organizer->image = $name;
        }
        if ($request->imageprofile) {
            $name = BaseController::saveImage('Organizers', $request->file('imageprofile'));
            $Organizer->imageprofile = $name;
        }
        $Organizer->save();

        $orgId = $Organizer->id;
        $orgName = $Organizer->name;
        $orgImg = $Organizer->image;
        $orgImgProfile = $Organizer->imageprofile;

        $plan = new OrganizePlans();
        $plan->name = $orgName;
        $plan->image = $orgImg;
        $plan->image_profile = $orgImgProfile;
        $plan->offer_name = $request->offer_name;
        $plan->offer_description = $request->offer_description;
        $plan->price = $request->price;
        $plan->teamid = $orgId;
        $plan->save();

        $msg = $lang == 'ar' ? 'تم اضافة المنظم بنجاح' : 'Organizer added successfully';
        return $this->apiResponseData(new OrganizerResource($Organizer), $msg);
    }

    /*
     * Edit admin
    */
    public function editOrganizer(Request $request, $OrganizerId)
    {
        $lang = $request->header('lang');

        $Organizer = Organizers::find($OrganizerId);
        $check = $this->not_found($Organizer, 'المنظم', 'Organizer', $lang);
        if (isset($check)) {
            return $check;
        }

        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم المنظم' : "Organizer name is required",
        ];
        $validator = Validator::make($input, [
            'name' => 'required',
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 400);
        }

        $Organizer->name = $request->name;
        $Organizer->about = $request->about;
        if ($request->image) {
            BaseController::deleteFile('Organizers', $Organizer->image);
            $name = BaseController::saveImage('Organizers', $request->file('image'));
            $Organizer->image = $name;
        }
        if ($request->imageprofile) {
            BaseController::deleteFile('Organizers', $Organizer->imageprofile);
            $name = BaseController::saveImage('Organizers', $request->file('imageprofile'));
            $Organizer->imageprofile = $name;
        }
        $Organizer->save();

        $orgId = $OrganizerId;
        $orgName = $Organizer->name;
        $orgImg = $Organizer->image;
        $orgImgProfile = $Organizer->imageprofile;

        $plan = OrganizePlans::where('teamid', $OrganizerId)->first();
        if ($plan) {
            $plan->name = $orgName;
            $plan->image = $orgImg;
            $plan->image_profile = $orgImgProfile;
            $plan->offer_name = $request->offer_name;
            $plan->offer_description = $request->offer_description;
            $plan->price = $request->price;
            $plan->save();
        }

        $msg = $lang == 'ar' ? 'تم تعديل المنظم بنجاح' : 'Organizer edited successfully';
        return $this->apiResponseData(new OrganizerResource($Organizer), $msg);
    }


    /*
     * get All product for Auth shop
     */
    public function allOrganizers(Request $request)
    {
        $user = Auth::user();
        $Organizer = Organizers::orderBy('id', 'desc')->get();
        return $this->apiResponseData(OrganizerResource::collection($Organizer), 'success');
    }


    /*
     * Show single Organizer
     */
    public function singleOrganizer(Request $request, $OrganizerId)
    {
        $lang = $request->header('lang');
        $Organizer = Organizers::find($OrganizerId);
        $check = $this->not_found($Organizer, 'المنظم', 'Organizer', $lang);
        if (isset($check)) {
            return $check;
        }
        $msg = $lang == 'ar' ? 'تمت العملية بنجاح' : 'success';
        return $this->apiResponseData($Organizer, $msg);
    }

    /*
     * Delete Organizer ..
     */

    public function deleteOrganizer(Request $request, $OrganizerId)
    {
        $lang = $request->header('lang');

//        $firstOrganizer = Organizers::where('type', 3)->firstOrFail();

        $Organizer = Organizers::where('id', $OrganizerId)->first();
        $check = $this->not_found($Organizer, 'المنظم', 'Organizer', $lang);
        if (isset($check)) {
            return $check;
        }

        $Organizer->delete();

        $msg = $lang == 'ar' ? 'تم حذف المنظم بنجاح' : 'Organizer Deleted successfully';
        return $this->apiResponseMessage(1, $msg, 200);
    }


    /*
     * @pram $request
     * @return Error message or check if cateogry is null
     */

    private function validateOrganizer($request)
    {
        $lang = $request->header('lang');
        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم المنظم' : "Organizer name is required",
        ];
        $validator = Validator::make($input, [
            'name' => 'required',
        ], $validationMessages);
        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 400);
        }

    }

}
