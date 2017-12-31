<?php
    include("styles.php");
    include("constants/loginCred.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());
    session_start();

    $currentCategory = '';
    $catName = '';

    if (isset($_GET["catName"])) {
        
        $lookFor = $_GET["catName"];
        $_SESSION["returnFromAddTopic"] = $_GET['catName'];
        //check which category the user chose
        for ($i = 1; $i <= 10; $i++){
            $catName = 'category'. $i;
            if ($catName == $lookFor) {
                  $currentCategory = $_SESSION[$catName];
                  break;
            }
            // echo "The names : " . $catName . " adf " . $currentCategory["C_id"];
        }
    }

    //display 10 topics with 3 subtopics each
    //echo "<head align='center'>HEADERRR : Category : " . $currentCategory["C_name"] . "<br></head>";
    listHeader();
    //dashBoardDirect();
    categoryHeader();
    chooseTopics($currentCategory, $con, $catName);
    
    function chooseTopics($currentCategory, $con,$catName){

        $cid = $currentCategory["C_id"];
        $top10Topics = $con->query("SELECT * FROM topic NATURAL JOIN includes  GROUP BY C_id HAVING C_id = '$cid'"); 
        $number_of_rows = $top10Topics->num_rows; 
        for ($i = 0; $i < $number_of_rows; $i++){
            $top10Topics->data_seek($i);
            $singleTopic = $top10Topics->fetch_assoc();

            $subtopicsHMTL = chooseSubtopics($singleTopic, $con);
            if ($subtopicsHMTL == "<ul></ul>"){
                $subtopicsHMTL = "";
            }
            $k = $i+1;
            $topicName = 'topic' . $k;
            $_SESSION[$topicName] = $singleTopic;
            categoryListElementComplex($catName,$currentCategory,$topicName,$singleTopic,$subtopicsHMTL,$con);
        } 
    }

    function chooseSubtopics($currentTopic, $con){
      
        $tid = $currentTopic['T_id'];   
        $top3Subtopics = $con->query("SELECT * FROM subtopic WHERE T_id = '$tid' "); /* AND  
                                    (   SELECT COUNT(S_id) AS coutner
                                        FROM subtopic 
                                        WHERE 1 ) coutner < 3 ");*/
        $number_of_rows = $top3Subtopics->num_rows;
        $result ="<ul>";

        for ($j = 0; $j < $number_of_rows; $j++){
            $top3Subtopics->data_seek($j);
            $singleSubTopic = $top3Subtopics->fetch_assoc();

           // echo "The subtopic: " . $singleSubTopic["S_name"];
            $k = $j+1;        
            $subTName = 'subtopic' . $k;
            
            $_SESSION[$subTName] = $singleSubTopic;
            $result = $result . '<li><a href = "subtopic.php?subtopic='.$subTName.'">'. $singleSubTopic["S_name"].'</a></li>';
           

            /***********************************************************************
            This should be on a function so that it can be reused frequently through different files. To be done later.$_COOKIE
            ************************************************************************/
           /* for ($i = 1; $i <= 10; $i++){
                $catName = 'subtopic'. $i;
                if ($catName != $subTName) {
                    unset($_SESSION[$catName]);
                }
            }*/
        }
        $result = $result . "</ul>";
        return $result;
    }
?>

