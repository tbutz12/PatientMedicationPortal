<?php
require 'databaseConnection.php';
session_start();
$date = $doctorName = $reasonForVisit = $dateError = $doctorNameError = $reasonForVisitError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["date"])){
        $dateError = "No date provided";
    }
    else{
        $date = $_POST["date"];
    }
    if(empty($_POST["doctorName"])){
        $doctorNameError = "No doctor name provided";
    }
    else{
        $doctorName = $_POST["doctorName"];
    }
    if(empty($_POST["reasonForVisit"])){
        $reasonForVisitError = "No reason for visit provided";
    }
    else{
        $reasonForVisit = $_POST["reasonForVisit"];
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
            <p>Date: <input type=text name="date" placeholder = "0000-00-00 00:00:00-00:00" value="<?php echo $date; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$dateError</div>"; ?></span></p>
            <p>Doctor Name: <input type=text name="doctorName" value="<?php echo $doctorName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$doctorNameError</div>"; ?></span></p>
            <p>Reason For Visit: <input type=text name="reasonForVisit" value="<?php echo $reasonForVisit; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$reasonForVisitError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["date"]) && !empty($_POST["doctorName"]) && !empty($_POST["reasonForVisit"])){
                    $con = connectDB();
                    $visit_id = uniqid();
                    $query = "insert into Visit(visit_id)
                    values('$visit_id')";
                    if($r1 = mysqli_query($con, $query)){
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                    $query1 = "insert into Patient_Visit(visit_id, patient_id, date, doctorName, reasonForVisit)
                    values('$visit_id', '$patient_id', '$date', '$doctorName', '$reasonForVisit')";
                    if($result = mysqli_query($con, $query1)){
                        header('Location: dxdetails.php?patient_id=' . $patient_id . '&visit_id=' . $visit_id);
                    }
                    else{
                        echo "Error: " . $query1 . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>