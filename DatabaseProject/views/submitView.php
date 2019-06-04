<?php
	function redirect($url, $statusCode = 303)
	{
	   header('Location: ' . $url, true, $statusCode);
	   die();
	}
	function alert($msg) {
	    echo "<script type='text/javascript'>alert('$msg');</script>";
	}
	$servername = "localhost";
	$username = "root";
	$password = "vasilis1";
	$db = "db";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $db);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}


	//===========================================================
	// ==================== POST FOR DELETE =====================
	if ($_POST['submit']== 'deleteView'){
		//$entityBody = file_get_contents('php://input');
		// echo $entityBody ."<br>";

		$mid = $_POST['mid'];
		//check if user exists
		// does not exist. add him
		$sql = "SELECT * FROM Athens_members where Member_Id = '$mid';";
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
			header("refresh:0.5;url=index.php");
			alert("Member does not exist");
		}
		else {
			$sql = "DELETE FROM Athens_members WHERE Member_Id ='$mid';";
			if ($conn->query($sql) === TRUE){
				redirect("index.php");
			}
			else {
				header("refresh:0.5;url=index.php");
				alert("En error has occured while trying to delete from view. Try again.");
				//echo "Deleting Error: " . $sql . "<br>". $conn->error;
			}
		}
	}
	// ==================== POST FOR DELETE =====================
	//===========================================================

	//===========================================================
	// ==================== POST FOR UPDATE =====================
	if ($_POST['submit']== 'updateView'){
		$mid = $_POST['mid'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$str = $_POST['str'];
		$num = $_POST['num'];
		$bday= $_POST['bday'];

		$sql = "SELECT * FROM Athens_members where Member_Id = '$mid';";
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
				header("refresh:0.5;url=index.php");
				alert("Member does not exist");
		}
		else {
			$changed = false;
			$sql = "UPDATE Athens_members SET ";
			if ($str != ""){
				$changed = true;
				$sql .= " Street = '$str' ";
			}
			if ($fname != ""){
				if ($changed)
					$sql .= " , MFirst = '$fname' ";
				else{
					$sql .= " MFirst = '$fname' ";
					$changed = true;
				}
			}
				if ($lname != ""){
				if ($changed)
					$sql .= " , MLast = '$lname' ";
				else{
					$sql .= " MLast = '$lname' ";
					$changed = true;
				}
			}
			if ($bday != ""){
				if ($changed)
					$sql .= " , MBirthday = '$bday' ";
				else{
					$sql .= " MBirthday = '$bday' ";
					$changed = true;
				}
			}
			if ($num != ""){
				if ($changed)
					$sql .= " , Num = '$num' ";
				else{
					$sql .= " Num = '$num' ";
					$changed = true;
				}
			}

			if (!$changed){
				header("refresh:0.5;url=index.php");
				alert("Fill the form and try again");
				}
			else
				$sql .= " WHERE Member_Id ='$mid';";

			if ($conn->query($sql) === TRUE){
				redirect("index.php");
			}
			else {
				header("refresh:0.5;url=index.php");
				alert("An error has occured while trying to update view. Try again");
				//echo "Updating Error: " . $sql . "<br>". $conn->error;
			}
		}
	}
	// ==================== POST FOR UPDATE =====================
	//===========================================================

	//===========================================================
	// ==================== POST FOR INSERT =====================
	if ($_POST['submit']== 'submitView'){
		//$entityBody = file_get_contents('php://input');
		// echo $entityBody ."<br>";

		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$str = $_POST['str'];
		$num = $_POST['num'];
		$city = $_POST['city'];
		$bday = $_POST['bday'];
		//check if user exists
		$sql = "SELECT * FROM Athens_members where MFirst = '$fname' and MLast = '$lname' and MBirthday = '$bday';";
		$result = $conn->query($sql);
		if ($result->num_rows > 0){
				header("refresh:0.5;url=index.php");
				alert("Member exists");
		}
		else {
			// does not exist. add him
			$sql = "INSERT INTO Athens_members(MFirst, MLast, MBirthday, Street, Num, City) VALUES ('$fname','$lname','$bday','$str','$num','$city');";
			if ($conn->query($sql) === TRUE){
				redirect("index.php");
			}
			else {
				header("refresh:0.5;url=index.php");
				alert("CHECK OPTION FAILED");
			}
		}
	}
	// ==================== POST FOR INSERT =====================
	//===========================================================
?>
