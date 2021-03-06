<?php
	include_once('config.php');
	include_once('dbutils.php');
?>
<html>
<head>
	<title>
		<?php echo "Add Pay Stub " . $Title; ?>
	</title>

	<!-- Following three lines are necessary for running Bootstrap -->
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>	
</head>

<body>
<div class="container">

<!-- Page header -->
<div class="row">
<div class="col-xs-12">
<div class="page-header">
	<h1><?php echo "Add Pay Stub: " . $Title; ?></h1>
</div>
</div>
</div>

<?php
// Back to PHP to perform the search if one has been submitted. Note
// that $_POST['submit'] will be set only if you invoke this PHP code as
// the result of a POST action, presumably from having pressed Submit
// on the form we just displayed above.
if (isset($_POST['submit'])) {
//	echo '<p>we are processing form data</p>';
//	print_r($_POST);
	// get data from the input fields
	$paycheck = $_POST['paycheck'];
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$paydate = $_POST['paydate'];
	
	// check to make sure we have an email
	if (!$paycheck) {
		punt("Please enter the amount on your paycheck");
	}
	if (!$startdate) {
		punt("Please enter a start date");
	}
	if (!$enddate) {
		punt("Please enter a end date");
	}
		
	if (!$paydate) {
		punt("Please enter the date paycheck recieved ");
	}
	// check if email already in database
	// connect to database
	$db = connectDB($DBHost,$DBUser,$DBPassword,$DBName);
	
	// set up my query
	$query = "SELECT email FROM Employee WHERE email='$email';";
	
	// run the query
	$result = queryDB($query, $db);
	// check if the email is there
	if (nTuples($result) > 0) {
	   punt("The email address $email is already in the database");
	}
	
	// generate hashed password using the system-provided salt.
	$hashedPass = crypt($password1);
	
	// set up my query
	$query = "INSERT INTO Employee(email, hashedPass) VALUES ('$email', '$hashedPass');";
	print($query);
	
	// run the query
	$result = queryDB($query, $db);
	
	// tell users that we added the player to the database
	echo "<div class='panel panel-default'>\n";
	echo "\t<div class='panel-body'>\n";
	echo "\t\tThe user " . $email . " was added to the database\n";
	echo "</div></div>\n";
}
?>

<!-- Form to enter new users -->
<div class="row">
<div class="col-xs-12">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="form-group">
	<label for="paycheck">Please enter the amount on the paycheck</label>
	<input type="paycheck" class="form-control" name="paycheck"/>
</div>

<div class="form-group">
	<label for="startdate">Please enter the start date</label>
	<input type="startdate" class="form-control" name="startdate"/>
</div>

<div class="form-group">
	<label for="enddate">Please enter the end date</label>
	<input type="enddate" class="form-control" name="enddate"/>
</div>

<div class="form-group">
	<label for="paydate">Please enter the date paycheck recieved</label>
	<input type="paydate" class="form-control" name="paydate"/>
</div>


<button type="submit" class="btn btn-default" name="submit">Add</button>

</form>

</div>
</div>


<!-- Titles for table -->
<thead>
<tr>

</tr>
</thead>

<tbody>
<?php
	// connect to database
	$db = connectDB($DBHost,$DBUser,$DBPassword,$DBName);
	
	// set up my query
	$query = "SELECT email FROM Employee ORDER BY email;";
	
	// run the query
	$result = queryDB($query, $db);
	
	while($row = nextTuple($result)) {
		echo "\n <tr>";
		echo "<td>" . $row['email'] . "</td>";
		echo "</tr>";
	}
?>

</tbody>
</table>
</div>
</div>

</div> <!-- closing bootstrap container -->
</body>
</html>
