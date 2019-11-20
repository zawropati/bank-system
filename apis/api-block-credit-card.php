<?php
//ini_set('display_errors', 0);

if( !isset( $_GET['userId'] ) ){
  header('Location: user-account.php');
}

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ echo 'System update'; }
$jInnerData = $jData->data;

$sPhone = $_GET['userId'];
  foreach( $jInnerData->$sPhone->accounts as $sAccountId=>$jAccount ){
    if( $sPhone == $_GET['userId'] && $sAccountId == $_GET['accountId'] ){
      $jAccount->card = 0;
      unset($jAccount->cardType);
      echo json_encode($jAccount);
        $sData = json_encode($jData, JSON_PRETTY_PRINT);
        file_put_contents('../data/clients.json', $sData);
        header('Location: ../user-account.php');

}}

// sendResponse(1, __LINE__);


// **************************************************

function sendResponse( $bStatus, $iLineNumber ){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
  exit;
}

