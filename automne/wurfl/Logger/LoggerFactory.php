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
 * @package    WURFL_Logger
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Logger_LoggerFactory {
	
	public static function createUndetectedDeviceLogger($wurflConfig) {	
		if(self::isLoggingConfigured($wurflConfig)) {
			return self::createFileLogger("undetected_devices.log");
		}
		return new WURFL_Logger_NullLogger ( );
	}
	
	public static function create($wurflConfig) {
		if(self::isLoggingConfigured($wurflConfig)) {
			return self::createFileLogger("wurfl.log");
		}
		return new WURFL_Logger_NullLogger ( );				
	}
	

	private static function createFileLogger($wurflConfig, $fileName) {
		$logFileName = self::createLogFile ( $wurflConfig->logDir, $fileName );
		return new WURFL_Logger_FileLogger ( $logFileName );
	
	}
	
	private static function isLoggingConfigured($wurflConfig) {	
		$logDir = $wurflConfig->logDir;
		return isset ( $wurflConfig->logDir ) && is_writable ( $logDir );
	}
	
		
	private static function createLogFile($logDir, $fileName) {		
		return $logDir . File . DIRECTORY_SEPARATOR . $fileName;
	}

}

?>