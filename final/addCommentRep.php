<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();

    
    if (isset($_GET["sid"]) && isset($_GET['addComtocom']) && isset($_GET['coid'])){
        //&& isset($_POST["addComtocom"]) && isset($_POST["comToComText"])
       // $sid =  $_GET["sid"];
        $sid =  $_GET["sid"];
        $coid = $_GET['coid'];
        $currentdate = date("Y-m-d H:i:s");
        $currentUser = $_SESSION['currentUser'];
        $sqlValues = '"' .  $_GET["addComtocom"] . 
                            '","'.$currentdate . '","' .
                            "$coid" . '","'.$currentdate . '","'.
                            $currentUser['U_id'] . '","' . 
                            $sid . '","' .
                            "2" . '","' .
                            "approved" . 
                            '","'.$currentdate.'"' ;
        
        $sqlInsertSub = "INSERT INTO comment (`Co_text`, `Co_date`, `isReplyToCom`, `makeDate`, `U_id`, `S_id`, `M_id`, `approve_status`,`approve_date`)
                     VALUES (".$sqlValues.")";

        $sqlGetId = "SELECT * FROM `comment` 
                    GROUP BY Co_id
                    ORDER BY `comment`.`Co_id` DESC
                    LIMIT 1 ";
        
        $res = $con->query($sqlGetId );
        $res->data_seek(0);
        $resu = $res->fetch_assoc(); 

        $sqlUpdateParent = "UPDATE `comtocom` 
                            SET `add_Com`= ".$resu['Co_id']."
                            WHERE  `add_Com`= 0";
        $con->query( $sqlUpdateParent );

        $sqlValuesInsert = "INSERT INTO comtocom (`belong_Com`)
                            VALUES (".$coid.")";
       
      
                    $con->error;

        if ($con->query($sqlInsertSub) && $con->query($sqlValuesInsert)){
            echo "Topic Added successfully";
              header('Location: subtopic.php?sid='.$sid);
           // header('Location: regular_homePG.php');
        } else {
            echo "could not insert";
            $con->error;
        }
        echo $sqlInsertSub;
    }
   
?>
