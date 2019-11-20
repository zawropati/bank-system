<?php 
ini_set('display_errors', 0);

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
$jInnerData = $jData->data;

$sPhone = $_SESSION['sUserId'];

$sOldPass = $_POST['txtOldPass'];
if( empty($sOldPass) ){ sendResponse(0, __LINE__, "Old password is empty!");  }

$sNewPass = $_POST['txtNewPass'];
if( empty($sNewPass) ){ sendResponse(0, __LINE__, "New password is empty!");  }
if( strlen($sNewPass) < 4 ){ sendResponse(0, __LINE__, "New password has to be longer than 4 characters."); }
if( strlen($sNewPass) > 50 ){ sendResponse(0, __LINE__, "New password has to be shorter than 50 characters."); }

$sConfirmNewPass = $_POST['txtConfirmNewPass'];
if( empty($sConfirmNewPass) ){ sendResponse(0, __LINE__,"Confirm password is empty."); }
if ($sNewPass != $sConfirmNewPass){ sendResponse(0, __LINE__,"New password and confirm password are not the same."); }


if( !password_verify( $sOldPass, $jInnerData->$sPhone->password)){ sendResponse(0, __LINE__, "New password does not match with your old password.") ;  }

$sHashedNewPassword = password_hash($sNewPass, 1);
$jInnerData->$sPhone->password = $sHashedNewPassword; 

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
file_put_contents('../data/clients.json', $sData);

sendResponse(1, __LINE__,"Success");

// **************************************************

function sendResponse( $bStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}
