<?php
	
	include_once('../includes/site_vars.php');
	
	$instructorID 				= (isset($_REQUEST['instructorID']) ? $_REQUEST['instructorID'] : '');
	$coursesArray				= array();
	$courseData					= array();
	$instructorCoursesArray		= array();
	
	
	
	$search = $fmpConnection->newFindAllCommand('web_certificates');
		$searchResults = $search->execute();
	
	if(!FileMaker::isError($searchResults)) {
		
		$records 	= $searchResults->getRecords();
		
		foreach($records as $record){
			
			$courseData['CourseID']			= $record->getField('ID');
			$courseData['CourseName']		= $record->getField('DisplayName');
			$courseData['CourseNumber']		= $record->getField('CourseNumber_num');
			
			$coursesArray[$record->getField('CourseNumber_num')] = $courseData;
		}
		
		
	}
	

	
	$search = $fmpConnection->newFindCommand('web_persons');
		$search->addFindCriterion('ID',	'==' . $instructorID);
	$searchResults = $search->execute();
	
	if(!FileMaker::isError($searchResults)) {
		
		$record 	= $searchResults->getRecords()[0];
		
		$coursesObject		= $record->getRelatedSet('PersonCertifications_Persons');
		
		if(!FileMaker::isError($coursesObject)){

			foreach($coursesObject as $relatedRec){
				
				$courseKey		= '';
				$courseNumber	= $relatedRec->getField('Certifications_Persons::CourseNumber_num');
				
				if(strlen($courseNumber) == 3){
					
					$courseKey = (string)((int)$courseNumber - 100);
					
				} else if(strlen($courseNumber) == 4){
					
					$courseKey = (string)((int)$courseNumber - 1000);
				}
				
				if(!isset($coursesArray[$courseKey])){
					continue;
				}

				array_push($instructorCoursesArray, $coursesArray[$courseKey]);
				
			}
						
		}
	}
	
	echo json_encode($instructorCoursesArray);
			
?>