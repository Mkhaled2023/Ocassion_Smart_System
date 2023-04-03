<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\aboutorgaize;
class aboutorgainzeController extends Controller
{
    public function aboutOrganization (Request $request){

        $information = new aboutorgaize;
        $information->name=$request->name;
        $information->about=$request->about;
        $image = $request->file('image');
        $imageName = '';

            $new_name = rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/upload/images'),$new_name);
            $imagesName=$new_name;

        $information->image=$new_name;
       
        

        $information->imageprofile=$request->image_profile;

        $information->save();

        return response()->json(['massege'=>'success']);
         }
         public function getinformation (Request $request){
         $information=aboutorgaize::all();
         return response()->json(['massege'=>'success','data'=>$information]);
        }}
