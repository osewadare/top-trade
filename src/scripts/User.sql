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
ADD COLUMN Username varchar(50);


ALTER TABLE Users
DROP COLUMN UserPassword;

ALTER TABLE Users
ADD COLUMN UserPassword varchar(100)

USE toptrade;
SELECT * FROM USERs


USE toptrade;
CREATE TABLE Trades (
    Id int NOT NULL AUTO_INCREMENT,
    Name varchar(50),
	Description varchar(50),
	PRIMARY KEY (Id)
);


USE toptrade;
CREATE TABLE ArtisanTrades (  
    
    artisanId int,
	tradeId int,

    FOREIGN KEY (artisanId) REFERENCES Users(Id),
    FOREIGN KEY (tradeId) REFERENCES Trades(Id)

);

SELECT tradeId, name FROM ArtisanTrades LEFT JOIN Trades ON ArtisanTrades.tradeId = Trades.Id  WHERE artisanId = "1"; 

SELECT tradeId, name FROM ArtisanTrades LEFT JOIN Trades ON ArtisanTrades.tradeId = Trades.Id WHERE artisanId = 1

SELECT Id FROM Trades WHERE name in ('Plumbing', 'Carpentry')

UPDATE ArtisanTrades SET tradeId=2 WHERE artisanId = 1 

SELECT * FROM ArtisanTrades


ALTER TABLE Trades
ADD imageurl varchar(500);

ALTER TABLE Users
ADD isAvailable int;

USE toptrade;
ALTER TABLE Users
ADD COLUMN HourlyRate varchar(10);



CREATE TABLE ArtisanProfRegistrations (  
    
	Id int NOT NULL AUTO_INCREMENT,
    artisanId int,
    tradeId int,
	profReg varchar(1000),

	PRIMARY KEY (Id),
    FOREIGN KEY (artisanId) REFERENCES Users(Id),
    FOREIGN KEY (tradeId) REFERENCES Trades(Id)
);

SELECT profReg, tradeId, Name FROM ArtisanProfRegistrations A LEFT JOIN Trades B ON A.tradeId = B.Id WHERE A.artisanId = 1


CREATE TABLE Cities (  
    
	Id int NOT NULL AUTO_INCREMENT,
    Name varchar(100),
	PRIMARY KEY (Id)

);


ALTER TABLE Users
ADD isAvailable int;

ALTER TABLE Users
ADD CONSTRAINT FK_UserCity
FOREIGN KEY (City) REFERENCES City(Id); 