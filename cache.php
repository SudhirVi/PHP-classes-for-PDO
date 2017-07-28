<?php
if (extension_loaded('memcached')) {
	class Cache extends Singleton {
		private $memcached;
		const DEFAULT_TTL = 60;

		public function __construct (){

			try {
				if (!is_array(conf::memcache_pool)) {
					throw new Exception("Caching IP Address Not found");
				}

				$this->memcached = new Memcached();
				$this->memcached->addServers(conf::memcache_pool); 
				
				// Use faster compression if available
	        	if (Memcached::HAVE_IGBINARY) {
	            	$this->memcached->setOption(Memcached::OPT_SERIALIZER, Memcached::SERIALIZER_IGBINARY);
	        	}
			
				$this->memcached->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
		        $this->memcached->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
		        $this->memcached->setOption(Memcached::OPT_NO_BLOCK, true);
		        $this->memcached->setOption(Memcached::OPT_TCP_NODELAY, true);
		        $this->memcached->setOption(Memcached::OPT_COMPRESSION, true);
		        $this->memcached->setOption(Memcached::OPT_CONNECT_TIMEOUT, 2);

			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}
		}
		public function get($key){
			if (empty($key)) {return false;}

			try {
				return $this->memcached->get($key);
			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}
			
			return $results;
		}
		public function set($key,$value, $ttl = self::DEFAULT_TTL){
			if (empty($key)) {return false;}

			try {
				return $this->memcached->set($key, $value, $ttl);
			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}		
		}
		public function delete($key){
			if (empty($key)) {return false;}
			try {
				return $this->memcached->delete($key);
			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}		
		}
	}
} else {
	class Cache extends Singleton {
		private $memcache;
		const DEFAULT_TTL = 60;

		public function __construct (){
			try {
				$this->memcache = new Memcache;
				if (!is_array(conf::memcache_pool)) {
					throw new Exception("Caching IP Address Not found");
				}

				foreach (conf::memcache_pool as $key => $value) {
					$this->memcache->addServer($value[0],$value[1]);
				}				
				
			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}
		}
		public function get($key){
			if (empty($key)) {return false;}

			try {
				return $this->memcache->get($key);
			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}
			
			return $results;
		}
		public function set($key,$value, $ttl = self::DEFAULT_TTL){
			if (empty($key)) {return false;}

			try {
				return $this->memcache->set($key, $value, MEMCACHE_COMPRESSED, $ttl);
				
			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}		
		}
		public function delete($key){
			if (empty($key)) {return false;}
			try {
				return $this->memcache->delete($key);
			} catch (Exception $e) {
				trigger_error('Cache: '.$e->getMessage(), E_USER_ERROR);
			}		
		}
	}
}
