<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Check;
use App\User;
use App\Order;

class Code extends Model
{
    //
    protected $table = 'code';
    
    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'status',
    ];

    
    public function medicine()
    {
        return $this->belongsTo('Panacea\Medicine');

    }

    public function order()
    {
        return $this->belongsTo('Panacea\Order');

    }

    public static function CheckCodeValidity($code, $source)
    {
        if ($source == "SMS") 
        {
            $code = substr( $code, 3 );
            $code = str_replace( ' ', '' , $code );
            return $code;
        }
        else
        {
            $code = str_replace( ' ', '' , $code );
            if( strlen($code) > 7)
            {
                if (strtoupper(substr( $code, 0, 3 )) == "REN")
                    $code = substr( $code, 3 );
            }
            return $code;
        }
    }

    // if code not valid "invalid code"

    public static function HandleCode($code, $phoneNo, $source)
    {
        $code = str_replace( ' ', '' , $code );
        if( strlen($code)> 7 )
        {
            $code = substr( $code, 2 );
        }
        $code = strtoupper($code);
        $exists = Code::where('code',$code)
                        ->first();
        \Log::info($code);
        
        $checkHistory = new Check;
        $checkHistory->code = $code;
        $checkHistory->source = $source;
        $checkHistory->phone_number = $phoneNo;
        $checkHistory->location = '';
        
        $response["code"] = $code;
        try
        {
            if( !$user = User::where( 'phone_number', $phoneNo )->first() )
            {
                $credentials["phone_number"] = $phoneNo;
                $credentials['password'] = 'a';
                if($source == 'SMS') $user = Sentinel::registerAndActivate($credentials);
                else $user = Sentinel::register($credentials);
            }
            if( $exists )
            {
                $verified = Check::where('code', $exists->code)->orderBy('created_at', 'asc')->first();

                $order = Order::find($exists->status);

                if($order)
                {
                    $today = date("M D");
                    // code expired
                    if ( strtotime($order->expiry_date) < strtotime($today) ) 
                    {
                        $checkHistory->remarks = "expired";
                        $response["status"] = 'expired';
                        $response["message"] = self::FormatResponse('expired',$order,$verified,$phoneNo);
                    } 
                    // if the code is already verified by someone
                    else if ($verified)
                    {
                        $checkHistory->remarks = "already verified";

                        $response["status"] = 'already verified';
                        $response["message"] = self::FormatResponse('already verified',$order,$verified,$phoneNo);
                    }
                    // code verified first time
                    else
                    {
                        $checkHistory->remarks = "verified first time";
                        $response["status"] = 'verified first time';
                        $response["message"] = self::FormatResponse('verified first time',$order,$verified,$phoneNo);
                    }
                }
                else
                {
                    $checkHistory->remarks = "not ordered yet";
                    $response["status"] = 'invalid code';
                    $response["message"] = self::FormatResponse('invalid code');
                }
            }
            else
            {
                $checkHistory->remarks = "invalid code";
                $response["status"] = 'invalid code';
                $response["message"] = self::FormatResponse('invalid code');
            }

            $checkHistory->save();
            return $response;
        }
        catch(\Illuminate\Database\QueryException $ex){
            if($source == 'SMS') echo "Sorry something went wrong! Please report error 901 at support@panacea.live";
            \Log::error("Error 901, at App/Code.php file. Details: ".$ex->getMessage());
            abort(303);
        }
        catch(Exception $e){
            if($source == 'SMS') echo "Sorry something went wrong! Please report error 902 at support@panacea.live";
            \Log::error("Error 902, at App/Code.php file. Details: ".$ex->getMessage());
            abort(303);
        }
    }

    private static function FormatResponse( $remark, $order = null, $check = null, $phoneNo = null )
    {
        if( $remark == "verified first time")
        {
            return "This medicine is Panacea Verified. It is manufactured by Renata, named " .
                $order->medicine->medicine_name . " " .
                $order->medicine->medicine_dosage . " and expires on " .
                $order->expiry_date->format('d M Y') . ".";
        }
        else if ( $remark == "already verified")
        {
            return 'This medicine was first verified on ' .
                    $check->created_at->format('d M Y') .
                    ' by '. substr( $phoneNo, 0,5) . '***' .substr( $phoneNo, 8).
                    '. We advise you not to use the medicine if it was not verified by you or someone you know first.';
        }
        else if ( $remark == "expired")
        {
            return 'This medicine has expired on '.$order->expiry_date->format('d M Y')
            .'. Please do not use this and report to www.panacea.live if needed.';
        }
        else
        {
            return 'This code is not a right code. Please try again with a 7 characters correct code.';
        }
    }
}
