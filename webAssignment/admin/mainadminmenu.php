<?php  
session_start();

if(!isset($_SESSION["username"]))
{
    header("LOCATION: index.php");
}



require_once("DBconnection.php");


$carsql= "SELECT * FROM vehicles";
$carresult = mysqli_query($conn,$carsql);

$per_cpage = 8;
$total_cresults = mysqli_num_rows($carresult);
$num_cpages = ceil($total_cresults / $per_cpage);


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
    <title>Epoka Car rental-Admin-Main menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="adminpgstyles/sbuttons.css">
    <link rel="stylesheet" href="adminpgstyles/adminmenulayout.css">
 
</head>
<body style="background-image: url('adminpgstyles/adminmenu2-bg.jpg');">
<div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



<di class="flex-child">

<div style="text-align:center">

<h1>Cars table</h1>

</div>  


<div>
<?php

$carsql2 = "SELECT * FROM vehicles ORDER BY vehicleID DESC LIMIT $cstart,$per_cpage";
$carresult2 = mysqli_query($conn,$carsql2);

echo "<table class='table table-dark'>";
echo  "<tr><th>Vehicle ID</th><th>License Plate</th><th>Brand</th><th>Model</th><th>Category</th><th>Price</th></tr>";
while($crow=mysqli_fetch_array($carresult2))
{
  echo "<tr>";
  echo "<td>".$crow["vehicleID"]."</td>";
  echo "<td>".$crow["licenseplate"]."</td>";
  echo "<td>".$crow["brand"]."</td>";
  echo "<td>".$crow["model"]."</td>";
  echo "<td>".$crow["category"]."</td>";
  //echo "<td>".$crow["seats"]."</td>";
  //echo "<td>".$crow["transmission"]."</td>";
  echo "<td>".$crow["price"]."</td>";
  echo "</tr>";
}
echo "</table>";

?>
</div>

<div style="text-align:center">
<?php 
for($i = 1 ; $i <= $num_cpages; $i++)
{
  echo "<a href=mainadminmenu.php?carpage=$i><button type='button' class='btn btn-sky'>$i</button></a>";
}
?>
</div>
 




<form action="logout.php" method="post">
<div style="position:absolute; bottom:0; left:0; z-index:10;">

<input hidden type="text" name="tokenval" value=<?php  echo $_SESSION['token'];   ?>> 
<input type="submit" name="logoutReq" class="btn btn-hot" value = "LOG OUT">

</div>
</form>

<div style="position:absolute; bottom:0; left:85px; z-index:10;">
<div>
<a href="inspectcars.php?carpage=1"> <button class="btn btn-fresh"> INSPECT </button></a>
</div> 
</div> 



</body>
</html>

