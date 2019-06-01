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
	if ($_POST['submit']== 'deleteBorrows'){
		
		$isbn = $_POST['isbn'];
		$cnum = $_POST['cnum'];
		$bday = $_POST['bday'];
		$mid = $_POST['mid'];

		
		$sql = "SELECT * FROM Borrows where Member_Id = '$mid' and ISBN = '$isbn' and CopyNumber = '$cnum' and Borrowing_Day = '$bday';";
		//echo $sql;
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
			header("refresh:0.5;url=index.php");
			alert("No such entry");
		}
		else {
			$sql = "DELETE FROM Borrows WHERE Member_Id = '$mid' and ISBN = '$isbn' and CopyNumber = '$cnum' and Borrowing_Day = '$bday';";
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
	if ($_POST['submit']== 'updateBorrows'){
		
		$mid = $_POST['mid'];
		$isbn = $_POST['isbn'];
		$cnum = $_POST['cnum'];
		$bday = $_POST['bday'];
		$retday = $_POST['retday'];
		$returned = $_POST['returned'];


		$sql = "SELECT * FROM Borrows where Member_Id = '$mid' and ISBN = '$isbn' and CopyNumber = '$cnum' and Borrowing_Day = '$bday';";
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
			alert("Entry does not exist");
		}
		else {
			$changed = false;
			$sql = "UPDATE Borrows SET ";
			if ($retday != ""){
				$changed = true;
				$sql .= " Returning_Day = '$retday' ";
			}
			if ($returned != ""){
				if ($changed)
					$sql .= " , Day_Returned = '$returned' ";
				else{
					$sql .= " Day_Returned = '$returned' ";
					$changed = true;
				}
			}
			if ($changed){
				$sql .= " where Member_Id = '$mid' and ISBN = '$isbn' and CopyNumber = '$cnum' and Borrowing_Day = '$bday';";
				if ($conn->query($sql) === TRUE){
					redirect("index.php");
				}
				else {
					header("refresh:0.5;url=index.php");
					alert($conn->error);
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
	if ($_POST['submit']== 'submitBorrows'){
		//$entityBody = file_get_contents('php://input');
		// echo $entityBody ."<br>"; 

		$name = $_POST['name'];
		$pieces = explode(" ", $name);
		$fname = $pieces[0];
		$lname = $pieces[1];
		$title = $_POST['title'];
		//check if user exists
 		$last_id = $conn->query("SELECT Member_Id From Member WHERE MFirst = '$fname' and MLast = '$lname';")->fetch_object()->Member_Id;
 		$last_isbn = $conn->query("SELECT ISBN From Book WHERE Title = '$title';")->fetch_object()->ISBN;
		
		// select as number of copy the number of available books
		// as it is incremented every time i add one
		$last_cpnum = $conn->query("SELECT Available From DetailsofBooks WHERE Title = '$title' LIMIT 1;")->fetch_object()->Available;
		--$last_cpnum;
		if ($last_cpnum < '0'){
			header("refresh:0.5;url=index.php");
			alert("No copy available");
		}
		else{
			$sql = "INSERT INTO Borrows(Member_Id, ISBN, CopyNumber, Borrowing_Day) VALUES ('$last_id','$last_isbn','$last_cpnum', CURRENT_DATE());";
			if ($conn->query($sql) === TRUE){
				redirect("index.php");
			}
			else {
				header("refresh:0.5;url=index.php");
				alert($conn->error);
			}
		}
	}
	// ==================== POST FOR INSERT =====================
	//===========================================================

?>

