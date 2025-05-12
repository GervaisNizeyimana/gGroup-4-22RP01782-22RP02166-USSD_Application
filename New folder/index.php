<?php
include 'menu.php';
include_once"database.php";
$sessionId   = $_POST['sessionId'];
$phoneNumber = $_POST['phoneNumber'];
$serviceCode = $_POST['serviceCode'];
$balance=$_POST['balance'];
$text        = $_POST['text'];
    $isRegistered = False;
 $database = new Connection();
$conn = $database->connect();
try {

    $stmt=$conn->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");

    $stmt->bindParam(":phone",$phoneNumber);
    $stmt->execute();
    $subscriber=$stmt->fetch();
    if($subscriber){

        $isRegistered = True;



    }
    
} catch (PDOException $e) {

    echo "END Error:".$e->getMessage();
    
}




$menu = new Menu($text,$sessionId,$phoneNumber);
$text=$menu->middleware($text);
if($text == "" && !$isRegistered){
    //Do something
    $menu->mainMenuUnregistered();
}else if($text == "" && $isRegistered){
    $menu ->mainMenuRegistered();
}else if(!$isRegistered){
    $textArray = explode("*", $text);
    switch($textArray[0]){
        case 1:
            $menu->menuRegister($textArray);
            break;
        default:
            echo "END Invalid option, Retry";
    }
}
else{
    $textArray = explode("*", $text);
    switch($textArray[0]){
        case 1:
            $menu->menuSendMoney($textArray);
            break;
        case 2:
            $menu->menuWithdrawMoney($textArray);
            break;
        case 3:
            $menu->menuCheckBalance($textArray);
            break;
        default:
            echo "END Invalid choice\n";
    }
}
?>