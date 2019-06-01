use db;

# NOT UPDATABLE VIEW, CONTAINS GROUP BY
drop view if exists DetailsofBooks;
CREATE VIEW DetailsofBooks AS
SELECT Title, ALast, AFirst, bt.CategoryName, p.PubName, PubYear, Number_of_Copies, av.Available
FROM Author a, Written_by w, Book b, Belongs_to bt, Category c, Publisher p,
	(
		# FIND MAXIMUN NUMBER OF COPIES OF A BOOK 
		Select ISBN, count(CopyNumber) as Number_of_Copies 
		FROM Copies 
		GROUP BY ISBN
	) as cp,
	(
		# FIND THE AVAILABLE NUMBER OF COPIES
		SELECT c.ISBN, COUNT(c.CopyNumber) as Available FROM Copies AS c
		LEFT JOIN
		(
			# FIND NOT AVAILABLE NUMBER OF COPIES
			SELECT ISBN,CopyNumber 
			FROM Borrows b
			WHERE Day_Returned is NULL
		) AS na
		ON (c.ISBN = na.ISBN AND c.CopyNumber = na.CopyNumber)
		WHERE na.ISBN is NULL
		GROUP BY c.ISBN
	) AS av
WHERE a.AuthID = w.AuthID AND b.ISBN = w.ISBN AND b.ISBN = bt.ISBN AND c.CategoryName = bt.CategoryName AND av.ISBN=b.ISBN AND b.PubName = p.PubName AND cp.ISBN = b.ISBN 