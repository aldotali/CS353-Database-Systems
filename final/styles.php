<head><style type="text/css" id="night-mode-pro-style"></style><link type="text/css" rel="stylesheet" id="night-mode-pro-link"><!--<![endif]--><!-- Mirrored from www.similaricons.com/demos/helper/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 19 Nov 2017 07:42:14 GMT --><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Basic -->
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Site Metas -->
    <title>Database Forum</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="http://localhost:7777/assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="http://localhost:7777/assets/images/apple-touch-icon.png">
    
    <!-- Material Design fonts -->
    <link href="./htmlFiles/index_files/css" rel="stylesheet">
    <link rel="stylesheet" href="./htmlFiles/index_files/icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./htmlFiles/index_files/bootstrap.css">
    <link rel="stylesheet" href="./htmlFiles/index_files/bootstrap-material-design.css">
    <link rel="stylesheet" href="./htmlFiles/index_files/ripples.min.css">
    <link rel="stylesheet" href="./htmlFiles/index_files/font-awesome.min.css">
    
    <!-- Site CSS -->
    <link rel="stylesheet" href="./htmlFiles/index_files/style.css">
    <!-- Colors CSS -->
    <link rel="stylesheet" href="./htmlFiles/index_files/colors.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<?php
function outputSearchBar($currentUser){
    echo '
    <body class="" data-gr-c-s-loaded="true" align="center">

        <div id="wrapper">
        <h1> Welcome '.$currentUser["nickname"] .'</h1>
        <div class="page-title text-center">
            <div class="submit-button">
                    '.dashBoardDirect().'
                </div>
        </div>
        <section class="section lb">
        <div class="container">
            <div class="row">
                <div class="col-md-13">
                    <div class="widget nopadding clearfix">
                        <div class="panel panel-primary nopadding">
                            <div class="panel-heading">
                                <h3 class="panel-title">Fast Explore</h3>
                            </div>
                            <div class="panel-body">
                            <form class="site-search" action="searchPage.php" method="post" accept-charset="utf-8" id="form1">
                                <div class="form-group label-floating is-empty">
                                    <label for="focusedInput2">Use me how you like!</label>
                                    <input class="form-control" id="focusedInput2" type="text" name="focusedInput2">
                                </div>
                                <div class="form-group clearfix"> <!-- inline style is just to demo custom css to put checkbox below input above -->
                                <div class="checkbox pull-left">
                                    <label>
                                        <input type="checkbox" name="category"><span class="checkbox-material"><span class="check"></span></span> &nbsp;Category
                                    </label>
                                    <label>
                                        <input type="checkbox" name="topic"><span class="checkbox-material"><span class="check"></span></span> &nbsp;Topic
                                    </label><label>
                                        <input type="checkbox" name="subtopic"><span class="checkbox-material"><span class="check"></span></span> &nbsp;Subtopic    
                                    </label><label>
                                        <input type="checkbox" name="user"><span class="checkbox-material"><span class="check"></span></span> &nbsp;User   
                                    </label>
                                </div>

                                <!-- UPDATED ZONE START-->
                                <script>

                                    $(\'input:checkbox\').on(\'change\', function() {
                                        $(\'input:checkbox\').not(this).prop(\'checked\', false);  
                                    });

                                </script>
                                <!-- UPDATED ZONE END -->
                                <div class="submit-button pull-right">
                                    <button type="submit" form="form1" value="Submit" class="btn btn-raised btn-info gr" ><i class="material-icons"></i> Search</button>
                                </div>
                            </div>
                        </form><!-- end well -->
                    </div>
                </div>
            </div>
    ';
}
function outputSearchBarInRange($currentUser){
       echo '
    <form action="searchPage.php" method="post">
        <div class="form-group is-empty"><input type="text" name="range1" class="form-control" placeholder="Follow Range low"></div>
        <div class="form-group is-empty"><input type="text" name="range2" class="form-control" placeholder="Follow Range up"></div>
        <input type="submit" value="Search" class="btn btn-raised btn-info gr">
    </form> 
    ';
}




