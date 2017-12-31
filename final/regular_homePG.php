<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<?php
    include("styles.php");
    include("constants/loginCred.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());
    session_start();


    $currentUser = $_SESSION['currentUser'];
    $currentPage = 1;
    if (isset($_SESSION['currentPageNo'])) {
         $currentPage = $_SESSION['currentPageNo'];
    } else {
        $_SESSION['currentPageNo'] = $currentPage;
    }

    $redirectPage = 'regular_homePG.php';
    outputSearchBar($currentUser);
    outputSearchBarInRange($currentUser);
    outputNavigationTab();
    outputCategoriesPage($currentPage, $con);
    outputPageNumbers($currentPage,$redirectPage);
?>
