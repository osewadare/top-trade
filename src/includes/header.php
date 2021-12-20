<?php

require_once('config/db.php');
require_once('models/user.php');
$db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if ($db->connect_errno) {
	echo 'Database connection problem: ' . $db->connect_errno;
	exit();
}

// If not signed in just proceed
// If signed in determine if Artisan or Admin and then instantitate that class 

$user = new User($db);


?>


<!DOCTYPE html>
<html>
<head>
<meta name="author" content="Top Trade">
<meta name="description" content="">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Top Trade: Only the best</title>

<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon.png">

<!-- Custom Style CSS -->
<link rel="stylesheet" href="assets/css/stylesheet.css">

<!--Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&display=swap&subset=latin-ext,vietnamese" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800" rel="stylesheet" type="text/css">

</head>

<body>

<?php

 $currentPath = basename($_SERVER['PHP_SELF']);

	if (!$user->is_logged() && $currentPath != "register.php") 
    {
        /*include('login.php');

		include('includes/footer.php');

		exit();*/

	}
?>
