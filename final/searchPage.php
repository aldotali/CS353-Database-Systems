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
   
    if (isset($_POST['range1'])){
        $query = "SELECT * FROM countfollowers NATURAL JOIN user
                 WHERE countfollowers.counter BETWEEN ".$_POST['range1']." AND ". $_POST['range2'];
        $resu = $con->query($query);
        $number_of_rows = $resu->num_rows;

        $_SESSION['displayCount'] = $number_of_rows;

        for ($i = 0; $i < $number_of_rows; $i++){
            $resu->data_seek($i);
            $singleResu = $resu->fetch_assoc();
            $p = $i+1;
            $catName = "category" . $p;
            $_SESSION[$catName] = $singleResu;
            userListElement($singleResu, $singleResu["U_id"]);
        }
        
    } else {
        if(isset($_POST['focusedInput2'])){
        outputSearchResults($con);
        }
    }
  
    
?>