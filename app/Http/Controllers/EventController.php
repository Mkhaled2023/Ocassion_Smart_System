<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event; 
use App\EventCategories;
class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     				
     public function events(Request $request){
     $Event=new Event();
     $Event->name=$request->name;
     $Event->address=$request->address;
     $Event->date_time=$request->date_time;
     $Event->about=$request->about;
     $Event->price=$request->price;
     $Event->typeof=$request->typeof;
     $Event->duration=$request->duration;
     $Event->image=$request->image;


        $Event->save();
         return response()->json(['massege'=>'success']);
       

}
  
        public function getcatdeatils(){
     $Event=Event::all();
        return response()->json(['massege'=>'success','data'=>$Event]);
    }
     
}
