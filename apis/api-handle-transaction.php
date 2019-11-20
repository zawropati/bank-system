<?php

ini_set('display_errors', 0);

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );
if( $jData == null ){ fnvSendResponse(-1, __LINE__, 'Cannot convert the data file to json'); }
$jInnerData = $jData->data;

$sPhoneFromOtherServer = $_GET['phone'];
$iAmountFromOtherServer = $_GET['amount'];
$sMessageFromOtherServer = $_GET['message'];

// VALIDATE


if( !$jInnerData->$sPhoneFromOtherServer ){   
  fnvSendResponse(0, __LINE__, 'Phone not registered in Patrycja Bank');
}


// Give the amount to the registered phone
$jInnerData->$sPhoneFromOtherServer->balance += $iAmountFromOtherServer;

$jTransaction->date = time();
$jTransaction->amount = $iAmountFromOtherServer;
$jTransaction->fromPhone = $sPhoneFromOtherServer;
$jTransaction->message = $sMessageFromOtherServer;

$sTransactionUniqueId = uniqid();

$jInnerData->$sPhoneFromOtherServer->transactions->$sTransactionUniqueId = $jTransaction;


$sData = json_encode($jData);
file_put_contents('../data/clients.json', $sData);
// Check if this was success




fnvSendResponse(1, __LINE__, 'Transaction success from Patrycja Bank');


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}