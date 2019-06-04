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
	if ($_POST['submit']== 'deleteEmployee'){

		$eid = $_POST['eid'];

		//check if user exists
		$sql = "SELECT * FROM Employee where EmpID = '$eid';";
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
			header("refresh:0.5;url=index.php");
			alert("Employee does not exist");
		}
		else {
			$sql = "DELETE FROM Employee WHERE EmpID ='$eid';";
			if ($conn->query($sql) === TRUE){
				redirect("index.php");
			}
			else {
				// $result='<div class="alert alert-success">Thank You! I will be in touch</div>';
				header("refresh:0.5;url=index.php");
				alert("An error has occured. Try again!");
				//echo "Deleting Error: " . $sql . "<br>". $conn->error;
			}
		}
	}
	// ==================== POST FOR DELETE =====================
	//===========================================================

	//===========================================================
	// ==================== POST FOR UPDATE =====================
	if ($_POST['submit']== 'updateEmployee'){
		$eid = $_POST['eid'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$sal = $_POST['sal'];
		$day = $_POST['day'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		$cnum = $_POST['cnum'];
		$hday = "{$year}-{$month}-{$day}";

		$sql = "SELECT * FROM Employee where EmpID = '$eid';";
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
			header("refresh:0.5;url=index.php");
			alert("Employee does not exist");
		}
		else {
			//check for permanent employee update
			if ($day != "" and $month != "" and $year != ""){
				$sql = "UPDATE Permanent_Employee SET ";
				$sql .= " HiringDate = '$hday' ";
				$sql .= " WHERE EmpID ='$eid';";
				if (!($conn->query($sql) === TRUE)){
					header("refresh:0.5;url=index.php");
					alert("An error has occured while trying to update permanent employee. Try again");
				}
			}
			else if ($cnum != ""){
			//check for temporary employee update
				$sql = "UPDATE Temporary_Employee SET ";
				$sql .= " ContractNum = '$cnum' ";
				$changedtem = true;
				$sql .= " WHERE EmpID ='$eid';";
				if (!($conn->query($sql) === TRUE)){
					header("refresh:0.5;url=index.php");
					alert("An error has occured while trying to update temporary employee. Try again");
				}
			}
			// time to update
			$changed = false;
			$sql = "UPDATE Employee SET ";
			if ($fname != ""){
				$changed = true;
				$sql .= " EFirst = '$fname' ";
			}
			if ($lname != ""){
				if ($changed)
					$sql .= " , ELast = '$lname' ";
				else{
					$sql .= " ELast = '$lname' ";
					$changed = true;
				}
			}
			if ($sal != ""){
				if ($changed)
					$sql .= " , Salary = '$sal' ";
				else{
					$sql .= " Salary = '$sal' ";
					$changed = true;
				}
			}
			if ($changed){
				$sql .= " WHERE EmpID ='$eid';";
				if ($conn->query($sql) === TRUE){
					redirect("index.php");
				}
				else {
					header("refresh:0.5;url=index.php");
					alert("An error has occured while trying to update employee. Try again");
				}
			}
			else
				redirect("index.php");
		}
	}
	// ==================== POST FOR UPDATE =====================
	//===========================================================


	//===========================================================
	// ==================== POST FOR INSERT =====================
	if ($_POST['submit']== 'submitEmployee'){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$sal = $_POST['sal'];
		$emptype = $_POST['emptype'];
		$day = $_POST['day'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		$cnum = $_POST['cnum'];
		$hday = "{$year}-{$month}-{$day}";

		$sql = "SELECT * FROM Employee where EFirst = '$fname' and ELast = '$lname';";
		$result = $conn->query($sql);
		if ($result->num_rows > 0){
			header("refresh:0.5;url=index.php");
			alert("Employee exists");
		}
		else {
			if ($emptype == "01" and $day == "" and $month == "" and $year == ""){
				header("refresh:0.5;url=index.php");
				alert("All permanent employess must have a hiring date.");
			}else if ($emptype == "02" and $cnum == ""){
				header("refresh:0.5;url=index.php");
				alert("All temporary employess must have a contract number.");
			}
			else{
	 			$sql = "INSERT INTO Employee(EFirst, ELast, Salary) VALUES ('$fname','$lname','$sal');";
				if ($conn->query($sql) === TRUE){
					$last_id = $conn->insert_id;
					if ($emptype == '01'){
						$sql = "INSERT INTO Permanent_Employee(EmpID, HiringDate) VALUES ('$last_id','$hday');";
					}
					else{
						$sql = "INSERT INTO Temporary_Employee(EmpID, ContractNum) VALUES ('$last_id','$cnum');";
					}
					if ($conn->query($sql) === TRUE){
						redirect("index.php");
					}
					else {
						echo "Error: " . $sql . "<br>". $conn->error;
					}
				}
				else {
					//$result='<div class="alert alert-success">Thank You! I will be in touch</div>';
					header("refresh:0.5;url=index.php");
					alert("An error has occured. Try again");
				}
			}
		}
	}
	// ==================== POST FOR INSERT =====================
	//===========================================================

?>
