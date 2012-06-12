<?php

	class OS {
		public function getOS() {
        	// Sourced from http://www.geekpedia.com/code47_Detect-operating-system-from-user-agent-string.html
			$osList = array(
							'Windows 8' => 'windows nt 6.2',
							'Windows 7' => 'windows nt 6.1',
							'Windows Vista' => 'windows nt 6.0',
							'Windows Server 2003' => 'windows nt 5.2',
							'Windows XP' => 'windows nt 5.1',
							'Windows 2000 sp1' => 'windows nt 5.01',
							'Windows 2000' => 'windows nt 5.0',
							'Windows NT 4.0' => 'windows nt 4.0',
							'Windows Me' => 'win 9x 4.9',
							'Windows 98' => 'windows 98',
							'Windows 95' => 'windows 95',
							'Windows CE' => 'windows ce',
							'Windows 3.11' => 'Win16',
							'Windows (version unknown)' => 'windows',
							'OpenBSD' => 'openbsd',
							'SunOS' => 'sunos',
							'Solaris 11' => 'Solaris11',
							'Solaris 10' => 'Solaris10',
							'Solaris 9' => 'Solaris9',
							'Ubuntu 12.10' => 'Ubuntu 12.10',
							'Ubuntu 12.04 LTS' => 'Ubuntu 12.04',
							'Ubuntu 11.10' => 'Ubuntu 11.10',
							'Ubuntu 11.04' => 'Ubuntu 11.04',
							'Ubuntu 10.10' => 'Ubuntu 10.10',
							'Ubuntu 10.04 LTS' => 'Ubuntu 10.04',
							'Ubuntu 9.10' => 'Ubuntu 9.10',
							'Ubuntu 9.04' => 'Ubuntu 9.04',
							'Ubuntu 8.10' => 'Ubuntu 8.10',
							'Ubuntu 8.04 LTS' => 'Ubuntu 8.04',
							'Ubuntu 6.06 LTS' => 'Ubuntu 6.06',
							'Ubuntu' => 'ubuntu',
							'Red Hat Linux' => 'Red Hat',
							'Red Hat Enterprise Linux' => 'Red Hat Enterprise',
							'Fedora 17' => 'Fedora 17',
							'Fedora 16' => 'Fedora 16',
							'Fedora 15' => 'Fedora 15',
							'Fedora 14' => 'Fedora 14',
							'Chromium OS' => 'ChromiumOS',
							'Google Chrome OS' => 'ChromeOS',
							'Linux' => '(linux)|(x11)',
							'Mac OS X Beta (Kodiak)' => 'mac os x beta',
							'Mac OS X Cheetah' => 'mac os x 10.0',
							'Mac OS X Puma' => 'mac os x 10.1',
							'Mac OS X Jaguar' => 'mac os x 10.2',
							'Mac OS X Panther' => 'mac os x 10.3',
							'Mac OS X Tiger' => 'mac os x 10.4',
							'Mac OS X Leopard' => 'mac os x 10.5',
							'Mac OS X Snow Leopard' => 'mac os x 10.6',
							'Mac OS X Lion' => 'mac os x 10.7',
							'Mac iOS 4.0.1' => 'os 4_0_1 like mac os x',
							'Mac iOS 4.0' => 'os 4_0 like mac os x',
							'Mac iOS 4.1' => 'os 4_1 like mac os x',
							'Mac iOS 4.2.1' => 'os 4_2_1 like mac os x',
							'Mac iOS 4.2.5' => 'os 4_2_5 like mac os x',
							'Mac iOS 4.2' => 'os 4_2 like mac os x',
							'Mac iOS 4.3.1' => 'os 4_3_1 like mac os x',
							'Mac iOS 4.3.2' => 'os 4_3_2 like mac os x',
							'Mac iOS 4.3.3' => 'os 4_3_3 like mac os x',
							'Mac iOS 4.3.4' => 'os 4_3_4 like mac os x',
							'Mac iOS 4.3.5' => 'os 4_3_5 like mac os x',
							'Mac iOS 4.3' => 'os 4_3 like mac os x',
							'Mac iOS 5.0' => 'os 5_0 like mac os x',
							'Mac iOS 5.1' => 'os 5_1 like mac os x',
							'Mac iOS 6.0' => 'os 6_0 like mac os x',
							'Mac OS X (version unknown)' => 'mac os x',
							'Mac OS (classic)' => '(mac_powerpc)|(macintosh)',
							'Android 1.0' => 'android 1.0',
							'Android 1.1' => 'android 1.1',
							'Android 1.5 Cupcake' => 'android 1.5',
							'Android 1.6 Donut' => 'android 1.6',
							'Android 2.0 Eclair' => 'android 2.0',
							'Android 2.1 Eclair' => 'android 2.1',
							'Android 2.2 Froyo' => 'android 2.2',
							'Android 2.3 Gingerbread' => 'android 2.3',
							'Android 3.0 Honeycomb' => 'android 3.0',
							'Android 3.1 Honeycomb' => 'android 3.1',
							'Android 3.2 Honeycomb' => 'android 3.2',
							'Android 4.0 Ice Cream Sandwich' => 'android 4.0',
							'CentOS' => 'CentOS',
							'QNX' => 'QNX',
							'BeOS' => 'beos',
							'OS2' => 'os\/2',
							'SearchBot'=>'(nuhk)|(googlebot)|(yammybot)|(openbot)|(slurp)|(msnbot)|(ask jeeves\/teoma)|(ia_archiver)'
						);
						
			// output operating system in $os
			$useragent = HTTP_USER_AGENT;
			$useragent = strtolower($useragent);
		
			if(isset($useragent) && !empty($useragent)) {
				foreach($osList as $os=>$match) {
					if (preg_match('/' . $match . '/i', $useragent)) {
						break;
					} else {
						$os = "Could not detect";
					}
				}
			} else {
				$os = "Could not detect";
			}
			
			
			return $os;
		}
	}

?>