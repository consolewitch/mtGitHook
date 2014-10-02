<h3> git hook! </h3>

<?php
/**
  * This script is for easily deploying updates to Github repos to your local server. It will automatically git clone or
  * git pull in your repo directory every time an update is pushed to your $BRANCH (configured below).
  *
  * INSTRUCTIONS:
  * 1. Edit the variables below
  * 2. Upload this script to your server somewhere it can be publicly accessed
  * 3. Make sure the apache user owns this script (e.g., sudo chown www-data:www-data webhook.php)
  * 4. (optional) If the repo already exists on the server, make sure the same apache user from step 3 also owns that
  *    directory (i.e., sudo chown -R www-data:www-data)
  * 5. Go into your Github Repo > Settings > Service Hooks > WebHook URLs and add the public URL
  *    (e.g., http://example.com/webhook.php)
  *
  *
  * TODO
  * 1. when data is copied into live wp-config file, it should also remove files that are no longer part of the repo
  * 2. switch code to use variables rather than hard-coded paths
  *
**/

// Set Variables
//$LOCAL_ROOT         = "~/git";
//$LOCAL_REPO_NAME    = "futureecon.org";
//$LOCAL_REPO         = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
$REMOTE_REPO        = "https://github.com/Ecotrust/futureecon.org.git";
//$BRANCH             = "master";

if ( $_POST['payload'] ) {
// Only respond to POST requests from Github

  if( file_exists("../git/futureecon.org") ) {

    // If there is already a repo, just run a git pull to grab the latest changes
    shell_exec("(cd ../git/futureecon.org && git pull) && cp -a ../git/futureecon.org/app/* ../html/wp-content/");
    die("done pulling ".time()."\n" );

  } else {

    // If the repo does not exist, then clone it into the parent directory
    shell_exec("cd ../git && git clone {$REMOTE_REPO} && cp -a ./futureecon.org/app/* ../html/wp-content/");
    die("done cloning ".time()."\n" );
  }
print $_POST['payload'];
}
else {
        print "payload fail" . time();
}
?>

