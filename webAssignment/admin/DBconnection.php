<?php



$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "webassignment";

$conn = "";

try {

    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
} catch (mysqli_sql_exception) {

    echo '<script>alert("Error connecting to database")</script>';
    header("index.php");
}




function deleteOrder($todelete, $conn)
{

    $deletion = "DELETE FROM orders WHERE orderID=$todelete";
    mysqli_query($conn, $deletion);
}

function deleteCar($todelete, $conn)
{

    $check = "SELECT * FROM vehicles WHERE vehicleID=$todelete";
    $res = mysqli_query($conn, $check);
    $res2 = mysqli_fetch_array($res);
    $imgtodelete = $res2["imgsrc"];

    unlink($imgtodelete);


    $deletion = "DELETE FROM vehicles WHERE vehicleID=$todelete";
    mysqli_query($conn, $deletion);
}


function uploadFile($file)
{
    if (empty($file)) {
        echo '<script>alert("no file was uploaded - is file_uploads enabled in your php.ini?")</script>';
        return false;
    }

    if ($file["image"]["error"] !== UPLOAD_ERR_OK) {
        switch ($file["image"]["error"]) {
            case UPLOAD_ERR_PARTIAL:
                echo '<script>alert("file only partially uploaded")</script>';
                return false;
                break;
            case UPLOAD_ERR_NO_FILE:
                echo '<script>alert("No file was uploaded")</script>';
                return false;
                break;
            case UPLOAD_ERR_EXTENSION:
                echo '<script>alert("file stopped by a php extension")</script>';
                return false;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo '<script>alert("file exceeds maximum size")</script>';
                return false;
                break;
            case UPLOAD_ERR_INI_SIZE:
                echo '<script>alert("file exceeds maximum size in php.ini")</script>';
                return false;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo '<script>alert("file exceeds maximum size")</script>';
                return false;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                exit("Temporary folder not found");
                echo '<script>alert("Temporary folder not found")</script>';
                return false;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo '<script>alert("failed to write file")</script>';
                return false;
                break;
            default:
                echo '<script>alert("unknown file error")</script>';
                return false;
                break;
        }
    }



    $mime_types = ["image/gif", "image/png", "image/jpeg"];

    if (!in_array($file["image"]["type"], $mime_types)) {
        echo '<script>alert("Invalid file ype entered")</script>';
        return false;
    }

    $pathinfo = pathinfo($file["image"]["name"]);
    $base = $pathinfo["filename"];
    $base = preg_replace("/[^\w-]/", "_", $base);

    $filename = $base . "." . $pathinfo["extension"];

    $destination = __DIR__ . "/uploads/" . $filename;

    $i = 1;

    while (file_exists($destination)) {
        $filename = $base . "($i)." . $pathinfo["extension"];
        $destination = __DIR__ . "/uploads/" . $filename;
        $i++;
    }

    if (!move_uploaded_file($file["image"]["tmp_name"], $destination)) {
        echo '<script>alert("could not upload file")</script>';
        return false;
    }

    $destination = str_replace('\\', "/", $destination);
    return $destination;
}

function addCar($conn, $licencePlate, $name, $brand, $category, $seats, $transmission, $imgSrc, $price)
{

    if ($licencePlate == "" || $name == "" || $brand == "" || $category == "" || $transmission == "" || $imgSrc == "" || $price == 0) {
        echo '<script>alert("Please fill out all the fields properly!")</script>';
        return;
    }

    if (!checkPlate($conn, -1, $licencePlate)) {
        echo '<script>alert("The liecense plate entered is already in use!")</script>';
        return;
    }

    $upload = uploadFile($imgSrc);
    if (!$upload) {
        return;
    }


    $sql = "INSERT vehicles SET licenseplate='$licencePlate', model = '$name', brand = '$brand', category = '$category', seats = $seats, transmission = '$transmission', imgsrc = '$upload', price = $price ";

    if (mysqli_query($conn, $sql)) {
        echo '<script>
          alert("Vehicle inserted successfully!")
          window.location.replace("inspectcars.php?carpage=1");
          </script>';
        //header("LOCATION: inspectcars.php?carpage=1");
    } else {
        unlink($upload);
        echo '<script>alert("Error entering data in database.")</script>';
        return;
    }
}

