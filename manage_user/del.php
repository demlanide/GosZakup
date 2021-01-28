<?php

    require 'db.php';
    $delete=$_POST['delete'];

        $checkbox = $_POST['cbox']; //from name="checkbox[]"
        $countCheck = count($_POST['cbox']);

        for($i=0;$i<$countCheck;$i++)
        {
            $del_id  = $checkbox[$i];
			echo $del_id;
            $sql = "DELETE from users where id_user = '$del_id'";
            $result = $db->query($sql) or die(mysqli_error($db));
			echo $result;

        }
            if($result)
        {   
                header('Location: https://gz.open-k.com/manage_user/');
            }
            else
            {
                echo "Error: ".mysqli_error($db);
            }
    

?>