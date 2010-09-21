<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once("config.php");
define("_KEY_", "bf85cc88aa021aa07e2db6690734c6b5");      // Authentication key provided to you

define("_OUTPUT_", "XML");        // Don't change this unless you have to
                                // XML/JSON
                                
define("_ERRORLEVEL_", 1);        // 0 - displays basic errors
                                // 1 - more detailed errors

/** Do not edit below this line **/
                                
if (_ERRORLEVEL_ >= 1) {
        error_reporting(E_ALL ^ E_NOTICE); // All but notice errors
} else {
        error_reporting(E_NONE);
}
                                
define("_APISERVER_", "http://api.votesmart.org");       // Without trailing slash and with protocol

/**
 * VoteSmart API interfacing class
 * 
 * This class can be initialized with params or used 
 * repeatedly by directly calling query()
 * 
 * Copyright 2008 Project Vote Smart
 * Distributed under the BSD License
 * 
 * http://www.opensource.org/licenses/bsd-license.php
 * 
 * Special thanks to Adam Friedman for the idea and code
 * contribution for the slimmed down version of this lib.
 * 
 */
class VoteSmart {
        
        protected $iface;          // Interface(URL) used to gain the data
        protected $xml;            // Raw XML
        protected $xmlObj;         // SimpleXML object
		protected $_apiKey;			// API Key
        
        /**
         * function __construct
         * 
         * Initialize object(optional)
         * 
         * @param string $method optional 'CandidateBio.getBio'
         * @param array $args optional Array('candidateId' => '54321')
         */
        public function __construct($method = null, $args = null) {
                
                if ($method && $args) {
                        
                        $this->query($method, $args);
                        
                }
                
        }
		
		function setAPIKey($key_value) {
                assert ( is_string($key_value) );
                $this->_apiKey = $key_value;
                
        }
        
        /**
         * function getXml
         * 
         * Return raw XML string
         * 
         * @return string
         */
        public function getXml() {
                
                return $this->xml;
                
        }
        
        /**
         * function getXmlObj
         * 
         * Return SimpleXML object
         * 
         * @return object SimpleXMLElement
         */
        public function getXmlObj() {
                
                return $this->xmlObj;
                
        }
        
        /**
         * function getIface
         * 
         * Return string of URL queried
         * 
         * @return string
         */
        public function getIface() {
                
                return $this->iface;
                
        }
        
        /**
         * function query
         * 
         * Query API backend and return SimpleXML object.  This
         * function can be reused repeatedly
         * 
         * @param string $method CandidateBio.getBio'
         * @param array $args Array('candidateId' => '54321')
         * @return object SimpleXMLElement
         */
        public function query($method, $args = Array()) {
                
                $terms = "";
                
                if(!empty($args)) {
				
			foreach($args as $n => $v) {
				
				$terms .= '&' . $n . '=' . $v;
				 
			}
		}
		
		$this->iface = _APISERVER_ . "/" . $method . "?key=" . $this->_apiKey . "&o=" . _OUTPUT_  . $terms;
		
                if (!$this->xml = file_get_contents($this->iface)) {
                		
                        return false;
                		
                } else {
                		
                        // Let's use the SimpleXML to drop the whole XML
                        // output into an object we can later interact with easilly
                        $this->xmlObj = new SimpleXMLElement($this->xml, LIBXML_NOCDATA);
                        
                        return $this->xmlObj;
                		
                }
                
        }
	
}
