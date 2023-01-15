<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <title>NoSQL Attack Lab - Regex exploitation</title>
        <meta name="description" content="Robin's NoSQL attack lab" />
        <link rel='stylesheet' href='/css/style.css'>
        <script src="/lab.js" type="text/javascript"></script>
</head>
<body>
        <div style="float:right"><img src="/digininja_avatar.png" alt="DigiNinja avatar" /></div>
        <h1>User Lookup Challenge</h1>
        <p><a href="/">&laquo; Home</a></p>
        <p>
                Let's get some passwords!
        </p>
<?php

$password = @$_GET['password'];
$username = @$_GET['username'];
$type = @$_GET['type'];

if ($password !== null and $username !== null and $type !== null)
{

        require ("debug.php");

        $manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");

        $filter = [ "type" => $type, "username" => $username, "pwd" => $password] ;
        $options = [];
        $query = new MongoDB\Driver\Query($filter, $options);
        $rows = $manager->executeQuery('sans.users', $query);

        $row_count = 0;
        foreach($rows as $user){
                if (array_key_exists ("fullname", $user)) {
                        ?>
                        <p>
                                <?php echo "Hi " . $user->fullname . " <br/>\n"; ?>
                        </p>
                        <?php
                }

                $row_count++;
        }

        if ($row_count == 0) {
                ?>
                <p>User not found</p>
                <?php
        }
}
?>
<form method="GET">
        <input type="hidden" name="type" value="user" />
        <label for="username">Enter a username: </label>
        <input type="text" id="username" name="username" value="" /><br/>
        <label for="username">Enter a password: </label>
        <input type="text" id="password" name="password" value="" />
        <br/>
        <input type="submit" value="Guess" />
</form>
</body>
</html>
