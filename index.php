<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="style.css" title="Styl podstawowy" rel="stylesheet" type="text/css"/>
<title>Policz swoją sieć!</title>
</head>
<body>


<?php
include('class.php');
include('form.html');
?>
<div class='site'>
<?php 


if(isset($_GET['ip']) && isset($_GET['mask'])) {

	main($_GET['ip'], $_GET['mask']);

} 

?>
</div>
</body>
</html>