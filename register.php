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
    require("config.php");
    include("nav_links.html");

    //declaring variables to prevent errors and hacking
    $psn = $serverName = $email = $confirmEmail = $enterLeague = $password = $confirmPwd = $dateOfReg = $error_array = ""; 

    //validating and stripping inputs on form
    if(isset($_POST['regBtn'])) {
        $psn = strip_tags($_POST['psn']);
        $psn = str_replace(' ','',$psn);
    } 
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
    } 
    if(isset($_POST['confirmEmail'])) {
        $confirmEmail = $_POST['confirmEmail'];
    } 
    if ($email != $confirmEmail) {
        echo "emails don't match";
    }
    // TODO: add a check for "." in email address    
    if(isset($_POST['password'])) {
        $password = strip_tags($_POST['password']);
    } 
    if(isset($_POST['confirmPwd'])) {
        $confirmPwd = strip_tags($_POST['confirmPwd']);
    } 
    if ($password != $confirmPwd) {
        echo "passwords don't match";
    }

    $dateOfReg = date("Y-m-d");

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
            <label for="email">Your email address (optional but recommended to receive update news on leagues and results. No one else can see your email address)</label>
            <input type="email" name="email">
        </div>

        <div class="box regd" id="confirmEmail">
            <label for="confirmEmail">Confirm Email</label>
            <input type="email" name="confirmEmail">
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