<?php
	
	require_once(EXTENSIONS . '/support_details/class/class.os.php');
	require_once(EXTENSIONS . '/support_details/class/class.browser.php');
	
	Class datasourcesupport_details extends Datasource{
		
		public $dsParamROOTELEMENT = 'support-details';
		public $dsParamLIMIT = '1';
		public $dsParamSTARTPAGE = '1';
		
		public function __construct(&$parent, $env=NULL, $process_params=true){
			parent::__construct($parent, $env, $process_params);
		}
		
		public function about(){
			return array(
					'name' => 'Support Details',
					'author' => array(
							'name' => 'Phill Gray',
							'website' => 'phill@randb.com.au'
						),
					'description' => 'This datasource outputs the users browser info and OS info into usable XML data.',
					);	
		}
		
		public function getSource(){
			return NULL;
		}
		
		public function allowEditorToParse(){
			return FALSE;
		}
		
		public function grab(&$param_pool) {
			// Get the ip address
			//$ip = $_SERVER['REMOTE_ADDR'];
			$ip = '203.144.8.51';
			
			// get contents from external api
			$content = file_get_contents('http://api.hostip.info/get_xml.php?ip='.$ip);
			// process data into variables
			if ($content != FALSE) {
				$xml = new SimpleXmlElement($content);
				
				$parent = $xml->children('gml', TRUE)->featureMember->children('', TRUE)->Hostip;
				$coordinates = $parent->ipLocation->children('gml', TRUE)->pointProperty->Point->coordinates;
				
				$longlat = explode(',', $coordinates);
				$location['longitude'] = $longlat[0];
				$location['latitude'] = $longlat[1];	
					
			    $location['city'] = $parent->children('gml', TRUE)->name;
				$location['country'] =  $parent->countryName;
				$location['country_abbr'] =  $parent->countryAbbrev;
				$location['ip'] =  $ip;
			}
		

			//initiate classes
			$os = new os();
			$browser = new Browser();
			
			// root element with attributes
			$result = new XMLElement(
				$this->dsParamROOTELEMENT, 
				null, 
				array(
					'mobile'=>$browser->isMobile() ? 'yes' : 'no',
					'chromeframe'=>$browser->isChromeFrame() ? 'yes' : 'no',
					'robot'=>$browser->isRobot() ? 'yes' : 'no'
				)
			);
			// browser
			$result->appendChild(
				new XMLElement(
					'browser',
					$browser->getBrowser(),
					array(
						'version' => $browser->getVersion(),
						'handle' => Lang::createHandle($browser->getBrowser())
					)
				)
			);
			// platform
			$result->appendChild(
				new XMLElement(
					'operating-system',
					$os->getOS(),
					array(
						'handle' => Lang::createHandle($os->getOS()),
						'platform' => $browser->getPlatform()
					)
				)
			);

			// IP address
			$result->appendChild(
				new XMLElement(
					'ip-address',
					$ip
				)
			);
			// user location
			$result->appendChild(
				new XMLElement(
					'location',
					$location['city'].', '.$location['country'],
					array(
						'city' => Lang::createHandle($location['city']),
						'country' => Lang::createHandle($location['country']),
						'abbr' => Lang::createHandle($location['country_abbr']),
						'latitude' => $location['latitude'],
						'longitude' => $location['longitude']
					)
				)
			);
			
			return $result;
		}
	}