<?php
require 'databaseConnection.php';
session_start();
if(isset($_SESSION['firstName']) && !empty($_SESSION['firstName'])){
    $firstName = $_SESSION['firstName'];
    echo "<h1>$firstName's Medical Records</h1>";
}
?>
<a href="logout.php">Click here to search another patient!</a>
<style>
    <?php 
         include 'styles.css'; 
    ?>
</style>
<br>
<br>
    <?php
    insertImages();
    $connect = connectDB();
    $q1 = "select patient_id from Patient where patient_first_name = '$firstName'";
    if($r1 = mysqli_query($connect, $q1)){
        $_SESSION['patient_id'] = $patient_id;
    }
    else{
        echo "Error: " . $q1 . "<br>" . mysqli_error($connect);
    }
    $r1 = mysqli_fetch_array($r1);
    $patient_id = $r1['patient_id'];

    $q4 = "select * from Patient_PCP where patient_id = '$patient_id'";
    if($r4 = mysqli_query($connect, $q4)){
    }
    else{
        echo "Error: " . $q4 . "<br>" . mysqli_error($connect);
    }
    $r4 = mysqli_fetch_array($r4);
    $doctor_first_name = $r4["doctor_first_name"];
    $doctor_last_name = $r4["doctor_last_name"];
    echo "<h2>Current PCP: $doctor_last_name, $doctor_first_name </h2>";
    echo "<hr>";
    if(empty($doctor_last_name)){
        echo "<a href='pcp.php?patient_id=$patient_id'>Add a new PCP</a>";
    }
    $q5 = "select * from InsuranceProvider where patient_id = '$patient_id'";
    if($r5 = mysqli_query($connect, $q5)){
    }
    else{
        echo "Error: " . $q5 . "<br>" . mysqli_error($connect);
    }
    $r5 = mysqli_fetch_array($r5);
    $provider_name = $r5["provider_name"];
    $provider_address = $r5["provider_address"];
    echo "<h2>Current Insurance Provider: $provider_name </h2>";
    echo "<hr>";
    if(empty($provider_name)){
        echo "<a href='provider.php?patient_id=$patient_id'>Add a new Insurance Provider</a>";
    }
    echo "<h3>Provider Address: $provider_address</h3>";
    echo "<hr>";
    $q4 = "select * from Patient_Location where patient_id = '$patient_id'";
    if($r4 = mysqli_query($connect, $q4)){
    }
    else{
        echo "Error: " . $q4 . "<br>" . mysqli_error($connect);
    }
    $r4 = mysqli_fetch_array($r4);
    $street_number = $r4["street_number"];
    $street_name = $r4["street_name"];
    $city = $r4["city"];
    $state = $r4["state"];
    $zip = $r4["zip_code"];
    echo "<h2>Patient Address Information</h3>";
    if(empty($street_number) || empty($street_name)){
        echo "<a href='address.php?patient_id=$patient_id'>Add a new patient address</a>";
    }
    echo "<div class = 'address'";
    echo "<p>";
    echo $street_number . " " . $street_name .  ", " . $city .  " " . $state .  " " . $zip;
    echo "</p>";
    echo "</div>";
    echo "<hr>";
    $q2 = "select * from Prescription where patient_id = '$patient_id'";
    if($r2 = mysqli_query($connect, $q2)){
            echo "<table>";
            echo "<tr>";
            echo "<th>Medication prescribed</th><th>Medication description</th><th>Medication side effects</th><th>Medication description</th>";
            echo "</tr>";
            while($row = mysqli_fetch_array($r2)) {
                $medication_id = $row['medication_id'];
                $q3 = "select * from medication where medication_id = '$medication_id'";
                if ($r3 = mysqli_query($connect, $q3)) {
                    $r3 = mysqli_fetch_array($r3);
                    echo "<tr>";
                    echo "<td>" . $r3['medication_name'] . "</td>";
                    echo "<td>" . $r3['medication_description'] . "</td>";
                    echo "<td>" . $r3['medication_side_effects'] . "</td>";
                    echo "<td>" . $r3['medication_directions'] . "</td>";
                    echo "</tr>";
                } else {
                    echo "Error: " . $query2 . "<br>" . mysqli_error($connect);
                }
            }
            echo "</table>";
            echo "<br><br>";

    }
    else{
        echo "Error: " . $q2 . "<br>" . mysqli_error($connect);
    }

    ?>
    <?php
        function insertImages(){
            static $result;
            if($result !== null){
                return;
            }
            $connect = connectDB();
            $q1 = "select patient_id from Patient";
            if($r1 = mysqli_query($connect, $q1)){
            }
            else{
                echo "Error: " . $q1 . "<br>" . mysqli_error($connect);
            }
            $row1 = mysqli_fetch_array($r1);
            $row2 = mysqli_fetch_array($r1);
            $row3 = mysqli_fetch_array($r1);
            $row4 = mysqli_fetch_array($r1);
            $patient_id1 = $row1['patient_id'];
            $patient_id2 = $row2['patient_id'];
            $patient_id3 = $row3['patient_id'];
            $patient_id4 = $row4['patient_id'];
            $img1 = "images/1.jpeg";
            $img2 = "images/fracture.jpeg";
            $img3 = "images/rootCanal.jpeg";
            $img4 = "images/ivp.jpeg";
            $imgCheck = "select imaging_id from Imaging where imaging_id = 1";
            if($imgCheck = mysqli_query($connect, $imgCheck)){
                $imgCheck = mysqli_fetch_array($imgCheck);
                $checker1 = $imgCheck["imaging_id"];
                if(empty($checker1)){
                    for($x = 0; $x < 4; $x++){
                        $img1 = addslashes($img1);
                        $img2 = addslashes($img2);
                        $img3 = addslashes($img3);
                        $img4 = addslashes($img4);
                        $imageQ = "";
                        switch($x){
                            case 0:
                            $imageQ = "insert into Imaging(scan, image, patient_imaging)
                            values('Biopsy', '$img1', '$patient_id1')";
                            break;
                            case 1:
                            $imageQ = "insert into Imaging(scan, image, patient_imaging)
                            values('X-Ray', '$img2', '$patient_id2')";
                            break;
                            case 2:
                            $imageQ = "insert into Imaging(scan, image, patient_imaging)
                            values('CT-Scan', '$img3', '$patient_id3')";
                            break;
                            case 3:
                            $imageQ = "insert into Imaging(scan, image, patient_imaging)
                            values('Intravenous Pyelogram', '$img4', '$patient_id4')";
                            break;
                        }   
                        if($imgCheck = mysqli_query($connect, $imageQ)){
                        }
                        else{
                            echo "Error: " . $imageQ . "<br>" . mysqli_error($connect);
                        }
                    }
                }
            }
            $update1 = "update Imaging set patient_visit_imaging = @visit_id_1 where imaging_id = 1";
            if(mysqli_query($connect, $update1)){
            }
            else{
                echo "Error: " . $update1 . "<br>" . mysqli_error($connect);
            }
            $update2 = "update Imaging set patient_visit_imaging = @visit_id_2 where imaging_id = 2";
            if(mysqli_query($connect, $update2)){
            }
            else{
                echo "Error: " . $update2 . "<br>" . mysqli_error($connect);
            }
            $update3 = "update Imaging set patient_visit_imaging = @visit_id_3 where imaging_id = 3";
            if(mysqli_query($connect, $update3)){
            }
            else{
                echo "Error: " . $update3 . "<br>" . mysqli_error($connect);
            }
            $update4 = "update Imaging set patient_visit_imaging = @visit_id_4 where imaging_id = 4";
            if(mysqli_query($connect, $update4)){
            }
            else{
                echo "Error: " . $update4 . "<br>" . mysqli_error($connect);
            }
            $result = "DONE";
            return;
        }
        ?>
    <br>
    <a href="visit.php?patient_id=<?php echo $patient_id; ?>&name=<?php echo $firstName; ?>">Visit Terminal</a>
    <br>
    <br>
    <a href="prescription.php?patient_id=<?php echo $patient_id; ?>">Add a new prescription</a>