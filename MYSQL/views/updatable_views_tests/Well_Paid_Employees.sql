use db;

# AN EASY UPDATABLE VIEW
drop view if exists WellPaidEmployees;
CREATE VIEW WellPaidEmployees AS
SELECT EFirst, ELast, Salary
FROM  Employee e  
WHERE Salary > 1000