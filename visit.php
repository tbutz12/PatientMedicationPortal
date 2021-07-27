<?php
require 'databaseConnection.php';
session_start();
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
    if (isset($_GET['name'])) {
        $firstName = $_GET['name'];
    }
    $q1 = "select * from Patient_Visit where patient_id = '$patient_id'";
    if($r1 = mysqli_query($connect, $q1)){
        echo "<table>";
        echo "<tr>";
        echo "<th>Visit Date</th><th>Doctor's Name</th><th>Reason for Visit</th><th>Visit Report</th>";
        echo "</tr>";
        while($row = mysqli_fetch_array($r1)){
            echo "<tr>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["doctorName"] . "</td>";
            echo "<td>" . $row["reasonForVisit"] . "</td>";
            $visit_id = $row["visit_id"];
            echo "<td><a href='details.php?patient_id=$patient_id&
            visit_id=$visit_id'>Visit details</a>
            </td>";
            echo "</tr>";
        } 
        echo "</table>";
        echo "<br><br>";
    }
    else{
        echo "Error: " . $q1 . "<br>" . mysqli_error($connect);
    }
?>
<br>
<br><br>
<a href="newvisit.php?patient_id=<?php echo $patient_id; ?>">Add a new visit for <?php echo $firstName ?></a>