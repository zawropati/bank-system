<?php
ini_set('display_errors', 0);

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}
$sPhone = $_SESSION['sUserId'];

$sAccountName = $_POST['txtAccountName'] ?? '';
if( empty($sAccountName) ){ sendResponse(0, __LINE__, "Fill out account name");  }
if( strlen($sAccountName) < 2 ){ sendResponse(0, __LINE__, "Account name cannot be shorter than 2 characters"); }
if( strlen($sAccountName) > 20 ){ sendResponse(0, __LINE__,  "Account name cannot be longer than 20 characters"); }

$sAccountType = $_POST['txtAccountType'];
if( empty($sAccountType) ){ sendResponse(0, __LINE__,  "Select account type");  }

$sAccountCurrency = $_POST['txtAccountCurrency'];
if( empty($sAccountCurrency) ){ sendResponse(0, __LINE__, "Select account currency");  }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__, "Server error"); }


if( $jAccount->accountType == $_POST['txtAccountType']){
      sendResponse(0, __LINE__, "You can only have one account of each type");
}

$jAccount = new stdClass();
$jAccountId = uniqid();
$jAccount->balance = 0;
$jAccount->accountName = $sAccountName;
$jAccount->accountType = $sAccountType;
$jAccount->accountCurrency = $sAccountCurrency;

$jInnerData = $jData->data->$sPhone->accounts;
$jInnerData->$jAccountId = $jAccount;


$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null ){ sendResponse(0, __LINE__, "Server error"); }
file_put_contents( '../data/clients.json', $sData );

///SUCCESS
header('Location: ../user-account.php');
sendResponse(1, __LINE__, "Success! New account added!");


// **************************************************

function sendResponse( $bStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}