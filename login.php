<?php
require 'databaseConnection.php';
session_start();
$firstName = $lastName = $firstNameError = $lastNameError = "";
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
}

?>
<!doctype html>
<style>
    <?php 
         include 'styles.css'; 
    ?>
</style>
<h1>Patient Search!</h1>
    <a href = "registration.php">Click here to register a new patient!</a>
    <br>
    <br>
		<form action="" method="post">
			<br>
            <br>
            <p>First Name: <input type=text name="firstName" value="<?php echo $firstName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$firstNameError</div>"; ?></span></p>
            <p>Last Name: <input type=text name="lastName" value="<?php echo $lastName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$lastNameError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["firstName"]) && !empty($_POST["lastName"])){
                    $query1 = "select * from Patient where patient_first_name = '$firstName'
                    and patient_last_name = '$lastName'";
                    $con = connectDB();
                    if($r1 = mysqli_query($con, $query1)){
                        $r1 = mysqli_fetch_array($r1);
                        $checkFirstName = strval($r1["patient_first_name"]);
                        $checkLastName = strval($r1["patient_last_name"]);
                        if((strcmp($checkFirstName, $firstName) == 0) && (strcmp($checkLastName, $lastName) == 0)){
                            $r1 = mysqli_fetch_array($r1);
                            $_SESSION["firstName"] = $firstName;
                            header('Location: homepage.php');
                        }
                        else{
                            ?>
                            <script>
                                alert("Invalid name!");
                                window.location.href = "login.php";
                            </script>
        <?php
                        }
                    }
                    else{
                        echo "Error: " . $query1 . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>