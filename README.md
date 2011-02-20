Automated Lastfm Image Generator
================================

 - Version: 0.1
 - Date: February 20th 2011
 - Github Repository: [https://github.com/nils-werner/lastfm-albums](https://github.com/nils-werner/lastfm-albums)

This is a tool providing a service to generate and host album badges from Last.fm stats. It provides basic yet effective caching strategies that enables it to serve several hundreds of gigabytes per month from a shared host.

Overview
--------

This tool is written using PHP5 only. The minimum requirements to run it are

 - Apache 2.2
 - `mod_rewrite` Module
 - PHP5

Installation
------------

 1. Copy the files in place
 2. Create a copy of `defines.dist.php` and name it `defines.php`
 3. Fill the missing values in `defines.php` with your API key, your API secret and the cleanup key
 4. Create the following folders and set the permissions to allow PHP to write there
   - `images/overall`
   - `images/weekly`
   - `images/3month`
   - `images/6month`
   - `images/12month`
 5. To enable logging you also need to create the file `log.txt`
 
Maintenance
-----------

Before running this service you absolutely need to make sure you **created the folders** listed above. Without them only a small number of users will suffice to crash your server as **no caching** can take place!

You need to run `cleanup.php` at **least once a week** (it's recommended to run it on a daily basis) to refresh the image cache. The key you've provided in `defines.php` needs to be appended to the URL using the `key` parameter: `cleanup.php?key=yourcleanupkey`

If you've enabled logging you need to **check and flush** `log.txt` regularly. Depending on the settings you're using and the number of users this file can grow very quickly and deteriorate performance dramatically.


Usage
-----

The users are able to customize their images to a certain degree. They're able to select from the following chart types:

 - *default* (overall charts)
 - `12month` (last 12 months)
 - `6month` (last 6 months)
 - `3month` (last 3 months)
 - `weekly` (weekly chart)

Also, the can set the number of colums or rows being generated. They're denoted like this:

 - `COLUMSxROWS`
 
The maximum number of images is limited to 30.
 
Examples
--------

 - `http://yoursite.com/phoque.jpeg` (10x2 overall chart)
 - `http://yoursite.com/weekly/phoque.jpeg` (10x2 weekly chart)
 - `http://yoursite.com/weekly/3x3/phoque.jpeg` (3x3 weekly chart)

The generated images look similar to this:

![Example badge](http://lastfm.obsessive-media.de/phoque.jpeg)
