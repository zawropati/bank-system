<?php 
ini_set('display_errors', 0);
session_start();
require_once 'top.php'; ?>

   
   <form method="POST" action="apis/api-loan-apply" id="frmLoanApply">
   <h1>Apply for a loan</h1>
    <label>Yearly income</label>
    <input type="number" name="iYearlyIncome">
    <label>Amount to apply for</label>
    <input type="number" name="iLoanAmount">
    <label>Loan period</label>
    <select  name="txtLoanPeriodInMonths">
        <option disabled selected></option>
        <option value="6 months">6 months</option>
        <option value="12 months">12 months</option>
        <option value="24 months">24 months</option>
    </select>
    <label>Loan currency</label>
    <select name="txtLoanCurrency">
            <option disabled selected></option>
        <option value="Dkk">DKK</option>
        <option value="Usd">USD</option>
    </select>
    <label>Have you applied for a loan before?</label>
    <select name="txtLoanAppliedBefore">
        <option disabled selected></option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
    <button> Apply for a loan </button>
    </form>
<?php
echo '      
<div class="wrapper">
';
$sPhone = $_SESSION['sUserId'];

foreach( $jInnerData->$sPhone->loans as $sLoanId=>$jLoan ){
    $date = date('r',$jLoan->startDate);
    if($jLoan->accepted != 0){
    echo "
    <div class='loanDiv'>
    <h2>Loan</h2>
        <p><span>Amount: </span>$jLoan->requestedAmount $jLoan->currency</p>
        <p><span>Period: </span>$jLoan->period</p>
        <p><span>Payed back: </span>$jLoan->payedBack $jLoan->currency</p>
    <p><span>Starting date: </span>$date</p>
    ";
    echo "</div>"
    ;
}

}?>
<?php 
$sLinkToScript = '<script src="js/loan.js"></script>';
require_once 'bottom.php'; 
?>