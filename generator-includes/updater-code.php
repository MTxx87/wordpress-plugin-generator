<?php
include_once( plugin_dir_path( __FILE__ ) . 'includes/updater.php' );
$updaterBlankPlugin = new Updater_Blank_Plugin( __FILE__ );
$updaterBlankPlugin->set_username('//[USERNAME]//');
$updaterBlankPlugin->set_repository('//[REPO]//');
$updaterBlankPlugin->authorize('//[APIKEY]//'); // Your auth code goes here for private repos
$updaterBlankPlugin->initialize();
?>
