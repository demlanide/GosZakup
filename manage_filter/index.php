
<!DOCTYPE html>
<html lang="en">
	<head>
	<link href="../../assets/css/core.min.css" rel="stylesheet">
    <link href="../../assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
  	</head>
		<input type="text" id="filter_keycode" name="suit"class="form-control" value="" placeholder="Введите товар/услугу">
  <a style="background-color: #48B0F7; margin-top: 10px; border-radius: 5px; color:white; padding:5px; cursor: pointer;" onclick="addToFilters()">Отправить</a>
    <script src="../../assets/js/core.min.js"></script>
    <script src="../../assets/js/app.min.js"></script>
  <script>
	
	function addToFilters(){
		var keycode = document.getElementById("filter_keycode").value;
		$.ajax({
			type: 'POST',
			url: 'addTofilter.php',
			data: { 
				'keycode': keycode
			},
			success: function(msg){
				alert(msg);
			}
		});
	}
  </script>	
</html>
