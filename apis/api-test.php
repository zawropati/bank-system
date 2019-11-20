
<?php
ini_set('display_errors', 0);

$sPhone = $_POST['phone'];
$sPassword = $_POST['password'];

if ( empty($sPhone) ){ sendResponse( 0, __LINE__, "Phone is empty" ); }
if ( strlen($sPhone) != 8 ){ sendResponse( 0, __LINE__, "Phone has ot be 8" ); }

if ( strlen($sPassword) < 4 ){ sendResponse( 0, __LINE__, "Pass 4" ); }
if ( strlen($sPassword) > 50 ){ sendResponse( 0, __LINE__, "Pass 50" ); }


$sData = file_get_contents('1111.json');
$jData = json_decode($sData);
if($jData == null){ sendResponse(0, __LINE__, "sth went wrong");}

$userPhone = $jData->phone;
$userPass = $jData->password;
 
if( $userPhone != $sPhone ){
    sendResponse(0, __LINE__, "Wrong phone");
}

if( $userPass != $sPassword ){
    sendResponse(0, __LINE__, "Wrong pass");
}

$jData->active = 1;
// $jAccounts = new stdClass();

$jAccount = new stdClass();
$jAccountID = uniqid();
$jAccount->balance = 10;

$jData->accounts->$jAccountID = $jAccount;

echo $jAccountID.' '.'hej';
$sData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents('1111.json', $sData);

sendResponse(1, __LINE__, "user is active");

function sendResponse( $status, $code, $message ){

    echo '{"status":'.$status .',"code":'.$code.',"message":"'.$message.'"}';

    exit;
}