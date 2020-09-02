<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\Subscription;
use App\Post;
use App\Rate;
use App\Http\Controllers\PostsController;
use App\Mail\LoginEmail;
use App\Mail\AccountConfirmed;
use App\RateUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function fetchUser(Request $request) {
    	$user = User::find($request->user);
    	$emailCheck = substr($user->email, strpos($user->email, "@") + 1);
    	if ($emailCheck) {
    		return $user;
	    } else {
	    	return 'false';
	    }
    }

    public function checkAccess(Request $request) {
        if ($request->password == 'ripbobbyb') {
            return 'passed';
        } else if ($request->password == 'theonsdick') {
            return 'passed_nwtf';
        } else {
            return 'failed';
        }
    }

    public function getFishermanProfile(Request $request) {
        $fishId = $request->fisherman_id;
        $user = User::find($fishId);
        $user->subscriptions = $this->getUserSubscriptions($fishId);
        $user->likes = $this->getLikesDislike($fishId, 2);
        $user->dislikes = $this->getLikesDislike($fishId, 1);
        $user->rating = $this->getRating($fishId);
        $user->already_rated = $this->checkIfRated($fishId, $request->user_id);
        return $user;
    }

    protected function getLikesDislike($userId, $rate) {
        $res = Rate::select('id')->where('fisherman_id', $userId)->where('like_dislike', $rate)->get();
        if ($res) {
            return count($res);
        } else {
            return 0;
        }
    }

    protected function getRating($fishId) {
        $res = RateUser::where('fisherman_id', $fishId)->avg('rate');
        return floatval($res);
    }

    protected function checkIfRated($fishId, $userId) {
        $res2 = RateUser::select()->where('fisherman_id', $fishId)->where('user_id', $userId)->first();
        if ($res2) {
            $rate = $res2->rate;
        } else {
            $rate = NULL;
        }
        return $rate;
    }

    public function getUsers(Request $request) {
    	$res = User::all();
    	return $res;
    }

    public function getNeedsConfirmed(Request $request) {
        $res = User::select()->where('confirmed', 0)->get();
        return $res;
    }

    public function saveUser(Request $request) {
    	$user = $request->user;
    	$res = User::find($user['id']);
    	$res->admin = $user['admin'];
        $res->customer_number = $user['customer_number'];
        $res->confirmed = 1;
    	$res->save();
    	return $res;
    }

    public function confirmUser(Request $request) {
        $user = $request->user;
        $res = User::find($user['id']);
        $res->customer_number = $user['customer_number'];
        $res->confirmed = 1;
        $res->save();

        if ($res) {
            Mail::to($user['email'])->send(new AccountConfirmed());
        }
        return $res;
    }

    public function logoutEveryone(Request $request) {
    	$res = DB::table('users')->update(['remember_token' => NULL]);
    	return $res;
    }

    public function getSearch(Request $request) {
        $search = $request->search;

        // $res = User::select()->where('name', 'LIKE', $search . '%')->get();
        $res = DB::table('users')
                    ->select()
                    ->where('users.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.username', 'LIKE', '%' . $search . '%')
                    ->orderBy('users.name', 'ASC')
                    ->get();
        foreach($res as $out) {
            $out->posts = count($this->getUserPosts($out->id, 'all'));
            $out->subscriptions = $this->getUserSubscriptions($out->id);
        }
        return $res;
    }

    protected function getUserPosts($id, $num) {
        if ($num != 'all') {
            $res = Post::select()->where('user_id', $id)->offset($num)->limit(10)->orderBy('id', 'DESC')->get();
        } else {
            $res = Post::select()->where('user_id', $id)->orderBy('id', 'DESC')->get();
        }
        return $res;
    }

    protected function getUserSubscriptions($id) {
        $res = Subscription::select()->where('fisherman_id', $id)->get();
        if ($res) {
            return count($res);
        } else {
            return 0;
        }
    }

    public function getUserData(Request $request) {
        $res = User::select()->where('username', $request->username)->where('user_token', $request->user_token)->first();
        if ($res) {
            $res->posts = $this->getUserPosts($res->id, $request->num);
            $pController = new PostsController;
            foreach($res->posts as $out) {
                $out->likes = $pController->checkRateTotal($out->id, 2);
                $out->dislikes = $pController->checkRateTotal($out->id, 1);
            }
            $res->subscriptions = $this->getUserSubscriptions($res->id);
            return $res;
        }
    }

    // Getting all subscriptions with user using user id
    public function getMySubscriptions(Request $request) {
        $userId = $request->user_id;
        $date = date('Y-m-d H:i:s');
        // $r = Subscription::select()
        //         ->where('user_id', $userId)
        //         ->where('subscription_end_timestamp', '>=', $date)
        //         ->get();
        $res = DB::table('subscriptions')
                    ->leftJoin('users', 'users.id', '=', 'subscriptions.fisherman_id')
                    ->select('subscriptions.*', 'users.name', 'users.id as user_id', 'users.user_pic', 'users.username', 'users.user_token')
                    ->where('user_id', $userId)
                    ->where('subscription_end_timestamp', '>=', $date)
                    ->get();

        foreach($res as $out) {
            $out->posts = count($this->getUserPosts($out->user_id, 'all'));
            $out->subscriptions = count($this->getUserSubscriptions($out->user_id));
        }

        return $res;
    }

    public function testEmail(Request $request) {
        $res = Mail::to('Bertia@sullivaneagles.org')->send(new LoginEmail());
        return $res;
    }
}
