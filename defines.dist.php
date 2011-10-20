<?php

// Your API key from Last.fm
define('API_KEY', '');
// Your API secret from Last.fm
define('SECRET', '');

// The URL to the site explaining this service (use only if the generator is running on a different domain/subdomain)
define('SITE', '');

// The key to run the cleanup-process
define('KEY', '');

// An csv string ('user1,user2') containing all allowed Last.fm usernames, set to NULL if all names are allowed
define('WHITELIST', NULL);
// An csv string ('user1,user2') containing all NOT allowed Last.fm usernames, set to NULL if all names are allowed
define('BLACKLIST', NULL);
// An csv string ('user1,user2') containing all Last.fm users allowed to override some values
define('SUPERUSERS', NULL);

// Log all operations
define('DEBUG_LOG', false);
// Log errors
define('ERROR_LOG', true);
