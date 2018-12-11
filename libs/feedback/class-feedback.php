<?php		

include_once get_template_directory() . '/libs/feedback/class-ajax.php';




$imperial_feedback = new imperial_feedback();
class imperial_feedback
{
	//~~~~~
	function __construct ()
	{		
		$this->addWPActions();		
	}
/*	---------------------------
	PRIMARY HOOKS INTO WP 
	--------------------------- */	
	function addWPActions ()
	{
		add_action( 'wp_enqueue_scripts', array ($this, 'front_scripts' ), 1 );			
		
	}
	
	
	function front_scripts()
	{
		wp_enqueue_style( 'imperial_feedback_css',  get_template_directory_uri() . '/libs/feedback/imperial-feedback-popup.css' );		
		
		wp_enqueue_script('imperial_feedback_js', get_template_directory_uri().'/libs/feedback/feedback.js', array( 'jquery' ) );
	
		// Localise the admin JS for Ajax
		//Localise the JS file
		$params = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
		);
		
		wp_localize_script( 'imperial_feedback_js', 'imperialFeedback_ajax', $params );	

	}
	
	
}		
?>