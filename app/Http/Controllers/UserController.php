<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Alert;
use DB;
use Redirect;
class UserController extends Controller
{
      public function googleLogout(Request $request){
        Auth::logout();
        $request->session()->flush();
        Alert::success('Signing off', 'Logging out with Google');
        return redirect::to('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://iquiz-jmccasusi249188.codeanyapp.com/');
      }
  
        
   
        public function googleLogin(Request $request)  {
            $google_redirect_url = route('glogin');
            $gClient = new \Google_Client();
            $gClient->setApplicationName(config('services.google.app_name'));
            $gClient->setClientId(config('services.google.client_id'));
            $gClient->setClientSecret(config('services.google.client_secret'));
            $gClient->setRedirectUri($google_redirect_url);
            $gClient->setDeveloperKey(config('services.google.api_key'));
            $gClient->setScopes(array(
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ));
            $google_oauthV2 = new \Google_Service_Oauth2($gClient);
            if ($request->get('code')){
                $gClient->authenticate($request->get('code'));
                $request->session()->put('token', $gClient->getAccessToken());
            }
            if ($request->session()->get('token'))
            {
                $gClient->setAccessToken($request->session()->get('token'));
            }
            if ($gClient->getAccessToken())
            {
                //For logged in user, get details from google using access token
                $guser = $google_oauthV2->userinfo->get();  
                   
                    $request->session()->put('name', $guser['name']);
              
              
              
                if(strpos($guser['email'], 'iacademy.edu.ph') > 0 
                  || strpos($guser['email'], 'nueva') > 0
                  || strpos($guser['email'], 'casusi') > 0
                  || strpos($guser['email'], 'reyes') > 0){
                  if ($user =User::where('email',$guser['email'])->first())
                            {
                                Auth::login($user);
                            }else{
                               User::create([
                                  'name' => $guser['name'],
                                  'email' => $guser['email'],
                                //  'password' => $gClient->getAccessToken(),
                                  'isFaculty' => ctype_alpha($guser['email'][0])  ]);
                            } 
                           Alert::success('Welcome!', 'Logged in via Google');
                           return redirect()->action('HomeController@index'); 
                        } else {
                           $request->session()->forget('token');
                          return redirect::to('https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://iquiz-jmccasusi249188.codeanyapp.com/noniac');
  
                }
              
              } else
            {
                //For Guest user, get google login url
                $authUrl = $gClient->createAuthUrl();
                return redirect()->to($authUrl);
            }
        }
  
  
       
}