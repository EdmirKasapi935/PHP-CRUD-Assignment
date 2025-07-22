<?php

session_start();
if(!isset($_SESSION["username"]))
{
    header("LOCATION: index.php");
}



require_once("DBConnection.php");
$carsql= "SELECT * FROM vehicles";
$carresult = mysqli_query($conn,$carsql);

$per_cpage = 8;
$total_cresults = mysqli_num_rows($carresult);
$num_cpages = ceil($total_cresults / $per_cpage);

if(isset($_POST['cardeletion']))
{
  $todelete = $_POST["cartodelete"];
  deleteCar($todelete,$conn);
  unset($_POST['cardeletion']);
  
}

if(isset($_GET["carpage"]) && is_numeric($_GET["carpage"]))
{
   $current_cpage = $_GET["carpage"];

   if($current_cpage > 0 && $current_cpage <= $num_cpages)
   {
      $cstart = ($current_cpage - 1) * $per_cpage;
      $cend = $cstart + $per_cpage;
   }
   else
   {
     $cstart = 0;
     $cend = $per_cpage;
   }
}
else
{
    $cstart = 0;
    $cend = $per_cpage;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka car rental-Admin-Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="adminpgstyles/sbuttons.css">
</head>

<body style="background-image: url('adminpgstyles/carorders-bg.jpg'); ">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



<div>
<?php

$carsql2 = "SELECT * FROM vehicles ORDER BY vehicleID DESC LIMIT $cstart,$per_cpage";
$carresult2 = mysqli_query($conn,$carsql2);

echo "<table class='table table-dark'>";
echo  "<tr><th>Vehicle ID</th><th>License Plate</th><th>Brand</th><th>Model</th><th>Category</th><th>Seats</th><th>Transmission</th><th>Price</th><th>Image</th><th></th><th></th></tr>";
while($crow=mysqli_fetch_array($carresult2))
{
  echo "<tr>";
  echo "<td>".$crow["vehicleID"]."</td>";
  echo "<td>".$crow["licenseplate"]."</td>";
  echo "<td>".$crow["brand"]."</td>";
  echo "<td>".$crow["model"]."</td>";
  echo "<td>".$crow["category"]."</td>";
  echo "<td>".$crow["seats"]."</td>";
  echo "<td>".$crow["transmission"]."</td>";
  echo "<td>".$crow["price"]."</td>";
  echo "<td>".$crow["imgsrc"]."</td>";
  echo '<td><a href="editcar.php?editing='.$crow["vehicleID"].'"><button  class="btn btn-sunny">EDIT</button></a></td>';
  echo '<td><form action="inspectcars.php?carpage='.$current_cpage.'" method="POST"> <input hidden type="text" name="cartodelete" value='.$crow["vehicleID"].'> <input name="cardeletion" type=submit class="btn btn-danger" value="DELETE">  </form></td>';
  echo "</tr>";
}
echo "</table>";


  

?>
</div>

<div style="text-align:center">
<?php 
for($i = 1 ; $i <= $num_cpages; $i++)
{
  echo "<a href=inspectcars.php?carpage=$i><button type='button' class='btn btn-info'>$i</button></a>";
}
?>
</div>

<div style="position:absolute; bottom:0; left:0; z-index:10;">
<a href="mainadminmenu.php?carpage=1"> <button class="btn btn-fresh"> MAIN MENU </button></a>
<a href="addcar.php"> <button class="btn btn-sunny"> ADD A NEW VEHICLE </button></a>
</div> 

</body>
</html>