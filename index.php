<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Project List</title>
</head>

<body>

<h1>Project List</h1>


<?php
require_once 'dbcon.php';

$sql = 'SELECT p.project_id, p.name FROM project p';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($pid, $pnam);

while($stmt->fetch()) {
	echo '<h1><a href="project.php?pid='.$pid.'">'.$pnam.'</a></h1>'.PHP_EOL;
}


?>


</body>
</html>