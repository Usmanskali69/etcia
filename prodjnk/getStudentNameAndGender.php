<?php
	include('../../../db_connect.php');
	$candidateId=htmlspecialchars($_GET['candidateId']);
	
	/*$candidateGenderQuery = "SELECT name,gender,casteCategory,XIIStream,isPhysicallyDisabled FROM students WHERE studentUniqueId='".$candidateId."'";
    $candidateGenederQueryResult= mysqli_query($con,$candidateGenderQuery);*/
	
	
	$candidateGenderQuery = "SELECT name,gender,casteCategory,XIIStream,isPhysicallyDisabled FROM students WHERE studentUniqueId=?";
	$stmt1 = mysqli_prepare($con, $candidateGenderQuery);
	mysqli_stmt_bind_param($stmt1, 'i', $candidateId);
	mysqli_stmt_execute($stmt1);
	$candidateGenederQueryResult = mysqli_stmt_get_result($stmt1);	
	
	
	$candidateGenderQueryRow = mysqli_fetch_array($candidateGenederQueryResult, MYSQLI_ASSOC);
	
	$casteCategory=$candidateGenderQueryRow['casteCategory'];
	$XIIStream=$candidateGenderQueryRow['XIIStream'];
	$isPhysicallyDisabled = $candidateGenderQueryRow['isPhysicallyDisabled'];
	
	$i="";
	
	if($candidateGenderQueryRow > 0)
	{
		$i=$candidateGenderQueryRow['name'];
		if($candidateGenderQueryRow['gender']=='Male' || $candidateGenderQueryRow['gender']=='Other')
		{
			$i=$i.",Male";
		}
		if($candidateGenderQueryRow['gender']=='Female')
		{
			$i=$i.",Female";
		}
		$j=checkAvailability($casteCategory,$XIIStream,$isPhysicallyDisabled,$con);
		//	echo $j.'aaaa';
		echo $i.$j.",".$casteCategory.",".$XIIStream;
	}
	else
	{
		echo "Invalid";
	}
	function checkForEngineeringPH($phEngineering,$filledPhEng,$isPhysicallyDisabled)
	{
		
		if(($phEngineering== $filledPhEng && $isPhysicallyDisabled=='Yes') || $isPhysicallyDisabled=='No')
		{
			$i=$i.",EngFull";
		}
		return $i;
	}
	function checkForGeneralPH($phGeneral,$filledPhGeneral,$isPhysicallyDisabled)
	{
		if(($phGeneral== $filledPhGeneral && $isPhysicallyDisabled=='Yes') || $isPhysicallyDisabled=='No')
		{
			$i=$i.",GenFull";
		}
		return $i;
	}
	function checkAvailability($casteCategory1,$XIIStream,$isPhysicallyDisabled,$con)
	{
		
		/*$seatQuery= "SELECT * FROM others";
		$seatResult= mysqli_query($con,$seatQuery);*/	
		
		
		$seatQuery = "SELECT * FROM others";
		$stmt12 = mysqli_prepare($con, $seatQuery);		
		mysqli_stmt_execute($stmt12);
		$seatResult = mysqli_stmt_get_result($stmt12);		
		
		
		$seatRow =mysqli_fetch_array($seatResult, MYSQLI_ASSOC);
		//echo $seatRow['openEngineering'].$seatRow['filledOpenEngineering'].$XIIStream;
		$i="";
		if($casteCategory1=="Open (OP)")
		{
	
			if($seatRow['openEngineering']== $seatRow['filledOpenEngineering'] && $XIIStream=='Science')
			{
				$i=checkForEngineeringPH($seatRow['phEngineering'],$seatRow['filledPhEng'],$isPhysicallyDisabled);
			}
			else if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'])
			{
				$i=checkForGeneralPH($seatRow['phGeneral'],$seatRow['filledPhGeneral'],$isPhysicallyDisabled);				
			}
		}
		else if($casteCategory1=="Socially and Economically Backward Classes (SEBC)")
		{
			if($seatRow['sbseEngineering']==$seatRow['filledSbseEng'] && $XIIStream=='Science')
			{
				$i=checkForEngineeringPH($seatRow['phEngineering'],$seatRow['filledPhEng'],$isPhysicallyDisabled);
			}
			else if($seatRow['sbseGeneral']==$seatRow['filledSbseGeneral'])
			{
				$i=checkForGeneralPH($seatRow['phGeneral'],$seatRow['filledPhGeneral'],$isPhysicallyDisabled);
			}
		}
		else if($casteCategory1=="Scheduled Caste (SC)")
		{
			if($seatRow['scheduledCasteEngineering']==$seatRow['filledScEng'] && $XIIStream=='Science')
			{
				$i=checkForEngineeringPH($seatRow['phEngineering'],$seatRow['filledPhEng'],$isPhysicallyDisabled);
			}
			else if($seatRow['scheduledCasteGeneral']==$seatRow['filledScGeneral'])
			{
				$i=checkForGeneralPH($seatRow['phGeneral'],$seatRow['filledPhGeneral'],$isPhysicallyDisabled);
			}
		}
		else if($casteCategory1=="Scheduled Tribe (ST)")
		{
			if($seatRow['scheduledTribeEngineering'] == $seatRow['filledStEng'] && $XIIStream=='Science')
			{
				$i=checkForEngineeringPH($seatRow['phEngineering'],$seatRow['filledPhEng'],$isPhysicallyDisabled);
			}
			else if($seatRow['scheduledTribeGeneral'] == $seatRow['filledStGeneral'])
			{
				$i=checkForGeneralPH($seatRow['phGeneral'],$seatRow['filledPhGeneral'],$isPhysicallyDisabled);
			}
		}
		return $i;
	}
?>  