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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Class CMS_browscap
  *
  * Extends Browscap class to use Zend_Http_Client for update method
  *
  * @package Automne
  * @subpackage cms_ua
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_browscap extends Browscap
{
	/**
	 * Retrieve the data identified by the URL
	 *
	 * @param string $url the url of the data
	 * @throws Browscap_Exception
	 * @return string the retrieved data
	 */
	protected function _getRemoteData($url) {
		$file = '';
		if ($this->_getUpdateMethod() == self::UPDATE_LOCAL) {
			$file = file_get_contents($url);
			if ($file !== false) {
				return $file;
			} else {
				throw new Browscap_Exception('Cannot open the local file');
			}
		} else {
			try {
				$client = new Zend_Http_Client();
				$client->setUri($url);
				//HTTP config
				$httpConfig = array(
				    'maxredirects'	=> 5,
				    'timeout'		=> 10,
					'useragent'		=> 'Mozilla/5.0 (compatible; Automne/'.AUTOMNE_VERSION.'; +http://www.automne-cms.org)',
				);
				if (defined('APPLICATION_PROXY_HOST') && APPLICATION_PROXY_HOST) {
					$httpConfig['adapter'] = 'Zend_Http_Client_Adapter_Proxy';
					$httpConfig['proxy_host'] = APPLICATION_PROXY_HOST;
					if (defined('APPLICATION_PROXY_PORT') && APPLICATION_PROXY_PORT) {
						$httpConfig['proxy_port'] = APPLICATION_PROXY_PORT;
					}
				}
				$client->setConfig($httpConfig);
				
				$client->request();
				$response = $client->getLastResponse();
			} catch (Zend_Http_Client_Exception $e) {
				CMS_grandFather::raiseError('Error for url: '.$url.' - '.$e->getMessage());
			}
			if (isset($response) && $response->isSuccessful()) {
				$file = $response->getBody();
			} else {
				if (isset($response)) {
					CMS_grandFather::raiseError('Error for url: '.$url.' - '.$response->getStatus().' - '.$response->getMessage());
				} else {
					CMS_grandFather::raiseError('Error for url: '.$url.' - no response object');
				}
			}
			if (!$file) {
				//try parent method
				$file = parent::_getRemoteData($url);
			}
		}
		return $file;
	}
}
?>
