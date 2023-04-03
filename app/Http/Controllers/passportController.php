<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class passportController extends Controller
{
    public function register(Request $request){
        $re=Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation'=>'required|same:password',
        ]);
        if($re->fails()){
            $error=$re->errors()    ;

        return response()->json($error,401);
}else
    $user= User::where('email',$request->email)->count();
    if($user > 0){
        return response()->json(['message'=>'This email is taken by another account'],200);
    }else{
  $user=User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' =>bcrypt($request->password),
    ]);

    $token=$user->createToken('APPLICATION')->accessToken;
    return response()->json(['token'=>$token,'message'=>'success'],200);

}


    }
    public function login(Request $request ){
        $credentials=[
            'email'=> $request->email,
            'password' =>$request->password,
        ];
        if(auth::attempt($credentials))
        {

            $token=auth::user()->createToken('APPLICATION')->accessToken;
            $data=auth::user();
            return response()->json(['token'=>$token,'message'=>'you are login now' , 'data'=>$data],200);

        }
        else{
            return response()->json(['message'=>'Password or Email  incorrect' , 'data'=>null],200);

        }

    }
    public function details(){
         $user= User::all();

         return response()->json(['user' => $user] , 200);



    }
    
        public function update(Request $request , $id){
    
      $user = user::get()->find($id);
         Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
    ]);
      
      $user->name=$request->name;
      $user->email=$request->email;
      $user->save();
      
      
      return response()->json(['message'=>'success'],200);
   }

}