function outputNavigationTab(){
        echo '
        <div class="home-tab clearfix">
            <ul class="nav nav-tabs">
                <li class="active"><a href="regular_homePG.php">Categories</a></li>
                <li><a href="latestTopics.php">Latest Topics</a></li>
                <li><a href="trendingTopics.php">Trending Topics</a></li>
                <li><a href="top_users.php">Top Users</a></li>
                <li><a href="newsfeed.php">Newsfeed</a></li>
            </ul>';
}
function outputCategoriesPage($currentPage, $con) {
    listHeader();

    $rangeup = ($currentPage-1) * 10 + 9;
    $rangedown = $rangeup - 9;
    $top10Categories = $con->query("SELECT * 
                                    FROM `category`AS c1 
                                    WHERE (
                                    SELECT COUNT(c2.date) AS counter
                                    FROM category AS c2
                                    WHERE c1.date >= c2.date ) <= '$rangeup' AND 
                                    (SELECT COUNT(c2.date)
                                    FROM category AS c2
                                    WHERE c1.date >= c2.date ) >= '$rangedown';");

    $number_of_rows = $top10Categories->num_rows;

    $_SESSION['displayCount'] = $number_of_rows;

    for ($i = 0; $i < $number_of_rows; $i++){
        $top10Categories->data_seek($i);
        $singleCategory = $top10Categories->fetch_assoc();
        $p = $i+1;
        $catName = "category" . $p;
        $_SESSION[$catName] = $singleCategory;
        categoryListElementSimple($singleCategory, $catName);
    } 
        
}
function outputPageNumbers($currentPage,$redirectPage){
        echo '
            <div class="panel panel-default">
                <article class="well btn-group-sm clearfix">
                                <ul class="pagination">
                                    <li><a href="decrementPagination.php">«</a></li>
                                    <li class="active"><a href='.$redirectPage.'>' . $currentPage . '</a></li>
                                    <li><a href="incrementPagination.php">' . ($currentPage+1) . '</a></li>
                                    <li><a href="incrementPagination.php">»</a></li>
                                </ul>
                            </article>
                        </div><!-- end panel -->
                    </div><!-- end panel-group -->
                </aside><!-- end topic-list -->
            </div>
  
                            </div><!-- end tab-content -->
                        </div><!-- end home-tab -->
                    </div>    
                </div><!-- end row -->
            </div><!-- end container -->
            </section>  
            </div>
        </body>';
}
function outputTopUsers($currentPage, $con){
    listHeader();

    /***************************************************************
    CHECK IF WE NEED TO ADD A CONDITION : s2.U_id<>$session[user]["id"]
    SO THAT WE DO NOT GET OURSELVES (THE LOGGED IN USER AS A RESULT)
    **************************************************************/
    $sqlTopUser = "SELECT *
                    FROM user NATURAL JOIN countfollowers
                    WHERE U_id in (
                    SELECT S1.U_id
                    FROM countfollowers AS S1
                    WHERE (SELECT COUNT(S2.U_id) 
                    FROM countfollowers AS S2
                    WHERE S2.counter > S1.counter) <= 9 )";

    $top10Users = $con->query($sqlTopUser);
    $number_of_rows = $top10Users->num_rows; 
    $_SESSION['displayCount'] = $number_of_rows;

    for ($i = 0; $i < $number_of_rows; $i++){
        $top10Users->data_seek($i);
        $singleUser = $top10Users->fetch_assoc();
        $k = $singleUser['U_id'];
        userListElement($singleUser, $k);
    } 
}
function outputLatestTopics($currentPage, $con) {
   listHeader();

    $rangeup = ($currentPage-1) * 10 + 9;
    $rangedown = $rangeup - 9;

    $sqllatestTopics = "SELECT * 
                    FROM `topic`AS c1 
                    WHERE (                                    
                    SELECT COUNT(c2.T_createDate) AS counter
                    FROM topic AS c2
                    WHERE c1.T_createDate <= c2.T_createDate ) <= $rangeup AND 
                    (SELECT COUNT(c2.T_createDate) AS counter
                    FROM topic AS c2
                    WHERE c1.T_createDate <= c2.T_createDate) >= '$rangedown' AND c1.approveStatus = 'approved' 
                    GROUP BY T_id
                    ORDER BY T_createDate DESC";
 
    $latestTopics = $con->query($sqllatestTopics);
    $number_of_rows = $latestTopics->num_rows;

    $_SESSION['displayCount'] = $number_of_rows;

    for ($i = 0; $i < $number_of_rows; $i++){
        $latestTopics->data_seek($i);
        $singleTopic = $latestTopics->fetch_assoc();
        $p = $i+1;
        $topicName = "topic" . $p;
        $_SESSION[$topicName] = $singleTopic;
        topicListElement($singleTopic,$topicName,$con);
    }


}
function outputTrendingTopics($currentPage, $con){
    listHeader();

    $rangeup = ($currentPage-1) * 10 + 9;
    $rangedown = $rangeup - 9;

    $sqltrendingTopics = "SELECT * 
                    FROM `topic`AS c1 
                    WHERE ( SELECT COUNT(S_id) as Scounter
                    FROM subtopic AS c2
                    WHERE c2.T_id = c1.T_id ) <= $rangeup AND c1.approveStatus = 'approved'  AND
                    ( SELECT COUNT(S_id) as Scounter
                    FROM subtopic AS c2
                    WHERE c2.T_id = c1.T_id ) >= $rangedown" ;
 
    $trendingTopics = $con->query($sqltrendingTopics);
    $number_of_rows = $trendingTopics->num_rows;

    $_SESSION['displayCount'] = $number_of_rows;

    for ($i = 0; $i < $number_of_rows; $i++){
        $trendingTopics->data_seek($i);
        $singleTopic = $trendingTopics->fetch_assoc();
        $p = $i+1;
        $topicName = "topic" . $p;
        $_SESSION[$topicName] = $singleTopic;
        topicListElement($singleTopic,$topicName,$con);
    }
}
function outputNewsfeedTopics($currentPage,$con){
    listHeader();
    $currentUserID = $_SESSION['currentUser']['U_id'];
    $sql = "CALL `getTop10NewsFeed`(".$currentUserID.");";
          $rest = $con->query($sql);
    $i = 1;
    while($row = mysqli_fetch_array($rest))
    {
       // echo $row[0];
        $uid = $row[0];
        $nickname = $row[1];
        $username = $row[2];
        $mail = $row[3];
        $passw = $row[4];

        $city = $row[5];
        $Uregistration_date = $row[6];
        $picture = $row[7];
        $type = $row[8];
        $tid = $row[9];
        $tname = $row[10];

        $tidcreate = $row[11];
        $tidDesc = $row[12];
        $Ticon = $row[13];
        $approveSt = $row[14];
        $applroveDate = $row[15];
        $mid = $row[16];
        $crId = $row[17];
        $topiNAme = "topic" . $i; 
        $i = $i +1;
        outputNF($topiNAme, $tname,$tidcreate,$approveSt,$tidDesc, $nickname,$uid,$con);

    }

}

function outputNF($topicName, $tname,$tidcreate,$approveSt,$tidDesc, $nickname,$uid,$con){
     echo '
    <article class="well clearfix">
        <div class="topic-desc row-fluid clearfix">
            <div class="col-sm-4">
                <img src="htmlFiles/image.jpg" alt="" class="img-responsive img-thumbnail">
            </div>
            <div class="col-sm-8">
                <h4><a href="topic.php?topic='.$topicName.'" title="">'. $tname .'</a></h4>
                <div class="blog-meta clearfix">
                    <small>'.$tidcreate.'</small>
                    <small>Status: '. $approveSt. '</small> 
                    <small>by <a href=user_profile.php?uid='. $uid .'>'.$nickname . '</a></small>
                </div>
                <p>'.$tidDesc.'</p>
                <a href="topic.php?topic='.$topicName.'" class="readmore" title="">Continue reading →</a>
            </div>
        </div>
        <!-- end tpic-desc -->
        <!-- end topic -->
            <footer class="topic-footer clearfix">
                <div class="pull-left">
                    <ul class="list-inline tags">
                     
         </ul>
                    <!-- end tags -->
                </div>
            </footer>
            </article>';
}

function outputSearchResults($con){
    $sqlQuery="";
    $noResult = false;
    /***************************************
    NEED TO ADD NOT BANEEDD. EXCLUDE THEM FROM QUERY
    approveStatus = 'approved' AND
    ******************************************/
    
    if (isset($_POST["user"])){
        $sqlQuery = $sqlQuery . "SELECT * FROM `user` WHERE nickname LIKE '%" . $_POST['focusedInput2'] . "%' OR 
                                U_username LIKE '%" . $_POST['focusedInput2'] . "%'";
        $queryRes = $con->query($sqlQuery);
        $number_of_rows = $queryRes->num_rows;

        $noResult = ( $number_of_rows == 0);
        for ($i = 0; $i < $number_of_rows; $i++){
            $queryRes->data_seek($i);
            $singleRes = $queryRes->fetch_assoc();
            $p = $i+1;
            $catName = "user" . $p;
            $_SESSION[$catName] = $singleRes;
            userListElement($singleRes, $singleRes["U_id"]);
        } 
        //echo "This is the user ". $_POST["user"];
    } else if (isset($_POST["topic"])){
        $sqlQuery = $sqlQuery . "SELECT * FROM `topic` WHERE  T_name 
                                LIKE '%" . $_POST['focusedInput2'] . "%' ";

        $queryRes = $con->query($sqlQuery);
        $number_of_rows = $queryRes->num_rows;

        $noResult = ( $number_of_rows == 0);
        for ($i = 0; $i < $number_of_rows; $i++){
            $queryRes->data_seek($i);
            $singleRes = $queryRes->fetch_assoc();
            $p = $i+1;
            $catName = "topic" . $p;
            $_SESSION[$catName] = $singleRes;
            topicListElement($singleRes, $catName,$con);
        } 
        //echo "This is topic ". $_POST["topic"];
    } else if (isset($_POST["subtopic"])){
        $sqlQuery = $sqlQuery . "SELECT * FROM `subtopic` WHERE S_name LIKE '%" . $_POST['focusedInput2'] . "%'";

        $queryRes = $con->query($sqlQuery);
        $number_of_rows = $queryRes->num_rows;

        $noResult = ( $number_of_rows == 0);
        for ($i = 0; $i < $number_of_rows; $i++){
            $queryRes->data_seek($i);
            $singleRes = $queryRes->fetch_assoc();
            $p = $i+1;
            $catName = "subtopic" . $p;
            $_SESSION[$catName] = $singleRes;
            outputSubTopicListElement($singleRes, $catName,$con);
        } 
        //echo "This is the subtopic ". $_POST["subtopic"];
    } else if (isset($_POST["category"])){
        $sqlQuery = $sqlQuery . "SELECT * FROM `category` WHERE C_name LIKE '%" . $_POST['focusedInput2'] . "%'";
 
        $queryRes = $con->query($sqlQuery);
        $number_of_rows = $queryRes->num_rows;

        $noResult = ( $number_of_rows == 0);
        for ($i = 0; $i < $number_of_rows; $i++){
            $queryRes->data_seek($i);
            $singleRes = $queryRes->fetch_assoc();
            $p = $i+1;
            $catName = "category" . $p;
            $_SESSION[$catName] = $singleRes;
            categoryListElementSimple($singleRes, $catName);
        } 
        
        //echo "This is category ". $_POST["category"];
    } else {
        echo "No checking was done. Please tell us what to look for mate :P ";
    }
    if ($noResult) {
        echo "We could not find anything Sorry";
    }
}

function listHeader(){
    echo '                    
    <div class="tab-content">
        <div id="knowledge_tab" class="tab-pane fade in active">
            <aside class="topic-list">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
}
function userListElement($singleUser, $k){
    echo '
        
    <div class="panel panel-default">
    <article class="well btn-group-sm clearfix">
    <div class="panel-heading" role="tab" id="headingOne">
    <div class="panel-title">
        <a role="button"  href="user_profile.php?uid='. $k . '" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
            <header class="topic-title clearfix">
    <h3 class="pull-left">' . $singleUser['nickname'] . '</h3>
    <br>
    <small class="pull-left"> Registration Date : ' . $singleUser["U_registration-date"] . '</small>
    <small class="pull-left"> User Type : ' . $singleUser["U_type"] . '</small>
    </header>
    </a>
    </div>
    </div>
        </article><!-- end article well -->
    </div>
    ';
}
function categoryListElementSimple($singleCategory, $catName){
    echo '
        <div class="panel panel-default">
        <article class="well btn-group-sm clearfix">
        <div class="panel-heading" role="tab" id="headingOne">
        <div class="panel-title">
            <a role="button"  href="category.php?catName='.$catName . '" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                <header class="topic-title clearfix">
        <h3>' . $singleCategory["C_name"] . '</h3>
        <br>
        <small> Create Date : ' . $singleCategory["date"] . '</small>
        </header>
        </a>
        </div>
        </div>
            </article>
        </div>
        ';
}
function  categoryListElementComplex($catName,$currentCategory,$topicName,$singleTopic,$subtopicsHMTL,$con){
    $sqltopicOwner = "SELECT nickname
                    FROM user NATURAL JOIN topic
                    WHERE U_id = create_id AND T_id = '$singleTopic[T_id]'";

    $topicOwner = $con->query($sqltopicOwner);
    $topicOwner->data_seek(0);
    $singleOwner = $topicOwner->fetch_assoc();
    echo '
    <article class="well clearfix">
    <div class="topic-desc row-fluid clearfix">
        <div class="col-sm-4">
            <img src="htmlFiles/image.jpg" alt="" class="img-responsive img-thumbnail">
        </div>
        <div class="col-sm-8">
            <h4><a href="topic.php?topic='.$topicName.'" title="">'. $singleTopic["T_name"] .'</a></h4>
            <div class="blog-meta clearfix">
                <small>'.$singleTopic["T_createDate"].'</small>
                <small>in <a href="category.php?catName='.$catName.'">'.$currentCategory["C_name"].'</a></small>
                <small>by <a href=user_profile.php?uid='.$singleTopic["create_id"].'>'.$singleOwner["nickname"].'</a></small>
            </div>
            <p>'.$subtopicsHMTL . '<br>' .$singleTopic["T_description"].'</p>
            <a href="topic.php?topic='.$topicName.'" class="readmore" title="">Continue reading →</a>
        </div>
    </div>
    </article>';
}

function topicListElement($singleTopic,$topicName,$con){
    $sqlUnderCategory = "SELECT *
                        FROM category
                        WHERE C_id IN
                        (SELECT C_id  
                        FROM category NATURAL JOIN includes
                        WHERE T_id = '$singleTopic[T_id]')";
    $masterCategory = $con->query($sqlUnderCategory);
    $masterCategory->data_seek(0);
    $masterCat = $masterCategory->fetch_assoc();
    $_SESSION["category1"] = $masterCat;

    $sqlTopicCreator = "SELECT nickname
                        FROM user
                        where U_id = '$singleTopic[create_id]'";
    
    $topicCreator = $con->query($sqlTopicCreator);
    $topicCreator->data_seek(0);
    $userNickame = $topicCreator->fetch_assoc();

    $sqlSubtopicCount = "SELECT COUNT(S_id) as Scounter
                         FROM subtopic
                         WHERE  T_id = '$singleTopic[T_id]'";

    $subTopicCount =  $con->query($sqlSubtopicCount);
    $subTopicCount->data_seek(0);
    $subTcount = $subTopicCount->fetch_assoc();
    $countSubTMessage = $subTcount["Scounter"]. " Subtopics";
    if ($subTcount["Scounter"] == 0){
        $countSubTMessage = "No Subtopics yet! Be the first to add one !";
    }

    echo '
    <article class="well clearfix">
                    <div class="topic-desc row-fluid clearfix">
                        <div class="col-sm-4">
                            <img src="htmlFiles/image.jpg" alt="" class="img-responsive img-thumbnail">
                        </div>
                        <div class="col-sm-8">
                            <h4><a href="topic.php?topic='.$topicName.'" title="">'. $singleTopic["T_name"] .'</a></h4>
                            <div class="blog-meta clearfix">
                                <small>'.$singleTopic["T_createDate"].'</small>
                                <small>'. $countSubTMessage. '</small>
                                <small>in <a href="category.php?catName=category1">'.$masterCat["C_name"].'</a></small>
                                <small>by <a href=user_profile.php?uid='.$singleTopic["create_id"].'>'.$userNickame["nickname"].'</a></small>
                            </div>
                            <p>'.$singleTopic["T_description"].'</p>
                            <a href="topic.php?topic='.$topicName.'" class="readmore" title="">Continue reading →</a>
                        </div>
                    </div>
                    <!-- end tpic-desc -->
                    <!-- end topic -->
            <footer class="topic-footer clearfix">
                <div class="pull-left">
                    <ul class="list-inline tags">
                        <li><a href="category.php?catName=category1">'.$masterCat["C_name"].'</a></li>';
        for ($i = 1; $i< $masterCategory->num_rows; $i++){
            $masterCategory->data_seek($i);
            $masterCat = $masterCategory->fetch_assoc();
            $p = $i+1;
            $catName = "category" . $p;
            $_SESSION[$catName] = $masterCat;
            echo '<li><a href="category.php?catName='.$catName.'">'.$masterCat["C_name"].'</a></li>';
        }
        echo ' </ul>
                    <!-- end tags -->
                </div>
            </footer>
            </article>';
}


function outputSubTopicListElement($singleSubTopic, $subTName,$con){
     $sqlTopicCreator = "SELECT nickname
                        FROM user
                        where U_id = '$singleSubTopic[U_id]'";
    
    $topicCreator = $con->query($sqlTopicCreator);
    $topicCreator->data_seek(0);
    $userNickame = $topicCreator->fetch_assoc();
    echo '
        <div class="panel panel-default">
        <article class="well btn-group-sm clearfix">
        <div class="panel-heading" role="tab" id="headingOne">
        <div class="panel-title">
            <a role="button"  href="subtopic.php?subtopic='.$subTName . '" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                <header class="topic-title clearfix">
        <h3>' . $singleSubTopic["S_name"] . '</h3>
        <br>
        <small> Create Date : ' . $singleSubTopic["createDate"] . '</small>
        <small> A subtopic by : ' . $userNickame["nickname"] . '</small>
        </header>
        </a>
        </div>
        </div>
        </article>
        </div>
        ';
}
function outputTopicDesc($singleTopic){
   
     echo '
    <body class="" data-gr-c-s-loaded="true" align="center">
    <div id="wrapper">
    <section class="section lb">
    <div class="container">
    <div class="row">
    <div class="col-md-10">
    <div class="widget nopadding clearfix">
    <div class="panel panel-primary nopadding">
        <div class="panel-heading">
            <h1 class="panel-title">'.$singleTopic["T_name"].'</h1>
        </div>
        <div class="panel-body">
            <h3>'.$singleTopic["T_description"].'</h3>
                <div class="form-group clearfix"> <!-- inline style is just to demo custom css to put checkbox below input above -->
                    <div class="submit-button">
                        <a class="btn btn-raised btn-info gr" href="addSubtopic.php?topic=' . $_GET["topic"]. '"> Add Subtopic</a>
                    </div>
                </div>
        </div>
    </div>
    </div><!-- end widget -->
    ';
}


function outputSubTopicDesc($singleSubTopic){
    //echo $singleSubTopic["S_name"];
     echo '
    <body class="" data-gr-c-s-loaded="true" align="center">
    <div id="wrapper">
    <section class="section lb">
    <div class="container">
    <div class="row">
    <div class="col-md-11">
    <div class="widget nopadding clearfix">
    <div class="panel panel-primary nopadding">
        <div class="panel-heading">
            <h1 class="panel-title">'.$singleSubTopic["S_name"].'</h1>
        </div>
        <div class="panel-body">
            <h3>'.$singleSubTopic["S_description"].'</h3>
                <div class="form-group clearfix"> <!-- inline style is just to demo custom css to put checkbox below input above -->
                    <div class="submit-button">
                        <a class="btn btn-raised btn-info gr" href="addComment.php?sid='.$singleSubTopic["S_id"].'"> Add Comment</a>
                    </div>
                </div>
        </div>
    </div>
    </div><!-- end widget -->
    ';
}


function outputComments($singleComment, $con,$reply){
    echo '<script>function updateValue(val, event) {
    document.getElementById("coid").value = val;
    event.preventDefault();
    }</script>';
    echo '<script>function addLink(val, event){
    var anchor = document.getElementById("comtoComText").innerHTML;
    document.getElementById("comtoComText").innerHTML = "Reply to the: <b>" + val + "</b>";
    anchor = val;
    event.preventDefault();
  }</script>';
    echo '<script> function AllInOne(name, event,text,ref){
        updateValue(name, event);
        addLink(text, event);
        window.location.href="#"+ref;
    }
    </script>';
    $likes= $con->query("SELECT count(U_id) AS counterL FROM likecomment WHERE Co_id = '$singleComment[Co_id]' AND voteType = 1");
    $likes->data_seek(0);
    $singleLikes = $likes->fetch_assoc(); 
    $reports= $con->query("SELECT count(U_id) AS counterR FROM reportcomment WHERE Co_id = '$singleComment[Co_id]'");
    $reports->data_seek(0);
    $singleReport = $reports->fetch_assoc(); 
    $dislikes= $con->query("SELECT count(U_id) AS counterL FROM likecomment WHERE Co_id = '$singleComment[Co_id]' AND voteType = -1");
    $dislikes->data_seek(0);
    $singledisLikes = $dislikes->fetch_assoc(); 


    $creator= $con->query("SELECT * FROM user WHERE U_id = '$singleComment[U_id]'");
    $creator->data_seek(0);
    $singleCreator = $creator->fetch_assoc(); 
    $utype = "";
    $deleteCommentHtml = "";
    if ( $singleCreator["U_type"] == "admin" || $singleCreator["U_type"] == "moderator" ) {
        $utype = "site_staff";  
    }else {
        $utype = "verified";
    }
    if ($_SESSION['currentUser']["U_id"] == $singleComment["U_id"] && $_SESSION['currentUser']["U_type"] == "regular" ){
        $deleteCommentHtml = '  <div class="pull-right">
              <div class="submit-button">
                        <a class="btn btn-raised btn-info gr" href="deleteComment.php?coid='.$singleComment["Co_id"].'"> Delete Comment</a>
                        <a class="btn btn-raised btn-info gr" href="reportComment.php?coid='.$singleComment["Co_id"].'"> Report Comment</a>
                    </div>
            </div>';
    } else if ($_SESSION['currentUser']["U_type"] != "regular"){
         $deleteCommentHtml = '  <div class="pull-right">
              <div class="submit-button">
                        <a class="btn btn-raised btn-info gr" href="deleteComment.php?coid='.$singleComment["Co_id"].'"> Delete Comment</a>
                        <a class="btn btn-raised btn-info gr" href="reportComment.php?coid='.$singleComment["Co_id"].'"> Report Comment</a>
                    </div>
            </div>';
    } else {
         $deleteCommentHtml = '  <div class="pull-right">
              <div class="submit-button">
                        <a class="btn btn-raised btn-info gr" href="reportComment.php?coid='.$singleComment["Co_id"].'"> Report Comment</a>
                    </div>
            </div>';
    }
    echo '

        <article class="well btn-group-sm clearfix">
        <div class="topic-desc row-fluid clearfix">
            <div class="col-sm-2 text-center publisher-wrap">
                <img src="htmlFiles/image.jpg" alt="" class="avatar img-circle img-responsive">
                <a href = "user_profile.php?uid=' . $singleCreator["U_id"] . '">' .$singleCreator["nickname"] . '</a>
            </div>
            <div class="col-sm-10">
                <header class="topic-footer clearfix">
                    <ul class="list-inline tags">
                        <li class="'. $utype . '""><a href="#">' . $singleCreator["U_type"] . ' User</a></li>
                    </ul>
                </header>
                <!-- end topic -->
              
                <div class="blog-meta clearfix">
                    <small><a href="#">' .$singleLikes["counterL"].' Likes</a></small>
                    <small><a href="#">' .$singledisLikes["counterL"].' DisLikes</a></small>
                    <small><a href="#">' .$singleReport["counterR"].' Reports</a></small>
                    <small>'.$singleComment["Co_date"].'</small>
                </div>
                <p>'. $singleComment["Co_text"]. '</p>
            </div>
           <div class="topic-meta clearfix">
           <a href="#" class="readmore" title="" name="'.$singleComment["Co_id"].'" onclick="AllInOne(this.name, event,\''.$singleComment["Co_text"].'\', \'reply\');">Reply →</a>
        <div class="pull-left">
            <a class="btn btn-default btn-fab btn-fab-mini" href="likeComment.php?coid='.$singleComment["Co_id"].'" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Like">
                <i class="material-icons">thumb_up</i>
            </a>
            <a class="btn btn-default btn-fab btn-fab-mini" href="dislikeComment.php?coid='.$singleComment["Co_id"].'" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Un Like">
                <i class="material-icons">thumb_down</i>
            </a>
        </div> ' . $deleteCommentHtml . '    
        </div>
            
        </div><!-- end tpic-desc --> '.$reply.'
        </div>
        </article>
    ';
}

