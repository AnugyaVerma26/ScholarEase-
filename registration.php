<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class= "container">
        <?php
        if(isset($_POST["submit"])){
            $fullName = $_POST["fullname"];
            $userid = $_POST["userid"];
            $contactno= $_POST["contactno"];
            $gender = $_POST["gender"];
            $state = $_POST["state"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();
            
            if(empty($fullName)OR empty($userid)OR empty($contactno)OR empty($gender)OR empty($state)OR empty($email)OR empty($password)OR empty($passwordRepeat)){
                array_push($errors,"All fields are required.");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL )){
                array_push($errors, "Email is not valid.");
            }
            if (strlen($password)<8) {
                array_push($errors,"Password must be at least 8 charactes long.");
            }
            if ($password!==$passwordRepeat) {
                array_push($errors,"Password does not match.");
            }
            require_once "database.php";
            $sql="SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if($rowCount>0){
                array_push($errors,"Email already exist");
            }
            if(count($errors)>0){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'> $error</div>";
                }
            }else{
                
                $sql = "INSERT INTO users (full_name, user_id, contact_no, gender, State, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt, "ssissss", $fullName, $userid, $contactno, $gender, $state, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo"<div class='alert alert-success'>You are registered successfully.</div>";
                }else{
                    die( "Something went wrong.");
                }
            }
        }
        ?>
        <form action="registration.php" method ="post">
            <div class="form-group">
                <input type="text"class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="text"class="form-control" name="userid" placeholder="User ID:">
            </div>
            <div class="form-group">
                <input type="phone" class="form-control"name="contactno"  placeholder="Contact No:">
            </div>
            <div class="form-group">
            <label><b>Gender</b></label>
        <select name = "gender" required >
          <option value="">Select</option>
        <option value = "Male">Male</option>
        <option value = "Female">Female</option>
        <option value = "Others">Others</option>
        </select>
                
            </div>
            <div class="form-group">
            <label ><b>State</b></label> 
          <select name = "state" required > 
            <option value="">Select</option>
            <option value = "Andhra Pradesh">Andhra Pradesh</option>
            <option value = "Arunachal Pradesh">Arunachal Pradesh</option>
            <option value = "Assam">Assam</option>
            <option value = "Bihar">Bihar</option>
            <option value = "Chhattisgarh">Chhattisgarh</option>
            <option value = "Delhi">Delhi</option>
            <option value = "Goa">Goa</option>
            <option value = "Gujarat">Gujarat</option>
            <option value = "Haryana">Haryana</option>
            <option value = "Himachal Pradesh">Himachal Pradesh</option>
            <option value = "Jharkhand">Jharkhand</option>
            <option value = "Karnataka">Karnataka</option>
            <option value = "Kerala">Kerala</option>
            <option value = "Madhya Pradesh">Madhya Pradesh</option>
            <option value = "Maharashtra">Maharashtra</option>
            <option value = "Manipur">Manipur</option>
            <option value = "Meghalaya">Meghalaya</option>
            <option value = "Mizoram">Mizoram</option>
            <option value = "Nagaland">Nagaland</option>
            <option value = "Odisha">Odisha</option>
            <option value = "Punjab">Punjab</option>
            <option value = "Rajasthan">Rajasthan</option>
            <option value = "Sikkim">Sikkim</option>
            <option value = "Tamil Nadu">Tamil Nadu</option>
            <option value = "Telangana">Telangana</option>
            <option value = "Tripura">Tripura</option>
            <option value = "Uttrakhand">Uttrakhand</option>
            <option value = "Uttar Pradesh">Uttar Pradesh</option>
            <option value = "West Bengal">West Bengal</option>
            </select>
                
            </div>
            <div class="form-group">
                <input type="email" class="form-control"name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password"class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control"name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div><p>Already Registered! <a href="login.php">Login Here</a></p></div>
    </div>
    
</body>
</html>