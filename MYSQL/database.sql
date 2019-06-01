drop Database if exists db;
create Database db;
use db;

create table  Member (
	Member_Id 		int unsigned auto_increment,
    MFirst  		varchar(64) not null,
    MLast  			varchar(64) not null,
	MBirthday 		date not null,
	Street			varchar(64) not null,
	Num 			smallint unsigned,
	Postal_Code     int unsigned,
	City     		varchar(64),
	primary key (Member_Id)
);

create table  Publisher (
	PubName			varchar(100) not null,
    EstYear  		year  not null,   
	Street			varchar(64) not null,
	Num 			smallint unsigned,
	Postal_Code     int unsigned,
	City     		varchar(64),
	primary key (PubName)
);	

create table  Book (
	ISBN 			bigint unsigned not null,
    Title 	 		varchar(100) not null,
	NumPages 		smallint unsigned not null,
    PubYear  		year  not null,
	PubName			varchar(100) not null,
    foreign key (PubName) references Publisher(PubName)
	on update cascade
	on delete cascade,
	primary key (ISBN)
);	

create table  Author (
	AuthID 			int unsigned auto_increment,
    AFirst  		varchar(64) not null,
    ALast  			varchar(64) not null,
	ABirthday 		date,
	primary key (AuthID)
);

create table  Category (
	CategoryName	varchar(64) not null,
	SuperCategory	varchar(64),
	primary key (CategoryName),
	foreign key (SuperCategory) references Category(CategoryName)
	on update cascade
	on delete cascade
);

create table  Copies (
	ISBN			bigint unsigned not null,
	CopyNumber		int unsigned not null,
	Shelf			varchar(64) not null,
	primary key (ISBN,CopyNumber),
	foreign key (ISBN) references Book(ISBN)
	on update cascade
	on delete cascade
);

create table  Employee (
	EmpID			int unsigned auto_increment,
	EFirst  		varchar(64) not null,
    ELast  			varchar(64) not null,
	Salary 			int unsigned not null,
	primary key (EmpID)
);	

create table  Permanent_Employee (
	EmpID			int unsigned not null,
	HiringDate		date not null,
	primary key (EmpID),
	foreign key (EmpID) references Employee(EmpID)
	on update cascade
	on delete cascade
);	

create table  Temporary_Employee (
	EmpID			int unsigned not null,
	ContractNum		smallint unsigned not null,
	primary key (EmpID),
	foreign key (EmpID) references Employee(EmpID)
	on update cascade
	on delete cascade
);	

create table  Borrows (
	Member_Id 		int unsigned not null,	
	ISBN			bigint unsigned not null,
	CopyNumber		int unsigned not null,
	Borrowing_Day	date not null,
	Returning_Day	date, 
	Day_Returned 	date,
	foreign key (Member_Id) references Member(Member_Id)
	on update cascade
	on delete cascade,
	foreign key (ISBN) references Book(ISBN)
	on update cascade
	on delete cascade,
 	foreign key (ISBN,CopyNumber) references Copies(ISBN,CopyNumber)
	on update cascade
	on delete cascade,
	primary key (Member_Id,ISBN,CopyNumber,Borrowing_Day)
);

create table  Belongs_to (
	ISBN			bigint unsigned not null,
	CategoryName	varchar(64) not null,
	foreign key (ISBN) references Book(ISBN)
	on update cascade
	on delete cascade,
	foreign key (CategoryName) references Category(CategoryName)
	on update cascade
	on delete cascade,
	primary key (ISBN,CategoryName)
);	

create table  Reminder (
	EmpID 			int unsigned not null,	
	Member_Id 		int unsigned not null,	
	ISBN			bigint unsigned not null,
	CopyNumber		int unsigned not null,
	Borrowing_Day	date not null,
	Reminder_Day	date not null,
	foreign key (EmpID) references Employee(EmpID)
	on update cascade
	on delete cascade,
	foreign key (Member_Id) references Member(Member_Id)
	on update cascade
	on delete cascade,
	foreign key (ISBN) references Book(ISBN)
	on update cascade
	on delete cascade,
	foreign key (ISBN,CopyNumber) references Copies(ISBN,CopyNumber)
	on update cascade
	on delete cascade,
	primary key (EmpID,Member_Id,ISBN,CopyNumber,Borrowing_Day,Reminder_Day)
);

create table  Written_by(
	ISBN			bigint unsigned not null,
	AuthID			int unsigned not null,
	foreign key (ISBN) references Book(ISBN)
	on update cascade
	on delete cascade,
	foreign key (AuthID) references Author(AuthID)
	on update cascade
	on delete cascade,
	primary key (ISBN,AuthID)
);	
