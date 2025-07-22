<?php

session_start();
if(isset($_SESSION["username"]))
{
    header("LOCATION: mainadminmenu.php?orderpage=1&carpage=1");
}



include("DBconnection.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka Car Rental-Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="adminpgstyles/loginstyle.css">
</head>
<body style="background-image: url('adminpgstyles/adminlogin2-bg.jpg');">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<!-- if something wrong happens with the css login form, we have this to go back to

<form action="adminlogin.php" method="post">

<input type="text" name="adminusername">
<input type="password" name="adminpassword">
<input type="submit" name="submission" value="login">
</form>

-->


<div style="text-align: center" >
<font color="white">

<h1 class="display-1"> CAR INVENTORY DASHBOARD <h1>
<h3 class="display-5"> ONLY ADMIN ACCESS ALLOWED <h3></h3>


</font>



</div>




<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card px-5 py-4" id="form1">
            <form action="index.php" method="post">
                <div class="forms-inputs mb-4"> <span>Username</span> <input autocomplete="off" type="text" name="adminusername" v-model="email" v-bind:class="{'form-control':true, 'is-invalid' : !validEmail(email) && emailBlured}" v-on:blur="emailBlured = true">
                </div>
                <div class="forms-inputs mb-4"> <span>Password</span> <input autocomplete="off" type="password" name="adminpassword" v-model="password" v-bind:class="{'form-control':true, 'is-invalid' : !validPassword(password) && passwordBlured}" v-on:blur="passwordBlured = true">
                </div>
                <div class="mb-3"> <input type="submit" name="submission" class="btn btn-dark w-100" value = "Log In"> </div>
                </form>
                <div class="mb-3"> <a href="signup.php"> <button class="btn btn-dark w-100"> Sign Up </button> </a> </div>

            </div>
        </div>
    </div>
</div>

<div style="text-align: center" >
<font color="white">
<h5> Forgot or want to change Password? <a href="resetpassword.php">Click here</a><h1></h1>
</font>
</div>


</body>
</html>

<?php
if(isset($_POST["submission"]))
{
    $ausername = filter_input(INPUT_POST, "adminusername", FILTER_SANITIZE_SPECIAL_CHARS);
    $apassword = filter_input(INPUT_POST, "adminpassword", FILTER_SANITIZE_SPECIAL_CHARS);
    
    $salt = "aspiofajpsfoansmcpvaspvav";
    $passwordcheck = $apassword.$salt;
    $passwordhash = md5($passwordcheck);

    $sqlcheck = "SELECT * FROM users WHERE Username='$ausername' AND Password='$passwordhash'";
    $result = mysqli_query($conn, $sqlcheck);

    if(mysqli_num_rows($result) != 0)
    {
        //session_start();
        $_SESSION["username"] = $ausername;
        $_SESSION["token"] = uniqid();
        //echo '<script>alert("'.$_SESSION["username"].'")</script>';
       
        header("LOCATION: mainadminmenu.php?carpage=1");
            //header("LOCATION: adminogin.php");
    }
    else
    {
       echo '<script>alert("incorrect username or password")</script>';
    }

}

?>
