
<ul class="menu menu-sm menu-bordery">
          <li class="menu-item">
            <a class="menu-link" href="/index.php">
              <span class="icon ti-home"></span>
              <span class="title">Dashboard</span>
            </a>
          </li>

          <li class="menu-item">
            <a class="menu-link" href="../manage_user">
              <span class="icon ti-user"></span>
              <span class="title">Пользователи</span>
            </a>
          </li>
	
          <li class="menu-item">
            <a class="menu-link" href="/product1.php">
              <span class="icon ti-receipt"></span>
              <span class="title">Поиск тендеров</span>
              <span class="badge badge-pill badge-info">2</span>
            </a>
          </li>
	
	<li class="menu-item">
            <a class="menu-link" href="/fastfilter.php">
              <span class="icon ti-receipt"></span>
              <span class="title">Сохраненные фильтры</span>
            </a>
          </li>
	
	<li class="menu-item">
            <a class="menu-link" href="/takenlotslist.php">
              <span class="icon ti-receipt"></span>
              <span class="title">Выгруженные лоты</span>
            </a>
          </li>
	
	<li class="menu-item">
            <a class="menu-link" href="/favourite-list.php">
              <span class="icon ti-receipt"></span>
              <span class="title">Избранные лоты</span>
            </a>
          </li>
	
		<li class="menu-item">
            <a class="menu-link" href="/otchet.php">
              <span class="icon ti-receipt"></span>
              <span class="title">Модуль отчетности</span>
            </a>
          </li>
	
	<li class="menu-item">
            <a class="menu-link" href="/new-lot.php">
              <span class="icon ti-receipt"></span>
              <span class="title">Создать фильтр</span>
            </a>
          </li>

<!--<li class="menu-item">
            <a class="menu-link" href="/settings.php">
              <span class="icon ti-settings"></span>
              <span class="title">Настройки</span>
            </a>
          </li>
-->
<?php // if($_SESSION['login'] == 'ads'){
//	echo '';
//}?>
		<iframe id="modal" src="../manage_filter/" height="80px" align="center" display="flex" position="fixed">
		Ваш браузер не поддерживает плавающие фреймы!
	 </iframe>
	<li class="menu-item">
		<center><button class="btn-xs btn-primary" onclick="showmodal()" type="submit">Синхронизировать</button></center>
    </li>
        </ul>
<script>
document.getElementById("modal").style.display ="none";
function showmodal(){
if(document.getElementById("modal").style.display =="none"){
document.getElementById("modal").style.display = "block";
}else{
document.getElementById("modal").style.display ="none"
}
}

</script>