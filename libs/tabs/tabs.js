jQuery(document).ready(function($) {		/* Firstly hide all the tabs then show the first tab */	$(".ekTabsContent").children().hide();		$(".ekTabsContent > div").eq(0).show();		// Apply class to the active tab	$(".ekTabsWrapper ul li").eq(0).addClass("activeTab");			//Listener for tabs	$(".ekTabsWrapper ul li").on("click", function() {		var clickedTab = $(this).index();				/* Remove the active class from all tabs and readd to clicked tab */		$(".ekTabsWrapper ul li").removeClass("activeTab");		$(".ekTabsWrapper ul li").eq(clickedTab).addClass("activeTab");				// Hide all content for divs in the main wrap		$(".ekTabsContent").children().hide();								// Finally show the div we have clicked		$(".ekTabsContent > div").eq(clickedTab).show();	});	});