<?php
require 'databaseConnection.php';
session_start();
$bodyWeight = $bodyWeightError =  $height = $heightError = $bloodPressure = $bloodPressureError = $bloodType = $bloodTypeError = $bodyTemp = $bodyTempError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["bodyWeight"])){
        $bodyWeightError = "No bodyweight provided";
    }
    else{
        $bodyWeight = $_POST["bodyWeight"];
    }
    if(empty($_POST["height"])){
        $heightError = "No height provided";
    }
    else{
        $height = $_POST["height"];
    }
    if(empty($_POST["bloodPressure"])){
        $bloodPressureError = "No blood pressure provided";
    }
    else{
        $bloodPressure = $_POST["bloodPressure"];
    }
    if(empty($_POST["bloodType"])){
        $bloodTypeError = "No blood type provided";
    }
    else{
        $bloodType = $_POST["bloodType"];
    }
    if(empty($_POST["bodyTemp"])){
        $bodyTempError = "No body temperature provided";
    }
    else{
        $bodyTemp = $_POST["bodyTemp"];
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
            <p>Body Weight: <input type=text placeholder = "000.00" name="bodyWeight" value="<?php echo $bodyWeight; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$bodyWeightError</div>"; ?></span></p>
            <p>Height: <input type=text name="height" placeholder = "Inches" value="<?php echo $height; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$heightError</div>"; ?></span></p>
            <p>Blood Pressure: <input type=text name="bloodPressure" placeholder = "000.00" value="<?php echo $bloodPressure; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$bloodPressureError</div>"; ?></span></p>
            <p>Blood Type: <input type=text name="bloodType" placeholder = "A+" value="<?php echo $bloodType; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$bloodTypeError</div>"; ?></span></p>
            <p>Body Temperature: <input type=text name="bodyTemp" placeholder = "000.00" value="<?php echo $bodyTemp; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$bodyTempError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["bodyWeight"]) && !empty($_POST["height"]) && !empty($_POST["bloodPressure"]) && !empty($_POST["bloodType"]) && !empty($_POST["bodyTemp"])){
                    $con = connectDB();
                    $query = "insert into Labs(bodyweight, height, bloodPressure, bloodType, bodyTemp, patient_lab, patient_visit_labs)
                    values('$bodyWeight', '$height', '$bloodPressure', '$bloodType', '$bodyTemp', '$patient_id', '$visit_id')";
                    if($r1 = mysqli_query($con, $query)){
                        header('Location: proceduredetails.php?patient_id=' . $patient_id . '&visit_id=' . $visit_id);
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>