<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();

    $sid =  $_GET["sid"];
    if (isset($_GET["sid"])&& isset($_POST["cotext"])){
        //echo $_GET["sid"];
        $sid =  $_GET["sid"];
        $currentdate = 'now()' ;//date("Y-m-d H:i:s");
        $currentUser = $_SESSION['currentUser'];
        $sqlValues = '"' .  $_POST["cotext"] . 
                            '",'.$currentdate . ',"' .
                            "NO" . '",'.$currentdate . ',"'.
                            $currentUser['U_id'] . '","' . 
                            $sid . '","' .
                            "2" . '","' .
                            "approved" . 
                            '",'.$currentdate ;
        
        $sqlInsertSub = "INSERT INTO `comment`(`Co_text`, `Co_date`, `isReplyToCom`, `makeDate`, `U_id`, `S_id`, `M_id`, `approve_status`,`approve_date`)
                     VALUES (".$sqlValues.")";

        if ($con->query($sqlInsertSub) == TRUE ){
            echo "Topic Added successfully";
              header('Location: subtopic.php?sid='.$sid);
           // header('Location: regular_homePG.php');
        } else {
            echo "could not insert";
        }
        echo $sqlInsertSub;
    }
   

    addCommentHTML($sid);
    function addCommentHTML($sid){
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
                <form class="sidebar-login" method="post" action="addComment.php?sid='.$sid.'">
                    <div  class="form-group is-empty"><input type="text" name = "cotitle" class="form-control" placeholder="Comment Title"></div>
                    <div class="form-group is-empty"><input type="text" name = "cotext" class="form-control" placeholder="Comment Text"></div>
                    <input type="submit" value = "Add the comment" <button type="button" class="btn btn-raised btn-info gr"></button>
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
