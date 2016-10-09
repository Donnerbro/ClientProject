<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT  c.name, c.address, z.zip, z.City, c.contact_name, c.contact_phone, p.name, p.project_id
from project p, client c, zip z
where c.client_id = ?
AND c.client_id=p.client_client_id
AND c.zip_zip = z.zip';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $cid);
$stmt->execute();
$stmt->bind_result($cnam, $cadd, $zzip, $zcity, $ccn, $ccp, $pnam, $pid);
?>

<ul>
<?php
while($stmt->fetch()) {
echo '<h1>'.$cnam.'</h1>'; 
echo '<li><h2>Client Address:</h2>'.$cadd.'</li>';
echo '<li><h2>Zip Code:</h2>'.$zzip.'</li>';
echo '<li><h2>City:</h2>'.$zcity.'</li>';
echo '<li><h2>Client Contact Name:</h2>'.$ccn.'</li>';
echo '<li><h2>Client Contact Phone:</h2>'.$ccp.'</li>';
echo '<li><h2>Project Name:</h2><a href="project.php?pid='.$pid.'">'.$pnam.'</a></li>';
}
?>
</ul>
</body>
</html>