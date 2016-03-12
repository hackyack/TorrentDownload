# dltorrent
this projet is for my raspberry PI.

The aim is that during the night, the script downloads all news torrents film on a website (For the moment www.cpasbien.io)

the script is executed every night at 12PM.

For now, the script will download all, even if a film is posted several times (brip, 720p, etc.)

------- WHAT IS WORKING ---------

get links from cpasbien.io
separe the name of film from other characters  & words ( ex : anna-2016-french.torrent -> anna)
download all .torrent
transmission download all files in reception .torrent folder

-------- FOR THE FUTUR  ------------

* Analyze if a film is available in several qualities  ( ex : anna brip , anna 720p , anna 1080p) and select the best quality
 - A data base with name and quality will be created

* Work with other website

------------- WHAT YOU NEED TO EXECUTE THE SCRIPT -------------

Deb distro (Debian, ubuntu, raspbian) : I use mint linux

Work with 
  - PHP5-CLI
  - Command "at" 
  - transmission (automatically download .torrent from a folder) /!\ tmp solution , i'm looking for a terminal torrent client

///////////// Work of command at ///////////

sudo apt-get install at

---> at 0:0
---> php5 ./home/user/Scripts/dltorrent/start.php


