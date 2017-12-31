<?php
    session_start();
    if (isset($_SESSION['currentPageNo'])){
        if ($_SESSION['currentPageNo'] > 1) {
            $_SESSION['currentPageNo'] = $_SESSION['currentPageNo'] -1;
            echo "Changed ".  $_SESSION['currentPageNo'];
        }
    }
    $page =  $_SESSION['redirectPage'];
    echo "the val " . $_SESSION['currentPageNo'];
    header("Location: ' . $page . ");
?>