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

//generate a mac address for the entire run
$mac=implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));

// source.m3u is regenerated every 3 hours from the Maddox repo script
$file=file("source.m3u");
$i=0;
foreach ($file as $f){
	if (strpos($f,"DEVICEID")!==false) {		
		$uuid1=gen_uuid_timebased($mac);
		//echo "uuid1: $uuid1 \r\n";
		$file[$i]=str_replace("DEVICEID",$uuid1,$f);
	}
	echo $file[$i];
	$i++;
}

?>
