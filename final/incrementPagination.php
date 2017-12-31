<?php
    session_start();
    if (isset($_SESSION['displayCount'])){
        if (isset($_SESSION['currentPageNo'])){
            if ($_SESSION['displayCount'] >= 9){
                $_SESSION['currentPageNo'] = $_SESSION['currentPageNo'] + 1;
                    echo "Changed ".  $_SESSION['currentPageNo'];
            }
        }
    }
    echo "the val " . $_SESSION['currentPageNo'];
    header('Location: regular_homePG.php');
?>