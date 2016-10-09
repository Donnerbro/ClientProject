<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Resource List</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<h1>Resource List</h1>
<h3><a href="index.php">See list of Projects</a></h3>

<?php
require_once 'dbcon.php';

$sql = 'SELECT r.resource_id, r.r_name FROM resource r';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rid, $rnam);

while($stmt->fetch()) {
	echo '<h1><a href="resource.php?rid='.$rid.'">'.$rnam.'</a></h1>'.PHP_EOL;
}
?>

<h1>Add New Resource</h1>
<form method="post">
	<h2>Name</h2>
	<input type="text" name="R_name">
    <h2>Description</h2>
    <input type="text" name="R_dt">
    <h2>Job</h2>
    <select name="rtc">
    <?php
$sql = 'select t.r_type_code, t.r_type_name
from type_code t';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rtc, $rtnam);
while ($stmt->fetch()) {
	echo '<option value="'.$rtc.'">'.$rtnam.'</option>'.PHP_EOL;
}
?>
	</select>
    <input type="submit" name="add">
</form>

<?php
if (isset($_POST['add'])) {
$rnam = filter_input(INPUT_POST, 'R_name');
$rdt = filter_input(INPUT_POST, 'R_dt');
$rtc = filter_input(INPUT_POST, 'rtc');


$sql = 'INSERT INTO resource
VALUES (null, ?, ?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('ssi', $rnam, $rdt, $rtc);
$stmt->execute();
header ('refresh:0');
}
?>
</ul>

</body>
</html>