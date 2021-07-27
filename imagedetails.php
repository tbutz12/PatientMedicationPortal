<?php
require 'databaseConnection.php';
session_start();
?>
<a href="homepage.php">Click here to return to homepage!</a>
<!doctype html>
<style>
    <?php 
         include 'styles.css'; 
    ?>
</style>
<br>
<br>
<?php
    $connect = connectDB();
    if (isset($_GET['patient_id'])) {
        $patient_id = $_GET['patient_id'];
    }
    if (isset($_GET['visit_id'])) {
        $visit_id = $_GET['visit_id'];
    }
?>
            <form action="" method="post"
            enctype="multipart/form-data">
            <br>
            <p>Scan Type: <input type=text name="scan" value="<?php echo $scan; ?>">
            <label for="file">Filename:</label>
            <input type="file" name="file" id="file"><br>
            <br>
            <input type="submit" name="submit" value="Submit">
            <br>
            </form>
			<br>
            <a href="homepage.php">Click here to return to skip image upload!</a>
        <?php
            // File upload path
            if (isset($_POST['submit'])) {
                $allowedExts = array("jpg", "jpeg", "gif", "png", "pjpeg");
                $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                if ((($_FILES["file"]["type"] == "image/gif")
                  || ($_FILES["file"]["type"] == "image/jpeg")
                  || ($_FILES["file"]["type"] == "image/jpg")
                  || ($_FILES["file"]["type"] == "image/png")
                  || ($_FILES["file"]["type"] == "image/pjpeg"))
                  && ($_FILES["file"]["size"] < 100000)
                  && in_array ($extension, $allowedExts))
                {
                    if ($_FILES["file"]["error"] > 0){
                            echo "Its type is " . $_FILES["file"]["type"];
                        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                        }
                    else{
                        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                        echo "Type: " . $_FILES["file"]["type"] . "<br>";
                        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
                            if (file_exists("upload/" . $_FILES["file"]["name"])){
                                echo $_FILES["file"]["name"] . " already exists. ";
                                }
                            else{
                                move_uploaded_file($_FILES["file"]["tmp_name"],
                                "upload/" . $_FILES["file"]["name"]);
                                echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
                            }
                        }
                } else {
                    echo "Invalid file";
                }
                $image = addslashes(file_get_contents($_FILES['file']['tmp_name']));
                // Upload file to server
                    $con = connectDB();
                    $scan = $_POST["scan"];
                    $sql = "insert into Imaging (scan, image, patient_imaging, patient_visit_imaging) 
                    values('$scan', '$image', '$patient_id', '$visit_id')";
                    if (mysqli_query($con, $sql)) {
                        echo "File uploaded successfully";
                        header('Location: visit.php?patient_id=' . $patient_id . '&name=' . $firstName);
                    }
                    else {
                        echo "Failed to upload file.";
                        header('Location: visit.php?patient_id=' . $patient_id . '&name=' . $firstName);
                    }
                }
        ?>