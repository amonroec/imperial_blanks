<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Storage;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'price' => 'required',
        ]);

        return tap($user)->update($request->only('name', 'email', 'price'));
    }

    public function updateUserImage(Request $request) {
        $file = $request->file('user_pic');
        $user = $request->all();
        // foreach($file as $f) {
            $upload = Storage::disk('public')->putFile('', $file, 'public');
        // }
        $res = User::find($user['id']);
        $res->user_pic = '/storage/' . $upload;
        $res->save();
        return $res;
    }
}
