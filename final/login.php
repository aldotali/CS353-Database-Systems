<?php

    include_once("constants/loginCred.php");

    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    

    if(isset($_SESSION['currentUser'])){
        header('Location: index.html');
    }
    session_start();
    $username='';
    $password='';
    //get the username and pasword from the form
    if (isset($_POST['login_username']) && isset($_POST['login_pass'])){
        $username= $_POST['login_username'];
        $password= $_POST['login_pass'];
        //$username=strtolower($username);
        //$password=strtolower($password);
        //$_SESSION['username'] = $username;
        //$_SESSION['sid'] = $password;

        $userPresenceCheck = $con->query("SELECT * FROM user WHERE U_username = '$username' AND U_password ='$password' "); //where U_username = '$username' AND U_password ='$password'"
        $number_of_rows = $userPresenceCheck->num_rows; 


        if($number_of_rows == 1){
            $userPresenceCheck->data_seek(0);
            $user = $userPresenceCheck->fetch_assoc();
            $_SESSION['currentUser'] = $user;
            $_SESSION['iz'] = "izel";
            echo "$number_of_rows";
            echo "The login was successful. We had missed you "."$username";
            if ($user['U_type'] == "admin"){
                //TO DO: header(admin_homePG.php)
                //echo  " You are an admin boyyyy :)" ;
               header('Location: regular_homePG.php');
            } else if ($user['U_type'] == "moderator"){
                //TO DO: header(moderator_homePG.php)
                //echo " You are a moderator boyyyy :)";
               header('Location: regular_homePG.php');
            } else if ($user['U_type'] == "regular") {
                //TO DO: 
                //header('Location: regular_homePG.php');
                header('Location: regular_homePG.php');
             }   //echo " You are a peasant. Get lost!";
             else {
              //  echo " We can't identify you ://///";
            }
        } else {
            if ("$username" == "" || "$password" == ""){?> 
            <html>
                <div>
                    <!-- THE COMMENT BELOW IS VALID HERE AS WELL -->
                    <head>"The submision fields should not be empty"</head>
                    <form action="../index.php" method="post">
                        <input type="submit" value="OK!"> 
                    </form>
                </div>
            </html> <?php
            }
            else { ?> 
            <html>
                <div>
                <head>The login failed. Probably because the login information was wrong</head>
                    <!-- NOTE THAT V2.0 IS THE FOLDER I HAVE PUT MY FILES IN. WE HAVE TO CHANGE THIS 
                        ON OUR DEMO OR ON OUR FINAL PROJECT!! (IT WILL CRASH THE PAGE IF WE DONT )
                        ALTERNATIVE: USE OF JS TO SHOW A POPUP WINDOW SHOWING THAT WE INSERTED WRONG INFO
                        ON LOGIN. -->
                    <form action="../index.html" method="post">
                        <input type="submit" value="OK!"> 
                    </form>
                </div>
            </html> <?php
            }
        }
    }

?>
    <div>
        <form action="login.php" method="post">
            USERNAME:<input type="text" name="login_username">
            PASSWORD:<input type="text" name="login_pass">
            <input type="submit" value="Login"> 
        </form>
    </div>