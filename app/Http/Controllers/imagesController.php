<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\info;
use App\images;
class imagesController extends Controller
{
    function upload(Request $request){
        $newinfo=new info;
        $newinfo->about_as=$request->about;
        $newinfo->start=$request->start;
        $newinfo->end=$request->end;
        $newinfo->review=$request->review;
        $newinfo->Deals=$request->Deals;
        $newinfo->Name_Halls=$request->Name_Halls;
        $newinfo->save();


        $images = $request->image;

        foreach ($images as $image){
          //  $new_name = rand().'.'.$image->getClientOriginalExtension();
           // $image->move(public_path('/upload/images'),$new_name);
           // $imagesName=$imageName.$new_name;
            $images=new images;
            $images->name=$image;

    $images->info_id=$newinfo->id;
    $images->save();
        }

        return response()->json(['messeage'=>'success']);

       }
       public function getinfo($id)
{

$name=info::where('Name_Halls',$id)->first()->id;
    
    $getinfo=info::find($name);
    $images=images::all()->where('info_id',$name);
    return response()->json(['messeage'=>'success','info'=>$getinfo,'imags'=>$images]);

}

}
