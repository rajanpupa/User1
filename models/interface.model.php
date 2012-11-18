<?php
	interface IUser{
	
		/**
		 *	load data of the given user id
		 **/
		function load($id);
		/**
		 *	load the data ='username'=>username, 'password' =>password
		 *	@argument, array of username and password
		 *	@return void,
		 **/
		function loadByData($data);
		
		function insert($fieldArray);
		
		function getArray();
		
	}//interface


?>
