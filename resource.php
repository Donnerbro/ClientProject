<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<h2><a href="resourcelist.php">Back to Resourcelist</a></h2>

<?php
$rid = filter_input(INPUT_GET, 'rid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT r.r_name, r.resource_detail, t.r_type_name
FROM resource r, type_code t
WHERE r.resource_id = ?
AND R_type_code = type_code_r_type_code';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $rid);
$stmt->execute();
$stmt->bind_result($rnam, $rdt, $tynam);
?>
<ul>
<?php
while($stmt->fetch()) {
echo '<h2>Name of Person:</h2>'.$rnam;
echo '<h2>Details:</h2>'.$rdt;
echo '<h2>Job:</h2>'.$tynam;
}

?>

<?php
$sql = 'SELECT p.name, p.project_id
FROM project p, resource_has_project rp, resource r
WHERE r.resource_id = ?
AND p.project_id = rp.project_project_id
AND r.resource_id = rp.resource_resource_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $rid);
$stmt->execute();
$stmt->bind_result($pnam, $pid);
?>

<?php
while($stmt->fetch()) {
echo '<h2>Works on:</h2>'.$pnam;
echo '<h2>Project ID:</h2>'.$pid;

}
?>
</ul>


</body>
</html>