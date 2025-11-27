<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

use Sentinel;
use Activation;
use SoapClient;
use App\Code;
use App\Check;
use App\Order;
use App\User;
use Cookie;

class WebVerificationController extends Controller
{
    //
    use Traits\CommonlyUsedFunctions;

    // landing page
    public function Home()
    {
        return view('public.home');
    }
    
    public function IsValidCode(Request $req)
    {
        //Cache::flush();
        $code = Code::CheckCodeValidity($req->code, "Web");
        $userID=$req->cookie('userId');
        $phoneNo=$req->cookie('phoneNo');
        //dd($userID)
        /*$userID=Cache::get('userId');
        $phoneNo=Cache::get('phoneNo');*/
        if( strlen($code) != 7 )
        {
            if(strlen($code)!=0)
            {
                //$errors["code"] = 'You have sent a '.strlen($code).'-character code. All Essilor lenses carry 7-character codes. Please retype the code and send again.';
                $errors["code"] = strtoupper($code).' is not a correct code. Please try again.';
            }
            else
            {
                $errors["code"] = 'Please enter the 7-character code provided in the back of the medicine strip.';
            }
            $response = array(
                'errors' => $errors
            );
        }
        else if ($userID != null && $phoneNo !=null)
        {
            $response = array(
                'cache' => "cache"
            );
            session(
                [
                    'code'=>$code
                ]
            );

        }
        else
        {
            $response = array(
                'success' => "done"
            );
            session(
                [
                    'code'=>$code
                ]
            );
        }
        return response()->json($response);
    }

    public function IsValidPhone(Request $req)
    {
        if( $phoneNo = User::IsValidPhoneNo($req->phoneNo) )
        {
            if( !$user = Sentinel::findByCredentials(['phone_number'=>$phoneNo]) )
            {
                $arr['phone_number'] = $phoneNo;
                $user = Sentinel::register($arr);
            }
            
            session(
                [
                    'userId'=>$user->id,
                    'phoneNo' => $phoneNo
                ]

            );
            /*Cache::put('userId', $user->id, now()->addMinutes(60));
            Cache::put('phoneNo', $phoneNo, now()->addMinutes(60));*/
            /*$cookieResponse = new Response('Set Cookie');
            $cookieResponse->withCookie(cookie('userId', $user->id,600000000));
            $cookieResponse->withCookie(cookie('phoneNo', $phoneNo,600000000));*/

            /*$cookieResponse = Response::make('Set Cookie');

            $cookieResponse->withCookie(Cookie::make('userId', $user->id, 2));
            $cookieResponse->withCookie(Cookie::make('phoneNo', $phoneNo, 2));*/
            Cookie::queue('userId', $user->id, 525600);
            Cookie::queue('phoneNo', $phoneNo, 525600);
            /*$response=array(
                'cookie'=>$cookieResponse,
            );*/
            //return $cookieResponse;

            
            if($this->SendConfirmationCode($user->id))
            {
                $response = array(
                    'success' => 'A phone authentication code has been sent to '.$phoneNo
                );
            }
            else
            {
                $response = array(
                    'codeNotSent' => 'Sorry something went wrong. Please report error 905 to support@panacea.live'
                );
            }
            return response()->json($response);
        }
        else
        {
            $response = array(
                'phoneError' => "Please enter a valid phone number"
            );
        }
        return response()->json($response);
    }

    public function LiveCheck(Request $req)
    {
        if($req->phoneNo=="cache")
        {
            $userID=$req->cookie('userId');
            $phoneNo=$req->cookie('phoneNo');

            $code = session('code');
            $response = Code::HandleCode($code,$phoneNo,'Web');
                if($response["status"]=='verified first time')
                {
                    $res = array(
                        'success' => $response["message"]
                    );
                    return response()->json($res);
                }
                else if ($response["status"]=='expired')
                {
                    $res = array(
                        'error' => $response["message"]
                    );
                    return response()->json($res);
                }
                else if ($response["status"] == 'already verified')
                {
                    $res = array(
                        'warning' => $response["message"]
                    );
                    return response()->json($res);
                }
                else
                {
                    $res = array(
                        'error' => $response["message"]
                    );
                    return response()->json($res);
                }

        }
        else
        {
            $user = User::find(session('userId'));
            $activationCode = strtoupper($req->activationCode);
            if ( Activation::complete($user, $activationCode) )
            {
                $errors = [];
                $phoneNo = session('phoneNo');
                $code = session('code');
                $response = Code::HandleCode($code,$phoneNo,'Web');
                if($response["status"]=='verified first time')
                {
                    $res = array(
                        'success' => $response["message"]
                    );
                    return response()->json($res);
                }
                else if ($response["status"]=='expired')
                {
                    $res = array(
                        'error' => $response["message"]
                    );
                    return response()->json($res);
                }
                else if ($response["status"] == 'already verified')
                {
                    $res = array(
                        'warning' => $response["message"]
                    );
                    return response()->json($res);
                }
                else
                {
                    $res = array(
                        'error' => $response["message"]
                    );
                    return response()->json($res);
                }
            }
            else
            {
                
                $phoneNo=$req->cookie('phoneNo');
                $res = array(
                    'activationError' => 'The phone authentication code did not match, please provide the correct authentication code.'
                    /*'activationError' => 'Hwaskdjsdkjsahdksja'.$phoneNo*/
                );
                return response()->json($res);
            }

        }
        
    }

    public function ResendCode(Request $req)
    {
        if( !$user = Sentinel::findByCredentials(['phone_number'=>$req->phoneNo]) )
        {
            $arr['phone_number'] = $req->phoneNo;
            $user = Sentinel::register($arr);
        }
        if($this->SendConfirmationCode($user->id))
        {
            $response = array(
                'success' => 'An authentication code has been resend to '.$user->phone_number
            );
        }
        else
        {
            $response = array(
                'error' => 'Sorry something went wrong. Please report error 905 to support@panacea.live'
            );
        }
        return response()->json($response);
    }
}
