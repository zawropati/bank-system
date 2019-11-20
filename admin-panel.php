<?php
ini_set('display_errors', 0);

session_start();

if( !isset($_SESSION['sUserId'] ) ){
  sendResponse(-1, __LINE__, 'You must login');
}

$sUserId = $_SESSION['sUserId'];
$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ echo 'System update'; }
$jInnerData = $jData->data;

require_once 'top.php';
?>
 <div class="sendEmailsDiv">
   <p>Send emails about troubles with the server to all bank customers</p>
   <button><a href="apis/api-send-emails-to-all">Send emails</a></button>
     </div>
  <?php

echo '     

<div class="wrapper">
';
foreach($jInnerData as $sPhone=>$jUser ){
  foreach( $jUser->loans as $sLoanId=>$jLoans ){
    if($jLoans->accepted != 1){
      echo "
      <div class='loanDiv'>
      <h1>Loan application</h1>
    <input id='phone' name='phone' type='hidden' value='$sPhone'>
    <input id='loanId' name='loanId' type='hidden' value='$sLoanId'>

    <p id='phone'>$sPhone</p>
    <p id='loanId'>$sLoanId</p>
    <p><span>Accepted: </span>$jLoans->accepted</p>
    <p><span>Applicant yearly income: </span>$jLoans->applicantYearlyIncome</p>
    <p><span>Requested amount: </span>$jLoans->requestedAmount</p>
    <p><span>Request payback period: </span>$jLoans->period</p>
    <p><span>Applicant applied before: </span>$jLoans->applicantAppliedBefore</p>
    <p><span>Loan currency: </span>$jLoans->currency</p>
      <button class='acceptLoan'><a>Accept loan</a></button>
    </div>
  "

;}


}}
echo '</div>';

?>

  <div class="table">
    <table>
      <thead>
          <h1>Bank customers</h1>
      <tr class="trCategories">
        <td>Phone</td>
        <td>Name</td>
        <td>Last Name</td>
        <td>Email</td>
        <td>Balance</td>
        <td>Active</td>
        <td>Cpr</td>
        <td>Block:</td>
      </tr>
    </thead>
    
    
    
    
    <?
      foreach($jInnerData as $sPhone=>$jUser ){
        $sActive = $jUser->active;
        if ($jUser->active == false){
          $sActive = "No";
          $sWord = "Unblock";
        }else{
          $sActive = "Yes";
          $sWord = "Block";
        }
        
        echo "
        <tr>
        <td>$sPhone</td>
        <td>$jUser->name</td>
        <td>$jUser->lastName</td>
        <td>$jUser->email</td>
        <td>$jUser->balance</td>
        <td>$sActive</td>
        <td>$jUser->cpr</td>
        <td><a href='apis/api-block-user.php?id=$sPhone'>$sWord</a></td>
        </tr>
        
        ";
      }       
      ?>

    </tbody>
  </table>
    </div>
 
<?php 
$sLinkToScript = '<script src="js/admin-panel.js"></script>';
require_once 'bottom.php'; 
?>

