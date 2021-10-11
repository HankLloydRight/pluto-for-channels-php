<style>
body {background:black;color:white;}
a {color:green;}
</style>

<h1>Pluto-for-Channels</h1>
<h2>
	These files are updated every 3 hours.
	Unique deviceID and sid parameters are inserted into the stream URLs every time the playlist link below file is called.<Br>
	This should prevent stream conflicts and dropouts.<Br>
<br>
	Thank you, Channels Devs for the <a href=https://github.com/maddox/pluto-for-channels>maddox/pluto-for-channels</a> repo which this page calls in the background.
	<hr>
<br>
To use these links, just right-click and "Copy Link Address", then paste into the Channels Admin page for Pluto settings.	<br>
<a href=pluto/playlist.m3u>Pluto Playlist.m3u</a>
<br>
<a href=pluto/epg.xml>Pluto epg.xml</a>
<br><br>Files last updated:
<?
$f=filemtime("pluto/source.m3u");
		date_default_timezone_set('America/New_York');
		echo  date(DATE_RFC2822,$f);//"l F jS   Y h:i:s A T"
	?>
<hr>
This project on Github: <a href=https://github.com/HankLloydRight/pluto-for-channels-php>pluto-for-channels-php</a>

