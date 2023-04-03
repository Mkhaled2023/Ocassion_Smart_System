<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\aboutorgaize;
use App\comments;
use App\deal;
use App\deal_packget;
use APP\Http\Resources\offerss;
class offerController extends Controller
{
    public function offerinsert(Request $request)
    {

        $offer = new Offer();
        $offer->name = $request->name;
        $offer->price =$request->price;
        $offer->offer_description =$request->offer_description;
        $offer->offer_name =$request->offer_name;
        $offer->image=$request->image;
        $offer->image_profile=$request->image_profile;
        $offer->date_time =$request->date_time;
        $offer->teamid =$request->teamid;
        $offer->save();

       return response()->json(['message'=>'success'],200);
       }

       public function offershow(Request $request)
       {


          $offer=offer::all();
          return response()->json(['message'=>'success','offer'=>$offer],200);
          }
          public function getimagepro($id)
          {

             $about=aboutorgaize::find($id);
             return response()->json(['message'=>'success' , 'data'=>$about],200);

                 //
             }
               public function offerreview(Request $request)
    {
        $offer = new comments();
        $offer->comments = $request->comments;
        $offer->Rate =$request->Rate;
        $offer->teamId =$request->teamId;

        $offer->userId=$request->userId;

        $offer->save();

       return response()->json(['message'=>'success'],200);
       }
                    public function getofferreview($id)
    {
        $comments =comments::all()->where('teamId',$id);


       return response()->json(['message'=>'success','comments'=>$comments],200);
       }

           public function getoffers($id)
      {
        $offer =Offer::where('teamid',$id)->get();
        $comments =comments::where('teamId',$id)->get();
        //$offer = new offerss($offer);
        //$comments = new offerss($comments);

       return response()->json(['message'=>'success','offer'=>$offer,'comments'=>$comments],200);
       }

           public function deal(Request $request)

      {
        $deal =new deal();
        $deal->name=$request->deals;
        $deal->pricce=$request->price;
        $deal->Hall=$request->Hall;
        $deal->Foods=$request->Foods;
        $deal->Number_Paragraphs=$request->Number_Paragraphs;
        $deal->number_invities=$request->number_invities;
        $deal->Number_hours=$request->Number_hours;
        $deal->save();




       return response()->json(['message'=>'success'],200);

       }

}
