<?php
    /******************************************************
    REGISTER PAGE FOR A NEW USER. ALL REGISTER OPERATIONS
    HAPPEN AS A REGULAR USER.
    ******************************************************/
    include_once("constants/loginCred.php");
	//session_start();

	//if ($_GET("signup")){

if(isset($_POST['city']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['username']) &&
    	isset($_POST['password']) && isset($_POST['psw_repeat'])){

    	$username= $_POST['username'];

        $password= $_POST['password'];

        $psw_repeat= $_POST['psw_repeat'];

        $picture = isset($_POST['picture']) ? $_POST['picture'] : "http://bivi.co/sites/default/files/default220.jpg"; 

        $city= $_POST['city'];

        $fullname= $_POST['fullname'];

        $email= $_POST['email'];

        $userPresenceCheck = $con->query("SELECT * FROM user WHERE U_username = '$username' ");
        $userEmailPresenceCheck = $con->query("SELECT * FROM user WHERE U_mail = '$email' ");

        if($userPresenceCheck->num_rows !== 0){
        	echo "<font color=\"red\"> There is a user with the username ". $username."</font>";
        }
        elseif($userEmailPresenceCheck->num_rows !== 0){
        	echo "<font color=\"red\"> There is a user with the email ". $email."</font>";
        }
        elseif($password !== $psw_repeat){
        	echo "<font color=\"red\"> You have enetered wrong password. On each password field you should enter same value.</font>";
        }
        else{
        	$currentdate = date("Y-m-d H:i:s");
			$reg = "U_registration-date";
        	if($con->query("INSERT INTO `user` (`nickname`, `U_username`, `U_mail`, `U_password`, `U_city`, `U_registration-date`, `U_picture`, `U_type`) 
			VALUES ('$fullname', '$username', '$email', '$password', '$city',"."now()".", '$picture', 'regular') ")){
        		echo "You registered succesfully. You will be redirecting to the login page. You can login on that page...";
        		header('Location: index.html');
        	}
        	else{
        		echo "There is an error on the database. COntact with administration. ".$con->error;
        	}
        }
        


		}
   

   // }
?>

<!DOCTYPE html>
<html>
<style>
/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
select{
	width: 50%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn,.signupbtn {
    float: left;
    width: 50%;
}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
</style>
<body>

<h2>Signup Form</h2>

<form action="register.php" method="post" style="border:1px solid #ccc">
  <div class="container">
    <label><b>Full Name</b></label>
    <input type="text" placeholder="Enter Full Name" name="fullname" required>

    <label><b>Nickname</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <label><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw_repeat" required>

    <label><b>Your Picture URL (We only accept if user put the link of the image)</b></label>
    <input type="text" placeholder="Image URL" name="image" >

	<label><b>Registration is accepted only from Turkey</b></label><br>
    <select name="city" required>
	    <option value="0">Select The City</option>
	    <option value="Adana">Adana</option>
	    <option value="Adıyaman">Adıyaman</option>
	    <option value="Afyonkarahisar">Afyonkarahisar</option>
	    <option value="Ağrı">Ağrı</option>
	    <option value="Amasya">Amasya</option>
	    <option value="Ankara">Ankara</option>
	    <option value="Antalya">Antalya</option>
	    <option value="Artvin">Artvin</option>
	    <option value="Aydın">Aydın</option>
	    <option value="Balıkesir">Balıkesir</option>
	    <option value="Bilecik">Bilecik</option>
	    <option value="Bingöl">Bingöl</option>
	    <option value="Bitlis">Bitlis</option>
	    <option value="Bolu">Bolu</option>
	    <option value="Burdur">Burdur</option>
	    <option value="Bursa">Bursa</option>
	    <option value="Çanakkale">Çanakkale</option>
	    <option value="Çankırı">Çankırı</option>
	    <option value="Çorum">Çorum</option>
	    <option value="Denizli">Denizli</option>
	    <option value="Diyarbakır">Diyarbakır</option>
	    <option value="Edirne">Edirne</option>
	    <option value="Elazığ">Elazığ</option>
	    <option value="Erzincan">Erzincan</option>
	    <option value="Erzurum">Erzurum</option>
	    <option value="Eskişehir">Eskişehir</option>
	    <option value="Gaziantep">Gaziantep</option>
	    <option value="Giresun">Giresun</option>
	    <option value="Gümüşhane">Gümüşhane</option>
	    <option value="Hakkâri">Hakkâri</option>
	    <option value="Hatay">Hatay</option>
	    <option value="Isparta">Isparta</option>
	    <option value="Mersin">Mersin</option>
	    <option value="İstanbul">İstanbul</option>
	    <option value="İzmir">İzmir</option>
	    <option value="Kars">Kars</option>
	    <option value="Kastamonu">Kastamonu</option>
	    <option value="Kayseri">Kayseri</option>
	    <option value="Kırklareli">Kırklareli</option>
	    <option value="Kırşehir">Kırşehir</option>
	    <option value="Kocaeli">Kocaeli</option>
	    <option value="Konya">Konya</option>
	    <option value="Kütahya">Kütahya</option>
	    <option value="Malatya">Malatya</option>
	    <option value="Manisa">Manisa</option>
	    <option value="Kahramanmaraş">Kahramanmaraş</option>
	    <option value="Mardin">Mardin</option>
	    <option value="Muğla">Muğla</option>
	    <option value="Muş">Muş</option>
	    <option value="Nevşehir">Nevşehir</option>
	    <option value="Niğde">Niğde</option>
	    <option value="Ordu">Ordu</option>
	    <option value="Rize">Rize</option>
	    <option value="Sakarya">Sakarya</option>
	    <option value="Samsun">Samsun</option>
	    <option value="Siirt">Siirt</option>
	    <option value="Sinop">Sinop</option>
	    <option value="Sivas">Sivas</option>
	    <option value="Tekirdağ">Tekirdağ</option>
	    <option value="Tokat">Tokat</option>
	    <option value="Trabzon">Trabzon</option>
	    <option value="Tunceli">Tunceli</option>
	    <option value="Şanlıurfa">Şanlıurfa</option>
	    <option value="Uşak">Uşak</option>
	    <option value="Van">Van</option>
	    <option value="Yozgat">Yozgat</option>
	    <option value="Zonguldak">Zonguldak</option>
	    <option value="Aksaray">Aksaray</option>
	    <option value="Bayburt">Bayburt</option>
	    <option value="Karaman">Karaman</option>
	    <option value="Kırıkkale">Kırıkkale</option>
	    <option value="Batman">Batman</option>
	    <option value="Şırnak">Şırnak</option>
	    <option value="74">Bartın</option>
	    <option value="Bartın">Ardahan</option>
	    <option value="Iğdır">Iğdır</option>
	    <option value="Yalova">Yalova</option>
	    <option value="Karabük">Karabük</option>
	    <option value="Kilis">Kilis</option>
	    <option value="Osmaniye">Osmaniye</option>
	    <option value="Düzce">Düzce</option>
	</select>
	<br>
    <input style="margin-top: 2%;" type="checkbox" checked="checked"> Remember me
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancel</button>
      <button type="submit" class="signupbtn" name="signup">Sign Up</button>
   </div>
  </div>
</form>

</body>
</html>
