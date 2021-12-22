USE toptrade;
CREATE TABLE ArtisanTrades (  
    
    artisanId int,
	tradeId int,

    FOREIGN KEY (artisanId) REFERENCES Users(Id),
    FOREIGN KEY (tradeId) REFERENCES Trades(Id)

);
