<?php
		
		/*
		 *	The core purpose of this form is to provide some default set of functionalities
		 *	to handle general tasks to the actual implementations extending this class.
		 *	especially the error message concept implementation.
		 */


		abstract class AbstractForm {
				public $_error_message = "";
				public $_error_code	=	0;	//
				protected $_db	;						// database object
				protected $_flag	=	false;	//to check if the for is readed or not
				
				
				/**
				 * Checks for a database object and creates one if none is found
				 * 
				 * @param object $db
				 * @return void
				 */
				public function __construct($db=NULL){
					if(is_object($db)){
						$this->_db = $db;
					}
					else{
						$con_string = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
						$this->_db = new PDO($con_string, DB_USER, DB_PASS);
					}
				}//__construct
				
				protected function readSuccess(){
					$this->_flag	=	true;
				}
				
				
		}//abstractForm
		
		
		
?>
