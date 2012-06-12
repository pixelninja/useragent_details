<?php

	require_once(EXTENSIONS . '/useragent_details/class/class.os.php');
	require_once(EXTENSIONS . '/useragent_details/class/class.browser.php');
	require_once(EXTENSIONS . '/useragent_details/class/class.geolocation.php');

	Class datasourceuseragent_details extends Datasource{

		public $dsParamROOTELEMENT = 'useragent-details';
		public $dsParamLIMIT = '1';
		public $dsParamSTARTPAGE = '1';

		public function __construct(&$parent, $env=NULL, $process_params=true){
			parent::__construct($parent, $env, $process_params);
		}

		public function about(){
			return array(
					'name' => 'Useragent Details',
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
			$ip = $_SERVER['REMOTE_ADDR'];
			//$ip = '122.56.115.160';
			
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
			if(Symphony::Configuration()->get('geoplugin', 'useragent_details') == 'yes') {
				$geolocation = new geolocation();
				$location = $geolocation->geolocation();
				
				$result->appendChild(
					new XMLElement(
						'location',
						$location['geoplugin_city'].', '.$location['geoplugin_countryName'],
						array(
							'city' => Lang::createHandle($location['geoplugin_city']),
							'region' => Lang::createHandle($location['geoplugin_region']),
							'country' => Lang::createHandle($location['geoplugin_countryName']),
							'abbr' => Lang::createHandle($location['geoplugin_countryCode']),
							'latitude' => $location['geoplugin_latitude'],
							'longitude' => $location['geoplugin_longitude']
						)
					)
				);
			}

			return $result;
		}
	}