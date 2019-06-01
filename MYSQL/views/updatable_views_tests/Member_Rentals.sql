use db;

#UPDATABLE VIEW
drop view if exists Rentals;
CREATE VIEW Rentals AS
SELECT *
FROM  Member as m 
inner join Borrows as b
on m.Member_Id = b.Member_Id
inner join Book as bk
on b.ISBN= bk.ISBN

# if i want to insert i have to insert first in MFirst, MLast and then to the rest
# Can not modify more than one base table through a join view
# need triggers when im going to insert a rental ry

#insert into Rentals (MFirst,MLast,MBirthday,Street) values ('dsa','efa',CURRENT_DATE(),'e');
#insert into Rentals (Title, NumPages, PubYear, PubName) values ('dsa', 124 , '1992','e');
 