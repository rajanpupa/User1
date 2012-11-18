<?php
	
	/*
	 *The methods a form element should provide
	 */
	 
	interface IForm{
	
		/*
		 * read the posted fields of the form from $_POST['fieldName']
		 *
		 * @return true if success, else return false
		 */
		function read();
		
		/*
		 *	checks if the requirements of the fields are valid or not
		 *	returns true if the submitted form is valid, else false
		 *	@return boolean
		 */
		function isValid();
		
		/*
		 *	returns an array of "fieldName"=>"fieldValue"
		 *	for all the required fields for further processing
		 *	
		 *	@return array of form fields values
		 */
		function getArray();
		
		/*
		 *	echo's the form's html
		 *	There is a div with class="error" for displaying error messages
		 *	@return void
		 */
		function display($action="");
		
	}
	

?>
