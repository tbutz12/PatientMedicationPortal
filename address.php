<?php
require 'databaseConnection.php';
session_start();
$streetNumber = $streetNumberError = $streetName = $streetName = $streetNameError = $city = $cityError = $state = $stateError = $zip = $zipError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["streetNumber"])){
        $streetNumberError = "No street number provided";
    }
    else{
        $streetNumber = $_POST["streetNumber"];
    }
    if(empty($_POST["streetName"])){
        $streetNameError = "No street name provided";
    }
    else{
        $streetName = $_POST["streetName"];
    }
    if(empty($_POST["city"])){
        $cityError = "No city provided";
    }
    else{
        $city = $_POST["city"];
    }
    if(empty($_POST["state"])){
        $stateError = "No state provided";
    }
    else{
        $state = $_POST["state"];
    }
    if(empty($_POST["zip"])){
        $zipError = "No zip provided";
    }
    else{
        $zip = $_POST["zip"];
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
            <p>Street Number: <input type=text name="streetNumber" value="<?php echo $streetNumber; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$streetNumberError</div>"; ?></span></p>
            <p>Street Name: <input type=text name="streetName" value="<?php echo $streetName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$streetNameError</div>"; ?></span></p>
            <p>City: <input type=text name="city" value="<?php echo $city; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$cityError</div>"; ?></span></p>
            <p>State: <input type=text name="state" placeholder = "PA" value="<?php echo $state; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$stateError</div>"; ?></span></p>
            <p>Zip: <input type=text name="zip" value="<?php echo $zip; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$zipError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["streetNumber"]) && !empty($_POST["streetName"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"])){
                    $con = connectDB();
                    $query = "insert into Patient_Location(street_number, street_name, city, state, zip_code, patient_id)
                    values('$streetNumber', '$streetName', '$city', '$state', '$zip', '$patient_id')";
                    if($r1 = mysqli_query($con, $query)){
                        header("Location: homepage.php");
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>