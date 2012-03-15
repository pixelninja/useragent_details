<?php

	require_once(EXTENSIONS . '/useragent_details/class/class.os.php');
	require_once(EXTENSIONS . '/useragent_details/class/class.browser.php');

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

			if(Symphony::Configuration()->get('geoplugin', 'useragent_details') == 'yes') {
				$cache_id = md5('useragent_details-geoplugin-' . $ip);
				$cache = new Cacheable(Symphony::Database());
				$cachedData = $cache->check($cache_id);

				// No data has been cached previously
				if(!$cachedData) {
					include_once(TOOLKIT . '/class.gateway.php');

					$ch = new Gateway;
					$ch->init('http://www.geoplugin.net/php.gp?ip='.$ip);
					$response = $ch->exec();
					$info = $ch->getInfoLast();

					// We expected a 200 (OK)
					// It didn't come, so just return the existing $result
					if($info['http_code'] !== 200) {
						return $result;
					}

					$cache->write($cache_id, $response, 1440); // Cache lifetime of 1 Day
					$location = unserialize($response);
				}
				// fill data from the cache
				else {
					$location = unserialize($cachedData['data']);
				}

				// user location
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