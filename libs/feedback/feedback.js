
// Start listening for click events in the quiz
function feedback_start_page_listen()
{
	//Listener for clicking an option
	jQuery('.imperialFeedbackButton').on( 'click', function ( )
	{
		
		
		document.getElementById('imperial-feedback-popup').style.display = "block";
		
		
	
	});
	
	//Listener for close button X
	jQuery('.imperial-feedback-close').on( 'click', function ( ) {		
		
		document.getElementById('imperial-feedback-popup').style.display = "none";
	
	});


	// AFter submission close button
	jQuery('#feedbackPopupCloseButton').on( 'click', function ( ) {		
		
		document.getElementById('imperial-feedback-popup').style.display = "none";
	
	});
	
	
	
	jQuery('#imperial-feedback-send-button').on( 'click', function ( ) {	

		submitImperialFeedback();
	});
	

	
	
}
// Start listening on page load 
jQuery(document).ready(function() {
	feedback_start_page_listen();
});



// This handles the single question submission
function submitImperialFeedback()
{
	
	//var feedbackText =  document.getElementById('my-imperial-feedback').value;
	var feedbackText = jQuery("#my-imperial-feedback").val();
	var currentPage = jQuery("#currentFeedbackPage").val();
		
	jQuery.ajax({
		type: 'POST',
		url: imperialFeedback_ajax.ajaxurl,
		data: {			
			"action"			: "sendImperialFeedback",
			"feedback"			: feedbackText,
			"currentPage"		: currentPage,
		},
		success: function(data){
						
			document.getElementById("imperial-feedback-content").innerHTML = data;
			feedback_start_page_listen();
			
			

		}
			
	});
	
	
	
	return false;		
	
}