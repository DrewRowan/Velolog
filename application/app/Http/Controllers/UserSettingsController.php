<?php

namespace App\Http\Controllers;

use App\Models\StravaBikeModel;
use App\Services\StravaService;
use App\StravaSettings;
use App\Repositories\Interfaces\BikeRepositoryInterface;
use App\User;
use App\UserSettings;
use CodeToad\Strava\Strava;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient; 

class UserSettingsController extends Controller
{
    public $successStatus = 200;
    
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $bikeRepository;
    private $stravaService;

    public function __construct(BikeRepositoryInterface $bikeRepository)
    {
        $this->bikeRepository = $bikeRepository;
        $this->client_id = env('CT_STRAVA_CLIENT_ID', ''); # Strava Client ID
        $this->client_secret = env('CT_STRAVA_SECRET_ID', ''); # Strava Secrect
        $this->redirect_uri = env('CT_STRAVA_REDIRECT_URI', ''); # Strava Redirect URi
        $this->stravaService = new StravaService();
    }

    public function index() {

        $strava_settings = new StravaSettings;
        $units = ['metric', 'imperial'];
        $strava_authorised = $strava_settings->IsStravaAuthorised(Auth::user()->id);

        $settings = UserSettings::where('user_id', Auth::user()->id)->get()->first();

        return view('settings', ['settings' => $settings, 'units' => $units, 'strava_authorised' => $strava_authorised]);
    }

    public function store(Request $request)
    {
        // need to add backend validation
        $requestObject = $request->all();

        $settings = UserSettings::where('user_id', Auth::user()->id)->get()->first();

        $settings->units = $requestObject['units'];
        $settings->strava_id = isset($requestObject['strava_id']) ? $requestObject['strava_id'] : '';

        $settings->save();

        return redirect('settings')->withSuccess('Settings updated!');
    }

    public function connectStrava()
    {
        return redirect('https://www.strava.com/oauth/authorize?client_id='. $this->client_id .'&response_type=code&redirect_uri='. $this->redirect_uri . '&scope=read_all,profile:read_all,activity:read_all&state=strava');
    }

    public function completeRegistration(Request $request)
    {
        $error = $request->input('error');

        if (isset($error) && $error == 'access_denied') {
            return redirect('settings')->with('error', 'You have not authorised connection with Strava');
        }

        $code = $request->input('code');
        $this->saveSettings($code);

        $stravaBikeModel = new StravaBikeModel($this->bikeRepository);
        $stravaBikeModel->fetchStravaGear();

        return redirect('/home')->withSuccess('Strava sync successful!');;
    }

    public function getStravaGear()
    {
        $stravaBikeModel = new StravaBikeModel($this->bikeRepository);
        $stravaBikeModel->fetchStravaGear();

        return redirect('/settings')->withSuccess('Bikes synced from Strava!');
    }

    private function saveSettings($code)
    {
        $token = $this->stravaService->getToken($code);

        $strava_settings = new StravaSettings;
        $strava_settings->strava_authorised = 1;
        $strava_settings->user_id = Auth::user()->id;
        $strava_settings->strava_id = $token->athlete->id;
        $strava_settings->return_code = $code;
        $strava_settings->refresh_token = $token->refresh_token;
        $strava_settings->access_token = $token->access_token;
        $strava_settings->expires_at = $token->expires_at;

        $strava_settings->save();
    }
}
