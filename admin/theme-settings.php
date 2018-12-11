<h1>Theme Settings</h1>
<?php
	$blogID = get_current_blog_id();
	
	


	// If form was submitted
	if ( isset( $_GET['action'] ) )
	{
		// Check the nonce before proceeding;	
		$retrieved_nonce="";

		$myAction = $_GET['action'];
		switch ($myAction)
		{
		
		
			case "updateIcon":
			
						
				if(isset($_REQUEST['_wpnonce'])){$retrieved_nonce = $_REQUEST['_wpnonce'];}
			
				if (wp_verify_nonce($retrieved_nonce, 'siteIcon_nonce' ) )
				{			
			
					$siteIcon = $_POST['siteIcon'];
					
					update_option( 'siteIcon',  $siteIcon);					
					
					echo '<div class="notice notice-success"><p>Icon updated</p></div><br/>';
			
				}
			
			
			break;
		
			case "updateTopicSettings":
			
				if(isset($_REQUEST['_wpnonce'])){$retrieved_nonce = $_REQUEST['_wpnonce'];}
			
			
				if (wp_verify_nonce($retrieved_nonce, 'topicSettingsNonce' ) )
				{
					

					// Get the current set - for defaults etc or if blank
					$siteNomenclature = getTopicNaming();

				
					// Create the array that we will be saving as site option
					$namingArray = array();
					$i=1;
					while($i<=3)
					{
						//$optionName = 'level'.$i.'_naming';
						$optionValue = $_POST['level'.$i.'_name'];

						
						// If its blank use the existing defaults
						if($optionValue== "")
						{
							$optionValue= $siteNomenclature[$i-1];
						}
						
						$namingArray[] = $optionValue;
						$i++;
						
		
					}
					
					// Update the site option
					update_option( 'topicNaming', $namingArray  );


					// Update the skip homepage
					$skipLectureOverviewPage = "";
					if(isset ($_POST['skipLectureOverviewPage'] ))
					{
						$skipLectureOverviewPage = "on";
					}
					update_option( 'skipLectureOverviewPage', $skipLectureOverviewPage  );



					echo '<div class="notice notice-success"><p>Settings updated</p></div><br/>';

					
				}		
			
			break;
		
		
		
		
			case "updateCats":
			
				if(isset($_REQUEST['_wpnonce'])){$retrieved_nonce = $_REQUEST['_wpnonce'];}
				if (wp_verify_nonce($retrieved_nonce, 'form_nonce' ) )
				{				
		
					imperialSiteCategories::updateSiteCategories($blogID);
					echo '<div class="notice notice-success"><p>Category updated</p></div><br/>';
					
				}
				


			break;	
			
			
			// Turn this blog into an imperial module so it appears in the 'Sites Page'
			case "createModule":
				if(isset($_REQUEST['_wpnonce'])){$retrieved_nonce = $_REQUEST['_wpnonce'];}
				if (wp_verify_nonce($retrieved_nonce, 'courseEdit_nonce' ) )
				{						
			
					$yos = $_POST['yos'];
					$deptID = $_POST['deptID'];
					$academicYear = $_POST['academicYear'];
					$siteTitle = get_bloginfo( 'name' );
					$blogID = get_current_blog_id();						

					global $wpdb;
					global $imperialNetworkDB;
					
					
					// update the courses table_name
					$thisTable = $imperialNetworkDB::imperialTableNames()['dbTable_courses'];

					$wpdb->insert( 
						$thisTable, 
						array( 
							'course_name' => $siteTitle,
							'blogID' => $blogID,
							'deptID' => $deptID,
							'academic_year' => $academicYear,
							'yos'	=> $yos,
						), 
						array( 
							'%s',
							'%d',
							'%s',									
							'%d',
							'%d',									
						) 
					);	
				}
			
			break;
			
		}
		
	}	
	
	
	// Start of page Settings //
	
	// See if its in the imperial site list
	$courseInfo = imperialQueries::getCourseInfoFromBlogID($blogID);	
	
	if($courseInfo)
	{		
		echo '<div class="admin-settings-group">';

		// Get the site academic year and deptID
		$blogMeta = imperialQueries::getCourseInfoFromBlogID($blogID);
		$courseID = $blogMeta['courseID'];
		 
		$academicYear = $blogMeta['academic_year'];
		$deptID = $blogMeta['deptID'];
		$yos = $blogMeta['yos'];
		
		$deptInfo = imperialQueries::getDeptInfo($deptID);
		$deptName = $deptInfo['deptName'];
		
		$niceAcademicYear = imperialNetworkUtils::getNiceAcademicYear($academicYear);
		
		echo 'Academic Year : <strong>'.$niceAcademicYear.'</strong><br/>';
		echo '<h2>Module Information</h2>';
		echo 'Department : <strong>'.$deptName.'</strong> ('.$deptID.')<br/>';
		echo 'Year of Study : <strong>'.$yos.'</strong><br/>';
		
		if(current_user_can('manage_network') )
		{
			echo '<a class="button-primary" href="network/admin.php?page=imperial-network-courses&view=courseEdit&courseID='.$courseID.'">Edit Course Meta</a>';
		}
		
		echo '</div>';

	}		
	
	
	// Topics Settings if its on the course thene	

	$myTheme = wp_get_theme();	
	$themeName = $myTheme->get('Name');
	
	if($themeName =="Imperial Course Template")
	{
		
		echo '<div class="admin-settings-group">';
		
		$siteNomenclature = getTopicNaming();
		echo '<h1>Learning Content Settings</h1>';

		// Check the site options




		$level1Name = $siteNomenclature[0];
		$level2Name = $siteNomenclature[1];
		$level3Name = $siteNomenclature[2];

		$skipLectureOverviewPage = get_option( 'skipLectureOverviewPage'  );

		echo '<h2>Navigation</h2>';

		//$siteNomenclature = getTopicNaming();
		echo '<form action="?page=theme-options&action=updateTopicSettings" method="post">';

		echo '<label for="skipLectureOverviewPage">';
		echo '<input type="checkbox" name="skipLectureOverviewPage" id="skipLectureOverviewPage"';

		if($skipLectureOverviewPage=="on")
		{
			echo ' checked ';
		}
		echo ' />Skip the '.$level2Name.' overview page';
		echo '</label>';


		echo '<hr/><h2>Nomenclature</h2>';





		$i=1;
		while($i<=3)
		{
			$thisVar = 'level'.$i.'Name';
			echo '<label for="level'.$i.'_name">Level '.$i.' Name : ';
			echo '<input name="level'.$i.'_name" type="text" value="'.$$thisVar.'">';
			echo '</label><hr/>';
			
			
			
			$i++;
		}

		// nonce field
		wp_nonce_field('topicSettingsNonce');    


		echo '<input type="submit" class="button-primary" value="Save Settings"/>';		
		
		echo '</form>';
		echo  '</div>';
		
	}	
	
	
	
	
	
	
	
	
	// Site Category

	
	
	if($courseInfo)
	{			
		
		echo '<div class="admin-settings-group">';
		
		 
		$siteCategories = imperialSiteCategories::getCategoriesByYear($academicYear, $deptID, $yos);
		$generalSiteCats = imperialSiteCategories::getCategoriesByYear($academicYear, $deptID, 0);

		//Get this blog cats
		$thisBlogCats = imperialSiteCategories::getSiteCategories($blogID);
		
		
		echo  '<h1>Module Category</h1>';
		
		echo '<form name="site_cat_form" action="?page=theme-options&action=updateCats"  method="post">';

		foreach ($generalSiteCats as $yos => $mySiteCats)
		{
			echo '<h2>General Categories</h2>';
			
			echo '<ul>';
			foreach ($mySiteCats as $catID => $catName)
			{
				echo '<li><label for="cat_'.$catID.'">';
				echo '<input type="checkbox" value="'.$catID.'" name="siteCats[]" id="cat_'.$catID.'"';
				
				if (array_key_exists($catID, $thisBlogCats)) {
					echo ' checked ';
				}				
				echo '/>'.$catName.'</label>';
			}
			echo '</ul>';
		}
		
		
		
		
		foreach ($siteCategories as $yos => $mySiteCats)
		{
			if($yos<>0)
			{
				echo '<h2>Year '.$yos.' Categories</h2>';
				
				echo '<ul>';
				foreach ($mySiteCats as $catID => $catName)
				{
					echo '<li><label for="cat_'.$catID.'">';
					echo '<input type="checkbox" value="'.$catID.'" name="siteCats[]" id="cat_'.$catID.'"';
					
					if (array_key_exists($catID, $thisBlogCats))
					{
						echo ' checked ';
					}				
					echo '/>'.$catName.'</label>';
				}
				echo '</ul>';
			}
		}
		
		echo '<input type="submit" value="Update Category" class="button-primary">';
		wp_nonce_field('form_nonce');   
		echo '</form>';	
		echo '</div>';				
		
	}
	else
	{
		
		echo '<div class="admin-settings-group">';
	
		
		$courseFieldsArray = array(
			array ("course_name", "Course Name"),
			array ("deptID", "Dept ID"),
			array ("academic_year", "Academic Year"),
			array ("yos", "Year Of Study"),				

		);
		
		echo 'This blog is not currently an imperial module.<hr/>';

		echo '<form name="module_form" action="?page=theme-options&action=createModule"  method="post" class="imperial-form">';

		echo '<label for="academicYear">Academic Year</label>';
		
		$academicYearArray = imperialNetworkUtils::getAcademicYearsArray();		
		
		echo '<select name="academicYear" id="academicYear">';
		foreach($academicYearArray as $KEY => $VALUE)
		{
			echo '<option value="'.$KEY.'">'.$VALUE.'</option>';
		}
		echo '</select>';
		
		// Get the Depts
		$facultyArray = imperialQueries::getFaculties();


		echo '<label for="deptID">Department</label>';
		echo '<select name="deptID" id="deptID">';
		foreach ($facultyArray as $facultyID => $facultyInfo)
		{
			
			$facultyName = $facultyInfo['Faculty'];
			$deptList = array();
			if(isset($facultyInfo['Departments']) )
			{
				$deptList = $facultyInfo['Departments'];
			}
			
			echo '<option value="'.$facultyID.'">'.$facultyName.' ('.$facultyID.')</option>';
			
			foreach($deptList as $deptID => $deptName)
			{
				
				echo '<option value="'.$deptID.'">- '.$deptName.' ('.$deptID.')</option>';					
			}	
		}	

		echo '</select>';
		
		
		// Year of study			
		echo '<label for="yos">Year of Study</label>';
		echo '<select name="yos" id="yos">';
		$i=1;
		while ($i<=6)
		{
			echo '<option value="'.$i.'">Year '.$i.'</option>';
			$i++;
		}	

		echo '</select>';
		

		echo '<input type="submit" value="Create Course Info">';
		wp_nonce_field('courseEdit_nonce');  



		echo '</form>';
		echo '</div>';
		
		
		
		
	}
	//echo '</div>';
	
	
	
	// Site Icon
	echo '<div class="admin-settings-group">';
	
	
	$siteIcon =  get_option( 'siteIcon' );
	
	echo '<h1>Site Icon</h1>';
	
	if($siteIcon<>"")
	{
		echo '<img src="'.$siteIcon.'" width="100px">';
	}
	
	echo '<form name="iconForm" action="?page=theme-options&action=updateIcon"  method="post" class="imperial-form">';
	
	echo '<label for="siteIcon">Icon URL</label>';
	echo '<input name="siteIcon" id="siteIcon" value="'.$siteIcon.'" size="50">';
	echo '<input type="submit" value="Add Icon">';
	wp_nonce_field('siteIcon_nonce');  	
	echo '</form>';
	
	echo '</div>';

?>