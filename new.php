<?php
require 'vendor/autoload.php'; // Composer autoloader

use AfricasTalking\SDK\AfricasTalking;

class sms {
    protected $phone;
    protected $AT;
    protected $username;
    protected $message;
    protected $from;
    protected $to;

    // Constructor
    function __construct($phone, $username, $to, $message, $from) {
        $this->phone = $phone;
        $this->username = $username;
        $this->to = $to;
        $this->message = $message;
        $this->from = $from;

        $this->AT = new AfricasTalking('sandbox', 'atsk_a746364f6190b8fe200dbe2d1c762254b9ddb51a117114094b689d8d3f380a67da00894d');
    }

    // Send SMS method
    public function sendSMS() {
        $sms = $this->AT->sms();

        try {
            $result = $sms->send([
                'username' => $this->username,
                'to'       => $this->to,
                'message'  => $this->message,
                'from'     => $this->from
            ]);
            return $result;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = $_POST['to'] ?? '';
    $from = $_POST['from'] ?? '';
    $message = $_POST['message'] ?? '';
    $username = $_POST['username'] ?? 'sandbox';

    if(empty($to)){
        $to="+250786139330";
        echo "$to";
    }


}





?>
