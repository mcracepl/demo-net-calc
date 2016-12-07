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