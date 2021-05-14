<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Redirect;
use Socialite;
use View;
use Auth;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return Response
     */
    public function login()
    {
        return view('welcome');
    }


    /**
     * Callback with User's data
     * @param  string $provider Returns either twitter or github
     * @return array User's data
     */
    public function getUser()
    {
        $user = Socialite::driver('telegram')->user();

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect('wallet');
    }


    /**
     * Find User and return or Create User and return
     * @param  Object $user
     * @return array User's data
     */
    private function findOrCreateUser($user)
    {
        if ($authUser = User::where('uid', $user->id)->first()) {
            $authUser->update([
                'avatar'    => $user->avatar,
                'name'      => $user->name,
                'username'  => $user->nickname
            ]);

            return $authUser;
        }



        $user = User::create([
            'uid'       => $user->id,
            'avatar'    => $user->avatar,
            'name'      => $user->name,
            'username'  => $user->nickname
        ]);

        $user->createWallet(
            [
                'name' => 'USDT',
                'slug' => 'USDT',
            ]
        );
        $user->createWallet(
            [
                'name' => 'BTC',
                'slug' => 'BTC',
                'decimal_places' => '8'
            ]
        );
        $user->createWallet(
            [
                'name' => 'ETH',
                'slug' => 'ETH',
                'decimal_places' => '6'
            ]
        );

        $user->createWallet(
            [
                'name' => 'DHB',
                'slug' => 'DHB',
            ]
        );

        return $user;

    }
}
