<?php
		include_once('./common/base.php');
		$title = "login";
		include_once('./common/header.php');
		include_once('./forms/form.login.php');
		
		$login_form = new LoginForm();
		
		if($login_form->read()){
		
			//login form is submitted
			if($login_form->isValid()){
				//do some session setting here
				
				$data = $login_form->getArray();//username and password
				include_once('./models/class.users.php');
				$user = new UserClass();
				$user->loadByData($data);				//load by username and password
				
				$_SESSION['loggedin']='true';
				$data2 = $user->getArray();
				$_SESSION['userid']=$data2['id'];
				echo "Congratulations, you are logged in";
			}else{
			
				//invalid form submitted, do sth here
				$login_form->display();
			}
		}else{
		
			//form is not submitted at all.
			$login_form->display();
		}
		
		$footer = "copyright &copy; 2012 reserved to rajan prasad upadhyay.";
		include_once("./common/footer.php");

?>
