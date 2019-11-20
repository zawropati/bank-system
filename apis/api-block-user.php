<?php
if( !isset( $_GET['id'] ) ){
  header('Location: admin-panel.php');
}

//echo $_GET['id'];

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ echo 'System update'; }
$jInnerData = $jData->data;


//echo json_encode($jInnerData);

foreach($jInnerData as $sPhone=>$jUser ){
    if( $sPhone== $_GET['id'] ){
        $jUser->active = !$jUser->active;
        echo json_encode($jUser->active);
        $sData = json_encode($jData, JSON_PRETTY_PRINT);
        file_put_contents('../data/clients.json', $sData);
        // $sData = json_encode($jData);
        header('Location: ../admin-panel.php');
    }
}