<?php
	
	include_once('models/interface.model.php');
	
	class UserClass implements IUser {
			private $_id;
			private $_username;
			private $_password;
			private $_email;
			
			//resource
			private $_db;
			
			/*
			 *	the constructor
			 */
			public function __construct($db=NULL){
				if(is_object($db)){
					$this->_db = $db;
				}
				else{
					$con_string = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
					$this->_db = new PDO($con_string, DB_USER, DB_PASS);
				}
			}//constructor
			
			/*
			 *
			 */
			 
			public function load($id){
				try{
					$sql1 = "SELECT * from users where (id = :id )";
					if($stmt = $this->_db->prepare($sql1)) {
						$stmt->bindParam(":id", $id , PDO::PARAM_STR);
						$stmt->execute();
						$row = $stmt->fetch();
						
						$this->_username = $row['username'];
						$this->_password = $row['password'];
						$this->_email = $row['email'];
						$this->_id = $row['id'];
						
						$stmt->closeCursor();
						return true;
					}
				}catch(Exception $e){
					return false;
				}//catch
			}//load
			
			
			public function loadByData($data){
				try{
					$sql1 = "SELECT * from users where ((username like :username or email like :username)".
						" and password like SHA1(:password) )";
					if($stmt = $this->_db->prepare($sql1)) {
						$stmt->bindParam(":username", $data['username'] , PDO::PARAM_STR);
						$stmt->bindParam(":password", $data['password'] , PDO::PARAM_STR);
						$stmt->execute();
						$row = $stmt->fetch();
						
						$this->_username = $row['username'];
						$this->_password = $row['password'];
						$this->_email = $row['email'];
						$this->_id = $row['id'];
						
						$stmt->closeCursor();
						return true;
					}
				}catch(Exception $e){
					return false;
				}//catch
			}
			
			/*
			 *	The field should contain 'username', 'password', 'email'
			 */
			 
			public function insert($fieldArray){
					try{
						$sql1 = "Insert into users (username, password, email) values (:username, :password, :email)";
						if($stmt = $this->_db->prepare($sql1)) {
							$stmt->bindParam(":username", $fieldArray['username'] , PDO::PARAM_STR);
							$enc_password = SHA1($fieldArray['password']);
							$stmt->bindParam(":password", $enc_password , PDO::PARAM_STR);
							$stmt->bindParam(":email", $fieldArray['email'] , PDO::PARAM_STR);
							$stmt->execute();
							$stmt->closeCursor();
							return true;
						}
					}catch(Exception $e){
						return false;
					}
			}//register
			
			public function getArray(){
				$data = array('id'=> $this->_id, 'username'=>$this->_username,
							 'password'=> $this->_password, 'email'=>$this->_email);
				return $data;
			}
	}

?>
