<?php
if(isset($_GET['to']) && isset($_GET['filename'])){
	$filename = $_GET['filename'];
    $err = ''; 
	if (!$filename) {
	echo $err;
	} else {

		$path = './document/'.$filename;
		if (file_exists($path) && is_readable($path)) {
		$size = filesize($path);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		$file = fopen($path, 'rb');
		if ($file) {
			echo "ass";
		fpassthru($file);
		return true;
		} else {
			//echo "aaaaa";
		echo $err;
		}
		} else {
			echo $filename;
		echo $err;
		}
}
}
/*function downloadfile($filename, $to_path){;
    $err = '';
	if (!$filename) {
	echo $err;
	} else {
		$path = './document/'.$filename;
		if (file_exists($path) && is_readable($path)) {
		$size = filesize($path);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		$file = fopen($path, 'rb');
		if ($file) {
		fpassthru($file);
		return true;
		} else {
		echo $err;
		}
		} else {
		echo $err;
		}
}
}*/

?>
