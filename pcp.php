<?php
require 'databaseConnection.php';
session_start();
$doctorFirstName = $doctorFirstNameError = $doctorLastName = $doctorLastNameError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["doctorFirstName"])){
        $doctorFirstNameError = "No doctor first name provided";
    }
    else{
        $doctorFirstName = $_POST["doctorFirstName"];
    }
    if(empty($_POST["doctorLastName"])){
        $doctorLastNameError = "No doctor last name provided";
    }
    else{
        $doctorLastName = $_POST["doctorLastName"];
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
?>
    <form action="" method="post">
			<br>
            <br>
            <p>Doctor First Name: <input type=text name="doctorFirstName" value="<?php echo $doctorFirstName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$doctorFirstNameError</div>"; ?></span></p>
            <p>Doctor Last Name: <input type=text name="doctorLastName" value="<?php echo $doctorLastName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$doctorLastNameError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["doctorFirstName"]) && !empty($_POST["doctorLastName"])){
                    $con = connectDB();
                    $query = "insert into Patient_PCP(doctor_first_name, doctor_last_name, patient_id)
                    values('$doctorFirstName', '$doctorLastName', '$patient_id')";
                    if($r1 = mysqli_query($con, $query)){
                        header('Location: homepage.php');
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>