<?php

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}
$sPhone = $_SESSION['sUserId'];

$iApplicantYearlyIncome = $_POST['iYearlyIncome'] ?? '';
if( empty($iApplicantYearlyIncome) ){ sendResponse(0, __LINE__, "Yearly income is empty.");  }

// validate last name
$iLoanAmount = $_POST['iLoanAmount'] ?? '';
if( empty($iLoanAmount) ){ sendResponse(0, __LINE__, "Amount is empty.");  }

// validate email
$sLoanPeriod = $_POST['txtLoanPeriodInMonths'] ?? '';
if( empty($sLoanPeriod) ){ sendResponse(0, __LINE__, "Loan period is empty.");  }

// validate password
$sLoanCurrency = $_POST['txtLoanCurrency'] ?? '';
if( empty($sLoanCurrency) ){ sendResponse(0, __LINE__, "Currency is empty.");  }

// validate confirm password
$sLoanAppliedBefore = $_POST['txtLoanAppliedBefore'] ?? '';
if( empty($sLoanAppliedBefore) ){ sendResponse(0, __LINE__, "Pick yes or no.");  }



$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__, "Problems with server."); }
$jInnerData = $jData->data;

$jClient = $jInnerData->$sPhone;
$jLoans = $jClient->loans;


$jLoan = new stdClass();
$jLoan->accepted = 0;
$sLoanId = uniqid();
$jLoan->applicantYearlyIncome = $iApplicantYearlyIncome;
$jLoan->requestedAmount = $iLoanAmount;
$jLoan->period = $sLoanPeriod;
$jLoan->currency = $sLoanCurrency;
$jLoan->applicantAppliedBefore = $sLoanAppliedBefore;


$jInnerData = $jData->data->$sPhone->loans;
$jInnerData->$sLoanId = $jLoan;


if( $sLoanId == null ){ sendResponse(0, __LINE__, "Id is empty."); }
if( $jLoan == null ){ sendResponse(0, __LINE__, "Loan is empty."); }

$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null ){ sendResponse(0, __LINE__, "Problems with server."); }
file_put_contents( '../data/clients.json', $sData );

// SUCCESS
//header('Location: ../loan.php');
sendResponse(1, __LINE__, "Application was sent and it's waiting to be accepted.");


// **************************************************

function SendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}

