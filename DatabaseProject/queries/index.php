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
    <title>Queries</title>
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
<div class = "Queries">
    <div class="content">
      <div class = "insert-form">
        <center><h1> Querie 1</h1></center>
        <div class = "query_description">Εμφάνισε το ονοματεπώνυμο των συγγραφέων των οποίων έστω και ένα βιβλίο έχει δανειστεί μέσω της βιβλιοθήκης.<br>
          Χρησιμοποιήθηκαν: join - in<p></p>
          <center><h3> Querie:</h3></center>
          select distinct AFirst, ALast<br>
          from (Written_by  join Author using(AuthID))<br>
          where (<br>
            ISBN in (select ISBN from Borrows)<br>
          );<br>
          <center><h3> Output:</h3></center>
        </div>
        <?php
        $sql = "select distinct AFirst, ALast from (Written_by  join Author using(AuthID)) where (ISBN in (select ISBN from Borrows));";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<table class = "table"><tr><th>First Name </th><th>Last Name</th></tr>';

            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["AFirst"]."</td><td>".$row["ALast"]." </td></tr>";
            }
            echo "</table>";
        } else {
            echo "Empty set";
        }
        ?>
      </div>

      <div class = "query-form">
        <center><h1> Querie 2</h1></center>
        <div class = "query_description">Εμφάνισε τους 2 υψηλότερους μισθούς, χωρίς την χρήση του order by. <br>
          Χρησιμοποιήθηκαν:  nested query - aggregate query - not in<p></p>
          <center><h3> Querie:</h3></center>
          select<br>
                      (SELECT MAX(Salary) FROM Employee) maxsalary,<br>
                      (SELECT MAX(Salary) FROM Employee<br>
                      WHERE Salary NOT IN (SELECT MAX(Salary) FROM Employee )) as 2nd_max_salary;<br>
          <center><h3> Output:</h3></center>
        </div>
        <?php
        $sql = "select
                    (SELECT MAX(Salary) FROM Employee) maxsalary,
                    (SELECT MAX(Salary) FROM Employee
                    WHERE Salary NOT IN (SELECT MAX(Salary) FROM Employee )) as 2nd_max_salary;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<table class = "table"><tr><th>Max Salary </th><th>Second Max Salary</th></tr>';

            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["maxsalary"]."</td><td>".$row["2nd_max_salary"]." </td></tr>";
            }
            echo "</table>";
        } else {
            echo "Empty set";
        }
        ?>
      </div>

        <div class = "query-form">
          <center><h1> Querie 3</h1></center>
          <div class = "query_description">
            Εμφάνισε τους χρήστες που οφείλουν βιβλία σε φθείνουσα σειρά ως προς τον αριθμό οφειλόμενων βιβλίων, καθώς και τον αριθμό των βιβλίων.<br>
            Χρησιμοποιήθηκαν: order by - join - group by - nested query - aggregate query<p></p>
            <center><h3> Querie:</h3></center>
            select Member_Id, MFirst, MLast, x.num_of_books <br>
                     from(<br>
                       (select Member_Id, count(ISBN) as num_of_books<br>
                       from (<br>
                         Borrows<br>
                       )<br>
                       where Day_Returned IS NULL<br>
                       group by Member_Id<br>
                       ) as x<br>
                       join<br>
                       Member<br>
                       using(Member_Id)<br>
                     )<br>
                     order by(num_of_books) desc;<br>

              <center><h3> Output:</h3></center>

            </div>
          <?php
          $sql = "  select Member_Id, MFirst, MLast, x.num_of_books
                    from(
                      (select Member_Id, count(ISBN) as num_of_books
                      from (
                        Borrows
                      )
                      where Day_Returned IS NULL
                      group by Member_Id
                      ) as x
                      join
                      Member
                      using(Member_Id)
                    )
                    order by(num_of_books) desc;
                  ";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              echo '<table class = "table"><tr><th>Member_Id </th><th>First Name </th><th>Last Name</th><th>Books Number</th></tr>';

              // output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>".$row["Member_Id"]."</td><td>".$row["MFirst"]." </td><td>".$row["MLast"]." </td><td>".$row["num_of_books"]." </td></tr>";
              }
              echo "</table>";
          } else {
              echo "Empty set";
          }
          ?>
        </div>

        <div class = "query-form">
          <center><h1> Querie 4</h1></center>
          <div class = "query_description">
            Εμφάνισε το ονοματεπώνυμο όσων έχουν δανειστεί τουλάχιστον ένα βιβλίο που ανήκει στην κατηγορία υπολογιστών.<br>
            Χρησιμοποιήθηκαν: join - like<p></p>
            <center><h3> Querie:</h3></center>
            select distinct MFirst, MLast<br>
            from Member join ((Borrows join Book using (ISBN)) join Belongs_to using (ISBN) )  using (Member_Id)<br>
            where (<br>
              CategoryName like '%computer%'<br>
            );<br>

              <center><h3> Output:</h3></center>

            </div>
          <?php
          $sql = " select distinct MFirst, MLast
                    from Member join ((Borrows join Book using (ISBN)) join Belongs_to using (ISBN) )  using (Member_Id)
                    where (
                      CategoryName like '%computer%'
                    );
                  ";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              echo '<table class = "table"><tr><th>First Name </th><th>Last Name</th></tr>';

              // output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>".$row["Member_Id"]."</td><td>".$row["MFirst"]." </td><td>".$row["MLast"]." </td><td>".$row["num_of_books"]." </td></tr>";
              }
              echo "</table>";
          } else {
              echo "Empty set";
          }
          ?>
        </div>

        <div class = "query-form">
          <center><h1> Querie 5</h1></center>
          <div class = "query_description">
            Βρες το ονοματεπώνυμο όσων μελών έχουν δανειστεί περισσότερα απο 53 διαφορετικά βιβλία
            <br>Χρησιμοποιήθηκαν: group by with having - join -  nested query - aggregate query<p></p>
            <center><h3> Querie:</h3></center>
            select Member_Id, MFirst, MLast<br>
            from(<br>
              (select Member_Id, count(ISBN) as cnt<br>
              from (<br>
                Borrows<br>
              )<br>
              group by Member_Id<br>
              having cnt > 53<br>
              ) as x<br>
              join<br>
              Member<br>
              using(Member_Id)<br>
            );<br>

              <center><h3> Output:</h3></center>

            </div>
          <?php
          $sql = " select Member_Id, MFirst, MLast
                    from(
                      (select Member_Id, count(ISBN) as cnt
                      from (
                        Borrows
                      )
                      group by Member_Id
                      having cnt > 53
                      ) as x
                      join
                      Member
                      using(Member_Id)
                    );
                  ";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              echo '<table class = "table"><tr><th>Member_Id</th><th>First Name </th><th>Last Name</th></tr>';

              // output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>".$row["Member_Id"]."</td><td>".$row["MFirst"]." </td><td>".$row["MLast"]." </td></tr>";
              }
              echo "</table>";
          } else {
              echo "Empty set";
          }
          ?>
        </div>


        <div class = "query-form">
          <center><h1> Querie 6</h1></center>
          <div class = "query_description">
            Βρες το ονοματεπώνυμο όσων μελών έχουν δανειστεί περισσότερα απο 53 διαφορετικά βιβλία
            <br>Χρησιμοποιήθηκαν: group by with having - join -  nested query - aggregate query<p></p>
            <center><h3> Querie:</h3></center>

            select salary<br>
            from (<br>
              select EmpID, count(ISBN) as cnt1<br>
              from Reminder<br>
              group by (EmpID)) as x join Employee using (EmpID)<br>
            order by cnt1 desc<br>
            LIMIT 5;<br>

              <center><h3> Output:</h3></center>

            </div>
          <?php
          $sql = "
                select salary
                from (
                  select EmpID, count(ISBN) as cnt1
                  from Reminder
                  group by (EmpID)) as x join Employee using (EmpID)
                order by cnt1 desc
                LIMIT 5;
                  ";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              echo '<table class = "table"><tr><th>Salary</th></tr>';

              // output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>".$row["salary"]."</td></tr>";
              }
              echo "</table>";
          } else {
              echo "Empty set";
          }
          ?>
        </div>



        <div class = "query-form">
          <center><h1> Querie 7</h1></center>
          <div class = "query_description">
            Εμφάνισε χρήστες οι οποίοι οφείλουν επιστροφή βιβλίου ή έχουν δανειστεί γενικά λιγότερες απο 10 φορές
            <br>Χρησιμοποιήθηκαν: Union - group by - join<p></p>
            <center><h3> Querie:</h3></center>
            select distinct Member_Id<br>
            from Borrows<br>
            where Day_Returned is NULL<br>
            UNION<br>
            select distinct Member_Id<br>
            from (Borrows join<br>
              ((select Member_Id, count(ISBN) as cnt<br>
              from Borrows<br>
              group by Member_Id) as x) using (Member_Id ))<br>
            where cnt < 10;<br>

              <center><h3> Output:</h3></center>

            </div>
          <?php
          $sql = "
                select distinct Member_Id
                from Borrows
                where Day_Returned is NULL
                UNION
                select distinct Member_Id
                from (Borrows join
                ((select Member_Id, count(ISBN) as cnt
                from Borrows
                group by Member_Id) as x) using (Member_Id ))
                where cnt < 10;
                  ";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              echo '<table class = "table"><tr><th>Member ID</th></tr>';

              // output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>".$row["Member_Id"]."</td></tr>";
              }
              echo "</table>";
          } else {
              echo "Empty set";
          }
          ?>
        </div>
</div>

    </div>
  </body>
</html>
