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
    $password = "password";
    $db = "rf_league_db";
    $conn = new mysqli($servername, $username, $password, $db);
    include("nav_links.html");

    //declaring variables to prevent errors and hacking
    $psn = $serverName = $email = $confirmEmail = $enterLeague = $password = $confirmPwd = $dateOfReg = $error_array = "";

    //validating and stripping inputs on form
    if (isset($_POST['regBtn'])) {

        $psn = strip_tags($_POST['psn']);
        $psn = str_replace(' ', '', $psn);
        $email = $_POST['email'];
        $confirmEmail = $_POST['confirmEmail'];

        if ($email == $confirmEmail) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $emailCheck = mysqli_query($conn, "SELECT Email FROM player WHERE Email = '$email'");
                $numRows = mysqli_num_rows($emailCheck);
                //echo "Error: " . mysqli_error($conn);
                //echo $numRows;
                if ($numRows > 0) {
                    echo "this email aready exists";
                } else {
                    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                }
            } else {
                echo "email is not a valid format";
            }
        } else {
            echo "emails don't match";
        }

        $password = strip_tags($_POST['password']);
        $confirmPwd = strip_tags($_POST['confirmPwd']);

        if ($password != $confirmPwd) {
            echo "passwords don't match";
        }
        else {
            if(!preg_match("/^[a-zA-Z0-9]$/", $password)) {
                echo "password can only contain English characters or numbers";
            }
            else {
                echo "password is fine";
            }
        }

        $dateOfReg = date("Y-m-d");
    }

    ?>

    <form action="register.php" method="POST">
        <div class="box rega"><label for="psn">What is your PSN ID?</label>
            <input type="text" name="psn" required>
            <!-- TODO: need code here to test if player already exists on db, and if so, test if has a login. If no login, then continue with form.  If user has a login then go to login form. -->
        </div>

        <div class="box regb" id="serverSelect">
            <label for="server">Select your local server:</label>
            <select name="server" required>
                <option value="europe">Europe</option>
                <option value="usaeast">USA East</option>
                <option value="usawest">USA West</option>
                <option value="australia">Australia</option>
                <option value="Asia">Asia</option>
                <option value="canada">Canada East</option>
                <option value="india">India</option>
                <option value="japan">Japan</option>
                <option value="russia">Russia</option>
                <option value="russiaeast">Russia East</option>
                <option value="samerica">South America</option>
                <option value="skorea">South Korea</option>
            </select>
        </div>

        <div class="box regc" id="email">
            <label for="email">Your email address (optional but recommended to receive league updates. No one can see your email)</label>
            <input type="email" name="email" placeholder="Email address (optional)">
        </div>

        <div class="box regd" id="confirmEmail">
            <label for="confirmEmail">Confirm your email</label>
            <input type="email" name="confirmEmail" placeholder="Confirm Email">
        </div>

        <div class="box rege" id="enterLeague">
            <label for="enterLeague">Would you like to enter yourself into next season's league? </label>
            <select name="enterLeague" required>
                <option value="yes">Yes please!</option>
                <option value="no">Not right now, but maybe later!</option>
            </select>
        </div>

        <div class="box regf" id="password">
            <label for="password">Create a password</label>
            <input type="password" name="password">
        </div>

        <div class="box regg" id="confirmPwd">
            <label for="confirmPwd">Confirm your new password</label>
            <input type="password" name="confirmPwd">
        </div>

        <div class="box regh" id="submit">
            <label for="submit">Submit Form</label>
            <input type="submit" name="regBtn" value="register">
        </div>

    </form>


</body>

</html>