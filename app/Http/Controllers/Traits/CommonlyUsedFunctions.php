<?php 
namespace App\Http\Controllers\Traits;

use Activation;
use SoapClient;
use App\User;
use Illuminate\Support\Facades\Mail;

trait CommonlyUsedFunctions
{
    public function SendConfirmationCode($userId = null)
    {
        if ($userId == null) $userId = session('userId');
        $user = User::find($userId);
        $activation = Activation::create($user);
        $message = $activation->code." is your phone verification code for Renata Live Check.";
        return $this->SendSms($user->phone_number,$message);
        //return true;
    }
    
    public function SendSms($phone_number, $message, $mask = 'Panacea')
    {
        try {
            $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array('userName' => "01675430523",
                'userPassword' => "tapos99", 'mobileNumber' => $phone_number,
                'smsText' => $message, 'type' => "TEXT",
                'maskName' => "Panacea", 'campaignName' => '',);

            $value = $soapClient->__call("OneToOne", array($paramArray));
            if (substr(get_object_vars($value)["OneToOneResult"], 0, 4) == "1903") {
                Mail::raw('Onnorokom needs to be recharged', function ($message) {
                    $message->to("ashfaq@panacea.live");
                    $message->subject("[Panacea] Onnorokom Recharge Alert!");
                });
                return false;
            }
            return true;
        } catch (Exception $e) {
            \Log::error("Error 905, at App/Traits/CommonlyUsedFunctions.php file. Details: ".$e->getMessage());
            return false;
        }
    }
}