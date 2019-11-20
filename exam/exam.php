<?php

$jPeople = new stdClass();

$jA = new stdClass();
$aId = uniqid();

$jA->name = "a";

$jB = new stdClass();
$bId = uniqid();
$jB->name = "b";

$jPeople->$aId = $jA;
$jPeople->$bId = $jB;


echo json_encode($jPeople);


foreach( $jPeople as $id=>$user ){
    echo $user->name;

}