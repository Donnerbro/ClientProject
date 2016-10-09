<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Projects</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php
// filmlist.php?cid=2
$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT p.name, p.description, p.start_date, p.end_date, c.client_id, c.name from project p, client c
where p.project_id = ?
AND c.client_id=p.client_client_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($pnam, $pdesc, $pstart, $pend, $cid, $cnam);
?>

<?php
while($stmt->fetch()) {
echo '<h1>'.$pnam.'</h1>';
echo '<h3><a href="index.php">Back to Project List</a></h3>'; 
echo '<h2>Description:</h2>'.$pdesc;
echo '<h2>Date of Project start:</h2>'.$pstart;
echo '<h2>Date of Project End:</h2>'.$pend;
echo '<h2>Client for this Project:</h2><a href="client.php?cid='.$cid.'">'.$cnam.'</a>';
}
?>


<hr>
<div id="updbox">
<h1>Update project description</h1>
<form method="post">
<textarea rows="10" cols="60" name="pdesc"></textarea><br>
<input type="submit" name="update" value="Update">
</form>
<?php

if (isset($_POST['update'])) {
$pdesc = filter_input(INPUT_POST, 'pdesc');
$sql = 'update project p
set p.description = ?
where p.project_id = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('si', $pdesc, $pid);
$stmt->execute();
header ('refresh:0');
}
?>
</div>


<?php
$sql = 'SELECT r.r_name, r.resource_id, t.r_type_name
from resource r, project p, resource_has_project rp, type_code t
where p.project_id = ?
AND p.project_id = rp.project_project_id
AND r.resource_id = rp.resource_resource_id
AND r.type_code_r_type_code = t.r_type_code';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($rnam, $rid, $rtnam);
?>
<div id="resbox">
<h1>Resource For This Project</h1>
<h3><a href="resourcelist.php">See list of Resources</a></h3>
<?php
while($stmt->fetch()) {
echo '<h4>Resource Name:</h4><a href="resource.php?rid='.$rid.'">'.$rnam.'</a>';
echo '<h4>Job:</h4>'.$rtnam.'<hr>';
}
?>
</div>
 
<div id="addbox">
<h1>Add Resource to Project</h1>
<form method="post">
	<select name="rid"> 
    <?php
$sql = 'select r.resource_id, r_name, t.r_type_name
from resource r, type_code t
Where r_type_code = type_code_r_type_code';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rid, $rnam, $tynam);
while ($stmt->fetch()) {
	echo '<option value="'.$rid.'">'.$rnam.' ('.$tynam.')</option>'.PHP_EOL; 
}
?>
	</select>
	<h2>Start Dato</h2>
	<input type="date" name="start">
    <h2>Slut Dato</h2>
    <input type="date" name="end">
    <h2>Hourly Usage Rate</h2>
    <input type="number" name="hur"><br>
    <input type="submit" name="add">
</form>

<?php
if (isset($_POST['add'])) {
$rstart = filter_input(INPUT_POST, 'start');
$rend = filter_input(INPUT_POST, 'end');
$hur = filter_input(INPUT_POST, 'hur');
$rid = filter_input(INPUT_POST, 'rid'); 
$sql = 'INSERT INTO resource_has_project
VALUES (?, ?, ?, ?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('iissi', $rid, $pid, $rstart, $rend, $hur);
$stmt->execute();
header ('refresh:0');
}
?>
</div>

<!-- *********************************************************************** -->
<div id="delbox">
<h1>Remove resource from project</h1>

<form method="post">
<select name="rid"> 
    <?php
$sql = 'select r.resource_id, r_name, t.r_type_name
from resource r, type_code t
Where r_type_code = type_code_r_type_code';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rid, $rnam, $tynam);
while ($stmt->fetch()) {
	echo '<option value="'.$rid.'">'.$rnam.' ('.$tynam.')</option>'.PHP_EOL; 
}
?>
	</select>
	<input type="submit" name="delRes" value="Delete">
    </form>

<?php
$rid = filter_input(INPUT_POST, 'rid');
if (isset($_POST['delRes'])) {
 
$sql = 'delete from resource_has_project
where resource_resource_id = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $rid);
$stmt->execute();
header ('refresh:0');
}
?>
</div>




</body>
</html>