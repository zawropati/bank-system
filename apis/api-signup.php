<?php

$sPhone = $_POST['txtSignupPhone'] ?? '';
if( empty($sPhone) ){ sendResponse(0, __LINE__);  }
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__); }
if( intval($sPhone) < 10000000 ){ sendResponse(0, __LINE__); }
if( intval($sPhone) > 99999999 ){ sendResponse(0, __LINE__); }

// validate name
$sName = $_POST['txtSignupName'] ?? '';
if( empty($sName) ){ sendResponse(0, __LINE__);  }
if( strlen($sName) < 2 ){ sendResponse(0, __LINE__); }
if( strlen($sName) > 20 ){ sendResponse(0, __LINE__); }

// validate last name
$sLastName = $_POST['txtSignupLastName'] ?? '';
if( empty($sLastName) ){ sendResponse(0, __LINE__);  }
if( strlen($sLastName) < 2 ){ sendResponse(0, __LINE__); }
if( strlen($sLastName) > 20 ){ sendResponse(0, __LINE__); }

// validate email
$sEmail = $_POST['txtSignupEmail'] ?? '';
if( empty($sEmail) ){ sendResponse(0, __LINE__);  }
if( !filter_var( $sEmail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__);  }

// validate password
$sPassword = $_POST['txtSignupPassword'] ?? '';
if( empty($sPassword) ){ sendResponse(0, __LINE__);  }
if( strlen($sPassword) < 4 ){ sendResponse(0, __LINE__); }
if( strlen($sPassword) > 50 ){ sendResponse(0, __LINE__); }

// validate confirm password
$sConfirmPassword = $_POST['txtSignupConfirmPassword'] ?? '';
if( empty($sConfirmPassword) ){ sendResponse(0, __LINE__);  }
if( $sPassword != $sConfirmPassword ){ sendResponse(0, __LINE__);  }


// CPR validate
$sCpr = $_POST['txtSignupCpr'] ?? '';
if( empty($sCpr) ){ sendResponse(0, __LINE__);  }
if( strlen($sCpr) != 10 ){ sendResponse(0, __LINE__); }
if( !ctype_digit($sCpr)  ){ sendResponse(0, __LINE__);  }

$sAccountName = $_POST['txtAccountName'] ?? '';
if( empty($sAccountName) ){ sendResponse(0, __LINE__);  }
if( strlen($sAccountName) < 2 ){ sendResponse(0, __LINE__); }
if( strlen($sAccountName) > 20 ){ sendResponse(0, __LINE__); }

$sAccountCurrency = $_POST['txtAccountCurrency'];
if( empty($sAccountCurrency) ){ sendResponse(0, __LINE__);  }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__); }
$jInnerData = $jData->data;


$jClient = new stdClass(); // json empty
$jClient->name = $sName;
$jClient->lastName = $sLastName;
$jClient->email = $sEmail;
$jClient->password = password_hash( $sPassword, PASSWORD_DEFAULT );
$jClient->cpr = $sCpr;
$jClient->balance = 0;
$jClient->active = 1;
$jClient->iLoginAttemptsLeft = 3;
$jClient->iLastLoginAttempt = 0;
$jClient->admin = 0;
$jClient->loans = new stdClass();

$jClient->accounts = new stdClass();
$jAccount = new stdClass();
$jAccount->balance = 0;
$jAccount->accountName = $sAccountName;
$jAccount->accountType = "mainAccount";
$jAccount->accountCurrency = $sAccountCurrency;

$sAccountId = uniqid();
$jClient->accounts->$sAccountId = $jAccount;

$jClient->transactions = new stdClass();
$jInnerData->$sPhone = $jClient;
$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ sendResponse(0, __LINE__); }
file_put_contents( '../data/clients.json', $sData );
sendResponse(1, __LINE__);

// SUCCESS


// **************************************************

function sendResponse( $bStatus, $iLineNumber ){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
  exit;
}
