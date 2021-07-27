<?php
require 'databaseConnection.php';
session_start();
$date = $dateError =  $testName = $testNameError = $testDescription = $testDescriptionError = $siteCollected = $siteCollectedError = $result = $resultError = "";
if(isset($_SESSION['firstName']) && !empty($_SESSION['firstName'])){
    $firstName = $_SESSION['firstName'];
    echo "<h1>$firstName's Medical Records</h1>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["date"])){
        $dateError = "No date provided";
    }
    else{
        $date = $_POST["date"];
    }
    if(empty($_POST["testName"])){
        $testNameError = "No test name provided";
    }
    else{
        $testName = $_POST["testName"];
    }
    if(empty($_POST["testDescription"])){
        $testDescriptionError = "No test description provided";
    }
    else{
        $testDescription = $_POST["testDescription"];
    }
    if(empty($_POST["siteCollected"])){
        $siteCollectedError = "No site collected provided";
    }
    else{
        $siteCollected = $_POST["siteCollected"];
    }
    if(empty($_POST["result"])){
        $resultError = "No result provided";
    }
    else{
        $result = $_POST["result"];
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
            <p>Date: <input type=text name="date" placeholder = "0000-00-00 00:00:00-00:00" value="<?php echo $date; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$dateError</div>"; ?></span></p>
            <p>Test Name: <input type=text name="testName" placeholder = "X-ray" value="<?php echo $testName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$testNameError</div>"; ?></span></p>
            <p>Test Description: <input type=text name="testDescription" value="<?php echo $testDescription; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$testDescriptionError</div>"; ?></span></p>
            <p>Site Collected: <input type=text name="siteCollected" placeholder = "Kidney" value="<?php echo $siteCollected; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$siteCollectedError</div>"; ?></span></p>
            <p>Result: <input type=text name="result" placeholder = "Benine" value="<?php echo $result; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$resultError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["date"]) && !empty($_POST["testName"]) && !empty($_POST["testDescription"]) && !empty($_POST["siteCollected"]) && !empty($_POST["result"])){
                    $con = connectDB();
                    $query = "insert into Pathology(date, testName, testDescription, siteCollected, result, patient_pathology, patient_visit_pathology)
                    values('$date', '$testName', '$testDescription', '$siteCollected', '$result', '$patient_id', '$visit_id')";
                    if($r1 = mysqli_query($con, $query)){
                        header('Location: imagedetails.php?patient_id=' . $patient_id . '&visit_id=' . $visit_id);
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>