function outputCommentHeader(){
 echo'   <section class="section lb">
    <div class="container">
    <div class="row">
    <div class="col-md-10">
    <aside class="topic-page topic-list blog-list forum-list single-forum">';
}
function outputCommentFooter(){
    echo '
     
        </aside>
        </div><!-- end col -->
        </div><!-- end row -->
        <ul class="pager" class="col-md-10">
            <li><a class="withripple""><i class="material-icons">chevron_left</i></a></li>
            <li><a class="withripple""><i class="material-icons">chevron_right</i></a></li>
        </ul>
        </div><!-- end container -->
        </section>
    ';
}

function outputAddCommentSection($coid,$sid){
 $result =   '<div id="reply" class="forum-answer topic-desc clearfix">
        <div class="row">
            <div class="col-sm-2 text-center publisher-wrap">
                <img src="htmlFiles/image.jpg" alt="" class="avatar img-circle img-responsive">
                <h5>'.$_SESSION["currentUser"]["nickname"].' </h5>
            </div>
            <div class="col-md-10">
                <div class="form-group is-empty">
                    <label for="textArea" class="col-md-2 control-label">Add Comment</label>
                    <div class="col-md-10">
                         <div class="col-md-10" id="comtoComText" style="display:inline-block;
                                    width:500px;
                                    white-space: nowrap;
                                    overflow:hidden !important;
                                    text-overflow: ellipsis;
                        "></div>
                        <form method="get" action="addCommentRep.php">

                            <textarea class="form-control" rows="3" id="addComtocom" name = "addComtocom"></textarea>
                              <input type="hidden" name="sid" value="'.$sid.'">
                              <input type="hidden" name="coid" id="coid" value="'.$coid.'">
                            <button type="submit" class="btn btn-raised btn-info gr">Add Comment</a>
                        </form>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div>';
    return $result;


}



