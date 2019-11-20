<?php

$userEmail = $_POST['userEmail'] ?? '';
if(empty($userEmail)){
  sendResponse(0, __LINE__, 'Email field is empty');
}

$phoneNumber = $_POST['userPhoneNumber'] ?? '';
if(empty($phoneNumber)){
  sendResponse(0, __LINE__, 'Phone field is empty');
}

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if($jData == null){
 sendResponse(0, __LINE__, "Problem with json");
}

$jInnerData = $jData->data;

if($jInnerData->$phoneNumber->email != $userEmail){
 sendResponse(0, __LINE__, "The credentials are incorrect");
}

$sNewTemporaryPassword = substr(md5(microtime()),rand(0,26),10);
$sHashedNewTemporaryPassword = password_hash( $sNewTemporaryPassword, 1);

$jInnerData->$phoneNumber->password = $sHashedNewTemporaryPassword;



$sData = json_encode($jData, JSON_PRETTY_PRINT);
if( $sData == null){
 sendResponse(0, __LINE__, 'Phone field is empty');
}
file_put_contents('../data/clients.json', $sData);

//SUCCESS
sendResponse(1, __LINE__, $sNewTemporaryPassword );

//**************************************************
function sendResponse($bStatus, $iLineNumber, $sMessage){
 echo '{"status": '.$bStatus.', "code": '.$iLineNumber.', "message": "'.$sMessage.'"}';
 exit;
}
