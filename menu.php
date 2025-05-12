<?php 
require_once 'database.php';

include'sms.php';

class Menu {

    private $sessionId;
    private $serviceCode;
    private $phoneNumber;
    private $balance;
    private $text;
    private $textArray;

    function __construct($sessionId, $phoneNumber, $serviceCode, $balance, $text) {
        $this->sessionId   = $sessionId;
        $this->phoneNumber = $phoneNumber;
        $this->serviceCode = $serviceCode;
        $this->balance     = $balance;
        $this->text        = $text;
    }

    public function handleRequest() {
        header("Content-type: text/plain");
        try {
            $connection = new Connection();
            $conn = $connection->connect();

            $stmt = $conn->prepare("SELECT * FROM subscribers WHERE phoneNumber = :phone");
            $stmt->bindParam(":phone", $this->phoneNumber);
            $stmt->execute();
            $subscriber = $stmt->fetch();

            $this->textArray = explode("*", $this->text);

            if ($subscriber) {
                $this->menuRegistered();
            } else {
                $this->registerMenu();
            }

        } catch (PDOException $e) {
            echo "END " . $e->getMessage();
        }
    }

    private function registerMenu() {
        $level = count($this->textArray);

        if ($this->text == "") {
            echo "CON 1. Register now";
        } else if ($this->textArray[0] == 1 && $level == 1) {
            echo "CON Enter Full Name";
        } else if ($level == 2) {
            echo "CON Enter PIN";
        } else if ($level == 3) {
            echo "CON Confirm PIN";
        } else if ($level == 4) {
            $response = "CON Is this number $this->phoneNumber the one you want to register?\n";
            $response .= "1. Confirm\n";
            $response .= "2. Cancel";
            echo $response;
        } else if ($level == 5) {
            $fullName = $this->textArray[1];
            $pin = $this->textArray[2];
            $confirmPin = $this->textArray[3];
            $choice = $this->textArray[4];

            if ($pin !== $confirmPin) {
                echo "END PINs do not match. Please restart.";
                return;
            }

            if ($choice == 1) {
                

                echo "END You're registered successfully!";
            } else {
                echo "END Registration cancelled.";
            }
        }
    }

    private function menuRegistered() {
        $level = count($this->textArray);

        if ($this->text == "") {
            echo "CON Welcome to Gervais USSD System\n";
            echo "1. Send Money\n";
            echo "2. Withdraw Money\n";
            echo "3. Check Balance\n";
            echo "q. Exit Service";
            return;
        }

        switch ($this->textArray[0]) {
            case 1:
                $this->sendMoney();
                break;
            case 2:
                $this->withdraw();
                break;
            case 3:
                if ($level == 1) {
                    echo "END Your balance is Rwf $this->balance";
                } else {
                    echo "END Invalid input for Balance.";
                }
                break;
            case 'q':
                if ($level == 1) {
                    echo "END Thank you for using our service.";
                } else {
                    echo "END Invalid exit command.";
                }
                break;
            default:
                echo "END Invalid choice.";
        }
    }

    private function sendMoney() {
        $level = count($this->textArray);

        if ($level == 1) {
            echo "CON Enter recipient Phone Number";
        } else if ($level == 2) {
            echo "CON Enter amount to send";
        } else if ($level == 3) {
            echo "CON Enter your PIN";
        } else if ($level == 4) {
            $recipient = $this->textArray[1];
            $amount = $this->textArray[2];
            echo "CON Send Rwf $amount to $recipient?\n1. Confirm\n2. Cancel";
        } else if ($level == 5) {
            $choice = $this->textArray[4];
            $recipient = $this->textArray[1];
            $amount = $this->textArray[2];

            if ($choice == 1) {
                $message = "You have received Rwf $amount from $this->phoneNumber.";
                $smsInstance = new sms($this->phoneNumber);
                $from = "Momo";
                $result = $smsInstance->sendSMS($message, $recipient, $from);

                if (is_array($result) && strtolower($result['status']) === 'success') {
                    echo "END Rwf $amount sent to $recipient. SMS sent successfully.";
                } else {
                    echo "END Money sent, but SMS failed: " . ($result['message'] ?? 'Unknown error');
                }
            } else {
                echo "END Transaction cancelled.";
            }
        } else {
            echo "END Invalid input.";
        }
    }

    private function withdraw() {
        $level = count($this->textArray);

        if ($level == 1) {
            echo "CON Enter amount to withdraw";
        } else if ($level == 2) {
            echo "CON Enter Agent code";
        } else if ($level == 3) {
            echo "CON Enter PIN";
        } else if ($level == 4) {
            $amount = $this->textArray[1];
            $agentCode = $this->textArray[2];
            echo "CON Confirm withdrawal of Rwf $amount from Agent $agentCode?\n1. Confirm\n2. Cancel";
        } else if ($level == 5) {
            $choice = $this->textArray[4];
            if ($choice == 1) {
                echo "END You have withdrawn Rwf " . $this->textArray[1];
            } else {
                echo "END Withdrawal cancelled.";
            }
        } else {
            echo "END Invalid input.";
        }
    }
}

// Read POST parameters
$sessionId   = $_POST['sessionId']   ?? '';
$phoneNumber = $_POST['phoneNumber'] ?? '';
$serviceCode = $_POST['serviceCode'] ?? '';
$balance     = $_POST['balance']     ?? '5000'; // default balance
$text        = $_POST['text']        ?? '';

// Run the menu
$menu = new Menu($sessionId, $phoneNumber, $serviceCode, $balance, $text);
$menu->handleRequest();
