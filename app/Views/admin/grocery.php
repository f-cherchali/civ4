<?php 
    if ($output->isJSONResponse) {
        header('Content-Type: application/json; charset=utf-8');
        echo $output;
        exit;
    }else{
        // echo "Une érreur est survenue"; 
        echo $output;
    }
?>