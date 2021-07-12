<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
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
        return redirect('/');
    }

    public function authUser($token) {
        $user = User::where('auth_token', $token)->firstOrFail();
        Auth::login($user, true);

        return redirect('wallet');
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




        return redirect('wallet');
    }


    /**
     * Find User and return or Create User and return
     * @param  Object $user
     * @return array User's data
     */
    public function findOrCreateUser($user)
    {
        if ($authUser = User::where('uid', $user['user_id'])->first()) {

            //generate unique token
            do
            {
                $token = Str::random(40);
                $auth_token = User::where('auth_token', $token)->get();
            }
            while(empty($auth_token));

            $authUser->update([
                'name'      => $user['first_name'],
                'username'  => $user['username'],
                'auth_token' => $token
            ]);

            return 'Добро пожаловать! Ваша временная ссылка для авторизации в системе: ' . env('APP_URL').'/auth/'.$authUser->auth_token;
        }
        else {

            //generate unique token
            do
            {
                $token = Str::random(40);
                $auth_token = User::where('auth_token', $token)->get();
            }
            while(empty($auth_token));

            $newUser = User::create([
                'uid'           => $user['user_id'],
                'name'          => $user['first_name'],
                'username'      => $user['username'],
                'referred_by'   => $user['referred_by'],
                'auth_token' => $token
            ]);

            $newUser->createWallet(
                [
                    'name' => 'USDT',
                    'slug' => 'USDT',
                ]
            );
            $newUser->createWallet(
                [
                    'name' => 'BTC',
                    'slug' => 'BTC',
                    'decimal_places' => '8'
                ]
            );
            $newUser->createWallet(
                [
                    'name' => 'ETH',
                    'slug' => 'ETH',
                    'decimal_places' => '6'
                ]
            );

            $newUser->createWallet(
                [
                    'name' => 'DHB',
                    'slug' => 'DHB',
                ]
            );


            return 'Вы успешно зарегистрированы в системе. Ваша сылка для авторизации в системе: ' . env('APP_URL').'/auth/'.$newUser->auth_token;
        }


    }
}
