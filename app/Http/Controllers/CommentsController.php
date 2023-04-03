<?php

namespace App\Http\Controllers;

use App\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function comments(Request $request){
    $ncomment = new comments();
    $ncomment->comments = $request->comments;
    $ncomment->Rate = $request->Rate;
    $ncomment->teamId = $request->teamId;
    $ncomment->userId = $request->userId;

    $id =Auth::User()->id;
    $ncomment->userId = $id;
    $ncomment->save();
    return response()->json(['message'=>'success'],200);
    }

    public function showcomments(){

        $ncomment=comments::all();
        return response()->json(['massege'=>'success','data'=>$ncomment]);
    }


}
