<?php

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

    $filePath = str_replace('typo3conf/ext/pmtodo/Resources/Public/Script/upload.php', 'uploads/',$_SERVER["SCRIPT_FILENAME"]);

	if(move_uploaded_file($_FILES['upl']['tmp_name'], $filePath.'tx_pmtodo/'.$_FILES['upl']['name'])){
		echo 'uploads/tx_pmtodo/'.$_FILES['upl']['name'];
		exit;
	}
}
exit;