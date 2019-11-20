<?php

ini_set('display_errors', 0);

$sPhone = $_POST['txtLoginPhone'] ?? '';
if( empty($sPhone) ){ sendResponse(0, __LINE__, "Phone is empty.");  }
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__, "Phone has to be 8 characters!"); }
if( !ctype_digit($sPhone)  ){ sendResponse(0, __LINE__, "Phone number has to have digits only!");  }

$sPassword = $_POST['txtLoginPassword'] ?? '';
if( empty($sPassword) ){ sendResponse(0, __LINE__, "Password is empty");  }
if( strlen($sPassword) < 4 ){ sendResponse(0, __LINE__, "Password has to be more than 4 characters"); }
if( strlen($sPassword) > 50 ){ sendResponse(0, __LINE__, "Passwrod has to be less than 50 characters"); }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__, "Server error."); }
$jInnerData = $jData->data;

// && $jInnerData. ACTIVE == 1 chceck if user is active

session_start();
$_SESSION['sUserId'] = $sPhone;

$jUser = $jInnerData->$sPhone;

if ($jUser->iLoginAttemptsLeft == 0){
  $iSecondSinceLastLoginAttempt = $jUser->iLastLoginAttempt + 60 - time();
  if( $iSecondSinceLastLoginAttempt <= 0 ){
    if ( !password_verify( $sPassword, $jUser->password )){  
      sendResponse( 0, __LINE__, "Wrong credentials, wait to log in." );
    }else{
      $jUser->iLoginAttemptsLeft = 3;
      $jUser->iLastLoginAttempt = 0;
      file_put_contents("../data/clients.json", json_encode($jData, JSON_PRETTY_PRINT));
      sendResponse( 1, __LINE__, "success!" );
    }
  }
    sendResponse( 0, __LINE__, "Please, wait $iSecondSinceLastLoginAttempt seconds to try again" );
}


if ( !password_verify( $sPassword, $jUser->password)) {
    $jUser->iLoginAttemptsLeft --;
    $jUser->iLastLoginAttempt = time();
    file_put_contents("../data/clients.json", json_encode($jData, JSON_PRETTY_PRINT));
    sendResponse( 0, __LINE__, "Wrong credentials, you have {$jUser->iLoginAttemptsLeft} left" );
}

$jUser->iLoginAttemptsLeft = 3;
$jUser->iLastLoginAttempt = 0;
file_put_contents("../data/clients.json", json_encode($jData, JSON_PRETTY_PRINT));
sendResponse( 1, __LINE__, "success!" );

// **************************************************


function sendResponse( $bStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}


















