<?php		


$imperial_feedback_ajax = new imperial_feedback_ajax();
class imperial_feedback_ajax
{
	//~~~~~
	function __construct ()
	{		
		$this->addWPActions();		
	}
	
	
/*	---------------------------
	PRIMARY HOOKS INTO WP 
	--------------------------- */	

	
	
	
	function addWPActions()
	{
		// Front End
		add_action( 'wp_ajax_sendImperialFeedback', array($this, 'sendImperialFeedback' ));





	}
	
	function sendImperialFeedback()
	{
		
		$feedback = $_POST['feedback'];
		$currentFeedbackPage = $_POST['currentPage'];
		
		
		// GEt current logged i user info		
		
		$message='';
		$to_address = "afurr@ic.ac.uk";
		$subject = "Feedback from MedLearn";
		$headers = array('Content-Type: text/html; charset=UTF-8');	
		
		$username = $_SESSION['username'];
		$userType = $_SESSION['userType'];
		$firstName = $_SESSION['firstName'];
		$lastName = $_SESSION['lastName'];
		$userID = $_SESSION['userID'];
		$email = $_SESSION['email'];

		$message.='Feedback : '.$feedback.'<br/>';
		$message.='Name : '.$firstName.'.'.$lastName.'<br/>';
		$message.='userID : '.$userID.'<br/>';
		$message.='email : '.$email.'<br/>';
		$message.='userType : '.$userType.'<br/>';
		$message.='username : '.$username.'<br/>';
		$message.='Page : '.$currentFeedbackPage.'<br/>';
		
		$mailsent = wp_mail($to_address, $subject, $message, $headers);
		echo 'Thank you! your feedback has been sent<hr/>';
		echo '<button id="feedbackPopupCloseButton" class="imperial-button">Close this window</button>';		
		
		die();
		
		
		
	}
	
	

	
}		
?>