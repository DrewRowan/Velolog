<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\MailgunService;
use app\Services\StravaService;
use App\User;
use App\UserSettings;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    private $mailgunService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->mailgunService = new MailgunService();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $settings['units'] = $data['units'];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => '1',
        ]);

        $settings['user_id'] = $user->id;
        $settings['subscribe'] = $data['subscribe'];

        UserSettings::create($settings);

        // add user to subscribe queue - this should be moved to something async but i'm too stupid to figure it at the moment
        if (isset ($data['subscribe'])) {
            try {
                $response = $this->mailgunService->addSubscriber($user);
            } catch(Exception $e) {
                // handle failure
            }
        }

        if (isset($data['connectstrava'])) {
            $stravaService = new StravaService();
            $this->redirectTo = $stravaService->returnStravaUrl();
        }

        return $user;
    }
}
