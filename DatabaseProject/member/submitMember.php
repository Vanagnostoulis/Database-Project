<!DOCTYPE html>
<html>
	<body>
		<div class="content">
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
				if ($_POST['submit']== 'deleteMember'){
					//$entityBody = file_get_contents('php://input');
					// echo $entityBody ."<br>";

					$mid = $_POST['mid'];
					//check if user exists
					// does not exist. add him
					$sql = "SELECT * FROM Member where Member_Id = '$mid';";
					$result = $conn->query($sql);
					if ($result->num_rows == 0){
						header("refresh:0.5;url=index.php");
						alert("Member does not exist");
					}
					else {
						$sql = "DELETE FROM Member WHERE Member_Id ='$mid';";
						if ($conn->query($sql) === TRUE){
							redirect("index.php");
						}
						else {
							header("refresh:0.5;url=index.php");
							alert("En error has occured. Try again.");
							//echo "Deleting Error: " . $sql . "<br>". $conn->error;
						}
					}
				}
				// ==================== POST FOR DELETE =====================
				//===========================================================

				//===========================================================
				// ==================== POST FOR UPDATE =====================
				if ($_POST['submit']== 'updateMember'){
					$mid = $_POST['mid'];
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$str = $_POST['str'];
					$no = $_POST['no'];
					$pc = $_POST['pc'];
					$city= $_POST['city'];
					$day = $_POST['day'];
					$month = $_POST['month'];
					$year = $_POST['year'];
					$bday = "{$year}-{$month}-{$day}";

					$sql = "SELECT * FROM Member where Member_Id = '$mid';";
					$result = $conn->query($sql);
					if ($result->num_rows == 0){
							header("refresh:0.5;url=index.php");
							alert("Member does not exist");
					}
					else {
						$changed = false;
						$sql = "UPDATE Member SET ";
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
						if ($day != "" and $month != "" and $year !=""){
							if ($changed)
								$sql .= " , MBirthday = '$bday' ";
							else{
								$sql .= " MBirthday = '$bday' ";
								$changed = true;
							}
						}
						if ($no != ""){
							if ($changed)
								$sql .= " , Num = '$no' ";
							else{
								$sql .= " Num = '$no' ";
								$changed = true;
							}
						}
						if ($pc != ""){
							if ($changed)
								$sql .= " , Postal_Code = '$pc' ";
							else{
								$sql .= " Postal_Code = '$pc' ";
								$changed = true;
							}
						}
						if ($city != ""){
							if($changed)
								$sql .= " , City = '$city' ";
							else{
								$sql .= " City = '$city' ";
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
							alert("An error has occured. Try again");
							//echo "Updating Error: " . $sql . "<br>". $conn->error;
						}
					}
				}
				// ==================== POST FOR UPDATE =====================
				//===========================================================

				//===========================================================
				// ==================== POST FOR INSERT =====================
				if ($_POST['submit']== 'addMember'){
					//$entityBody = file_get_contents('php://input');
					// echo $entityBody ."<br>";

					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$day = $_POST['day'];
					$month = $_POST['month'];
					$year = $_POST['year'];
					$str = $_POST['str'];
					$no = $_POST['no'];
					$pc = $_POST['pc'];
					$city= $_POST['city'];
					$bday = "{$year}-{$month}-{$day}";
					//check if user exists
					$sql = "SELECT * FROM Member where MFirst = '$fname' and MLast = '$lname'and MBirthday = '$bday';";
					$result = $conn->query($sql);
					if ($result->num_rows > 0){
							header("refresh:0.5;url=index.php");
							alert("Member exists");
					}
					else {
						// does not exist. add him
						$sql = "INSERT INTO Member(MFirst, MLast, MBirthday, Street, Num, Postal_Code, City) VALUES ('$fname','$lname','$bday','$str','$no','$pc','$city');";
						if ($conn->query($sql) === TRUE){
							redirect("index.php");
						}
						else {
							header("refresh:0.5;url=index.php");
							alert("An error has occured. Try again");
						}
					}
				}
				// ==================== POST FOR INSERT =====================
				//===========================================================
			?>
		</div>
	</body>
</html>
