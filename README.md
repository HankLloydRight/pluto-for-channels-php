# pluto-for-channels-php
A server side PHP implementation of the pluto-for-channels Docker repo

This PHP program takes the output from the https://github.com/maddox/pluto-for-channels repo, and sets the deviceID and sid parameters in the stream URLs with unique UUIDs for time the page is called.

The index.js file is the same nodejs script from the pluto-for-channels repo, with a two code changes (to create placeholders for deviceID and sid). It also now outputs to source.m3u

The playlist.php file takes the output from the index.js and generates unique UUIDs for each stream link.

The uuid.inc includes one function to generate a custom UUID v1 with a randomly generated MAC address.