function outputUserProfileHeader($userInstance){
    $welcome="";
    if ($userInstance["U_id"] == $_SESSION["currentUser"]["U_id"]){
        $welcome = "Welcome Back to your Profile " . $_SESSION["currentUser"]["nickname"];
    } else {
        $welcome = "Welcome to the sexy Profile of " . $userInstance["nickname"]; 
    }
    echo '
    <section class="section">
        <div class="container">
            <div class="page-title text-center">
                <h1>'.$welcome.'</h1>
                <ul class="breadcrumb">
                    <li><a href="regular_HomePG.php">Home Page</a></li>
                    <li><a href="logout.php">LogOut?</a></li>
                </ul>
            </div><!-- end title -->
        </div><!-- end container -->
    </section>
    <section class="section lb">
    <div class="container">
    <div class="row">
    <div class="col-md-10 col-md-offset-1">
    <aside class="topic-page topic-list blog-list forum-list single-forum">';
}


function outputUserProfile($singleCreator,$con){
    $utype = "";
    if ( $singleCreator["U_type"] == "admin" || $singleCreator["U_type"] == "moderator" ) {
        $utype = "site_staff";  
    }else {
        $utype = "verified";
    }
    $follow="";
    if ($singleCreator["U_id"] == $_SESSION["currentUser"]["U_id"]){
    } else {
         $follow = '<div class="submit-button text-center">
            <a class="btn btn-raised btn-info gr" href="followUser.php?uid='.$singleCreator["U_id"] .'"> Follow User</a>
        </div>';
    }
    $l = is_null(likeCount($singleCreator,$con)) ? "None" : likeCount($singleCreator,$con);
    $f = is_null(followerCount($singleCreator,$con)) ? "None" : followerCount($singleCreator,$con);
    $c = is_null(commentCount($singleCreator,$con)) ? "None" : commentCount($singleCreator,$con);
    $r = is_null(reportCount($singleCreator,$con)) ? "None" : reportCount($singleCreator,$con); 
    $s = is_null(userStatus($singleCreator,$con)) ? "None" : userStatus($singleCreator,$con);
    $nt = is_null(notApprovedTopic($singleCreator,$con)) ? "None" : notApprovedTopic($singleCreator,$con);
    $nc = is_null(notApprovedComment($singleCreator,$con)) ? "None" : notApprovedComment($singleCreator,$con);
   echo '
    <article class="well btn-group-sm clearfix">
    <div class="topic-desc row-fluid clearfix">
        <div class="col-sm-2 text-center publisher-wrap">
            <img src="'.$singleCreator["U_picture"].'" alt="" class="avatar img-circle img-responsive">
            <h5>'.$singleCreator["nickname"]. '</h5>
        </div>
        <div class="col-sm-10">
            <header class="topic-footer clearfix">
                <ul class="list-inline tags">
                    <li class="'. $utype . '""><a href="#">' . $singleCreator["U_type"] . ' User</a></li>
                </ul>
            </header>
            <!-- end topic -->
            <div class="blog-meta clearfix">
                <small><a href="#">'.$l.' Likes</a></small>
                <small><a href="#">From '.$singleCreator["U_city"].'</a></small>
                <small>Create Date: '.$singleCreator["U_registration-date"].'</small>
            </div>
            <div><br>
                <head>UserStats </head>
                <table border=1 style="width:100%">
                    <tr>
                        <td>Comments Count</td>
                        <td>Followers Count</td>
                        <td>Likes Count</td>
                        <td>Reports Count</td>
                        <td>User Status</td>
                    </tr>
                    <tr>
                        <td>'.$c.'</td>
                        <td>'.$f.'</td>
                        <td>'.$l.'</td>
                        <td>'.$r.'</td>
                        <td>'.$s.'</td>
                    </tr>

                </table><br> 
                
            </div>
            <div><br>
                <head>Not Approval Counts</head>
                <table border=1 style="width:100%">
                    <tr>
                        <td>Not Approved Comment Count</td>
                        <td>Not Approved Topic Count</td>
                    </tr>
                    <tr>
                        <td>'.$nt.'</td>
                        <td>'.$nc.'</td>

                    </tr>

                </table><br> 
                
            </div>
        </div>
    </div>' .$follow . '
        
        </article>
    ';
}