function editCar($conn, $vehicle_id, $plate_edit, $name_edit, $brand_edit, $category_edit, $seats_edit, $transmission_edit, $price_edit, $image)
{


    if ($plate_edit == "" || $name_edit == "" || $brand_edit == "" || $category_edit == "" || $transmission_edit == "" || $price_edit == 0) {
        echo '<script>
          alert("Please fill out all the fields properly!")
          window.location.replace("editcar.php?editing=' . $vehicle_id . '");
          </script>';
        //header("Location: editcar.php?editing=$vehicle_id");
        return;
    }


    if (!checkPlate($conn, $vehicle_id, $plate_edit)) {
        echo '<script>
          alert("The liecense plate entered is already in use!")
          window.location.replace("editcar.php?editing=' . $vehicle_id . '");
          </script>';
        //header("Location: editcar.php?editing=$vehicle_id");
        return;
    }

    $newimg = "";

    if ($image["image"]["size"] != 0) {

        $newimg = uploadFile($image);
        if (!$newimg) {
            echo '<script>
          window.location.replace("editcar.php?editing=' . $vehicle_id . '");
          </script>';
            return;
        }
    }

    $check = "SELECT imgsrc FROM vehicles WHERE vehicleID=$vehicle_id ";
    $res = mysqli_query($conn, $check);
    $res2 = mysqli_fetch_array($res);
    $imgtodelete = $res2["imgsrc"];


    /*
    $sqli= "UPDATE cars SET imgSrc='$newimg' WHERE vehicleID=$vehicle_id";
    mysqli_query($conn,$sqli);
    */



    $sqln = "UPDATE vehicles SET licenseplate='$plate_edit', model='$name_edit', brand='$brand_edit', category='$category_edit', seats=$seats_edit, transmission='$transmission_edit', price=$price_edit WHERE vehicleID=$vehicle_id";

    if (mysqli_query($conn, $sqln)) {

        if ($image["image"]["size"] != 0) {
            unlink($imgtodelete);
            $sqli = "UPDATE vehicles SET imgSrc='$newimg' WHERE vehicleID=$vehicle_id";
            mysqli_query($conn, $sqli);
        }

        echo '<script>
          alert("Vehicle inserted successfully!")
          window.location.replace("inspectcars.php?carpage=1");
          </script>';
    } else {
        unlink($newimg);
        echo '<script>
          alert("Error updating data in database.")
          window.location.replace("editcar.php?editing=' . $vehicle_id . '");
          </script>';
    }
}




function checkPlate($conn, $id, $vehicle_plate)
{
    $sqlp = "SELECT * FROM vehicles WHERE licenseplate='$vehicle_plate' AND vehicleID!=$id";
    $result = mysqli_query($conn, $sqlp);

    if (mysqli_num_rows($result) != 0) {
        return false;
    } else {
        return true;
    }
}


function registerUser($conn, $username, $password)
{

    $check = "SELECT * FROM users WHERE Username='$username'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) != 0) {
        echo '<script>
        alert("Username is already taken!")
        </script>';
        return;
    }



    $sqlu = "INSERT users SET Username='$username', Password='$password'";

    if (mysqli_query($conn, $sqlu)) {
        echo '<script>
          alert("Registered successfully!")
          window.location.replace("index.php");
          </script>';
    } else {
        echo '<script>
          alert("Error registering in database.")
          </script>';
    }
}

function resetPassword($conn, $username, $password)
{

    $check = "SELECT * FROM users WHERE Username='$username'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) == 0) {
        echo '<script>
        alert("Please Enter a valid Username!")
        </script>';
        return;
    }



    $sqlu = "UPDATE users SET Password='$password' WHERE Username='$username'";

    if (mysqli_query($conn, $sqlu)) {
        echo '<script>
         alert("Password was reset sucessfully!")
         window.location.replace("index.php");
        </script>';
    } else {
        echo '<script>
          alert("Error registering in database.")
          </script>';
    }
}
