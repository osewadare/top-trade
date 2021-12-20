USE toptrade;
CREATE TABLE Users (
    Id int NOT NULL AUTO_INCREMENT,
    FirstName varchar(50),
	LastName varchar(50),
    Address varchar(255),
    Email varchar(50),
    PhoneNumber varchar(15),
    UserRole varchar(15),
    Username varchar(15),
    UserPassword varchar(15),
	PRIMARY KEY (Id)
);

ALTER TABLE Users
DROP COLUMN Username;

ALTER TABLE Users
ADD COLUMN Username varchar(50)