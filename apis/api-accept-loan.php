<?php
ini_set('display_errors', 0);

if( !isset( $_GET['userId'] ) ){
  header('Location: admin-panel.php');
}


$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__, "System update.");
}
if( $_GET['userId'] == null ){ sendResponse(0, __LINE__, "User id not provided.");
}
if( $_GET['loanId'] == null ){ sendResponse(0, __LINE__, "Loan id not provided.");
}

$jInnerData = $jData->data;



foreach($jInnerData as $sPhone=>$jUser ){
  foreach( $jUser->loans as $sLoanId=>$jLoan ){
    if( $sPhone == $_GET['userId'] && $sLoanId == $_GET['loanId'] ){
      $jLoan->accepted = 1;
      $jLoan->payedBack = 0;
      $jLoan->startDate = time();
      unset($jLoan->applicantAppliedBefore);
      unset($jLoan->applicantYearlyIncome);
        $sData = json_encode($jData, JSON_PRETTY_PRINT);
        file_put_contents('../data/clients.json', $sData);        
      }
    }}
    
    sendResponse(1, __LINE__, "Loan was accepted.");


// **************************************************

function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}