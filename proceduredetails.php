<?php
require 'databaseConnection.php';
session_start();
$surgicalHistory = $surgicalHistoryError =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["surgicalHistory"])){
        $surgicalHistoryError = "No surgical history provided";
    }
    else{
        $surgicalHistory = $_POST["surgicalHistory"];
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
            <p>Surgical History: <input type=text name="surgicalHistory" value="<?php echo $surgicalHistory; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$surgicalHistoryError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["surgicalHistory"])){
                    $con = connectDB();
                    $query = "insert into Procedures(surgicalHistory, patient_procedures, patient_visit_procedures)
                    values('$surgicalHistory', '$patient_id', '$visit_id')";
                    if($r1 = mysqli_query($con, $query)){
                        header('Location: pathologydetails.php?patient_id=' . $patient_id . '&visit_id=' . $visit_id);
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>