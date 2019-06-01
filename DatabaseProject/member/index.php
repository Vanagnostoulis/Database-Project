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
    <title>Members</title>
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
          </ul>
        </div>
    </nav>

    <div class="content">
      <div class = "insert-form">
        <center><h1> Current Members</h1></center>
        <?php
        $sql = "SELECT * FROM Member";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<table class = "table"><tr><th>ID</th><th>Name</th><th>Birthday</th><th>Address</th></tr>';

            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["Member_Id"]."</td><td>".$row["MFirst"]." ".$row["MLast"]."</td><td>".$row["MBirthday"]."</td><td>".$row["Street"]." ".$row["Num"].", ".$row["Postal_Code"].", ".$row["City"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Empty set";
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
            <form class="popup-form" name="Update Member" method="post" action="submitMember.php">
              <font color="blue"> ID: </font><input type="text" name="mid" required=""><p></p>
              <font color="blue"> First Name: </font> <input type="text" name="fname"><p></p>
              <font color="blue"> Last Name: </font> <input type="text" name="lname"><p></p>
              <font color="blue"> Street: </font> <input type="text" name="str">
              <font color="blue"> Street Number: </font><input type="text" name="no" size = "3">
              <font color="blue"> Postal Code: </font><input type="text" name="pc" size = "6"><p></p>
              <font color="blue"> City: </font><input type="text" name="city"><p></p>
              <font color="blue"> Birthday </font>
                  <select name= "day">
                    <option value = ""> Day </option>
                    <option value = "01"> 1 </option>
                    <option value = "02"> 2 </option>
                    <option value = "03"> 3 </option>
                    <option value = "04"> 4 </option>
                    <option value = "05"> 5 </option>
                    <option value = "06"> 6 </option>
                    <option value = "07"> 7 </option>
                    <option value = "08"> 8 </option>
                    <option value = "09"> 9 </option>
                    <option value = "10"> 10 </option>
                    <option value = "11"> 11 </option>
                    <option value = "12"> 12 </option>
                    <option value = "13"> 13 </option>
                    <option value = "14"> 14 </option>
                    <option value = "15"> 15</option>
                    <option value = "16"> 16</option>
                    <option value = "17"> 17</option>
                    <option value = "18"> 18</option>
                    <option value = "19"> 19 </option>
                    <option value = "20"> 20</option>
                    <option value = "21"> 21 </option>
                    <option value = "22"> 22 </option>
                    <option value = "23"> 23 </option>
                    <option value = "24"> 24 </option>
                    <option value = "25"> 25 </option>
                    <option value = "26"> 26 </option>
                    <option value = "27"> 27 </option>
                    <option value = "28"> 28 </option>
                    <option value = "29"> 29 </option>
                    <option value = "30"> 30 </option>
                    <option value = "31"> 31 </option>
                  </select>
                  <select name= "month">
                    <option value = ""> Month </option>
                    <option value = "01"> Jan </option>
                    <option value = "02"> Feb </option>
                    <option value = "03"> Mar </option>
                    <option value = "04"> Apr </option>
                    <option value = "05"> May </option>
                    <option value = "06"> Jun </option>
                    <option value = "07"> Jul </option>
                    <option value = "08"> Aug </option>
                    <option value = "09"> Sep </option>
                    <option value = "10"> Oct </option>
                    <option value = "11"> Nov </option>
                    <option value = "12"> Dec </option>
                  </select>
                  <select name= "year">
                    <option value = ""> Year </option>
                    <option value = "2001"> 2001 </option>
                    <option value = "2000"> 2000 </option>
                    <option value = "1999"> 1999 </option>
                    <option value = "1998"> 1998 </option>
                    <option value = "1997"> 1997 </option>
                    <option value = "1996"> 1996 </option>
                    <option value = "1995"> 1995 </option>
                    <option value = "1994"> 1994 </option>
                    <option value = "1993"> 1993 </option>
                    <option value = "1992"> 1992 </option>
                    <option value = "1991"> 1991 </option>
                    <option value = "1990"> 1990 </option>
                    <option value = "1989"> 1989 </option>
                    <option value = "1988"> 1988 </option>
                    <option value = "1987"> 1987 </option>
                    <option value = "1986"> 1986 </option>
                    <option value = "1985"> 1985 </option>
                    <option value = "1984"> 1984 </option>
                    <option value = "1983"> 1983 </option>
                    <option value = "1982"> 1982 </option>
                    <option value = "1981"> 1981 </option>
                    <option value = "1980"> 1980 </option>
                    <option value = "1979"> 1979 </option>
                    <option value = "1978"> 1978 </option>
                    <option value = "1977"> 1977 </option>
                    <option value = "1976"> 1976 </option>
                    <option value = "1975"> 1975 </option>
                    <option value = "1974"> 1974 </option>
                    <option value = "1973"> 1973 </option>
                    <option value = "1972"> 1972 </option>
                    <option value = "1971"> 1971 </option>
                    <option value = "1970"> 1970 </option>
                  </select><p></p>
              <button type ="submit" name="submit" value="updateMember" action="submitMember.php"> Update Member </button>
            </form>
            </div>
          </div>
          <div class="modal fade" id="insertModal" role="dialog">
           <div class = "modal-dialog">
              <form class="popup-form" name="Add Member" method="post" action="submitMember.php">
                <font color="blue">First Name: </font>
                <input type="text" name="fname" required><p></p>
                <font color="blue">Last Name: </font>
                <input type="text" name="lname" required><p></p>
                <font color="blue">Birthday </font>
                <select name= "day" required>
                  <option value = ""> Day </option>
                  <option value = "01"> 1 </option>
                  <option value = "02"> 2 </option>
                  <option value = "03"> 3 </option>
                  <option value = "04"> 4 </option>
                  <option value = "05"> 5 </option>
                  <option value = "06"> 6 </option>
                  <option value = "07"> 7 </option>
                  <option value = "08"> 8 </option>
                  <option value = "09"> 9 </option>
                  <option value = "10"> 10 </option>
                  <option value = "11"> 11 </option>
                  <option value = "12"> 12 </option>
                  <option value = "13"> 13 </option>
                  <option value = "14"> 14 </option>
                  <option value = "15"> 15</option>
                  <option value = "16"> 16</option>
                  <option value = "17"> 17</option>
                  <option value = "18"> 18</option>
                  <option value = "19"> 19 </option>
                  <option value = "20"> 20</option>
                  <option value = "21"> 21 </option>
                  <option value = "22"> 22 </option>
                  <option value = "23"> 23 </option>
                  <option value = "24"> 24 </option>
                  <option value = "25"> 25 </option>
                  <option value = "26"> 26 </option>
                  <option value = "27"> 27 </option>
                  <option value = "28"> 28 </option>
                  <option value = "29"> 29 </option>
                  <option value = "30"> 30 </option>
                  <option value = "31"> 31 </option>
                </select>
                <select name= "month" required>
                  <option value = ""> Month </option>
                  <option value = "01"> Jan </option>
                  <option value = "02"> Feb </option>
                  <option value = "03"> Mar </option>
                  <option value = "04"> Apr </option>
                  <option value = "05"> May </option>
                  <option value = "06"> Jun </option>
                  <option value = "07"> Jul </option>
                  <option value = "08"> Aug </option>
                  <option value = "09"> Sep </option>
                  <option value = "10"> Oct </option>
                  <option value = "11"> Nov </option>
                  <option value = "12"> Dec </option>
                </select>
                <select name= "year" required>
                  <option value = ""> Year </option>
                  <option value = "2001"> 2001 </option>
                  <option value = "2000"> 2000 </option>
                  <option value = "1999"> 1999 </option>
                  <option value = "1998"> 1998 </option>
                  <option value = "1997"> 1997 </option>
                  <option value = "1996"> 1996 </option>
                  <option value = "1995"> 1995 </option>
                  <option value = "1994"> 1994 </option>
                  <option value = "1993"> 1993 </option>
                  <option value = "1992"> 1992 </option>
                  <option value = "1991"> 1991 </option>
                  <option value = "1990"> 1990 </option>
                  <option value = "1989"> 1989 </option>
                  <option value = "1988"> 1988 </option>
                  <option value = "1987"> 1987 </option>
                  <option value = "1986"> 1986 </option>
                  <option value = "1985"> 1985 </option>
                  <option value = "1984"> 1984 </option>
                  <option value = "1983"> 1983 </option>
                  <option value = "1982"> 1982 </option>
                  <option value = "1981"> 1981 </option>
                  <option value = "1980"> 1980 </option>
                  <option value = "1979"> 1979 </option>
                  <option value = "1978"> 1978 </option>
                  <option value = "1977"> 1977 </option>
                  <option value = "1976"> 1976 </option>
                  <option value = "1975"> 1975 </option>
                  <option value = "1974"> 1974 </option>
                  <option value = "1973"> 1973 </option>
                  <option value = "1972"> 1972 </option>
                  <option value = "1971"> 1971 </option>
                  <option value = "1970"> 1970 </option>
                </select><p></p>
                <font color="blue"> Street: </font> <input type="text" name="str" required>
                <font color="blue"> Street Number: </font><input type="text" name="no" size = "3" required>
                <font color="blue"> Postal Code: </font><input type="text" name="pc" size = "6" required><p></p>
                <font color="blue"> City: </font>
                <input type="text" name="city" required><p></p>
                <button type ="submit" name="submit" value="addMember" action="submitMember.php"> Add Member </button>
              </form>
            </div>
          </div>

          <div class="modal fade" id="deleteModal" role="dialog">
           <div class = "modal-dialog">
              <form name="Delete Member" method="post" action="submitMember.php">
              <font color="blue">ID: </font>
              <input type="text" name="mid" required><p></p>
              <button type ="submit" name="submit" value="deleteMember" action="submitMember.php"> Delete </button>
            </div>
          </div>
        </div>
      </div>


  </body>


</html>
