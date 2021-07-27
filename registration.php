<?php
require 'databaseConnection.php';
session_start();
$firstName = $lastName = $firstNameError = $lastNameError = $sex = $sexError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["firstName"])){
        $firstNameError = "No first name provided";
    }
    else{
        $firstName = $_POST["firstName"];
    }
    if(empty($_POST["lastName"])){
        $lastNameError = "No last name provided";
    }
    else{
        $lastName = $_POST["lastName"];
    }
    if(empty($_POST["sex"])){
        $sexError = "No sex provided";
    }
    else{
        $sex = $_POST["sex"];
    }
}

?>
<!doctype html>
<style>
    <?php 
         include 'styles.css'; 
    ?>
</style>
<h1>Patient Registration!</h1>
<a href = "login.php">Click here to go back to patient search!</a>
		<form action="" method="post">
			<br>
            <br>
            <p>First Name: <input type=text name="firstName" value="<?php echo $firstName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$firstNameError</div>"; ?></span></p>
            <p>Last Name: <input type=text name="lastName" value="<?php echo $lastName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$lastNameError</div>"; ?></span></p>
            <p>Sex: <input type=text name="sex" placeholder = "M or F" value="<?php echo $sex; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$sexError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["firstName"]) && !empty($_POST["lastName"])){
                    $con = connectDB();
                    $uuid = uniqid();
                    $firstName = mysqli_real_escape_string($con, $firstName);
                    $lastName = mysqli_real_escape_string($con, $lastName);
                    $query1 = "insert into Patient(patient_id, patient_first_name, patient_last_name, sex)
                    values('$uuid', '$firstName', '$lastName', '$sex')";
                    if($result = mysqli_query($con, $query1)){
                        header('Location: login.php');
                    }
                    else{
                        echo "Error: " . $query1 . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>