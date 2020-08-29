<?php

/* 

This procedure preps a new season for a specific league (db design accounts for possibility of different season start dates for each league. )

PSUEDO CODE

Admin sets up a new season 


add new league-season in League-season table

insert dates for new season into league-season table

add new season number to season table if it doesn't exist.

First sesason players sorting into divisions will be based on self assessment but future seasons will be based on previous season performance and self assessment for new players.


[
First season sort:
Add new season number into season table if not existing. (sql proc done)
select all players (player_id) of specific league ordered by self rating, starting from 1 (Good) to 3 (beginner). (sql proc done)
Store sequence of player_ids result into a new table called Sorted (sql proc done)

set noOfDivs (in this league, in this season) to number of player_ids divided by 5 rounded up to nearest integer {sql proc done)}

Set CurrentMaxDiv to the highest div_id number in division table (sql proc done)
while noOfDivs greater than CurrentMaxDiv Do:
    add new row with value: CurrentMaxDiv+1 into Sorted
    increment CurrentMaxDiv
end while                     (sql Proc done)
    
set divCount = 1
set divPlayerscount = 0
for each player id row in Sorted
  update columns: league, season, division_id
  increment divPlayersCount
  if divplayers = 5 then
    increment divCount
    reset divPlayersCount to 0
    
append sorted rows to division_player table.   (sql Proc done)


]



*/

?>