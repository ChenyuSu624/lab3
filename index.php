<?php
include "inc/functions.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Lab 3: SilverJack</title>
        <link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
    </head>
    <style>
        @import url(css/styles.css);
    </style>
    <body>
        <h1>SilverJack</h1>
        <!-- TODO: 
            Display cards and player images correctly.
            Players' pictures and corresponding names are displayed RANDOMLY.
            The winner gets the SUM of ALL the points (currently it's just what they earned).
        -->
        <div id="gameUI">
            <?php
              demo();
            ?>
        </div>
        
        <form>
            <input type="submit" value="Play Again!"/>
        </form>
    </body>
    <footer>
        <hr>
        <br /><strong>CST336 Internet Programming. Lab3 By: Aymeric, Cody, Chenyu, Devin</strong><br />
        <br />
        <img id="otter" src="img/otter.png" alt="CSUMB Logo" />
    </footer>
</html>