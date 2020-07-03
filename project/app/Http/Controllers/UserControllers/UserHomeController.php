<?php

namespace App\Http\Controllers\UserControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserHomeController extends Controller
{
    public function index(Request $request){
        if($request->session()->has('user_id')){

            $user_id = $request->session()->get('user_id');

            $user = DB::table('user_details')
                        ->where('user_id', $user_id)
                        ->first();

            $login = DB::table('user_login')
                        ->where('user_id', $user_id)
                        ->first();
						
			$msgData = DB::table('message_details')
							->where('sender_id', $user_id)
							->orWhere('receiver_id', $user_id)
							->orderBy('message_time', 'desc')
							->get();
			
			$flwData = DB::table('user_follower')
							->where('user_id', $user_id)
							->get();
							
			$msgCnt = DB::table('message_details')
							->where('receiver_id', $user_id)
							->where('status', '0')
							->value(DB::raw('count(*)'));

            $post = DB::table('post_details')
            ->join('user_details', 'user_details.user_id','post_details.user_id')
            ->join('user_login','user_login.user_id','post_details.user_id')
            ->select('user_details.first_name','user_details.last_name','user_details.image','user_login.username','post_details.*')
            ->orderBy('post_details.post_time','DESC')
            ->get();

            // $likes = DB::table('post_likes')
            //             ->where('post_id',$post_id)
            //             ->count();

            //dd($likes);

            return view('UserViews.home', ['user' => $user, 'login' => $login, 'post'=>$post, 'msgData'=>$msgData, 'msgCnt'=>$msgCnt, 'flwData'=>$flwData]);
        }
        else{
            return redirect('/');
        }
    }
	
}