function commentCount($singleCreator,$con){
    $id = $singleCreator['U_id'];
    return mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(Co_id) as cnt, U_id FROM likecomment where U_id='$id' GROUP BY U_id"), MYSQLI_ASSOC)['cnt'];
}

function followerCount($singleCreator,$con){
    $id = $singleCreator['U_id'];

    return mysqli_fetch_array(mysqli_query($con,"SELECT counter FROM countfollowers WHERE U_id = ".$id." GROUP BY  U_id"), MYSQLI_ASSOC)['counter'];
}

function likeCount($singleCreator,$con){
    $id = $singleCreator['U_id'];

    return mysqli_fetch_array(mysqli_query($con,"SELECT Count(Co_id) as cnt,U_id FROM `likecomment` WHERE U_id = '$id' GROUP BY U_id DESC"), MYSQLI_ASSOC)['cnt'];
}

function reportCount($singleCreator,$con){
    $id = $singleCreator['U_id'];

    return mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) as cnt, U_id FROM `reportcomment` WHERE U_id = '$id' GROUP BY U_id DESC"), MYSQLI_ASSOC)['cnt'];
}

function userStatus($singleCreator,$con){
    $id = $singleCreator['U_id'];

    $q =  mysqli_query($con,"SELECT Count(*) as cnt, suspend.reactivationDate as tillDate FROM `suspend` join user WHERE user.U_id = '$id' and user.U_id = suspend.U_id");
    $f = mysqli_fetch_array($q, MYSQLI_ASSOC);
    if(mysqli_fetch_array(mysqli_query($con,"SELECT count(*) as cnt FROM `ban` join user WHERE user.U_id = '$id' and user.U_id = ban.U_id LIMIT 1"), MYSQLI_ASSOC)['cnt'] >= 1){
        return "Banned User (permanently)";
    }
    elseif($f['cnt'] >= 1){
        return "Suspended User (till ".$f['tillDate']. " )";
    }
    
    else{
        return "Verified User";
    }
}

