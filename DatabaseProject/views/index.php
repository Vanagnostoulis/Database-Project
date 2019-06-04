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

?>

<!DOCTYPE html>
<html>
  <head>
  <title> Views </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel = "stylesheet" href = "http://localhost/DatabaseProject/style.css"/>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>

  <body>


    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Scientific Library</a>
          </div>
          <ul class="nav navbar-nav">
            <li class="active"><a href="/DatabaseProject/index.php">Home</a></li>
            <li><a href="/DatabaseProject/member/index.php">Members</a></li>
            <li><a href="/DatabaseProject/employees/index.php">Employees</a></li>
            <li><a href="/DatabaseProject/borrows/index.php">Borrowing</a></li>
            <li><a href="/DatabaseProject/views/index.php">Views</a></li>
            <li><a href="/DatabaseProject/queries/index.php">Queries</a></li>
          </ul>
        </div>
    </nav>


    <div class="content">
      <div class = "insert-form">
        <center><h1> Members from Athens (Updatable view) </h1></center>

        <?php
        $sql = "select Member_Id, MFirst, MLast, MBirthday, Street, Num, City from Athens_members order by MLast;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Member ID</th><th>Name</th><th>Birthday</th><th>Street</th><th>Number</th><th>City</th></tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["Member_Id"]."</td><td>".$row["MLast"]." ".$row["MFirst"]."</td><td>".$row["MBirthday"]."</td><td>".$row["Street"]."</td><td>".$row["Num"]."</td><td>".$row["City"]."</td></tr>";
            }
            echo "</table><p></p><";
        }
        ?>
      </div>


      <div class = "buttons">
        <button type="button" class="insert-button btn btn-info btn-lg" data-toggle="modal" data-target="#insertModal">INSERT</button>
        <button type="button" class="update-button btn btn-info btn-lg" data-toggle="modal" data-target="#updateModal">UPDATE</button>
        <button type="button" class="delete-button btn btn-info btn-lg" data-toggle="modal" data-target="#deleteModal">DELETE</button>
      </div>

      <div class = "insert-form">
        <center><h1> Details of Books (Non updatable View) </h1></center>
        <?php
        $sql = "select * from DetailsofBooks order by Title;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Title</th><th>Author Name</th><th>Category</th><th>Publisher</th><th>Year</th><th>Copies</th><th>Available</th></tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["Title"]."</td><td>".$row["ALast"]." ".$row["AFirst"]."</td><td>".$row["CategoryName"]."</td><td>".$row["PubName"]."</td><td>".$row["PubYear"]."</td><td>".$row["Number_of_Copies"]."</td><td>".$row["Available"]."</td></tr>";
            }
            echo "</table><p></p><";
        }
        ?>
      </div>


        <div class="modal fade" id="updateModal" role="dialog">
          <div class = "modal-dialog">
            <form class="popup-form" name="Update View" method="post" action="submitView.php"><p></p>
              <font color="blue"> Member ID(*): </font> <input type="text" name="mid" required><p></p>
              <font color="blue"> MFirst: </font> <input type="text" name="fname" ><p></p>
              <font color="blue"> MLast: </font> <input type="text" name="lname" ><p></p>
              <font color="blue"> Birthday: </font> <input type="text" placeholder="YYYY-MM-DD" name="bday"><p></p>
              <font color="blue"> Street: </font> <input type="text" name="str" ><p></p>
              <font color="blue"> Num: </font> <input type="text" name="num" ><p></p>
              <button type ="submit" name="submit" value="updateView" action="submitView.php"> Update View </button>
            </form>
          </div>
        </div>

          <div class="modal fade" id="insertModal" role="dialog">
           <div class = "modal-dialog">
             <form class="popup-form" name="Add View" method="post" action="submitView.php">
              <font color="blue"> MFirst(*): </font> <input type="text" name="fname" required><p></p>
              <font color="blue"> MLast(*) </font> <input type="text" name="lname" required><p></p>
              <font color="blue"> Birthday: </font> <input type="text" placeholder="YYYY-MM-DD" name="bday" required><p></p>
              <font color="blue"> Street(*) </font> <input type="text" name="str" required=""><p></p>
              <font color="blue"> Num(*): </font> <input type="text" name="num" required><p></p>
              <font color="blue"> City(*): </font> <input type="text" name="city" required><p></p>
              <button type ="submit" name="submit" value="submitView"> Insert in view </button>
            </form>
           </div>
          </div>

          <div class="modal fade" id="deleteModal" role="dialog">
           <div class = "modal-dialog">
              <form class="popup-form" name="Delete View" method="post" action="submitView.php">
                <font color="blue">Member ID(*): </font><input type="text" name="mid" required><p></p>
                <button type ="submit" name="submit" value="deleteView" action="submitView.php"> Delete from view </button>
              </form>
            </div>
          </div>
        </div>
      </div>



  </body>
</html>
