<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function message(Request $request){
        try{
        $sender = Auth::user();

        $message = Chat::create([
            "message"=>$request->message,
            "sender_id"=>$sender->id,
            "receiver_id"=>$request->receiver_id,
            "isdeleted_sender"=>0,
            "isdeleted_receiver"=>0,

        ]);

        return response()->json([

            "status"=>"success",
            "message"=>"message sent successfully",
            "message"=>$message,



        ]);

        
    }catch(Exception $ex ){

        return response()->json([

            "status"=>"error",
            "message"=>" an error occured while sending message , EX : $ex ",
            



        ]);


    }


    }
    
    
     public function getAllChats(){
    try{
    $user = Auth::user();
    $sender_id = $user->id ;
    
    $chats = Chat::query()->where(function ($query) use ($sender_id) {
        $query->where('sender_id', $sender_id)->where(function ($subquery) { 
        
               $subquery->where('isdeleted_sender', 0);
            });
    })
    ->orWhere(function ($query) use ($sender_id) {
        $query->where('receiver_id', $sender_id)->where(function ($subquery) { 
                $subquery->where('isdeleted_receiver',0);
            });
    })->get();
    
    
    return response()->json([

        "status"=>"success",
        "message"=>"chats retrieved successfully",
        "chats"=>$chats,



    ]);


    }catch(Exception $ex){

        
        return response()->json([

            "status"=>"error",
            "message"=>" an error occured while retrieving chats , EX : $ex ",
            



        ]);




    }


   }
   
   
   public function getChat($receiver_id){


    try {

        $sender = Auth::user();
      
$sender_id = $sender->id;
$chat = Chat::query()
    ->where(function ($query) use ($sender_id, $receiver_id) {
        $query->where('sender_id', $sender_id)->where('receiver_id', $receiver_id)->where(function ($subquery) { 
        
               $subquery->where('isdeleted_sender', 0);
            });
    })
    ->orWhere(function ($query) use ($sender_id, $receiver_id) {
        $query->where('sender_id', $receiver_id)->where('receiver_id', $sender_id)->where(function ($subquery) { 
                $subquery
                    ->Where('isdeleted_receiver', 0);
            });
    })->get();
    
        return response()->json([

            "status"=>"success",
            "message"=>"chats retrieved successfully",
            "chat"=>$chat,
    
    
    
        ]);


        
    } catch (Exception $ex) {

         
        return response()->json([

            "status"=>"error",
            "message"=>" an error occured while retrieving chat , EX : $ex ",
            



        ]);

       
    }




   }
   
   
   
   public function deleteMessage($message_id){
    try{
    $user = Auth::user();

    $message = Chat::findorfail($message_id);
        if($message->sender_id !== $user->id && $message->receiver_id !== $user->id   ){

            return response()->json([

                "status"=>"error",
                "message"=>" only user can delete his messages",
                
        
        
        
            ]);
        

        }
         if($message->sender_id == $user->id ){
             $message->update([
                 
                 "isdeleted_sender"=>1,
                 
                 ]);
         }else{
               $message->update([
                 
                 "isdeleted_receiver"=>1,
                 
                 ]);
             
             
             
         }


   

    return response()->json([

        "status"=>"success",
        "message"=>"message deleted successfully",
       



    ]);

    
}catch(Exception $ex ){

    return response()->json([

        "status"=>"error",
        "message"=>" an error occured while deleting message , EX : $ex ",
        



    ]);

    
}
       
       
   }
   
   
   
   
   public function deleteChat($receiver_id){


    try {

 $sender = Auth::user();
$sender_id = $sender->id;
$messages = Chat::query()
  ->where(function ($query) use ($sender_id, $receiver_id) {
    $query->where('sender_id', $sender_id)
      ->where('receiver_id', $receiver_id);
  })
  ->orWhere(function ($query) use ($sender_id, $receiver_id) {
    $query->where('sender_id', $receiver_id)
      ->where('receiver_id', $sender_id);
  })
  ->get();
  
   foreach($messages as $message){
       
        if($message->sender_id == $sender_id ){
             $message->update([
                 
                 "isdeleted_sender"=>1,
                 
                 ]);
         }else{
               $message->update([
                 
                 "isdeleted_receiver"=>1,
                 
                 ]);
             
             
             
         }


       
   }


     
        return response()->json([

            "status"=>"success",
            "message"=>"chats deleted successfully",
            
    
    
    
        ]);


        
    } catch (Exception $ex) {

         
        return response()->json([

            "status"=>"error",
            "message"=>" an error occured while deleting chat , EX : $ex ",
            



        ]);

       
    }




   }
   
  
   

    
}
