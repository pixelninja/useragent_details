<?php

	class geolocation {
		public function geolocation() {
			$ip = $_SERVER['REMOTE_ADDR'];
			//$ip = '122.56.115.160';
		
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
		
			return $location;
		}
	}

?>