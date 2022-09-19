<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    public function index()
    {
        $messages = Room::with('messages')->where('from_id',1)->get();

        return response()->json(['messages'=>$messages]);
    }

    public function getUserMessage($username){

        
        $user_id = Auth::user()->id;
        $to_user = User::where('username',$username)->first();

        $message= Room::with(['toUser'=>function($query){
            $query->select('first_name','last_name','username');
        },'messages'])
        ->where('to_id', $to_user->id)
        ->where('from_id', $user_id)
        ->get();

        return response()->json(['messages'=>$message]);

    }


}
