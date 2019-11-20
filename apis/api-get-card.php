<?php
//ini_set('display_errors', 0);

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}
$sPhone = $_SESSION['sUserId'];

$sCardAccountTypeId = $_POST['txtCardAccountTypeId'] ?? '';
if( empty($sCardAccountTypeId) ){ sendResponse(0, __LINE__, "Select account type");  }

$sCardType = $_POST['txtCardType'];
if( empty($sCardType) ){ sendResponse(0, __LINE__, "Select card type");  }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__, "Server error"); }
$jClient = $jData->data->$sPhone;
$jAccount = $jClient->accounts->$sCardAccountTypeId;

if( $jAccount->card == 1){
      sendResponse(0, __LINE__, "You already have a card for this account! If you lost your card, block it and apply again");
}

$jAccount->card = 1;
$jAccount->cardType = $sCardType;



 
$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null ){ sendResponse(0, __LINE__, "Server error"); }
file_put_contents( '../data/clients.json', $sData );

///SUCCESS
header('Location: ../user-account.php');
//sendResponse(1, __LINE__, "Succsess");


// **************************************************


function sendResponse( $bStatus, $iLineNumber, $sMessage ){
    echo '{"status":'.$bStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
    exit;
  }
  

