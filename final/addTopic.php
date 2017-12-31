<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();


    if (isset($_POST["tname"])){
        $currentdate =  "now()" ;//date('Y-m-d ');
        $currentUser = $_SESSION['currentUser'];
        $sqlValues = '"'.$_POST["tname"].'",'.$currentdate . ',"' .$_POST["tdesc"] . '","' . $_POST['ticon'] . '","' . $currentUser['U_id'] .'"';
        $sqlInsertCat = "INSERT INTO `topic`(`T_name`, `T_createDate`, `T_description`, `T_icon`, `create_id`) 
                        VALUES (".$sqlValues.")";
        
        if ($con->query($sqlInsertCat) == TRUE ){
            echo "Topic Added successfully" . $currentdate;
            header('Location: category.php?catName='.$_SESSION["returnFromAddTopic"]);
        } else {
            echo "could not insert " . $sqlInsertCat;
        }
   // echo $sqlInsertCat;
    }
    addTopicHTML();
    function addTopicHTML(){
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
                <form class="sidebar-login" method="post" action="addTopic.php">
                    <div  class="form-group is-empty"><input type="text" name = "tname" class="form-control" placeholder="Topic Name"></div>
                    <div class="form-group is-empty"><input type="text" name = "tdesc" class="form-control" placeholder="Topic description"></div>
                    <div class="form-group is-empty"><input type="text" name = "ticon" class="form-control" placeholder="Topic icon"></div>
                    <input type="submit" value = "Add the topic" <button type="button" class="btn btn-raised btn-info gr"></button>> 
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
