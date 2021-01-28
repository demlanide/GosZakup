<?php
    	require 'db.php';
        $name = $_POST['name']; //from name="checkbox[]"
       	$role = $_POST['role'];
        $id  =$_POST['id'];
		$email = $_POST['email'];
        $sql = "UPDATE users SET name='$name',email='$email',status='$role'  WHERE id_user = '$id'";
        $result = $db->query($sql) or die(mysqli_error($db));
		if($result){ echo "Сохранено успешно";}else{echo "Error: ".mysqli_error($db);}
?>