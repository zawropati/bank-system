<?php require_once 'top.php'; ?>



<form id="frmSignup" action="apis/api-signup" method="POST">
<h1>Sign up</h1>
  <input name="txtSignupPhone" type="text" placeholder="phone" value="" maxlength="8">
  <input name="txtSignupName" type="text" placeholder="name" value="">
  <input name="txtSignupLastName" type="text" placeholder="last name" value="">
  <input name="txtSignupEmail" type="text" placeholder="email" value="">
  <input name="txtSignupCpr" type="text" placeholder="cpr" value="">
  <input name="txtSignupPassword" type="password" placeholder="password" value="">
  <input name="txtSignupConfirmPassword" type="password" placeholder=" confirm password" value="">
  <h2>Account registration</h2>
  <input type="text" name="txtAccountName" placeholder="Account name (eg. 'Alan account')">
    <select name="txtAccountCurrency">
        <option disabled selected>Currency</option>
        <option value="Dkk">DKK</option>
        <option value="Usd">USD</option>
    </select>
  <button>Signup</button>
</form>


<?php 
$sLinkToScript = '<script src="js/signup.js"></script>';
require_once 'bottom.php'; 
?>