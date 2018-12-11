</div>

<div class="footer-spacer"></div>
<footer id="footer">


<div id="imperialFeedbackButton" class="imperialFeedbackButton">
<button>
Give us your feedback
</button>
</div>


<div id="copyright">
&copy; <?php echo esc_html( date( 'Y' ) ); ?> Imperial College London
</div>



<!-- Add modal for use on all pages if required --->
<div id="imperial-modal" class="imperial-modal">
  <!-- Modal content -->
  <div class="imperial-modal-content-wrap">
    <span class="imperial-modal-close" id="imperial-modal-close">&times;</span>    
	<div id="imperial-modal-content"></div>
  </div>
</div>



<!-- Add feedback option for use on all pages if required --->

<!-- Add modal for use on all pages if required --->
<div id="imperial-feedback-popup" class="imperial-feedback-popup">
  <!-- Modal content -->
  <div class="imperial-feedback-content-wrap">
    <span class="imperial-feedback-close" id="imperial-feedback-close">&times;</span>    
	<div id="imperial-feedback-content">
	<h2>Tell us what you think!</h2>
	<span class="smallText">MedLearn is a brand new system so your feedback is essential.<br/>
	We value all feedback, positive and negative.</span><br/>
	<textarea placeholder="Add your comments" id="my-imperial-feedback"></textarea><br/>
	<button id="imperial-feedback-send-button" class="imperial-button"><i class="far fa-comment-dots"></i> Send your feedback</button>
	
	
	<?php
	$currentFeedackPage = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	echo '<input type="hidden" value="'.$currentFeedackPage.'" id="currentFeedbackPage">';
	
	?>
	
	
	</div>
  </div>
</div>


</footer>
</div>
<?php wp_footer();
/* Custom Styles  */
/* Count the widgets and if its zero make the content screen 100% */
global $sidebars_widgets;
$widgetCount= '';
if(isset($sidebars_widgets['primary-widget-area']))
{
	$widgetCount = count ($sidebars_widgets['primary-widget-area']);
}
$post_type = '';
if(!is_home())
{
	global $fullScreen;
	
	
	$fullWidthTypes = array();
	$post_type = '';
	if(is_object($post) )
	{
		$post_type = $post->post_type;
		$fullWidthTypes = array(
		"topic_session",
		"session_page",
		);
	}
			
	if( ( $widgetCount==0 && !in_array($post_type, $fullWidthTypes)) || $fullScreen==true )
	{
		?>
		<style>
			#content{width:100%;}
		</style>
		<?php
	}
	
}
// Get The header image background if it exists
// Has to be done last to override other styles if applicable
$headerInfo = get_custom_header();
$headerURL = $headerInfo->url;
if($headerURL)
{
	?>
		<style>
		#branding
		{
			background-image:
			
			url(<?php echo $headerURL;?>);
			background-repeat: no-repeat;
			background-size: cover;
		}
			
			
	</style>
	<?php
}
else
{
	?>
	<style>
	#branding {
    background: #ccc;    
    padding: 12px 0px 12px 28px;
    background-image: url(<?php echo get_template_directory_uri();?>/images/medlearn-header.png);
    background-repeat: no-repeat;
    background-size: cover;
	</style>
	
	<?php
}
?>
</body>
</html>