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
 * OperaHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_OperaHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "OPERA";
	const OPERA_TOLLERANCE = 5;
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs Containing AOL and are not mobile browsers
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	public function canHandle($userAgent) {
		if (WURFL_Handlers_Utils::isMobileBrowser ( $userAgent )) {
			return false;
		}
		
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Opera" );
	}
	
	/**
	 * Apply LD Match with tollerance 5
	 *
	 */
	function lookForMatchingUserAgent($userAgent) {
		return WURFL_Handlers_Utils::ldMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, self::OPERA_TOLLERANCE );
	}

}