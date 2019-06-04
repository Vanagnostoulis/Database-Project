/*Εμφάνισε το ονοματεπώνυμο των συγγραφέων των οποίων έστω και ένα βιβλίο έχει δανειστεί μέσω της βιβλιοθήκης
Χρησιμοποιήθηκαν: join - in
*/
select distinct AFirst, ALast
from (Written_by  join Author using(AuthID))
where (
  ISBN in (select ISBN from Borrows)
);



/*Εμφάνισε τους 2 υψηλότερους μισθούς, χωρίς την χρήση του order by.
Χρησιμοποιήθηκαν:  nested query - aggregate query - not in*/
select
  (SELECT MAX(Salary) FROM Employee) maxsalary,
  (SELECT MAX(Salary) FROM Employee
  WHERE Salary NOT IN (SELECT MAX(Salary) FROM Employee )) as 2nd_max_salary;




  /*Εμφάνισε τους χρήστες που οφείλουν βιβλία σε φθείνουσα σειρά ως προς τον αριθμό οφειλόμενων βιβλίων, καθώς και τον αριθμό των βιβλίων.
  Χρησιμοποιήθηκαν: order by - join - group by - nested query - aggregate query
  */
  select Member_Id, MFirst, MLast, x.num_of_books
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


  /*Εμφάνισε το ονοματεπώνυμο όσων έχουν δανειστεί τουλάχιστον ένα βιβλίο που ανήκει στην κατηγορία υπολογιστών.
  Χρησιμοποιήθηκαν: join - like*/
  select distinct MFirst, MLast
  from Member join ((Borrows join Book using (ISBN)) join Belongs_to using (ISBN) )  using (Member_Id)
  where (
    CategoryName like '%computer%'
  );

/*Βρες το ονοματεπώνυμο όσων μελών έχουν δανειστεί περισσότερα απο 53 διαφορετικά βιβλία
Χρησιμοποιήθηκαν: group by with having - join -  nested query - aggregate query
 */
select Member_Id, MFirst, MLast
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

/*Εμφάνισε τον μισθό των 5 υπαλλήλων που έχουν στείλει τις περισσότερες υπενθυμίσεις.
Χρησιμοποιήθηκαν: order by - join - nested query - limit - aggregate query*/

select salary
from (
  select EmpID, count(ISBN) as cnt1
  from Reminder
  group by (EmpID)) as x join Employee using (EmpID)
order by cnt1 desc
LIMIT 5;


/*Εμφάνισε χρήστες οι οποίοι οφείλουν επιστροφή βιβλίου ή έχουν δανειστεί γενικά λιγότερες απο 10 φορές
Χρησιμοποιήθηκαν: Union - group by - join*/
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
