<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Faculty</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class= "container">
        <?php
        if(isset($_POST["submit"])){
            $FacultyID = $_POST["Faculty_ID"];
            $Facltyname = $_POST["Faculty_name"];
            $email= $_POST["email"];
            $Address = $_POST["Address"];
            $contactnumber = $_POST["Contact_Number"];
            $password = $_POST["password"];
            $category = $_POST["category"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();
            
            if(empty($FacultyID)OR empty($Facltyname)OR empty($email)OR empty($Address)OR empty($contactnumber)OR empty($password)OR empty($category)){
                array_push($errors,"All fields are required.");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL )){
                array_push($errors, "Email is not valid.");
            }
            if (strlen($password)<8) {
                array_push($errors,"Password must be at least 8 charactes long.");
            }
            require_once "database.php";
            $sql="SELECT * FROM faculty WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if($rowCount>0){
                array_push($errors,"Email already exist!");
            }
            if(count($errors)>0){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'> $error</div>";
                }
            }else{
                
                $sql = "INSERT INTO faculty (FacltyID, Facultyname, email, Address, ContactNumber, password, category) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt, "ssssiss", $FacultyID, $Facltyname, $email, $gender, $Address, $contactnumber, $password, $category);
                    mysqli_stmt_execute($stmt);
                    echo"<div class='alert alert-success'>You are registered successfully.</div>";
                }else{
                    die( "Something went wrong.");
                }
            }
        }
        ?>
        <form action="addfaculty.php" method ="post">
            <div class="form-group">
                <input type="text"class="form-control" name="Faculty_ID" placeholder="Faculty ID:">
            </div>
            <div class="form-group">
                <input type="text"class="form-control" name="Faculty_name" placeholder="Faculty Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control"name="email"  placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="Address" class="form-control"name="Address"  placeholder="Address:">
            </div>
            <div class="form-group">
                <input type="number" class="form-control"name="Contact_Number" placeholder="Contact Number:">
            </div>
            <div class="form-group">
                <input type="password"class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
            <label><b>Category</b></label>
        <select name = "category" required >
          <option value="">Select</option>
        <option value = "Male">NEET</option>
        <option value = "Female">JEE</option>
        <option value = "Others">CLAT</option>
        <option value = "Others">NDA</option>
        </select>
                
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>
    
</body>
</html>