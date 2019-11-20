
<?php


ini_set('user_agent', 'any');

ini_set('display_errors',0);

session_start();

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
$jInnerData = $jData->data;

if($jData == null){
 sendResponse(-1, __LINE__, 'Can not convert data to json.');
}


if( !isset ($_SESSION['sUserId'])){
 sendResponse(-1, __LINE__, 'You must login to use this api.');
}

//$sendFromPhone = $_SESSION['sUserId'];
$sendFromPhone = $_SESSION['sUserId'];

$sendToPhone = $_GET['phone'] ?? '';
if(empty($_GET['phone'])){
 sendResponse(-1, __LINE__, 'Phone number is missing.');
}

$iAmount = $_GET['amount'] ?? '';
if(empty($_GET['amount'])){
 sendResponse(-1, __LINE__, 'Amount is missing.');
}
if($iAmount <= 0){
 sendResponse(-1, __LINE__, 'Amount has to be more, than 0.');
}


if( $jInnerData->$sendFromPhone->balance - $iAmount < 0  ){
 sendResponse(-1, __LINE__, 'The amount you want to send is bigger than your balance.');
}

if(!preg_match('/^[0-9]+$/', $sendToPhone)){ // !ctype_digit($sCpr)
 sendResponse(-1, __LINE__, 'Phone can only contain numbers.');
}

if( strlen($sendToPhone) != 8){
 sendResponse(-1, __LINE__, 'Phone must be 8 characters in length');
}


if(empty($_GET['message'])){
 sendResponse(-1, __LINE__, 'Message is missing.');
}


$sMessage = $_GET['message'] ?? '';


//if i dont have that phone in my own bank
if(!$jInnerData->$sendToPhone){
 $jListOfBanks = fnjGetListOfBanksFromCentralBank();
 //loop through the list of the banks, and connect to each bank
 foreach($jListOfBanks as $sKey => $jBank){
   $sUrl = $jBank->url.'/apis/api-handle-transaction?phone='.$sendToPhone.'&amount='.$iAmount.'&message='.$sMessage;
  
   $sBankResponse =  file_get_contents($sUrl);
   $jBankResponse = json_decode($sBankResponse);

     if( $jBankResponse->status ==1 && $jBankResponse->code && $jBankResponse->message){
        $jInnerData->$sendFromPhone->balance -= $iAmount;
        $sData = json_encode($jData, JSON_PRETTY_PRINT);
        file_put_contents('../data/clients.json', $sData);
        sendResponse(1, __LINE__, $jBankResponse->message);
     }
 }

 sendResponse(2, __LINE__, 'Phone doesnt exist');
}


$jInnerData->$sendToPhone->balance += $iAmount;
$jInnerData->$sendFromPhone->balance -= $iAmount;


$jTransaction->date = time();
$jTransaction->amount = $iAmount;
$jTransaction->fromPhone = $sendFromPhone;
$jTransaction->message = $sMessage;

$sTransactionUniqId = uniqid();

$jInnerData->$sendToPhone->transactions->$sTransactionUniqId = $jTransaction;


$sData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents('../data/clients.json', $sData);

sendResponse(1, __LINE__, 'I have the phone number locally!');

//***************************** */

function sendResponse( $iStatus, $iLineNumber, $sMessage){
 echo '{"status": '.$iStatus.', "code": '.$iLineNumber.',"message":"'.$sMessage.'"}';
 exit;
}

function fnjGetListOfBanksFromCentralBank(){
 $sData = file_get_contents('https://ecuaguia.com/central-bank/api-get-list-of-banks.php?key=1111-2222-3333');
 return json_decode($sData);
}














