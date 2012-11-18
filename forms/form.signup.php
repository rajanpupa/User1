<?php

	include_once('interface.form.php');
	include_once('abstract.form.php');
	/*
	 *The implementation of the interface is here
	 */
	 
	class SignupForm extends AbstractForm implements IForm{
	
		//property variables
		private 	$_username;
		private		$_password;
		private		$_c_password;
		private		$_email;
	
	/**
	 * reads the form fields on the signup form 
	 * 
	 * @return boolean true if the fields are found, else return false
	 */
		public function read(){
			if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['c_password'])&&isset($_POST['email'])){
				$this->_username = trim($_POST['username']);
				$this->_password = $_POST['password'];
				$this->_c_password = $_POST['c_password'];
				$this->_email = $_POST['email'];
				
				$this->_flag = true;
				return true;
			}
			return false;
		}//read
		
	/**
	 * server side validation of the data, uniqueness of username, and email,
	 * password is equal to c_password or not,
	 *
	 * @return boolean, true if valid , else return false
	 */
		public function isValid(){
			if(!$this->_flag){
				//the form is not read.
				$this->error_code = 10;
				$this->_error_message= "you should read the form first.";
				return false;
			}//if flag
			
			/**
			 *	check if the email is already registered or not
			 */
			$sql1 = "SELECT COUNT(email) AS count	FROM users WHERE email=:email ";
			if($stmt = $this->_db->prepare($sql1)) {
				$stmt->bindParam(":email", $this->_email, PDO::PARAM_STR);
				$stmt->execute();
				$row = $stmt->fetch();
				if($row['count']!=0) {
					$this->_error_code = 1;
					$this->_error_message= "<h2> Error </h2>"
						. "<p> Sorry, the email is already registered. "
						. "Use the forgot password link instead </p>";
						return false;
				}//if row 0
				$stmt->closeCursor();
			}//if stmt
			/**
			 *check if the username is available or not
			 */
			$sql1 = "SELECT COUNT(username) AS count	FROM users WHERE username=:username ";
			if($stmt = $this->_db->prepare($sql1)) {
				$stmt->bindParam(":username", $this->_username, PDO::PARAM_STR);
				$stmt->execute();
				$row = $stmt->fetch();
				if($row['count']!=0) {
					$this->_error_code = 1;
					$this->_error_message= "<h2> Error </h2>"
						. "<p> Sorry, the UserName is not available. "
						. "Try with a different User Name</p>";
						return false;
				}//if row 0
				$stmt->closeCursor();
			}//if stmt
			/**
			 *	check if the passwords match or not
			 */
			if(strcmp($this->_password, $this->_c_password)!=0){
				$this->_error_code = 2;
					$this->_error_message= "<h2> Error </h2>"
						. "<p> Sorry, but the password and the conform password did not match.</p>";
						return false;
			}
			return true;
		}//isValid
		
		/**
		 *	returns an array of values of the form
		 */
		public function getArray(){
			if($this->_flag){
				$fields = array();/*"username"=>$this->_username, "password"=>$this->_password,
														"email"=> $this->_email);*/
				$fields['username']=$this->_username;
				$fields['password']=$this->_password;
				$fields['email']	=$this->_email;
				return $fields;
			}
			return null;
		}//getArray
		
		public function display($action = ""){
?>
			<form method="post" action = "<?php echo $action; ?>" name = "signup_form">
			<div id="error"><?php 
				if($this->_error_code > 0){
					echo $this->_error_message;
				}			
			 ?></div>
				<label>UserName:</label>
				<input type="text" name="username" value = "<?php echo $this->_username; ?>"/><br/>
				<label>Password:</label>
				<input type="password" name="password" value = ""/><br/>
				<label>Conform password:</label>
				<input type="password" name="c_password" /><br/>
				<label> Email:</label>
				<input type="text" name="email" value = "<?php echo $this->_email;?>" /><br/>
				<input type="submit" value="Sign Up" name="signup"/>
			
			</form>
<?php
		}//display
	
	}//class

?>
