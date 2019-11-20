<?php

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: login');
}
$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ echo 'System update'; }
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;

require_once 'top.php';
?>

<div class="wrapper">
<div class="loanDiv">
  <h1>PROFILE</h1>
  <div>Name: <?= $jClient->name; ?></div>
  <div>Last Name: <?= $jClient->lastName; ?> </div>
  <div>Email: <?= $jClient->email; ?> </div>
  <div>Phone: <?= $sUserId; ?> </div>
  <div>Balance: <span id="lblBalance"><?= $jClient->balance; ?></span></div>
  <a id="changePass" href="change-password">Change pass</a>
</div>  
  <form id="frmTransfer">
    <h1>Transfer money</h1>
    <label for="txtTransferToPhone">Phone number to transfer to</label>
    <input name="txtTransferToPhone" id="txtTransferToPhone" type="text">
    <label for="txtTransferAmount">Amount to transfer</label>
    <input name="txtTransferAmount" id="txtTransferAmount" type="text">
    <label for="txtTransferMessage">Message</label>
    <input name="txtTransferMessage" id="txtTransferMessage" type="text">
    <button>Transfer</button>
  </form>
</div>
<div class="table">
  <h1>Transactions</h1>
  <table>
    <thead>
      <tr class="trCategories">
        <td>ID</td>
        <td>DATE</td>
        <td>AMOUNT</td>
        <td>PHONE</td>
        <td>MESSAGE</td>
      </tr>
    </thead>
    <tbody id="lblTransactions">



      <?php
      foreach( $jClient->transactions as $sTransactionId => $jTransaction ){
        echo "
          <tr>
            <td>$sTransactionId</td>
            <td>$jTransaction->date</td>
            <td>$jTransaction->amount</td>
            <td>$jTransaction->fromPhone</td>
            <td>$jTransaction->message</td>
          </tr>
        ";
      }   

   

      ?>









    </tbody>
  </table>
    </div>

<?php 
$sLinkToScript = '<script src="js/profile.js"></script>';
require_once 'bottom.php'; 
?>

