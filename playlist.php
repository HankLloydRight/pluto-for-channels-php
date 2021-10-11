<?

// note: This PHP file is symlinked to playlist.m3u 
// The following line added to .htaccess: 
// Addhandler application/x-httpd-php .html .php .m3u .m3u8
// This makes the php file appear as a static .m3u file, but is regenerated on each access

date_default_timezone_set("America/New_York");
header('Access-Control-Allow-Origin: *');
header($_SERVER["SERVER_PROTOCOL"].' 200 OK', true, 200);
header('Content-Type: application/octet-stream', true);
header('Content-Disposition: attachment; filename=playlist.m3u');

// generates a V1 UUID
include("uuid.inc");

// generates a V4 uuid
function guidv4() {
	$data=openssl_random_pseudo_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

//generate a mac address for the entire run
$mac=implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));

// source.m3u is regenerated every 3 hours from the Maddox repo script
$file=file("source.m3u");
$i=0;
foreach ($file as $f){
	if (strpos($f,"DEVICEID")!==false) {
		$uuid4=guidv4();
		$uuid1=gen_uuid_timebased($mac);
		//echo "uuid1: $uuid1 \t uuid4: $uuid4\r\n";
		$file[$i]=str_replace(array("DEVICEID","SID"),array($uuid1,$uuid4),$f);
	}
	echo $file[$i];
	$i++;
}

?>
