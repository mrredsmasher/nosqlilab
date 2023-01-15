<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>NoSQL Attack Lab - User Lookup</title>
	<meta name="description" content="Robin's NoSQL attack lab" />
	<link rel='stylesheet' href='/css/style.css'>
	<script src="/lab.js" type="text/javascript"></script>
</head>
<body>
	<div style="float:right"><img src="/digininja_avatar.png" alt="DigiNinja avatar" /></div>
	<h1>User Lookup Challenge</h1>
	<p><a href="/">&laquo; Home</a></p>
	<p>
		Get the details of an administrator. To get you started, sid is a user of the system<br />
		Bonus - Get the admin's password.
	</p>
	<p>
		Please enter a username below to look up their details.
	</p>
<?php
if (array_key_exists ("username", $_GET)) {
	require ("debug.php");
	$username = $_GET['username'];
	$type = $_GET['type'];

	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

	$filter = [ "type" => $type, "username" => $username ] ;
	$options = [];
	$query = new MongoDB\Driver\Query($filter, $options);
	$rows = $manager->executeQuery('sans.users', $query);

	$row_count = 0;
	foreach($rows as $user){
		if (array_key_exists ("fullname", $user)) {
			?>
			<p>
				<?php echo $user->_id, ': ' . $user->type . " - " . $user->fullname . " (" . $user->phone . ")<br />\n"; ?>
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
	<label for="username">Enter a username: </label><input type="text" id="username" name="username" value="" />
	<input type="submit" value="Guess" />
</form>

</body>
</html>
