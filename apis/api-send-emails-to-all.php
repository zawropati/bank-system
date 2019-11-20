<?php


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__, "Server error"); }
$jInnerData = $jData->data;
$quote = '"';

foreach($jInnerData as $key=> $jClient ){
    //$ret[]= $jClient->email;
    $email = $quote.$jClient->email.$quote;
    mail("$jClient->email", "Dear Patrycja Bank customer", "We are facing issues with our servers. We are currently working on it. We are very sorry for the inconvenience.");
    header('Location: ../admin-panel.php');

    //sendResponse(1, __LINE__, "Messages have been sent.");
    
}


//**************************************************
function sendResponse($bStatus, $iLineNumber, $message){
 echo '{"status": '.$bStatus.', "code": '.$iLineNumber.',"message":"'.$message.'"}';
 exit;
}

