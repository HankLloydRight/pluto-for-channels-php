# pluto-for-channels-php
A server side PHP implementation of the pluto-for-channels Docker repo
Allows users to access the full Pluto playlist with the custom tags and meta-data added for Channels, but no need to run a Docker instance locally.

This PHP program takes the output from the https://github.com/maddox/pluto-for-channels repo, and sets the deviceID and sid parameters in the stream URLs to unique UUIDs each time the page is called.  Since every load is unique, there should not be any conflicts that cause dropouts and disconnects as with other web based playlist.m3u sources.

The index.js file is the same nodejs script from the pluto-for-channels repo, with a two minor code changes to create simple placeholders for deviceID and sid. It also now outputs to 'source.m3u'

The playlist.php file takes the output from the index.js and generates unique UUIDs for each stream link and outputs the result.

The uuid.inc includes one function to generate a custom UUID v1 with a randomly generated MAC address.

The epg.xml file requires no modifications and is served as output from the index.js script.

The playlist.m3u and epg.xml outputs from this repo can be found here:  

https://sqrl.ws/pluto/playlist.m3u

https://sqrl.ws/pluto/epg.xml
