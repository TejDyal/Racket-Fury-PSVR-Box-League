<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Players Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class=wrapper>
        <?php
            include ("nav_links.html");
        ?>


        <div class="box ab" id="aTitle"> Racket Fury PSVR Box Leagues</div>
        <div class="box ac" id="aSubtitle1">A Racket Fury Non Profit Community Fan Website</div>
        <div class="box ad" id="aLeague">
            <form action="/action_page.php">
                <label for="region">Select a region:</label>
                <select name="region" id="region">
                  <option value="europe">Europe</option>
                  <option value="russia">Russia</option>
                  <option value="asia">Asia</option>
                  <option value="america">America</option>
                </select>
              </form>
        </div>        
    </div>
</body>
</html>