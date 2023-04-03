<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Manage\BaseController;
use Validator, Auth, Artisan, Hash, File, Crypt;

use App\Models\Dash\Events;
use App\Http\Resources\Dash\EventsResource;

class EventsController extends Controller
{
    use \App\Http\Controllers\ApiResponseTrait;

    /*
     * Add new Event to database
     */
    public function addEvent(Request $request)
    {
        $lang = $request->header('lang');
        $user = Auth::user();

        $validateEvent = $this->validateEvent($request);
        if (isset($validateEvent)) {
            return $validateEvent;
        }

//        return date($request->date_time);

        $Event = new Events();
        $Event->name = $request->name;
        if ($request->image) {
            $name = BaseController::saveImage('Events', $request->file('image'));
            $Event->image = $name;
        }
        $Event->date_time = date($request->date_time);
        $Event->address = $request->address;
        $Event->about = $request->about;
        $Event->price = $request->price;
        $Event->typeof = $request->typeof;
        $Event->duration = $request->duration;
        $Event->save();

        $msg = $lang == 'ar' ? 'تم اضافة الحدث بنجاح' : 'Event added successfully';
        return $this->apiResponseData(new EventsResource($Event), $msg);

    }

    /*
     * Edit product
    */
    public function editEvent(Request $request, $EventId)
    {
        $lang = $request->header('lang');

        $Event = Events::find($EventId);
        $check = $this->not_found($Event, 'الحدث', 'Event', $lang);
        if (isset($check)) {
            return $check;
        }

        $validateEvent = $this->validateEvent($request);
        if (isset($validateEvent)) {
            return $validateEvent;
        }

        $Event->name = $request->name;
        if ($request->image) {
            BaseController::deleteFile('Events', $Event->image);
            $name = BaseController::saveImage('Events', $request->file('image'));
            $Event->image = $name;
        }
        $Event->date_time = date($request->date_time);
        $Event->address = $request->address;
        $Event->about = $request->about;
        $Event->price = $request->price;
        $Event->typeof = $request->typeof;
        $Event->duration = $request->duration;
        $Event->save();

        $msg = $lang == 'ar' ? 'تم تعديل الحدث بنجاح' : 'Event edited successfully';
        return $this->apiResponseData(new EventsResource($Event), $msg);
    }


    /*
     * get All product for Auth shop
     */
    public function allEvents(Request $request)
    {
        $user = Auth::user();
        $Events = Events::orderBy('id', 'desc')->get();
        return $this->apiResponseData(EventsResource::collection($Events), 'success');
    }


    /*
     * Show single Event
     */
    public function singleEvent(Request $request, $EventId)
    {
        $lang = $request->header('lang');

        $Event = Events::find($EventId);
        $check = $this->not_found($Event, 'الحدث', 'Event', $lang);
        if (isset($check)) {
            return $check;
        }

        $msg = $lang == 'ar' ? 'تمت العملية بنجاح' : 'success';
        return $this->apiResponseData($Event, $msg);
    }

    /*
     * Delete Event ..
     */

    public function deleteEvent(Request $request, $EventId)
    {
        $lang = $request->header('lang');

        $Event = Events::where('id', $EventId)->where('id', '!=', 1)->first();
        $check = $this->not_found($Event, 'الحدث', 'Event', $lang);
        if (isset($check)) {
            return $check;
        }

        BaseController::deleteFile('Events', $Event->image);
        $Event->delete();

        $msg = $lang == 'ar' ? 'تم حذف الحدث بنجاح' : 'Event Deleted successfully';
        return $this->apiResponseMessage(1, $msg, 200);
    }


    /*
     * @pram $request
     * @return Error message or check if cateogry is null
     */

    private function validateEvent($request)
    {
        $lang = $request->header('lang');

        $input = $request->all();
        $validationMessages = [
            'name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم الحدث' : "Name is required",
//            'date_time.required' => $lang == 'ar' ? 'من فضلك ادخل موعد الحدث' : "Event date is required",
            'address.required' => $lang == 'ar' ? 'من فضلك ادخل عنوان الحدث' : "Event address is required",
            'price.required' => $lang == 'ar' ? 'من فضلك ادخل سعر حجز الحدث' : "Event reservation price is required",
            'typeof.required' => $lang == 'ar' ? 'من فضلك ادخل نوع الحدث' : "Event type is required",
            'duration.required' => $lang == 'ar' ? 'من فضلك ادخل فترة الحدث' : "Event duration is required",
        ];

        $validator = Validator::make($input, [
            'name' => 'required',
//            'date_time' => 'required',
            'address' => 'required',
            'price' => 'required',
            'typeof' => 'required',
            'duration' => 'required',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 400);
        }
    }
}
