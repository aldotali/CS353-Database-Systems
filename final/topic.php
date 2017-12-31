<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();
   
    $currentTopic= '';
    if (isset($_GET['topic'])) {
       $currentTopic = $_SESSION[$_GET['topic']];
       $_SESSION["topic"] = $currentTopic["T_id"];
    }
    //echo "Before : " .$_GET['topic']; 
    $tid = $currentTopic['T_id'];  
    $_SESSION["returnFromAddSubtopic"] = $_GET['topic'];
    $allSubtopics= $con->query("SELECT * FROM subtopic WHERE T_id = '$tid'");
    $number_of_rows = $allSubtopics->num_rows;
    
    categoryHeader();
    outputTopicDesc($currentTopic);
    for ($j = 0; $j < $number_of_rows; $j++){
        $allSubtopics->data_seek($j);
        $singleSubTopic = $allSubtopics->fetch_assoc();  
        $k = $j+1;      
        $subTName = 'subtopic' . $k;
        $_SESSION[$subTName] = $singleSubTopic;
        listHeader();
        outputSubTopicListElement($singleSubTopic, $subTName,$con);
    }
   // echo "Afterrrr : " .$_GET['topic']; 
?>        