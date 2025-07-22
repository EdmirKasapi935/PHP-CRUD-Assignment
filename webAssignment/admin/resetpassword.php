<?php
session_start();


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
<body style="background-image: url('adminpgstyles/editcar-bg.jpg'); background-size: cover;"></body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<!-- if something wrong happens with the css login form, we have this to go back to

<form action="adminlogin.php" method="post">

<input type="text" name="adminusername">
<input type="password" name="adminpassword">
<input type="submit" name="submission" value="login">
</form>

-->


<div style="text-align: center" >
<font color="lightgray">
<h1 class="display-1">RESET PASSWORD<h1></h1>
</font>
</div>




<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card px-5 py-4" id="form1" style="height: 400px">
            <form action="resetpassword.php" method="post">
                <div class="forms-inputs mb-4"> <span>Enter your username</span> <input autocomplete="off" type="text" name="registerusername" v-model="email" v-bind:class="{'form-control':true, 'is-invalid' : !validEmail(email) && emailBlured}" v-on:blur="emailBlured = true">
                </div>
                <div class="forms-inputs mb-4"> <span>Enter your new password below</span> <input autocomplete="off" type="password" name="registerpassword" v-model="password" v-bind:class="{'form-control':true, 'is-invalid' : !validPassword(password) && passwordBlured}" v-on:blur="passwordBlured = true">
                </div>
                <div class="forms-inputs mb-4"> <span>Confirm new Password</span> <input autocomplete="off" type="password" name="confirmpassword" v-model="password" v-bind:class="{'form-control':true, 'is-invalid' : !validPassword(password) && passwordBlured}" v-on:blur="passwordBlured = true">
                </div>
                <div class="mb-3"> <input type="submit" name="resetsubmission" class="btn btn-dark w-100" value = "Confirm"> </div>
                </form>
                <div class="mb-3"> <a href="index.php"> <button class="btn btn-dark w-100"> Cancel </button> </a> </div>

            </div>
        </div>
    </div>
</div>



</body>
</html>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resetsubmission"]))
{
    $reg_username = filter_input(INPUT_POST, "registerusername", FILTER_SANITIZE_SPECIAL_CHARS);
    $new_password = filter_input(INPUT_POST, "registerpassword", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_newpassword = filter_input(INPUT_POST, "confirmpassword", FILTER_SANITIZE_SPECIAL_CHARS);


    if(empty($reg_username) || empty($new_password) || empty($confirm_newpassword))
    {
        echo '<script> alert(" Please fill out all the fields!") </script>';
    }
    elseif($new_password != $confirm_newpassword)
    {
        echo '<script> alert(" The password entered does not match the confirmation!") </script>';
    }
    else
    {
        $salt = "aspiofajpsfoansmcpvaspvav";
        $tohash = $new_password.$salt;
        $hash = md5($tohash);
       
        resetPassword($conn, $reg_username, $hash);
        

        
    }
    

}

?>