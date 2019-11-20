<?php require_once 'top.php'; ?>


<form id="frmLogin">
    <h1>Login</h1>
    <label for="txtLoginPhone">Phone number</label>
    <input type="text" name="txtLoginPhone" placeholder="phone"  data-validate="yes" data-type="string" 
    data-min="8" data-max="8">
    <label for="txtLoginPassword">Password</label>
  <input type="password" name="txtLoginPassword" placeholder="password" data-validate="yes" data-type="string" 
      data-min="4" data-max="50">
  <button>login</button>
  <a id="forgotPassword">Forgot password</a>
</form>

<form id="frmForgotPassword" action="apis/api-forgot-password" method="POST">
     <h1>Forgot my password</h1>
       <label for="phoneNumber">Phone number</label>
       <input id="userPhoneNumber" placeholder="Phone number" type="text" name="userPhoneNumber"/>
       <label for="userEmail">E-mail address</label>
       <input id="userEmail" placeholder="Email-address" type="text" name="userEmail"/>
     <button>Forgot my password</button>
   </form>

<?php 
$sLinkToScript = '<script src="js/login.js"></script>';
require_once 'bottom.php'; 
?>