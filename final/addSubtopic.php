<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();
    $topic = $_GET["topic"];
    if (isset($_GET["topic"])&& isset($_POST["sname"])){
        //echo $_GET["topic"];
        $topic = $_SESSION[$_GET["topic"]];
        $currentdate = 'now()';//date("Y-m-d");
        $currentUser = $_SESSION['currentUser'];
        $sqlValues = '"' .  $_POST["sname"] . '","' .
                            $_POST["sdesc"] . '","' .
                            $_POST["sicon"] . '","' .
                            $topic["T_id"]  . '",' .
                            $currentdate . ',"' . 
                            $currentUser['U_id'] .'"';
        
        $sqlInsertSub = "INSERT INTO `subtopic`(`S_name`, `S_description`, `S_icon`, `T_id`, `createDate`, `U_id`)
                     VALUES (".$sqlValues.")";
    
        if ($con->query($sqlInsertSub) == TRUE ){
            echo "Topic Added successfully";
            echo $currentdate;
            header('Location: topic.php?topic='.$_SESSION["returnFromAddSubtopic"]);
            //catName='.$_SESSION["returnFromAddTopic"]
           //s header('Location: regular_homePG.php');
        } else {
            echo "could not insert";
        }
        echo $sqlInsertSub;
    }
   

    addSubTopicHTML( $topic );
    function addSubTopicHTML( $topic ){
        echo '
        <div id="wrapper">
        <section class="section lb">
        <div class="container">
        <!-- end row --> 

        <hr class="invis">

        <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="widget">
        <div class="custom-module">
        <h4 class="module-title"><i class="material-icons">mail</i> Fill these details for your topic</h4>

        <div class="panel panel-primary">
            <div class="panel-body">
                <form class="sidebar-login" method="post" action="addSubtopic.php?topic='. $topic  . '">
                    <div  class="form-group is-empty"><input type="text" name = "sname" class="form-control" placeholder="Subtopic Name"></div>
                    <div class="form-group is-empty"><input type="text" name = "sdesc" class="form-control" placeholder="Subtopic description"></div>
                    <div class="form-group is-empty"><input type="text" name = "sicon" class="form-control" placeholder="Subtopic icon"></div>
                    <input type="submit" value = "Add the subtopic" <button type="button" class="btn btn-raised btn-info gr"></button>
                </form> 
            </div>
        </div>
        </div><!-- end custom-module -->
        </div><!-- end widget -->
        </div>
        </div><!-- end row -->
        </div><!-- end container -->
        </section><!-- end section -->
        </div>
        ';
    }
?>
