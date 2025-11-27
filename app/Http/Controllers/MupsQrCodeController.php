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

class MupsQrCodeController extends Controller
{
    use Traits\CommonlyUsedFunctions;


    public function index()
    {
        return view('mups.index')->with('modal', 0);
    }


     // -------------------------------Arman-----------------------------

    public function mupslivecheck( Request $request ) {
        // return $request->all();

        $code = str_replace( ' ', '', $request->code );
        if ( strlen( $code ) > 7 ) {
            if ( strtoupper( substr( $code, 0, 3 ) ) == "REN" ) {
                $code = substr( $code, 3 );
            }
        }


        $phone_number = $request->phoneNo;
        if ( is_numeric($phone_number) )
        {
            if (strlen($phone_number) > 11) {
                $phone_number = substr($phone_number , -11);
            } else if (strlen($phone_number) < 11) {
                $response["status"] = 'wrong number';
                return view('mups.response')->with([
                    'response'  => $response,
                    'modal'  => 1,
                ]);
            }
            $startDigits = substr($phone_number , 0 , 3);
            if ($startDigits=='017' || $startDigits=='016' || $startDigits=='015' || $startDigits=='019' || $startDigits=='018' || $startDigits=='013' || $startDigits=='014') {
                $phone_number;
            } else {
                $response["status"] = 'wrong number';
                return view('mups.response')->with([
                    'response'  => $response,
                    'modal'  => 1,
                ]);
            }
        } else {
            $response["status"] = 'wrong number';
            return view('mups.response')->with([
                'response'  => $response,
                'modal'  => 1,
            ]);
        }


        $exists = Code::where('code',$code)->first();
        $checkHistory = new Check;
        $checkHistory->code = $code;
        $checkHistory->phone_number = $phone_number;
        $checkHistory->source = 'QR';
        $checkHistory->location = '';
        
        if( $exists ) {
            $verified = Check::where('code', $exists->code)->orderBy('created_at', 'asc')->first();
            $verificationCount = Check::where('code', $code)->count();
            $verificationCount += 1;
            $order = Order::find($exists->status);
            
            $verifiedPhoneNumber = Check::where('code', $exists->code)
            ->pluck('phone_number')
            ->first();
            
            if($order) {
                $today = date("M D");
                // code expired
                if ( strtotime($order->expiry_date) < strtotime($today) ) {
                    $checkHistory->remarks = "expired";
                    $response["status"] = 'expired';
                    $response["info"] = [
                        'manufacturer' => $order->company->company_name,
                        'product' => $order->medicine->medicine_name,
                        'dosage' => $order->medicine->medicine_dosage,
                        'mfg' => $order->mfg_date->format('M Y'),
                        'expiry' => $order->expiry_date->format('M Y'),
                        'batch' => $order->batch_number,
                    ];
                } 
                // if the code is already verified by someone
                else if ($verified) {
                    
                
                    $checkHistory->remarks = "already verified";
                    $response["status"] = 'already verified';                    
                    return $response["info"] = [
                        'manufacturer' => $order->company->company_name,
                        'product' => $order->medicine->medicine_name,
                        'dosage' => $order->medicine->medicine_dosage,
                        'mfg' => $order->mfg_date->format('M Y'),
                        'expiry' => $order->expiry_date->format('M Y'),
                        'batch' => $order->batch_number,
                        'preNumber' => substr($verifiedPhoneNumber, 0,5) . '***' .substr($verifiedPhoneNumber, 9),
                        'preDate' => $verified->created_at->format('d m Y'),
                        'totalCount' => $verificationCount,
                    ];
                }
                // code verified first time
                else {
                    $checkHistory->remarks = "verified first time";
                    $response["status"] = 'verified first time';

                    $response["info"] = [
                        'manufacturer' => $order->company->company_name,
                        'product' => $order->medicine->medicine_name,
                        'dosage' => $order->medicine->medicine_dosage,
                        'mfg' => $order->mfg_date->format('M Y'),
                        'expiry' => $order->expiry_date->format('M Y'),
                        'batch' => $order->batch_number,
                    ];
                }
            }
            else {
                $response["status"] = 'invalid code';
            }
        }
        else {
            $response["status"] = 'invalid code';
        }
        $checkHistory->save();
        return view('mups.response')->with([
            'response'  => $response,
            'modal'  => 1,
        ]);
    }





