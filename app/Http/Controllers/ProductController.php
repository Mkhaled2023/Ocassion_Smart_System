<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\User;
use App\info;
use App\images;
use App\reviewHall;
use App\deal;
use App\deal_packget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
      //desahbord
    public function index()
    {
        $product = Product::all();
       return response()->json([
        'success' => true,
        'data' => $product,
       ]);
    }

    // store data to hell
    public function store(Request $request)
    {
    $this->validate($request, [
        'name' => 'required',
        'price' => 'required|integer',
        'location' => 'required',
        'Rate' => 'required',
        'images' => 'required',
        'images_profile' => 'required',
        'Catgoery' => 'required',
    ]);

      $product = new Product();
      $product->name = $request->name;
      $product->price =$request->price;
      $product->location =$request->location;
      $product->Rate =$request->Rate;
      $product->images =$request->images;
      $product->images_profile =$request->images_profile;
      $product->Catgoery =$request->Catgoery;
      $product->save();
      return response()->json([
        'success' => true,
    ] , 200);

    }

    // show sell
    public function show($id)
    {
      if($id=='Birthday & Wedding')
      {

          $product=Product::where('Catgoery','Birthday')->orwhere('Catgoery','Birthday & Wedding')->orwhere('Catgoery','Wedding')->get();
             return response()->json([
                'success' => true,
                    'data' => $product
                      ], 200);

                         }

      //second case

        else if($id=='Meeting & Birthday'){

         $product=Product::where('Catgoery','Birthday')->orwhere('Catgoery','Meeting')->orwhere('Catgoery','Meeting & Birthday')->get();

           return response()->json([
             'success' => true,
             'data' => $product
                  ], 200);}

    // three code

           else if($id=='Wedding & Meeting'){

            $product=Product::where('Catgoery','Meeting')->orwhere('Catgoery','Wedding')->orwhere('Catgoery','Wedding & Meeting')->get();
              return response()->json([
               'success' => true,
               'data' => $product
                ], 200);
                        }
        // four code

         else if($id=='Birthday'){

          $product=Product::where('Catgoery','Meeting & Birthday')->orwhere('Catgoery','Birthday')->orwhere('Catgoery','Wedding & Birthday')->get();

           return response()->json([
             'success' => true,
             'data' => $product
               ], 200);
                       }

         // five code

           else if($id=='Wedding'){

           $product=Product::where('Catgoery','Wedding')->orwhere('Catgoery','Wedding & Meeting')->orwhere('Catgoery','Birthday & Wedding')->get();
      return response()->json([
           'success' => true,
             'data'=>$product
                       ], 200);

                             }



             // six code

               else if($id=='Meeting'){

                $product=Product::where('Catgoery','Meeting & Birthday')->orwhere('Catgoery','Meeting')->orwhere('Catgoery','Wedding & Meeting')->get();
                   return response()->json([
                      'success' => true,
                      'data' => $product
                           ], 200);
                                    }


             // seven
               else if($id=='Graduate'){

                $product=Product::where('Catgoery','Graduate')->get();
                   return response()->json([
                      'success' => true,
                      'data' => $product
                           ], 200);
                                    }

             //last case

                else{

                 $product= Product::all()->where('Catgoery',$id);
                   if(!$product){
                     return response()->json([
                        'success' => false,
                        'data' => 'product with id' . $id . 'not found',
                          ], 200);
                                   };

                                   return response()->json([
                                   'success' => true,
                                   'data' => $product->toArray(),
                                      ], 200);
                                                }}



    public function update(Request $request,$id)
    {
        $product = auth()->user()->products->find($id);
        if (!$product){
          return response()->json([
            'success' => false,
             'data' => 'product with id' . $id . 'not found',
          ] , 500);
        }
      $updated = $product->fill($request->all())->save();

      if($updated){
          return response()->json([
              'success' => true,
              'data' => 'product updated successfully',
          ] , 200);
      }else {
          return response()->json([
              'success' => false,
              'data' => 'product could not be updated',
          ] , 500);
      }
    }


    public function destroy(Product $product , $id)
    {
        $product = auth()->user()->products->find($id);
        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'product with id' . $id . 'not found',
            ],400);
        }

        if ($product->delete()){
            return response()->json([
                'success' => true,
              'message' => 'product deleted successfully',
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'product could not be deleted',
            ], 500);
        }
    }

    public function getinformation($name)
    {
    $product=Product::where('name',$name)->get();
    $info=info::where('Name_Halls',$name)->get();



$id_imga=info::where('Name_Halls',$name)->first()->id;
$Product_id=Product::where('name',$name)->first()->id;

$image=images::where('info_id',$id_imga)->get();
$reviewHall=reviewHall::where('product_id',$Product_id)->get();
$deal=deal::where('Hall',$Product_id)->get();



  return response()->json(['message'=>'success','product'=>$product,'info'=>$info,'images'=>$image,'reviewHall'=>$reviewHall,'deal'=>$deal]); }
 public function review_halls(Request $request )

   {

   $review_hall=new reviewHall();
   $review_hall->user_id=$request->user_id;
   $review_hall->Rate=$request->Rate;
   $review_hall->comments=$request->comments;
   $review_hall->product_id=$request->product_id;
   $review_hall->save();
    return response()->json(['message'=>'success']);
 }
 
 public function getreviewhalls($id){

    $review_hall=reviewHall::find($id);
    return response()->json(['message'=>'success','data'=>$review_hall],200);
 }


}
