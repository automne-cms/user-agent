<?php
/**
 * WURFL API
 *
 * LICENSE
 *
 * This file is released under the GNU General Public License. Refer to the
 * COPYING file distributed with this package.
 *
 * Copyright (c) 2008-2009, WURFL-Pro S.r.l., Rome, Italy
 * 
 * 
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

/**
 * DoCoMoUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_DoCoMoHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs starting with "DoCoMo"
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "DoCoMo" );
	}
	
	/**
	 * Exact Match
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function lookForMatchingUserAgent($userAgent) {
		if (array_key_exists ( $userAgent, $this->userAgentsWithDeviceID )) {
			return $this->userAgentsWithDeviceID [$userAgent];
		}
		
		return NULL;
	}
	
	protected $prefix = "DOCOMO";
}
?>