<?php
/**
  * Install or update cms_pdf module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

//check if module is already installed (if so, it is an update)
$installed = false;
$codenames = CMS_modulesCatalog::getAllCodenames(true);
if (isset($modules['cms_ua'])) {
	$installed = true;
}

if (!$installed) {
	echo "User Agent module installation : Not installed : Launch installation ...<br />";
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/mod_cms_ua.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/mod_cms_ua.sql',false);
		echo "User Agent module installation : Installation done.<br /><br />";
	} else {
		echo "User Agent module installation : INSTALLATION ERROR ! Problem in SQL syntax (SQL tables file) ...<br />";
	}
} else {
	echo "User Agent module installation : Already installed : update done.<br />";
}
?>