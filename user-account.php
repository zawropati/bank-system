<?php 
ini_set('display_errors', 0);
session_start();
require_once 'top.php'; ?>
<div class="wrapper">
<form method="POST" action="apis/api-add-account" id="frmAddAccount">
    <h1>Create new bank account</h1>
    <label for="txtAccountName">Account name (eg. 'Alan account')</label>
    <input type="text" name="txtAccountName">
    <label for="txtAccountType">Account type</label>
    <select class="required" name="txtAccountType">
      <option disabled selected></option>
      <option value="SavingsAccount">Savings Account</option>
      <option value="MoneyMarketAccount">Money Market Account</option>
    </select>
    <label for="txtAccountCurrency">Account currency</label>
    <select name="txtAccountCurrency">
        <option disabled selected></option>
        <option value="Dkk">DKK</option>
        <option value="Usd">USD</option>
    </select>
    <button>Add new account</button>
    </form>

    <form method="POST" action='apis/api-get-card' id="frmGetCard">
    <h1>Get a credit card</h1>
    <label for="txtCardAccountType">Choose account you want to get a card for</label>
    <select multiply class="required" name="txtCardAccountTypeId">
      <option disabled selected></option>
      <?php 
        $sUserId = $_SESSION['sUserId'];
            
        $sData = file_get_contents('data/clients.json');
        $jData = json_decode($sData);
        if( $jData == null ){ echo 'System update'; }
        $jClient = $jData->data->$sUserId;
        $jAccounts = $jClient->accounts;

        foreach( $jAccounts as $sAccountId=>$jAccount ){
        //$sAccountId = $_POST['accountId'];
        echo "<option value='$sAccountId'>$jAccount->accountName</option>";
      }
      ?>
    </select> 
    <label for="txtCardType">Card type</label>
    <select name="txtCardType">
        <option disabled selected></option>
        <option value="Visa">Visa</option>
        <option value="Mastercard">Mastercard</option>
    </select>
    <button>Get credit card</button>
    </form>
    </div>
<?php

echo '      
<div class="wrapper">
';
$sPhone = $_SESSION['sUserId'];

foreach( $jInnerData->$sPhone->accounts as $sAccountId=>$jAccount ){
    echo "
    <div class='loanDiv'>
    <h2>$jAccount->accountName</h2>
        <p><span>Balance: </span>$jAccount->balance $jAccount->accountCurrency</p>
    <p><span>Account type: </span>$jAccount->accountType</p>
    <p><span>Credit card: </span>$jAccount->card</p>
    ";
    if($jAccount->card != 0){
    echo "
    <p><span>Credit card type: </span>$jAccount->cardType</p>
      <button style='background:red'><a href='apis/api-block-credit-card.php?accountId=$sAccountId&userId=$sPhone'>Block my credit card</a></button>
  ";}
    echo "</div>"
;

}
?>

<?php 
$sLinkToScript = '<script src="js/user-account.js"></script>';
require_once 'bottom.php'; 
?>