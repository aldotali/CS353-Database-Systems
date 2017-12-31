
<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();
   
    $currentSubTopic= '';
    if (isset($_GET['subtopic'])) {
       $currentSubTopic = $_SESSION[$_GET['subtopic']];
       //echo "Here " . $currentSubTopic['S_name'];echo "Here " . $currentSubTopic['S_description'];
       $_SESSION["returnFromAddComment"] = $_GET['subtopic'];
    }else {
        if (isset($_GET['sid'])) {
        //echo "Here " . $_GET['sid'];
        $currentSubTopic = "SELECT* FROM subtopic WHERE S_id =".$_GET['sid'];
        // echo $currentSubTopic;
        $currentSubTopic = $con->query($currentSubTopic);
        $currentSubTopic->data_seek(0);
        $currentSubTopic = $currentSubTopic->fetch_assoc(); 
       
        }
    }
    categoryHeader();
   // categoryHeader();
    outputSubTopicDesc($currentSubTopic);
    //listHeader(); 
    //outputComments();
    $sid = $currentSubTopic['S_id'];  
    ///echo $sid;
    //$_SESSION["returnFromAddComment"] = $_GET['subtopic'];
    //$_SESSION[$_GET['subtopic']] = $currentSubTopic;

    $allComments= $con->query("SELECT * FROM comment WHERE S_id = '$sid'");
    $number_of_rows = $allComments->num_rows;
    $reply = "";
    for ($j = 0; $j < $number_of_rows; $j++){
        $allComments->data_seek($j);
        $singleComment = $allComments->fetch_assoc();  
        $k = $j+1;      
        $subTName = 'subtopic' . $k;
        $_SESSION[$subTName] = $singleComment;
        //listHeader();
        
        if ($j == ($number_of_rows-1)){
            $reply = outputAddCommentSection($singleComment['Co_id'],$sid);
        }
        outputCommentHeader();
        outputComments($singleComment,$con, $reply);
       // outputSubTopicListElement($singleSubTopic, $subTName,$con);
    }
       outputCommentFooter();
    
/*
    //check which subtopic the user chose
    for ($i = 1; $i <= 10; $i++){
        $subtopicName = 'subtopic'. $i;
        if (isset($_POST[$subtopicName])) {
            $currentSubTopic = $_SESSION[$subtopicName];
            //echo "What we found : " . $subtopicName . " " . $currentSubTopic;
            break;
        }
    }

    echo "<head>This is the subtopic : " . $currentSubTopic["S_name"] . "</head>";
    /*****************************
    NOTE THIS VERSION IS UNSTABLE REPLY TO SUBTOPIC WITH A COMMENT. THIS IS TO BE IMPLEMENTED TOMORROW!
    ***********************************/
   /* $sid = $currentSubTopic['S_id'];   
    $subtopicWithUser = $con->query("SELECT * FROM subtopics NATURAL JOIN createSubtopic NATURAL JOIN user WHERE S_id = '$sid'");
    $number_of_rows = $subtopicWithUser->num_rows;
    
    //$subtopicWithComment = $con->query("SELECT * FROM subtopics NATURAL JOIN hasComment NATURAL JOIN comment WHERE S_id = '$sid'");
    
    //this should be only 1 time loop at any time ideally
    for ($j = 0; $j < $number_of_rows; $j++){
        $subtopicWithUser->data_seek($j);
        $singleSubTopic = $subtopicWithUser->fetch_assoc();

        echo "The subtopic: " . $singleSubTopic["S_name"] . " With description : "  . $singleSubTopic["S_description"] . "<br>" ;
        echo "The creator of this subtopic was : " . $singleSubTopic["U_name"] . " and  he is a " . $singleSubTopic["U_type"] . " user" . "<br>";       
    }*/
?>