    // -------------------------------
    public function IsValidCode( Request $request ) {
        $code = str_replace( ' ', '', $request->code );
        if ( strlen( $code ) > 7 ) {
            if ( strtoupper( substr( $code, 0, 3 ) ) == "REN" ) {
                $code = substr( $code, 3 );
            }
        }

        $userID = $request->cookie( 'userId' );
        $phoneNo = $request->cookie( 'phoneNo' );

        if ( $userID != null && $phoneNo != null ) {
            $response = [
                'cache' => "cache",
            ];
            session( ['code' => $code] );

        } else {
            $response = [
                'success' => "done",
            ];
            session(
                [
                    'code' => $code,
                ]
            );
        }
        return response()->json( $response );
    }


    // ---------------------------------------
    public function IsValidPhone( Request $req ) {
        if ( $phoneNo = User::IsValidPhoneNo( $req->phoneNo ) ) {
            if ( !$user = Sentinel::findByCredentials( ['phone_number' => $phoneNo] ) ) {
                $arr['phone_number'] = $phoneNo;
                $user = Sentinel::register( $arr );
            }
            session([
                'userId'  => $user->id,
                'phoneNo' => $phoneNo,
            ]);
            Cookie::queue( 'userId', $user->id, 525600 );
            Cookie::queue( 'phoneNo', $phoneNo, 525600 );
            $userId = $user->id;
            if ( $this->SendConfirmationCode( $userId ) ) {
                $response = [
                    'success' => 'A phone authentication code has been sent to ' . $phoneNo,
                ];
            } else {
                $response = [
                    'codeNotSent' => 'Sorry something went wrong. Please report error 905 to support@panacea.live',
                ];
            }
            return $response;
        } else {
            $response = [
                'phoneError' => "Please enter a valid phone number",
            ];
        }
        return $response;
    }

    
    // -----------------------------------------------
    public function LiveCheck( Request $req ) {
        if ( $req->phoneNo == "cache" ) {
            $userID = $req->cookie( 'userId' );
            $phoneNo = $req->cookie( 'phoneNo' );
            $code = session( 'code' );
            $response = Code::HandleCode( $code, $phoneNo, 'QR' );
            if ( $response["status"] == 'verified first time' ) {
                $res = [
                    'verified' => $response["info"],
                ];
                return response()->json( $res );
            } else if ( $response["status"] == 'expired' ) {
                $res = [
                    'error' => $response["message"],
                ];
                return response()->json( $res );
            } else if ( $response["status"] == 'already verified' ) {
                $res = [
                    'reverify' => $response["info"],
                ];
                return response()->json( $res );
            } else {
                $res = [
                    'error' => $response["message"],
                ];
                return response()->json( $res );
            }
        } else {
            $user = User::find( session( 'userId' ) );
            $activationCode = strtoupper( $req->activationCode );
            if ( Activation::complete( $user, $activationCode ) ) {
                $errors = [];
                $phoneNo = session( 'phoneNo' );
                $code = session( 'code' );
                $response = Code::HandleCode( $code, $phoneNo, 'QR' );
                if ( $response["status"] == 'verified first time' ) {
                    $res = [
                        'verified' => $response["info"],
                    ];
                    return response()->json( $res );
                } else if ( $response["status"] == 'expired' ) {
                    $res = [
                        'error' => $response["message"],
                    ];
                    return response()->json( $res );
                } else if ( $response["status"] == 'already verified' ) {
                    $res = [
                        'reverify' => $response["info"],
                    ];
                    return response()->json( $res );
                } else {
                    $res = [
                        'error' => $response["message"],
                    ];
                    return response()->json( $res );
                }
            } else {

                $phoneNo = $req->cookie( 'phoneNo' );
                $res = [
                    'activationError' => 'The phone authentication code did not match, please provide the correct authentication code.',
                ];
                return response()->json( $res );
            }
        }
    }
    // -----------------------------------------------

}
