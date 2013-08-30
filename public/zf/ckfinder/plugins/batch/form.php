<div style=\"padding: 20px \"> 
	<h2>Загрузка нескольких файлов</h2>
	<p>&nbsp; &nbsp; Требуется браузер, поддерживающий HTML5</p>
	<p>&nbsp; &nbsp; Для загрузки нескольких файлов выберите их в открывшемся диалоговом окне (откроется при клике на кнопку "Выбрать файлы")</p>

	<form action='/public/zf/ckfinder/core/connector/php/connector.php?command=FileUpload&type=<?=$_GET['type'] ?>&currentFolder=<?=$_GET['currentFolder'] ?>' method='post' enctype='multipart/form-data'> 
	 <input type='hidden' name='selected_folder' value='"+ currentFolder +"'> 
	 <input name='upload[]' size='60' type=file multiple > &nbsp; &nbsp; 
	 <input type='submit'>
	</form>
    
    <div>&nbsp; &nbsp; Загрузка больших файлов может занять время.<br />
    	 &nbsp; &nbsp; Учтите: настройки сервера позволяют загружать до <?=ini_get('max_file_uploads') ?> файлов за раз.<br />
   		 &nbsp; &nbsp; Остальные <a href="?<?=rand(1,99999) ?>" onClick="document.getElementById('restrictions').style.display = 'block'; return false">ограничения конфигурации</a>.
    </div>
    <ul id="restrictions" style="display: none; list-style-position: inside; margin-left: 20px">
     	<li>Наибольший размер файла: <?=ini_get('upload_max_filesize') ?> </li>
        <li>Общий объем файлов: <?=ini_get('post_max_size') ?> </li>
        <li>Выделено памяти: <?=ini_get('memory_limit') ?> (учтите: обработка RBG изображений требует в среднем в 4 раза больше памяти) </li>
        <li>Сервер прекратит выполнение запроса через <?=ini_get('max_execution_time') ?> секунд</li>
    </ul>
</div>