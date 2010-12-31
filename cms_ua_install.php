<?php
/**
  * Install or update cms_pdf module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

//check if CMS_ua is already installed (if so, it is an update)
$sql = "select 1 from modules where codename_mod = 'cms_ua'";
$q = new CMS_query($sql);
$installed = $q->getNumRows() ? true : false;

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