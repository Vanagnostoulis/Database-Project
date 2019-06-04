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

  $optionbook = '';
  $sql = "SELECT Title FROM Book ORDER BY Title ASC";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $optionbook .= '<option value = "'.$row['Title'].'">'.$row['Title'].'</option>';
  }

  $optionmname = '';
  $sql = "SELECT MFirst,MLast FROM Member ORDER BY MLast ASC";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $optionmname.= '<option value = "'.$row['MFirst'].' '.$row['MLast'].'">'.$row['MFirst'].' '.$row['MLast'].'</option>';
  }
?>

<!DOCTYPE html>
<html>
  <head>
  <title>Borrows</title>
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

        <center><h1>Borrowings</h1></center>

        <?php
        $sql = "select br.Member_Id, MFirst, MLast, br.ISBN, Title, br.CopyNumber, Borrowing_Day , Returning_Day , Day_Returned from Borrows as br, Book as b, Copies as c, Member as m where m.Member_Id = br.Member_Id and br.ISBN =b.ISBN and c.CopyNumber = br.CopyNumber and c.ISBN =b.ISBN order by MLast asc;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Member ID</th><th>Name</th><th>ISBN </th><th>Title</th><th>Copy Number</th><th>Borrowing Day</th><th>Returning Day</th><th>Day Returned</th></tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["Member_Id"]."</td><td>".$row["MLast"]." ".$row["MFirst"]."</td><td>".$row["ISBN"]."</td><td>".$row["Title"]."</td><td>".$row["CopyNumber"]."</td><td>".$row["Borrowing_Day"]."</td><td>".$row["Returning_Day"]."</td><td>".$row["Day_Returned"]."</td></tr>";
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

        <div class="modal fade" id="updateModal" role="dialog">
          <div class = "modal-dialog">
            <form class="popup-form" name="Update Borrows" method="post" action="submitBorrows.php"><p></p>
              <font color="blue"> Member ID(*): </font> <input type="text" name="mid" required><p></p>
              <font color="blue"> ISBN(*): </font> <input type="text" name="isbn" required><p></p>
              <font color="blue"> Copy Number(*): </font> <input type="text" name="cnum" required><p></p>
              <font color="blue">Borrowing Day(*): </font> <input type="text" placeholder="YYYY-MM-DD" name="bday" required><p></p>
              <font color="blue">Returning Day: </font> <input type="text" placeholder="YYYY-MM-DD" name="retday"><p></p>
              <font color="blue">Day returned:  </font> <input type="text" placeholder="YYYY-MM-DD" name="returned"  ><p></p>
              <button type ="submit" name="submit" value="updateBorrows" action="submitBorrows.php"> Update Borrows </button>
            </form>
          </div>
        </div>

          <div class="modal fade" id="insertModal" role="dialog">
           <div class = "modal-dialog">
           <form class="popup-form" name="Add Borrows" method="post" action="submitBorrows.php">
              <font color="blue"> Member </font>
                <select name= "name" value= "">
                  <?php echo $optionmname; ?>
                </select><p></p>
              <font color="blue"> Title of the book </font>
                <select name= "title" value= "">
                  <?php echo $optionbook; ?>
                </select><p></p>
              <button type ="submit" name="submit" value="submitBorrows"> Borrow </button>
              </form>
            </div>
          </div>

          <div class="modal fade" id="deleteModal" role="dialog">
           <div class = "modal-dialog">
              <form class="popup-form" name="Delete Borrows" method="post" action="submitBorrows.php">
                <font color="blue">Member ID(*): </font><input type="text" name="mid" required><p></p>
                <font color="blue">ISBN(*): </font><input type="text" name="isbn" required><p></p>
                <font color="blue">Copy Number(*): </font><input type="text" name="cnum" required><p></p>
                <font color="blue">Borrowing Day(*): </font><input type="text" placeholder="YYYY-MM-DD" name="bday" required><p></p>
                <button type ="submit" name="submit" value="deleteBorrows" action="submitBorrows.php"> Delete </button>
              </form>
            </div>
          </div>
        </div>
      </div>



  </body>
</html>
