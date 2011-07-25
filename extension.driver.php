<?php
	
	require_once(EXTENSIONS . '/browser_detection/class/class.browser.php');
	
	Class extension_browser_detection extends Extension{
	
		public function about(){
			return array(
				'name' => 'Browser Detection',
				'version' => '1.0',
				'release-date' => '2011-07-18',
				'author' => array(
				 		'name' => 'Phill Gray',
						'email' => 'phill@randb.com.au'
					),
				'description' => 'Detects the users browser and OS, and outputs as params in the param pool.'
		 		);
		}
		
		public function getSubscribedDelegates() {
			return array(
                array(
                    'page' => '/frontend/',
                    'delegate' => 'FrontendParamsPostResolve',
                    'callback' => 'addParameters'
                )
			);
		}
		
        public function addParameters($context) {
        	// Sourced from http://www.geekpedia.com/code47_Detect-operating-system-from-user-agent-string.html
			$osList = array(
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
				'Windows (version unknown)' => 'windows',
				'OpenBSD' => 'openbsd',
				'SunOS' => 'sunos',
				'Ubuntu' => 'ubuntu',
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
				'Mac OS X (version unknown)' => 'mac os x',
				'Mac OS (classic)' => '(mac_powerpc)|(macintosh)',
				'QNX' => 'QNX',
				'BeOS' => 'beos',
				'OS2' => 'os/2',
				'SearchBot'=>'(nuhk)|(googlebot)|(yammybot)|(openbot)|(slurp)|(msnbot)|(ask jeeves/teoma)|(ia_archiver)'
			);
			
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			$useragent = strtolower($useragent);
			
			foreach($osList as $os=>$match) {
				if (preg_match('/' . $match . '/i', $useragent)) {
					break;
				} else {
					$os = "Could not detect";
				}
			}
			
			
			// Class sourced from http://chrisschuld.com/projects/browser-php-detecting-a-users-browser-from-php/
			$browser = new Browser();
			
			// Browser details
            $context['params']['browser'] = $browser->getBrowser();
            $context['params']['version'] = $browser->getVersion();
            $context['params']['mobile'] = $browser->isMobile() ? 'yes' : 'no';
            $context['params']['robot'] = $browser->isRobot() ? 'yes' : 'no';
            $context['params']['chromeframe'] = $browser->isChromeFrame() ? 'yes' : 'no';
            
            // OS details
            $context['params']['platform'] = $browser->getPlatform();
            $context['params']['os-version'] = $os;
        }
	}
?>