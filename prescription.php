<?php
require 'databaseConnection.php';
session_start();
$date = $dailyDosage = $dateError = $dailyDosageError = $medName = $medNameError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["medication"])){
        $medNameError = "No dosage provided";
    }
    else{
        $medName = $_POST["medication"];
    }
    if(empty($_POST["date"])){
        $dateError = "No start date provided";
    }
    else{
        $date = $_POST["date"];
    }
    if(empty($_POST["dailyDosage"])){
        $dailyDosageError = "No dosage provided";
    }
    else{
        $dailyDosage = $_POST["dailyDosage"];
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
    if (isset($_GET['patient_id'])) {
        $patient_id = $_GET['patient_id'];
    }
?>
    <form action="" method="post">
			<br>
            <br>
            <label for = "medication">Choose a medication</label>
            <select name = "medication" id = "medication">
                <option value = "Xanax">Xanax</option>
                <option value = "Lipitor">Lipitor</option>
                <option value = "Zoloft">Zoloft</option>
                <option value = "Valium">Valium</option>
            </select>
            <p>Start Date: <input type=text name="date" placeholder = "0000-00-00 00:00:00-00:00" value="<?php echo $date; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$dateError</div>"; ?></span></p>
            <p>Daily Dosage: <input type=text name="dailyDosage" placeholder = "1 per day" value="<?php echo $dailyDosage; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$dailyDosageError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["date"]) && !empty($_POST["dailyDosage"]) && !empty($_POST["medication"])){
                    $con = connectDB();
                    $q1 = "select medication_id from medication where medication_name = '$medName'";
                    if($r1 = mysqli_query($con, $q1)){
                    }
                    else{
                        echo "Error: " . $q1 . "<br>" . mysqli_error($con);
                    }
                    $r1 = mysqli_fetch_array($r1);
                    $medication_id = $r1["medication_id"];
                    $query1 = "insert into Prescription(patient_id, medication_id, prescription_start_date, prescription_daily_dosage)
                    values('$patient_id', '$medication_id', '$date', '$dailyDosage')";
                    if($result = mysqli_query($con, $query1)){
                        header('Location: homepage.php');
                    }
                    else{
                        echo "Error: " . $query1 . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>