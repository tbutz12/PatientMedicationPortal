<?php
require 'databaseConnection.php';
session_start();
$providerName = $providerNameError = $providerAddress = $provderAddressError = $insuranceType = $insuranceTypeError = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["providerName"])){
        $providerNameError = "No provider name provided";
    }
    else{
        $providerName = $_POST["providerName"];
    }
    if(empty($_POST["providerAddress"])){
        $providerAddressError = "No provider address provided";
    }
    else{
        $providerAddress = $_POST["providerAddress"];
    }
    if(empty($_POST["insuranceType"])){
        $insuranceTypeError = "No insurance type provided";
    }
    else{
        $insuranceType = $_POST["insuranceType"];
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
            <p>Insurance Provider Name: <input type=text name="providerName" value="<?php echo $providerName; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$providerNameError</div>"; ?></span></p>
            <p>Insurance Provider Address: <input type=text name="providerAddress" value="<?php echo $providerAddress; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$providerAddressError</div>"; ?></span></p>
            <p>Insurance Provider Type: <input type=text name="insuranceType" value="<?php echo $insuranceType; ?>">
            <span class="error"><?php echo "<div style=\"color: red;\">$insuranceTypeError</div>"; ?></span></p>
			<br>
			<input type="submit" value="submit" style="font-size:22px" />
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST["providerName"]) && !empty($_POST["providerAddress"])  && !empty($_POST["insuranceType"])){
                    $con = connectDB();
                    $query = "insert into InsuranceProvider(provider_name, provider_address, insurance_type, patient_id)
                    values('$providerName', '$providerAddress', '$insuranceType', '$patient_id')";
                    if($r1 = mysqli_query($con, $query)){
                        header('Location: homepage.php');
                    }
                    else{
                        echo "Error: " . $query . "<br>" . mysqli_error($con);
                    }
                }
            }
        ?>