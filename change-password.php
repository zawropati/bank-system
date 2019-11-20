<?php 
session_start();
require_once 'top.php'; ?>


<form  method="POST" action="apis/api-change-password.php" id="frmChangePass">
<h1>Change password</h1>
  <input type="password" name="txtOldPass" placeholder="Old pass">
  <input type="password" name="txtNewPass" placeholder="New Pass">
  <input type="password" name="txtConfirmNewPass" placeholder="Confirm new pass">
  <button>Change Password</button>
</form>
  


<?php 
$sLinkToScript = '<script src="js/change-password.js"></script>';
require_once 'bottom.php'; 
?>