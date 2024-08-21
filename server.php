<?php 
session_start();
$errors=array();
$mysqli = new mysqli("localhost:3307","root","","study");

######################################################### FOR FACULTY ################################################
if (isset($_POST['LoginF'])) {

    $FacultyID2	= $mysqli -> real_escape_string($_POST['facultyID']);
    $FacultyPassword2= $mysqli -> real_escape_string($_POST['facultypassword']);
if (empty($FacultyID2)) {
array_push($errors,"Faculty ID is required");
# code...
}
if (empty($FacultyPassword2)) {
array_push($errors,"Password is required");


    # code...
}


if (count ($errors)== 0) {

	
		
	

	$queryA="SELECT * FROM faculty WHERE FacultyID=('$FacultyID2')AND password=('$FacultyPassword2')";
	$resultA=mysqli_query($mysqli,$queryA);
	if (mysqli_num_rows($resultA) ==1 )  {
	
	

	
	$_SESSION['FacultyID']=$FacultyID2;
  	$_SESSION['success']="you are now logged in";
  	header('location:../faculty-register/indexF.php'); 
}  else{
		array_push($errors,"The ID/Password not correct");
		
	}
}


    


}

######################################################### FOR ADMIN #####################################################################
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
  
  
  if (isset($_POST['LoginA'])) {
  
          $adminID	= $mysqli -> real_escape_string($_POST['adminID']);
          $adminpassword= $mysqli -> real_escape_string($_POST['adminpassword']);
  if (empty($adminID)) {
      array_push($errors,"Admin ID is required");
      # code...
  }
  if (empty($adminpassword)) {
      array_push($errors,"Password is required");
      
  
          # code...
      }
  
  
      if (count ($errors)== 0) {
  
      
          
      
  
      $queryA="SELECT * FROM admin WHERE AdminID=('$adminID')AND adminpassword=('$adminpassword')";
      $resultA=mysqli_query($mysqli,$queryA);
      if (mysqli_num_rows($resultA) ==1 )  {
      
      
  
      
      $_SESSION['AdminID']=$adminID;
      $_SESSION['success']="you are now logged in";
      header('location:../admin-register/indexA.php'); 
  }  else{
          array_push($errors,"The ID/Password not correct");
          
      }
  }
  }
############################################### ADD FACULTY#########################################################


if (isset($_POST['Add'])) {

	



	$addID 				= $mysqli -> real_escape_string($_POST['addID']);
	$addname 			= $mysqli -> real_escape_string($_POST['addname']);
	$addAddress 		= $mysqli -> real_escape_string($_POST['addAddress']);
	$addContactNumber	= $mysqli -> real_escape_string($_POST['addContactNumber']);
	$addEmail 			= $mysqli -> real_escape_string($_POST['addEmail']);
	$addPassword 		= $mysqli -> real_escape_string($_POST['addpassword']);





	if (empty($addID)) {
	array_push($errors,"Faculty ID is required");
	# code...
}

if (empty($addname)) {
	array_push($errors,"Faculty Name is required");
	# code...
}


if (empty($addAddress)) {
	array_push($errors,"Address is required");
	# code...
}

if (empty($addContactNumber)) {
	array_push($errors,"Contact Number is required");
	# code...
}


if (empty($addEmail)) {
	array_push($errors,"Email is required");
	# code...
}

if (empty($addPassword)) {
	array_push($errors,"Password is required");
	# code...
}










if(count($errors)==0){

		$addcategory 	= $_REQUEST['addcategory'];


	$sqladd = "INSERT INTO  faculty (FacultyID, Facultyname, email, Address, ContactNumber, password,category) VALUES ('$addID','$addname','$addEmail','$addAddress','$addContactNumber','$addPassword','$addcategory') ";



	if ($mysqli -> query($sqladd)) {
  printf("%d Row inserted.\n", $mysqli->affected_rows);


 
}


  $_SESSION['addID']=$addID;
  $_SESSION['success']="you are now logged in";
  header('location:admin-register/DeleteFaculty.php');





}
	


	# code...
}

######################################### DELETE FACULTY #########################################################

if (isset($_POST['Delete'])) {

		$deleteID =$mysqli -> real_escape_string($_POST['deleteID']);

	if (empty($deleteID)) {
	array_push($errors,"Faculty ID is required");
}
 if (count($errors)==0) {
 




	$querydelete="DELETE FROM faculty WHERE FacultyID='$deleteID' ";
	if ($mysqli -> query($querydelete)) {

		if ($mysqli->affected_rows==0) {
			 array_push($errors,"Wrong Faculty ID");
			
			# code...
		}
		



	}
	  else {
	  
	  echo 'Book is Canceled';
	  


	  }

	}
}














?>




 
