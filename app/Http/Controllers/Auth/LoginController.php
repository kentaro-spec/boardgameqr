<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\Models\LinkedSocialAccount;
use App\Models\User;




class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // ログイン後に、トップページへ
    protected function redirectTo()
    {
        return '/';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider(string $provider)
    {
        // dd($provider);
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request , string $provider)
    {

        // try {
            // if ($request->missing('code')) {
            //     dd($request);
            // }
            // dd($provider);
            $user = Socialite::driver($provider)->user();
            dd($user);
        // } catch (\Exception $e) {
        //     return redirect('/')->with('oauth_error', 'ログインに失敗しました');
            // エラーならログイン画面へ転送
        // }

        $authUser = $this->findOrCreate(
            $user,
            $provider
        );
        auth()->login($authUser, true);
        return redirect($this->redirectTo);
    }

    public function findOrCreate($providerUser, $provider)
    {
        // linked_social_accountsへすでにユーザ登録済みかチェック
        $account = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();
        if ($account) {
            // すでにユーザ登録済みの場合はusersテーブルの情報を返す
            return $account->user;
        }

        $user = User::where('email', $providerUser->getEmail())->first();
        if (!$user) {
            // 未作成ならここで作成する
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'screen_name'  => $providerUser->getName(),
                'profile_image' => $providerUser->getAvatar(),
            ]);
        }

        // 取得(or作成)したusersテーブルに紐づくlinked_social_accountsのレコードを1行追加
        $user->accounts()->create([
            'provider_id'   => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        // 取得したusersテーブルの情報を返す
        return $user;
    }
}
