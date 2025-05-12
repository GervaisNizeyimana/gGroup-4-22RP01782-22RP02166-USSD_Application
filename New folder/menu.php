<?php
// include_once'sms.php';
// include_once 'database.php';
// include_once'util.php';

class Menu {
    protected $text;
    protected $sessionId;
    protected $phoneNumber;
    protected $balance;



    function __construct($text, $sessionId, $phoneNumber, $balance = 0.0) {
        $this->text = $text;
        $this->sessionId = $sessionId;
        $this->phoneNumber = $phoneNumber;
        $this->balance = $balance;
    }
    

    public function mainMenuUnregistered() {
        $response = "CON Welcome to XYZ MOMO \n"; 
     $response .= "1. Register\n"; 
        echo $response;
    }

    public function menuRegister($textArray) {
        $level = count($textArray);

        if ($level == 1) {
            echo "CON Enter your fullname \n";
        } else if ($level == 2) {
            $response="CON Enter your PIN \n";
            $response .="98. Back\n";
            $response .="99. Main Menu";
            echo $response;


        } else if ($level == 3) {
            echo "CON Re-enter your PIN \n";
        } else if ($level == 4) {
            $name = $textArray[1];
            $pin = $textArray[2];
            $confirm_pin = $textArray[3];
            if ($pin != $confirm_pin) {
                echo "END PINs do not match, Retry";
            } else {
                $hashedPin = password_hash($pin, PASSWORD_DEFAULT);
                try {
                    $database = new Connection();
                    $conn = $database->connect();
                    $query = "INSERT INTO subscribers(fullName, pin, phoneNumber, balance) VALUES(?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    if ($stmt->execute([$textArray[1], $hashedPin, $this->phoneNumber, $this->balance])) {
                        echo"END Dear $name, you have successfully registered";

                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        }
    }

    public function mainMenuRegistered() {
        $response = "CON Welcome back to XYZ MOMO.\n";
        $response .= "1. Send Money\n";
        $response .= "2. Withdraw Money\n";
        $response .= "3. Check balance";
        echo $response;
    }

    public function menuSendMoney($textArray) {
        $level = count($textArray);
        if ($level == 1) {
            echo "CON Enter recipient phone number";
        } else if ($level == 2) {
            echo "CON Enter amount";
        } else if ($level == 3) {
            echo "CON Enter PIN";
        } 
        else if($level==4){
            $response="CON Do you want to send amount of $textArray[2]Rwf to $textArray[1]\n";
            $response .="1.Confirm\n";
            $response .="2.Cancel\n";
            $response .="98. Go back\n";
            $response .="99.Main menu";
            echo $response;
        }
        else if($level==5 && $textArray[4]==1){
            $sms="END Amount of $textArray[2] Rwf sent to $textArray[1] successfully";
            $instance = new Sms($this->phoneNumber);
            $sent=$instance->sendSms($sms,$textArray[1]);

        }
        else if($level==5 && $textArray[4]==2){
            echo"END Thank you for using our services";
            
        }
        else if($level==5 && $textArray[4]==98){
            echo"END you are requesting to go back one step(to PIN)";
            
        }
        else if($level==5 && $textArray[4]==99){
            echo"You are requesting to go back to the main menu";
            
        }
        else{

            echo"END Invalid option";
        }
        // else {
        //     $senderPhone = $this->phoneNumber;
        //     $recipientPhone = $textArray[1];
        //     $amount = (float)$textArray[2];
        //     $pin = $textArray[3];

        //     try {
        //         $database = new Connection();
        //         $conn = $database->connect();

        //         $stmtSender = $conn->prepare("SELECT * FROM subscribers WHERE phoneNumber = :phone");
        //         $stmtSender->bindParam(':phone', $senderPhone);
        //         $stmtSender->execute();
        //         $sender = $stmtSender->fetch();

        //         $stmtRecipient = $conn->prepare("SELECT * FROM subscribers WHERE phoneNumber = :phone");
        //         $stmtRecipient->bindParam(':phone', $recipientPhone);
        //         $stmtRecipient->execute();
        //         $recipient = $stmtRecipient->fetch();

        //         if (!$recipient) {
        //             echo "END Recipient not found!";
        //             return;
        //         }

        //         if (password_verify($pin, $sender['pin']) == false) {
        //             echo "END Invalid PIN";
        //             return;
        //         }

        //         if ($sender['balance'] < $amount) {
        //             echo "END Insufficient balance!";
        //             return;
        //         }
        //         if($senderPhone==$recipientPhone){

        //             echo "END You can't send money on your own Account";
        //             return;
        //         }

        //         // Begin database transaction
        //         $conn->beginTransaction();


        //         // Deduct from sender
        //         $stmtUpdateSender = $conn->prepare("UPDATE subscribers SET balance = balance - :amount WHERE phoneNumber = :phone");
        //         $stmtUpdateSender->bindParam(':amount', $amount);
        //         $stmtUpdateSender->bindParam(':phone', $senderPhone);
        //         $stmtUpdateSender->execute();

        //         // Add to recipient
        //         $stmtUpdateRecipient = $conn->prepare("UPDATE subscribers SET balance = balance + :amount WHERE phoneNumber = :phone");
        //         $stmtUpdateRecipient->bindParam(':amount', $amount);
        //         $stmtUpdateRecipient->bindParam(':phone', $recipientPhone);
        //         $stmtUpdateRecipient->execute();

        //         // Commit transaction
        //         $conn->commit();

        //         echo "END You have successfully sent $amount to $recipientPhone";
        //     } catch (PDOException $e) {
        //         if ($conn->inTransaction()) {
        //             $conn->rollBack(); // Rollback transaction on error
        //         }
        //         echo "END Error: " . $e->getMessage();
        //     }
        // }
    }

    public function menuWithdrawMoney($textArray) {
        $level = count($textArray);
        if ($level == 1) {
            echo "CON Enter amount";
        } else if ($level == 2) {
            echo "CON Enter Agent code";
        } else if ($level == 3) {
            echo "CON Enter PIN";
        } else if ($level == 4) {
            $amount = $textArray[1];
            $agentCode = $textArray[2];
            $pin = $textArray[3];

            try {
                $database = new Connection();
                $conn = $database->connect();

                $stmtAgent = $conn->prepare("SELECT * FROM agents WHERE agentCode = :code");
                $stmtAgent->bindParam(":code", $agentCode);
                $stmtAgent->execute();
                $agent = $stmtAgent->fetch();

                if (!$agent) {
                    echo "END Invalid agent code.";
                    return;
                }

                $stmtSubscriber = $conn->prepare("SELECT * FROM subscribers WHERE phoneNumber = :phone");
                $stmtSubscriber->bindParam(":phone", $this->phoneNumber);
                $stmtSubscriber->execute();
                $subscriber = $stmtSubscriber->fetch();

                if (!$subscriber) {
                    echo "END Subscriber not found.";
                    return;
                }

                if (!password_verify($pin, $subscriber['pin'])) {
                    echo "END Invalid PIN.";
                    return;
                }

                if ($subscriber['balance'] < $amount) {
                    echo "END Insufficient balance.";
                    return;
                }

                // Begin transaction
                $conn->beginTransaction();

                // Deduct balance from subscriber
                $stmtDeduct = $conn->prepare("UPDATE subscribers SET balance = balance - :amount WHERE phoneNumber = :phone");
                $stmtDeduct->bindParam(":amount", $amount);
                $stmtDeduct->bindParam(":phone", $this->phoneNumber);
                $stmtDeduct->execute();

                // Add balance to agent
                $stmtAdd = $conn->prepare("UPDATE agents SET balance = balance + :amount WHERE agentCode = :code");
                $stmtAdd->bindParam(":amount", $amount);
                $stmtAdd->bindParam(":code", $agentCode);
                $stmtAdd->execute();

                // Commit transaction
                $conn->commit();

                echo "END You have successfully withdrawn $amount from your account.";
            } catch (PDOException $e) {
                if ($conn->inTransaction()) {
                    $conn->rollBack(); // Rollback transaction on error
                }
                echo "END Error: " . $e->getMessage();
            }
        }
    }

    public function menuCheckBalance($textArray) {
        $level = count($textArray);
        if ($level == 1) {
            echo "CON Enter PIN";
        } else {


            try {

                $database = new Connection();
                $conn = $database->connect();
                $conn->beginTransaction();

                $stmt5 = $conn->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
                $stmt5->bindParam(":phone",$this->phoneNumber);
                $stmt5->execute();
                $subscriber=$stmt5->fetch();
                if(!$subscriber){
                    echo "END Your phone number is not registered";
                    return;
                }
                if( !password_verify($textArray[1], $subscriber['pin'])){

                    echo "END Invalid PIN";

                   return;

                }
                " END Your balance: ".$subscriber['balance']." Frw";
                $result= $sms->sendSms($message,"+250786139330");
                
                
            } catch (Exception $e) {

                if ($conn->inTransaction()) {
                    $conn->rollBack(); // Rollback transaction on error
                }
                echo "END Error: " . $e->getMessage();

                
            }


            
        }
    }

    public function goBack($text){
        $explodedText =explode("*",$text);
        while(array_search(Util::$GO_BACK, $explodedText) !=false){

            $firstIndex=array_search(Util::$GO_BACK,$explodedText);
            array_splice($explodedText,$firstIndex -1,2);

        }
        return join("*",$explodedText);
    }
    public function goToMainMenu($text){
        $explodedText =explode("*",$text);
        while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) !=false){

            $firstIndex=array_search(Util::$GO_TO_MAIN_MENU,$explodedText);
            $explodedText=array_slice($explodedText,$firstIndex +1);

        }
        return join("*",$explodedText);
    }
    public function middleware($text){

        return $this->goBack($this->goToMainMenu($text));
    }
}
?>
