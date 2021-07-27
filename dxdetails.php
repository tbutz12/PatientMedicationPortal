<?php
require 'databaseConnection.php';
session_start();
$description = $descriptionError =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["description"])){
        $descriptionError = "No description provided";
    }
    else{
        $description = $_POST["description"];
    }
}
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
    <form action="" method="post">
			<br>
            <br>
            <p>Description: <input type=text name="description" value="<?php echo $description; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$descriptionError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["description"])){
                    $con = connectDB();
                    $query = "insert into Dx(description, patient_dx, patient_visit_dx)
                    values('$description', '$patient_id', '$visit_id')";
                    if($r1 = mysqli_query($con, $query)){
                        header('Location: labdetails.php?patient_id=' . $patient_id . '&visit_id=' . $visit_id);
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>