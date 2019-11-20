<?php

//TODO: Check if the user is logged
session_start();
$sUserId = $_SESSION['sUserId'];
$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
//TODO: Check if json is valid
$jInnerData = $jData->data;

$jTransactions = $jInnerData->$sUserId->transactions;

echo json_encode($jTransactions);
 


