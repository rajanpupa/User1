<?php
		
		include_once('interface.form.php');
		include_once('abstract.form.php');
		
		class LoginForm extends AbstractForm implements IForm{
				
				private $_username;
				private $_password;
			
				/*
				 * read the posted fields of the form from $_POST['fieldName']
				 *
				 * @return true if success, else return false
				 */
				function read(){
					if(isset($_POST['username']) && isset($_POST['password']) ){
						try{
								$this->_username = $_POST['username'];
								$this->_password = $_POST['password'];
								$this->_flag=true;
								return true;
							}catch(Exception $e){
								return false;
							}
					}//if
				}//read
		
				/*
				 *	checks if the requirements of the fields are valid or not
				 *	returns true if the submitted form is valid, else false
				 *	@return boolean
				 */
				function isValid(){
					if(!$this->_flag){
						//the form is not read.
						$this->error_code = 10;
						$this->_error_message= "you should read the form first.";
						return false;
					}//if flag
			
					/**
					 *	check if there is any row with the following values
					 */
					$sql1 = "SELECT COUNT(*) AS count	FROM users WHERE ".
						"((email like :username or username like :username) and password like SHA1(:password) )";
					if($stmt = $this->_db->prepare($sql1)) {
					
						$stmt->bindParam(":username", $this->_username, PDO::PARAM_STR);
						$stmt->bindParam(":password", $this->_password, PDO::PARAM_STR);
						$stmt->execute();
						
						$row = $stmt->fetch();
						
						if($row['count']==0) {
							$this->_error_code = 1;
							$this->_error_message= "<h2> Error </h2>"
								. "<p> Sorry, either the username or the password are not valid. "
								. "Use the forgot password link instead </p>";
								return false;
						}//if row 0
						$stmt->closeCursor();
						
					}//if stmt
					return true;
				}//isvalid
		
				/*
				 *	returns an array of "fieldName"=>"fieldValue"
				 *	for all the required fields for further processing
				 *	
				 *	@return array of form fields values
				 */
				function getArray(){
					$fieldArray = array('username'=> $this->_username, 'password'=>$this->_password);
					return $fieldArray;
				}//getArray
		
				/*
				 *	echo's the form's html
				 *	There is a div with class="error" for displaying error messages
				 *	@return void
				 */
				function display($action=""){
?>
					<form method="post" action = "<?php echo $action; ?>" name = "login_form">
					<div id="error"><?php 
						if($this->_error_code > 0){
							echo $this->_error_message;
						}
					 ?></div>
						<label>UserName:</label>
						<input type="text" name="username" value = "<?php echo $this->_username; ?>"/><br/>
						<label>Password:</label>
						<input type="password" name="password" value = ""/><br/>
						<input type="submit" value="login" name="Login"/>
					</form>
<?php
				}//display
		
		
		}//class
?>
