<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BANK PATRYCJA</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="css/app.css">
</head>
<body>
  


<?php

if( isset ($_SESSION['sUserId'])){
  echo '  <nav class="navLoggedIn">
  <a><i class="fas fa-piggy-bank"></i></a>


        <a href="profile">Profile</a>
        <a href="loan">Loans</a>
        <a href="user-account">Accounts</a>
        <a href="sign-out.php">Sign out</a>
  ';
  
    $sUserId = $_SESSION['sUserId'];
    $sData = file_get_contents('data/clients.json');
    $jData = json_decode($sData);
    if( $jData == null ){ echo 'System update'; }
    $jInnerData = $jData->data;
    $jClient = $jInnerData->$sUserId;
    $bAdmin = $jClient->admin;

  if ( $bAdmin == 1 ){
    echo '<a href="admin-panel.php"> Admin </a>';
  }
}else{
  echo '  <nav class="navLoggedOut">
  <a><i class="fas fa-piggy-bank"></i></a>


<a href="login">Log in</a>
<a href="signup">Sign up</a>
  ';}
?>
 </nav>