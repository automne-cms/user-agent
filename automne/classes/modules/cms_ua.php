<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Codename of the module
  */
define("MOD_CMS_UA_CODENAME", "cms_ua");

/**
  * Class CMS_module_cms_ua
  *
  * represent the User Agent module.
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_module_cms_ua extends CMS_moduleValidation
{
	const MESSAGE_MOD_CMS_PDF_EXPLANATION = 5;
	
	/**
	  * Module autoload handler
	  *
	  * @param string $classname the classname required for loading
	  * @return string : the file to use for required classname
	  * @access public
	  */
	function load($classname) {
		static $classes;
		if (!isset($classes)) {
			$classes = array(
				/**
				 * Module classes
				 */
				'browscap' 						=> PATH_MAIN_FS.'/phpbrowscap/Browscap.php',
				'wurfl_configuration_xmlconfig' => PATH_MAIN_FS.'/wurfl/WURFLManagerFactory.php',
				'wurfl_wurflmanagerfactory'		=> PATH_MAIN_FS.'/wurfl/WURFLManagerFactory.php',
			);
		}
		$file = '';
		if (isset($classes[io::strtolower($classname)])) {
			$file = $classes[io::strtolower($classname)];
		}
		return $file;
	}
	
	/** 
	  * Get the tags to be treated by this module for the specified treatment mode, visualization mode and object.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @return array of tags to be treated.
	  * @access public
	  */
	function getWantedTags($treatmentMode, $visualizationMode) 
	{
		$return = array();
		switch ($treatmentMode) {
			case MODULE_TREATMENT_PAGECONTENT_TAGS :
				switch ($visualizationMode) {
					default:
						$return = array (
							"atm-ua" 				=> array("selfClosed" => false, "parameters" => array()),
							"atm-ua-if" 			=> array("selfClosed" => false, "parameters" => array())
						);
					break;
				}
			break;
		}
		return $return;
	}
	
	/** 
	  * Treat given content tag by this module for the specified treatment mode, visualization mode and object.
	  *
	  * @param string $tag The CMS_XMLTag.
	  * @param string $tagContent previous tag content.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  * @return string the tag content treated.
	  * @access public
	  */
	function treatWantedTag(&$tag, $tagContent, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		switch ($treatmentMode) {
			case MODULE_TREATMENT_PAGECONTENT_TAGS:
				if (!is_a($treatedObject,"CMS_page")) {
					$this->raiseError('$treatedObject must be a CMS_page object');
					return false;
				}
				switch ($tag->getName()) {
					case 'atm-ua':
						$replace = array(
							"#\{\{(wurfl|browscap|ua)\:([a-zA-Z_-]+)\}\}#U" => '<?php echo CMS_module_cms_ua::getBrowserInfo(\'\2\'); ?>'
						);
						return preg_replace(array_keys($replace), $replace, $tag->getInnerContent());
					break;
					case 'atm-ua-if':
						//make replacement in tag content
						$replace = array(
							"#\{\{(wurfl|browscap|ua)\:([a-zA-Z_-]+)\}\}#U" => '<?php echo CMS_module_cms_ua::getBrowserInfo(\'\2\'); ?>'
						);
						$tagContent = preg_replace(array_keys($replace), $replace, $tag->getInnerContent());
						
						//decode ampersand
						$what = io::decodeEntities($tag->getAttribute('what'));
						$replace = array(
							"#\{\{(wurfl|browscap|ua)\:([a-zA-Z_-]+)\}\}#U" => 'CMS_module_cms_ua::getBrowserInfo(\'\2\')'
						);
						$what = preg_replace(array_keys($replace), $replace, $what);
						$return = '<?php'."\n".
						'$ifcondition = \''.addslashes($what).'\';'."\n".
						'if ($ifcondition):'."\n".
						'	$func = create_function("","return (".$ifcondition.");");'."\n".
						'	if ($func()): ?>'.
						'		'.$tagContent.
						'<?php'."\n".
						'	endif;'."\n".
						'	unset($func);'."\n".
						'endif;'."\n".
						'unset($ifcondition);'."\n".
						'?>';
						return $return;
					break;
				}
			break;
		}
		return $tagContent;
	}
	
	private function _getBrowserInfos() {
		if (isset($_SESSION['cms_ua']['browserInfos'])) {
			//check request
			if (isset($_REQUEST['ua']) && is_array($_REQUEST['ua'])) {
				foreach($_REQUEST['ua'] as $key => $value) {
					if (isset($_SESSION['cms_ua']['browserInfos']['browscap'][$key])) {
						$_SESSION['cms_ua']['browserInfos']['browscap'][$key] = $value;
					}
					if (isset($_SESSION['cms_ua']['browserInfos']['wurfl'][$key])) {
						$_SESSION['cms_ua']['browserInfos']['wurfl'][$key] = $value;
					}
				}
			}
			return $_SESSION['cms_ua']['browserInfos'];
		}
		
		//check cache dirs
		$cachedir = new CMS_file(PATH_CACHE_FS.'/browscap', CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
		if (!$cachedir->exists()) {
			$cachedir->writeTopersistence();
		}
		$cachedir = new CMS_file(PATH_CACHE_FS.'/wurfl', CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
		if (!$cachedir->exists()) {
			$cachedir->writeTopersistence();
		}
		//get Browscap datas
		$browscap = new Browscap(PATH_CACHE_FS.'/browscap');
		$browscap->silent = false;
		$_SESSION['cms_ua']['browserInfos']['browscap'] = $browscap->getBrowser($_SERVER['HTTP_USER_AGENT'], true);
		
		//get wurfl datas
		$wurflConfigFile = PATH_MAIN_FS.'/wurfl/wurfl-config.xml';
		$wurflConfig = new WURFL_Configuration_XmlConfig($wurflConfigFile);
		$wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);
		$wurflManager = $wurflManagerFactory->create();	
		$wurflInfo = $wurflManager->getWURFLInfo();
		//echo 'VERSION : '.$wurflInfo->version."\n"; 
		$requestingDevice = $wurflManager->getDeviceForHttpRequest($_SERVER);
		$_SESSION['cms_ua']['browserInfos']['wurfl'] = $requestingDevice->getAllCapabilities();
		//check request
		if (isset($_REQUEST['ua']) && is_array($_REQUEST['ua'])) {
			foreach($_REQUEST['ua'] as $key => $value) {
				if (isset($_SESSION['cms_ua']['browserInfos']['browscap'][$key])) {
					$_SESSION['cms_ua']['browserInfos']['browscap'][$key] = $value;
				}
				if (isset($_SESSION['cms_ua']['browserInfos']['wurfl'][$key])) {
					$_SESSION['cms_ua']['browserInfos']['wurfl'][$key] = $value;
				}
			}
		}
		return $_SESSION['cms_ua']['browserInfos'];
	}
	
	function getBrowserInfo($dataname) {
		$browserInfos = CMS_module_cms_ua::_getBrowserInfos();
		switch ($dataname) {
			case 'datas':
				$datas = '';
				if (isset($browserInfos['browscap'])) {
					foreach($browserInfos['browscap'] as $key => $value) {
						$datas .= '{{browscap:'.$key.'}} => '.$value.'<br />';
					}
				}
				if (isset($browserInfos['wurfl'])) {
					foreach($browserInfos['wurfl'] as $key => $value) {
						$datas .= '{{wurfl:'.$key.'}} => '.$value.'<br />';
					}
				}
				return $datas;
			break;
			default:
				if (isset($browserInfos['browscap'][$dataname])) {
					return $browserInfos['browscap'][$dataname];
				}
				if (isset($browserInfos['wurfl'][$dataname])) {
					return $browserInfos['wurfl'][$dataname];
				}
			break;
		}
		return '';
	}
	
	/**
	  * Return the module code for the specified treatment mode, visualization mode and object.
	  * 
	  * @param mixed $modulesCode the previous modules codes (usually string)
	  * @param integer $treatmentMode The current treatment mode (see constants on top of this file for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  *
	  * @return string : the module code to add
	  * @access public
	  */
	/*function getModuleCode($modulesCode, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters) {
		switch ($treatmentMode) {
			case MODULE_TREATMENT_ROWS_EDITION_LABELS :
				$modulesCode[MOD_CMS_PDF_CODENAME] = $treatmentParameters["language"]->getMessage(self::MESSAGE_MOD_CMS_PDF_EXPLANATION, false, MOD_CMS_PDF_CODENAME);
				return $modulesCode;
			break;
			case MODULE_TREATMENT_TEMPLATES_EDITION_LABELS :
				$modulesCode[MOD_CMS_PDF_CODENAME] = $treatmentParameters["language"]->getMessage(self::MESSAGE_MOD_CMS_PDF_EXPLANATION, false, MOD_CMS_PDF_CODENAME);
				return $modulesCode;
			break;
		}
		return $modulesCode;
	}*/
}
?>