function notApprovedTopic($singleCreator,$con){
    $id = $singleCreator['U_id'];
    $q = mysqli_query($con,"SELECT count(*) as cnt FROM `topic` join user WHERE  user.U_id = '$id' and user.U_id = topic.create_id and topic.approveStatus = 0");
    $f = mysqli_fetch_array($q, MYSQLI_ASSOC);
    return $f['cnt'];
}

function notApprovedComment($singleCreator,$con){
    $id = $singleCreator['U_id'];
    $q = mysqli_query($con,"SELECT count(*) as cnt FROM `comment` join user WHERE  user.U_id = '$id' and user.U_id = comment.U_id and comment.approve_status = 0");
    $f = mysqli_fetch_array($q, MYSQLI_ASSOC);
    return $f['cnt'];
}



function categoryHeader(){
  echo '  <br><br><div class="container">
            <div class="page-title text-center">
                <ul class="breadcrumb">
                    <li><a href="regular_HomePG.php">Home Page</a></li>
                    <li><a href="logout.php">LogOut?</a></li>
                </ul>
                <div class="submit-button">
                        <a class="btn btn-raised btn-info gr" href="addTopic.php"> Add Topic</a>'.dashBoardDirect().'
                    </div>
            </div><!-- end title -->
        </div><!-- end container -->
    </section>
    <section class="section lb">
    <div class="container">
    <div class="row">
    <div class="col-md-10 col-md-offset-1">
    ';
}

function dashBoardDirect(){

    $redirect = "";//'href="admin/"> Go To DashBoard</a>';
    if ($_SESSION["currentUser"]["U_type"]=="moderator"){
        $redirect = '<a class="btn btn-raised btn-info gr" href="moderator/"> Go To DashBoard</a>';
    } else if ($_SESSION["currentUser"]["U_type"]=="admin"){
        $redirect = '<a class="btn btn-raised btn-info gr" href="admin/"> Go To DashBoard</a>';
    } else {
        $redirect = "";
    }
    return $redirect;
}
?>
