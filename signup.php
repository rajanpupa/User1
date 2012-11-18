<?php
include_once('common/base.php');
/*
 *check if the form is submitted, and verify and register
 *if not then print the form
 */
 $title = "signUp";
 include_once('common/header.php');
 
 include_once('./forms/form.signup.php');
  
 $form = new SignupForm($db);
 
 if($form->read()){
 		//echo "The form is submitted.";
	 	if($form->isValid()){
	 			//echo "<br/>The form is valid";
		 		$fields = $form->getArray();
		 		include_once('./models/class.users.php');
		 		$user = new UserClass($db);
		 		if($user->insert($fields)){
		 				echo "<div id='note'>
		 								<p>Congratulation. You are registered.</p>
		 								<p><a href='./login.php'>Login</a></p>
		 							</div>";
		 		}
	 	}else{
	 		//echo "<br/>form is invalid.";
	 		$form->display();
	 	}
 }else{
 	//echo "The signup is not posted.";
 	$form->display();
 }
 $footer = "copyright &copy; 2012 reserved to rajan prasad upadhyay.";
 include_once('./common/footer.php');
 
 
?>
