<?php
if(isset($_GET['file']) && isset($_GET['filename'])){
	//echo "ass";
	$filename = $_GET['filename'];
	$file = $_GET['file'];
    $err = ''; 
	if (!$filename) {
	echo $err;
	} else {

		$path = "./".$file."/".$filename."";
		echo $path;
		if (file_exists($path) && is_readable($path)) {
		$size = filesize($path);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		$file = fopen($path, 'rb');
		if ($file) {
			//echo "ass";
		fpassthru($file);
		$_SESSION['msg'] = "Pdf document generated";
		header("Location: /selfservice/request_cash_details.php");
		return true;
		} else {
			//echo "aaaaa";
		echo $err;
		}
		} else {
			//echo $filename;
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
