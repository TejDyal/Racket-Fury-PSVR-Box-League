<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resgiter into the Players Database</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    //connect to db
    $servername = "localhost:3306";
    $username = "Normal User";
    $pwd = "password";
    $db = "rf_league_db";
    $conn = mysqli_connect($servername, $username, $pwd, $db);
    include("nav_links.html");

    //declaring variables to prevent errors and hacking
    $psn = $email = $confirmEmail = $enterLeague = $password = $confirmPwd = $dateOfReg = "";
    $errorArray = array();
    $serverNames = array();

    //fetch Racket Fury server list from db to show on form
    $result = mysqli_query($conn, "SELECT Server_id, serverName FROM server");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($serverNames, $row["serverName"]);
        }
    }



    //validating inputs on form and prepping the values before sending to DB
    if (isset($_POST['regBtn'])) {

        $psn = strip_tags($_POST['psn']);
        $psn = str_replace(' ', '', $psn);

        // According to Playstation site, Each Online ID must contain between three and 16 characters, and can consist of letters, numbers, hyphens (-) and underscores (_).
        $psnCheck = mysqli_query($conn, "SELECT PSN_id FROM player WHERE PSN_id = '$psn'");
        $numRows = mysqli_num_rows($psnCheck);

        if ($numRows > 0) {
            array_push($errorArray, "this PSN ID aready exists<br>");
        } else 
        if (preg_match("/[^a-zA-Z0-9\-_]/", $psn) || strlen($psn) < 3 || strlen($psn) > 16) {
            array_push($errorArray, "Invalid PSN ID<br>");
        }

        
        $serverNameSelected = $_POST['server'];


        $email = $_POST['email'];
        $confirmEmail = $_POST['confirmEmail'];

        if ($email == $confirmEmail) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $emailCheck = mysqli_query($conn, "SELECT Email FROM player WHERE Email = '$email'");
                $numRows = mysqli_num_rows($emailCheck);

                if ($numRows > 0) {
                    array_push($errorArray, "this email aready exists<br>");
                } else {
                    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                }
            } else {
                array_push($errorArray, "email is not a valid email format<br>");
            }
        } else {
            array_push($errorArray, "emails don't match<br>");
        }

        $enterLeague = $_POST['enterLeague'];

        $selfRating = $_POST['selfRating'];

        $password = strip_tags($_POST['password']);
        $confirmPwd = strip_tags($_POST['confirmPwd']);

        if ($password != $confirmPwd) {
            array_push($errorArray, "passwords don't match<br>");
        } else {
            if (preg_match("/[^a-zA-Z0-9]/", $password)) {
                array_push($errorArray, "password can only contain English characters or numbers<br>");
            } else {
                if (strlen($password) < 5 || strlen($password) > 25) {
                    array_push($errorArray, "password length must be between 5 and 25 characters<br>");
                }
            }
        }

        
        // on no errors after sbmitting form, prep other information before sending to DB
        if (empty($errorArray)) {

            $dateOfReg = date("Y-m-d");
        
            //encrypt password
            $password = md5($password);

            // assign a default profile pic
            do {
                $pics = scandir("assets/images/profile_pics/defaults/");
                $rand = rand(2, count($pics) - 1);
                $profilePic = $pics[$rand];
            } while (!preg_match("/\.png$/i", $profilePic));
            echo $profilePic;

            //match server id rom DB for the servername selected
            $result = mysqli_query($conn, "SELECT Server_id FROM server WHERE serverName = ('$serverNameSelected')");
            $row = mysqli_fetch_assoc($result);
            $serverId = $row["Server_id"];
        }

        //submit form data to DB
        $result = mysqli_query($conn, "INSERT INTO player (`PSN_id`, `Email`, `activeInLeague`, `enterInNextLeague`, `standard`, `Server_id`, `dateRegistered`, `pwd`, `profilePic`) VALUES ('$psn','$email', '0', '$enterLeague', '$selfRating', '$serverId', '$dateOfReg', '$password', '$profilePic')");

        if (!$result) {
            print_r(mysqli_error_list($conn));
        }
        else{ echo "Success"; }


    }



    ?>



    <form action="register.php" method="POST">
        <div class="box rega"><label for="psn">What is your PSN ID?</label>
            <input type="text" name="psn" value="<?php echo $psn ?>" required>
            <?php
            if (in_array("Invalid PSN ID<br>", $errorArray)) echo "Invalid PSN ID<br>";
            else if (in_array("this PSN ID aready exists<br>", $errorArray)) echo "this PSN ID aready exists<br>"
            ?>
            <!-- TODO: need code here to test if player already exists on db (DONE), and if so, test if has a login. If no login, then continue with form.  If user has a login then go to login form. (Login form yet to be implemented) -->
        </div>

        <!-- this is a dropdown select list cycles through the servers list array -->
        <div class="box regb" id="serverSelect">
            <label for="server">Select your local server:</label>
            <select name="server" required>
                <?php
                foreach ($serverNames as $server) {
                ?>
                    <option value="<?php echo $server; ?>" <?php if (isset($_POST['server']) && $_POST['server'] == $server)
                                                                echo 'selected= "selected"' ?>><?php echo $server; ?> </option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="box regc" id="email">
            <label for="email">Your email address (optional but recommended)</label>
            <input type="email" name="email" placeholder="Email address (optional)" value="<?php echo $email ?>">
        </div>

        <div class="box regd" id="confirmEmail">
            <label for="confirmEmail">Confirm your email</label>
            <input type="email" name="confirmEmail" placeholder="Confirm Email" value="<?php echo $confirmEmail ?>">
            <?php
            if (in_array("this email aready exists<br>", $errorArray)) echo "this email aready exists<br>";
            else if (in_array("email is not a valid email format<br>", $errorArray)) echo "email is not a valid email format<br>";
            else if (in_array("emails don't match<br>", $errorArray)) echo "emails don't match<br>";
            ?>
        </div>

        <div class="box rege" id="enterLeague">
            <label for="enterLeague">Would you like to enter yourself into next season's league? </label>
            <select name="enterLeague" required>
                <option value=1 <?php if (isset($_POST['enterLeague']) && $_POST['enterLeague'] == 1)
                                        echo 'selected= "selected"' ?>>Yes please!</option>
                <option value=0 <?php if (isset($_POST['enterLeague']) && $_POST['enterLeague'] == 0)
                                        echo 'selected= "selected"' ?>>Not right now, but maybe later!</option>
            </select>
        </div>

        <div class="box regf" id="selfRating">
            <label for="selfRating">How do you rate your playing ability?</label>
            <select name="selfRating" required>
                <option value="Beginner" <?php if (isset($_POST['selfRating']) && $_POST['selfRating'] == 'Beginner')
                                        echo 'selected= "selected"' ?>>Beginner!</option>
                <option value="Average" <?php if (isset($_POST['selfRating']) && $_POST['selfRating'] == 'Average')
                                        echo 'selected= "selected"' ?>>Average</option>
                <option value="Good" <?php if (isset($_POST['selfRating']) && $_POST['selfRating'] == 'Good')
                                        echo 'selected= "selected"' ?>>Good</option>


            </select>
        </div>

        <div class="box regg" id="password">
            <label for="password">Create a password</label>
            <input type="password" name="password" required>
        </div>

        <div class="box regh" id="confirmPwd">
            <label for="confirmPwd">Confirm your new password</label>
            <input type="password" name="confirmPwd" required>
            <?php
            if (in_array("passwords don't match<br>", $errorArray)) echo "passwords don't match<br>";
            else if (in_array("password can only contain English characters or numbers<br>", $errorArray)) echo "password can only contain English characters or numbers<br>";
            else if (in_array("password length must be between 5 and 25 characters<br>", $errorArray)) echo "password length must be between 5 and 25 characters<br>";
            ?>
        </div>

        <div class="box regi" id="submit">
            <label for="submit">Submit Form</label>
            <input type="submit" name="regBtn" value="register">
        </div>

    </form>


</body>

</html>