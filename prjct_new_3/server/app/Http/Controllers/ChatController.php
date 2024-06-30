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
    $chats = Chat::where("receiver_id",$user->id)->orwhere("sender_id",$user->id)->get();
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
//       
$sender_id = $sender->id;
$chat = Chat::query()
  ->where(function ($query) use ($sender_id, $receiver_id) {
    $query->where('sender_id', $sender_id)
      ->where('receiver_id', $receiver_id);
  })
  ->orWhere(function ($query) use ($sender_id, $receiver_id) {
    $query->where('sender_id', $receiver_id)
      ->where('receiver_id', $sender_id);
  })
  ->get();

     
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
        if($message->sender_id !== $user->id || $message->receiver_id !== $user->id   ){

            return response()->json([

                "status"=>"error",
                "message"=>" only user can delete his messages",
                
        
        
        
            ]);
        

        }


    $message->delete();

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
//       
$sender_id = $sender->id;
$chat = Chat::query()
  ->where(function ($query) use ($sender_id, $receiver_id) {
    $query->where('sender_id', $sender_id)
      ->where('receiver_id', $receiver_id);
  })
  ->orWhere(function ($query) use ($sender_id, $receiver_id) {
    $query->where('sender_id', $receiver_id)
      ->where('receiver_id', $sender_id);
  })
  ->get();
  
   if($message->sender_id !== $user->id || $message->receiver_id !== $user->id   ){

            return response()->json([

                "status"=>"error",
                "message"=>" only user can delete his messages",
                
        
        
        
            ]);
        

        }

  
  $chat->delete();

     
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
