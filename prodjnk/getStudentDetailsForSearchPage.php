<?php
	include('../../../db_connect.php');
	$candidateId=htmlspecialchars($_GET['candidateId']);
	//$candidateCasteQuery = "SELECT  casteCategory, isPhysicallyDisabled,XIIStream FROM students WHERE studentUniqueId='".$candidateId."' ";
    //$candidateCasteQueryResult= mysqli_query($con,$candidateCasteQuery);
	$candidateCasteQuery = "SELECT  casteCategory, isPhysicallyDisabled,XIIStream FROM students WHERE studentUniqueId=?";
	$stmt1 = mysqli_prepare($con, $candidateCasteQuery);
	mysqli_stmt_bind_param($stmt1, 'i', $candidateId);
	mysqli_stmt_execute($stmt1);
	$candidateCasteQueryResult = mysqli_stmt_get_result($stmt1);	
	
	$candidateCasteQueryRow = mysqli_fetch_array($candidateCasteQueryResult, MYSQLI_ASSOC);

	$seatQuery= "SELECT * FROM others";
	//$seatResult= mysqli_query($con,$seatQuery);
	
	$stmt12 = mysqli_prepare($con, $seatQuery);	
	mysqli_stmt_execute($stmt12);
	$seatResult = mysqli_stmt_get_result($stmt12);
	
	$seatRow =mysqli_fetch_array($seatResult, MYSQLI_ASSOC);
	
	
	function checkSeatForScience($candidateCasteQueryRow,$seatRow)
	{
		if($candidateCasteQueryRow['isPhysicallyDisabled']=='Yes')
		{
			if($seatRow['phGeneral']== $seatRow['filledPhGeneral'] && $seatRow['phEngineering']== $seatRow['filledPhEng'])
			{
				echo "SeatsFull";
			}
			else
			{
				echo "Reserve";
			}
		}
		//For Non Handicapped Open Candidates
		else
		{
			echo "SeatsFull";
		}	
	}
	function checkSeatForNonScience($candidateCasteQueryRow,$seatRow)
	{		
		if($candidateCasteQueryRow['isPhysicallyDisabled'] == 'Yes')
		{
			if($seatRow['phGeneral'] == $seatRow['filledPhGeneral'])
			{
				echo "SeatsFull";
			}
			else
			{
				echo "Reserve";
			}
		}
		//For Non Handicapped Open Candidates
		else
		{
			echo "SeatsFull";
		}
	}
	//For 1st ROund of counselling
	if($seatRow['isReallocationStarted'] == 'No')
	{
		if($candidateCasteQueryRow['XIIStream']=='Science')
		{
			if($candidateCasteQueryRow['casteCategory']=='Open (OP)')
			{	
				if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'] && $seatRow['openEngineering']== $seatRow['filledOpenEngineering'])
				{
					checkSeatForScience($candidateCasteQueryRow,$seatRow);											
				}
				//If seats are vacant in Either Engineering or General or Both
				else
				{
					echo "Open";
				}
			}
			
			 if($candidateCasteQueryRow['casteCategory']=='Scheduled Caste (SC)')
			{
				if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'] && $seatRow['openEngineering']== $seatRow['filledOpenEngineering'])
				{
					if($seatRow['scheduledCasteEngineering']==$seatRow['filledScEng'] && $seatRow['scheduledCasteGeneral']==$seatRow['filledScGeneral'])
					{
						checkSeatForScience($candidateCasteQueryRow,$seatRow);							
					}
					//If seats are vacant in Either Engineering or General or Both
					else
					{
						echo "Reserve";				
					}
				}
				else
				{
					echo "Reserve";
				}
			}
			
			if($candidateCasteQueryRow['casteCategory']=='Scheduled Tribe (ST)')
			{
				if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'] && $seatRow['openEngineering']== $seatRow['filledOpenEngineering'])
				{
					if($seatRow['scheduledTribeEngineering'] == $seatRow['filledStEng'] && $seatRow['scheduledTribeGeneral'] == $seatRow['filledStGeneral'])
					{
						checkSeatForScience($candidateCasteQueryRow,$seatRow);
					}
					//If seats are vacant in Either Engineering or General or Both
					else
					{
						echo "Reserve";
					}
				}
				else
				{
					echo "Reserve";
				}
			}
			 if($candidateCasteQueryRow['casteCategory']=='Socially and Economically Backward Classes (SEBC)')
			{	
				if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'] && $seatRow['openEngineering']== $seatRow['filledOpenEngineering'])
				{	
					if($seatRow['sbseEngineering']==$seatRow['filledSbseEng'] && $seatRow['sbseGeneral']==$seatRow['filledSbseGeneral'])
					{
						checkSeatForScience($candidateCasteQueryRow,$seatRow);
					}
					//If seats are vacant in Either Engineering or General or Both
					else
					{
					echo "Reserve";
					}
				}
				else
				{
					echo "Reserve";
				}
			}
		}
		else if($candidateCasteQueryRow['XIIStream'] != 'Science')
		{	
				if($candidateCasteQueryRow['casteCategory']=='Open (OP)')
				{
					if($seatRow['openGeneral'] == $seatRow['filledOpenGeneral'])
					{
						checkSeatForNonScience($candidateCasteQueryRow,$seatRow);
					}
					else
					{
						echo "Open";
					}
				}
				
				if($candidateCasteQueryRow['casteCategory']=='Scheduled Caste (SC)')
				{
					if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'])
					{				
						if($seatRow['scheduledCasteGeneral'] == $seatRow['filledScGeneral'])
						{	
							checkSeatForNonScience($candidateCasteQueryRow,$seatRow);
						}
						else
						{
							echo "Reserve";
						}
					}
					else
					{
						echo "Reserve";
					}
				}
				
				if($candidateCasteQueryRow['casteCategory']=='Scheduled Tribe (ST)')
				{
					if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'])
					{	
						if($seatRow['scheduledTribeGeneral'] == $seatRow['filledStGeneral'])
						{	
							checkSeatForNonScience($candidateCasteQueryRow,$seatRow);
						}
						else
						{
							echo "Reserve";
						}
					}
					else
					{
						echo "Reserve";
					}
				}
			
			if($candidateCasteQueryRow['casteCategory']=='Socially and Economically Backward Classes (SEBC)')
			{
				if($seatRow['openGeneral']==$seatRow['filledOpenGeneral'])
				{				
					if($seatRow['sbseGeneral'] == $seatRow['filledSbseGeneral'])
					{	
						checkSeatForNonScience($candidateCasteQueryRow,$seatRow);
					}
					else
					{
						echo "Reserve";
					}
				}
				else
				{
					echo "Reserve";
				}

			}
		}
	}
	//For Recounselling
	else if($seatRow['isReallocationStarted']=='Yes')
	{
		if($candidateCasteQueryRow['XIIStream'] !='Science')
		{
			if($seatRow['openGeneral'] == $seatRow['filledOpenGeneral'] && $seatRow['scheduledCasteGeneral'] == $seatRow['filledScGeneral'] && $seatRow['scheduledTribeGeneral'] == $seatRow['filledStGeneral'] && $seatRow['sbseGeneral']==$seatRow['filledSbseGeneral'] && $seatRow['phGeneral'] == $seatRow['filledPhGeneral'])
			{
				echo "SeatsFull";						
			}
			else
			{	
				echo 'Reserve';
			}	
		}
		else if($candidateCasteQueryRow['XIIStream'] == 'Science')
		{
			if($seatRow['openEngineering']==$seatRow['filledOpenEngineering'] && $seatRow['openGeneral']==$seatRow['filledOpenGeneral'])
			{
				if(($seatRow['scheduledCasteEngineering']==$seatRow['filledScEng']) && ($seatRow['scheduledCasteGeneral']==$seatRow['filledScGeneral']))
				{
					if(($seatRow['scheduledTribeEngineering']==$seatRow['filledStEng']) && ($seatRow['scheduledTribeGeneral']==$seatRow['filledStGeneral']))
					{
						if(($seatRow['sbseEngineering']==$seatRow['filledSbseEng']) && ($seatRow['sbseGeneral']==$seatRow['filledSbseGeneral']))
						{
							if(($seatRow['phEngineering']==$seatRow['filledPhEng']) && ($seatRow['phGeneral']==$seatRow['filledPhGeneral']))
							{	
								
								echo "SeatsFull";
							}
							else
							{	
								echo 'Reserve';
							}
						}
						else
						{	
							echo 'Reserve';
						}
					}
					else
					{	
						echo 'Reserve';
					}
				}
				else
				{	
					echo 'Reserve';
				}
				
			}
			else
			{	
				echo 'Reserve';
			}
			
						
		}
	}
	mysqli_close($con);
?>  