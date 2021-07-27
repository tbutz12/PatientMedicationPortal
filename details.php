<?php
require 'databaseConnection.php';
session_start();
?>
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
    if(isset($_SESSION['firstName']) && !empty($_SESSION['firstName'])){
        $firstName = $_SESSION['firstName'];
    }
?>
<a href="visit.php?patient_id=<?php echo $patient_id; ?>&name=<?php echo $firstName; ?>">Click here to return to visits!</a>
<div class="wrapper">
    <form>
    <input type="button" style="height:40px; width:160px;" value="Print report" onClick="window.print()" class = "btn">
    </form>
</div>
<?php
    $q1 = "select * from Dx where patient_visit_dx = '$visit_id'";
    if($r1 = mysqli_query($connect, $q1)){
    }
    else{
        echo "Error: " . $q1 . "<br>" . mysqli_error($connect);
    }
    $r1 = mysqli_fetch_array($r1);
    $description = $r1["description"];


    $q2 = "select * from Labs where patient_visit_labs = '$visit_id'";
    if($r2 = mysqli_query($connect, $q2)){
    }
    else{
        echo "Error: " . $q2 . "<br>" . mysqli_error($connect);
    }
    $r2 = mysqli_fetch_array($r2);
    $bodyweight = $r2["bodyweight"];
    $height = $r2["height"];
    $bloodPressure = $r2["bloodPressure"];
    $bloodType = $r2["bloodType"];
    $bodyTemp = $r2["bodyTemp"];

    $q3 = "select * from Procedures where patient_visit_procedures = '$visit_id'";
    if($r3 = mysqli_query($connect, $q3)){
    }
    else{
        echo "Error: " . $q3 . "<br>" . mysqli_error($connect);
    }
    $r3 = mysqli_fetch_array($r3);
    $surgicalHistory = $r3["surgicalHistory"];

    $q4 = "select * from Pathology where patient_visit_pathology = '$visit_id'";
    if($r4 = mysqli_query($connect, $q4)){
    }
    else{
        echo "Error: " . $q4 . "<br>" . mysqli_error($connect);
    }
    $r4 = mysqli_fetch_array($r4);
    $date = $r4["date"];
    $testName = $r4["testName"];
    $testDescription = $r4["testDescription"];
    $siteCollected = $r4["siteCollected"];
    $result = $r4["result"];
    $q5 = "select * from Imaging where patient_visit_imaging = '$visit_id'";
    if($r5 = mysqli_query($connect, $q5)){
    }
    else{
        echo "Error: " . $q5 . "<br>" . mysqli_error($connect);
    }
    $checkImage = -1;
    if(mysqli_num_rows($r5) == 0){
        $checkImage = 0;
        $q6 = "select * from Imaging where patient_imaging = '$patient_id'";
        if($r6 = mysqli_query($connect, $q6)){
        }
        else{
            echo "Error: " . $q6 . "<br>" . mysqli_error($connect);
        }
        $r6 = mysqli_fetch_array($r6);
        $scan = $r6["scan"];
        $image = $r6["image"];
        $image = stripslashes($image);
    }
    else{
        $checkImage = 1;
        $r5 = mysqli_fetch_array($r5);
        $scan = $r5["scan"];
        $image = $r5["image"];
    }
    echo "<h2 class = 'tableHeads'>Diagnosis</h2>";
    echo "<table>";
    echo "<th >Description</th>";
    echo "<tr>";
    echo "<td>" . $description . "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<h2 class = 'tableHeads'>Lab Report</h2>";
    echo "<table>";
    echo "<th>Bodyweight</th>";
    echo "<th>Height</th>";
    echo "<th>Blood Pressure</th>";
    echo "<th>Blood Type</th>";
    echo "<th>Body Temperature</th>";
    echo "<tr>";
    echo "<td>" . $bodyweight . "</td>";
    echo "<td>" . $height . "</td>";
    echo "<td>" . $bloodPressure . "</td>";
    echo "<td>" . $bloodType . "</td>";
    echo "<td>" . $bodyTemp . "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<h2 class = 'tableHeads'>Procedures</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Surgical History</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $surgicalHistory . "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<h2 class = 'tableHeads'>Pathology</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Date</th>";
    echo "<th>Test Name</th>";
    echo "<th>Test Description</th>";
    echo "<th>Site Collected</th>";
    echo "<th>Result</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $date . "</td>";
    echo "<td>" . $testName . "</td>";
    echo "<td>" . $testDescription . "</td>";
    echo "<td>" . $siteCollected . "</td>";
    echo "<td>" . $result . "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<h2 class = 'tableHeads'>Imaging</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Scan Type</th>";
    echo "<th>Image</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $scan . "</td>";
    if($checkImage == 0){
        echo "<td>" . '<image src=' . $image . ' />' . "</td>";
    }
    else{
        echo "<td>" . '<img src="data:image/jpeg;base64,'.base64_encode($image) .'" />' . "</td>";
    }
    echo "</tr>";
    echo "</table>";

    echo "<br>";
    echo "<br>";

?>