use db;

# =====================================================================
# =========== CHECKK THE AVAILABILITY OF THE BOOK =====================
DELIMITER $$
drop trigger if exists checkIfBorrowed;
CREATE TRIGGER checkIfBorrowed
	BEFORE INSERT ON Borrows
	FOR EACH ROW
	BEGIN
		IF (select COUNT(ISBN) from Borrows where (NEW.ISBN = ISBN and NEW.CopyNumber = CopyNumber and Day_Returned is NULL)) =1 THEN 
			SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "This book is already borrowed.";
    	END IF;
END $$
DELIMITER ;
# =========== CHECKK THE AVAILABILITY OF THE BOOK =====================
# =====================================================================

# =====================================================================
# === CHECKK IF MEMBER HAS LESS THAN FIVE BOOKS CURRENTLY BORROWED ====
DELIMITER $$
drop trigger if exists checkIfLessThanFive;
CREATE TRIGGER checkIfLessThanFive
	BEFORE INSERT ON Borrows
	FOR EACH ROW
	BEGIN
		IF (select COUNT(ISBN) from Borrows where (NEW.Member_Id = Member_Id and Day_Returned is NULL)) >= 5 THEN 
		SIGNAL SQLSTATE '45001' SET MESSAGE_TEXT = "This user has more than five active copies";
    	END IF;
END $$
DELIMITER ;
# === CHECKK IF MEMBER HAS LESS THAN FIVE BOOKS CURRENTLY BORROWED ====
# =====================================================================

# =====================================================================
# CHECKK IF MEMBER HAS RETURNED ALL HIS BORROWED BOOKS BEFORE RETURNING DAY
DELIMITER $$
drop trigger if exists checkIfBooksAreReturned;
CREATE TRIGGER checkIfBooksAreReturned
	BEFORE INSERT ON Borrows
	FOR EACH ROW
	BEGIN
		IF (select COUNT(ISBN) from Borrows where (NEW.Member_Id = Member_Id and Day_Returned is NULL and New.Borrowing_Day >= Returning_Day)) >= 1 THEN 
		SIGNAL SQLSTATE '45002' SET MESSAGE_TEXT = "This user has to return his books before he rents new ones";
    	END IF;
END $$
DELIMITER ;
# CHECKK IF MEMBER HAS RETURNED ALL HIS BORROWED BOOKS BEFORE RETURNING DAY
# =====================================================================

# =====================================================================
# ================= INSTEAD OF CHECK(DAY_RET> BORROWING_DAY)===========
DELIMITER $
CREATE TRIGGER `dates_before_insert` BEFORE INSERT ON Borrows
FOR EACH ROW
BEGIN
    IF NEW.Day_Returned < NEW.Borrowing_Day THEN
		SIGNAL SQLSTATE '45010' SET MESSAGE_TEXT = "Returning Day must be later than Borrowing Day";
    END IF;
END$   
DELIMITER ; 
-- before update

DELIMITER $
CREATE TRIGGER `dates_before_update` BEFORE UPDATE ON Borrows
FOR EACH ROW
BEGIN
    IF NEW.Day_Returned < NEW.Borrowing_Day THEN
		SIGNAL SQLSTATE '45011' SET MESSAGE_TEXT = "Returning Day must be later than Borrowing Day";
    END IF;
END$   
DELIMITER ; 

DELIMITER $
CREATE TRIGGER `remind_dates_before_insert` BEFORE INSERT ON Reminder
FOR EACH ROW
BEGIN
    IF NEW.Reminder_Day < NEW.Borrowing_Day THEN
		SIGNAL SQLSTATE '45012' SET MESSAGE_TEXT = "Reminder Day must be later than Borrowing Day";
    END IF;
END$   
DELIMITER ; 
-- before update

DELIMITER $
CREATE TRIGGER `remind_ates_before_update` BEFORE UPDATE ON Reminder
FOR EACH ROW
BEGIN
    IF NEW.Reminder_Day < NEW.Borrowing_Day THEN
		SIGNAL SQLSTATE '45013' SET MESSAGE_TEXT = "Reminder Day must be later than Borrowing Day";
    END IF;
END$   
DELIMITER ; 

# ================= INSTEAD OF CHECK(DAY > BORROWING_DAY)==============
# =====================================================================


# =====================================================================
# ===== SET RETURNING DAY +30 DAYS OF THE DAY THAT IT WAS BORROWED ====
drop trigger if exists setReturn;
CREATE TRIGGER setReturn 
	BEFORE INSERT ON Borrows
	FOR EACH ROW 
	SET NEW.Returning_Day := DATE_ADD(NEW.Borrowing_Day,INTERVAL 30 DAY)
# ===== SET RETURNING DAY +30 DAYS OF THE DAY THAT IT WAS BORROWED ====
# =====================================================================