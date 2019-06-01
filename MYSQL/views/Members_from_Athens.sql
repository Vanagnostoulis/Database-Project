use db;

# AN EASY UPDATABLE VIEW
drop view if exists Athens_members;
CREATE VIEW Athens_members AS
SELECT Member_Id, MFirst, MLast, MBirthday, Street, Num, City
FROM  Member as m 
WHERE City like '%Athens%'
WITH CASCADED CHECK OPTION;