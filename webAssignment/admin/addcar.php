<?php

session_start();
if(!isset($_SESSION["username"]))
{
    header("LOCATION: index.php");
}


include("DBconnection.php");



if(isset($_POST["carSubmission"]))
{
    
    $licencePlate = mysqli_real_escape_string($conn,htmlspecialchars($_POST["licencePlate"]));
    $name = mysqli_real_escape_string($conn,htmlspecialchars($_POST["model"]));
    $brand = mysqli_real_escape_string($conn,htmlspecialchars($_POST["brand"]));
    $category = mysqli_real_escape_string($conn,htmlspecialchars($_POST["category"]));
    $seats = $_POST["seats"];
    $transmission = mysqli_real_escape_string($conn,$_POST["transmission"]);
    $image = $_FILES;
    $price = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT);
    $price = intval($price);
    
    //print_r($_FILES);
   
    
    addCar($conn, $licencePlate, $name, $brand, $category, $seats, $transmission, $image, $price);
    

    unset($_POST["carSubmission"]);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminpgstyles/carform.css" media="all">
    <title>Epoka Car Rental-Admin-Cars</title>
</head>
<body style="background-image: url('adminpgstyles/carform5-bg.jpg');">


<!--
    <h2>Add a new car</h2>
    <form action = "addcar.php" method = "post" enctype="multipart/form-data">
    <label>License Plate: </label><input type = "text" name="licencePlate"><br>
    <label>Name: </label><input type = "text" name="name"><br>
    <label>Brand: </label><input type = "text" name="brand"><br>
    <label>Category: </label><input type = "text" name="category"><br>
    <label>Seats: </label><input type = "number" name="seats" min="1" max="100" value="1"><br>
    <label>Transmission: </label><input type = "text" name="transmission"><br>
    <label>Image: </label><input type="file" id="image" name="image"><br>
    <label>Price: </label><input type = "text" name="price" placeholder="please enter a number here"><br>
    <input type = "submit" value="Add Vehicle" name="carSubmission"><br>
     </form>
-->   


     <div class="page-wrapper p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Please fill the form to add a new vehicle</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action = "addcar.php" enctype="multipart/form-data">
                        <div class="form-row m-b-55">
                            <div class="name">Vehicle Name</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="brand">
                                            <label class="label--desc">Brand</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="model">
                                            <label class="label--desc">Model</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row m-b-55">
                            <div class="name">Features</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <br>
                                            <select class="input--style-5" name="transmission" >
                                              <option value="Manual">Manual</option> 
                                              <option value="Automatic">Automatic</option>   
                                            </select> 
                                            <label class="label--desc">Transmission type</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="number" name="seats" min="1" max="100" value="1">
                                            <label class="label--desc">Seating capacity</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="name">Category</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="category">
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-row m-b-55">
                            <div class="name">Reg.Info</div>
                            <div class="value">
                                <div class="row row-refine">
                                    <div class="col-3">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="licencePlate">
                                            <label class="label--desc">License plate</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="file" name="image" id="image">
                                            <label class="label--desc">Image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                        <div class="form-row">
                        <div class="name"></div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="price" placeholder="enter a number here">
                                    <label class="label--desc">Price</label>
                                </div>
                            </div>
                        </div>
                       
                        <div>
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="carSubmission"> Add Vehicle</button>    
                        </div>
             </form>
             <br>
             <div>
             <a href="inspectcars.php?carpage=1"> <button class="btn btn--radius-2 btn--red"> CANCEL </button></a>
             </div>
                </div>
            </div>
        </div>
    </div>

<!--  
<div>
<a href="inspectcars.php?carpage=1"> <button class="btn btn-danger"> CANCEL </button></a>
</div>
--> 
</body>
</html>