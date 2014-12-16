	

<?php
  require_once('report_replace_fields.php');

function createHtmlTimelineComboBox($dbSingleUse, $inTimelineMasterID) {
	
	$return = "";
	$return .=  '<select name="timelineMasterID">';
	
	$query = "select * from buildTimelineMaster btm where timelineIsActive = 1 order by timelineMasterName";
	
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$return .= '<option value="'.$resultRow->timelineMasterID.'"';
			if ($resultRow->timelineMasterID == $inTimelineMasterID ) {
					$return .= " selected=\"selected\"";
			} 
			$return .= '>'.$resultRow->timelineMasterName.'</option>';
		}
	}
	
   
   $return .= '</select>';

	return $return;	
}

function getNameFromUserName($dbSingleUse,$userName) {

	$query =  'SELECT firstName, lastName from users where userName = "'.$userName.'"';
		//echo '<br>'.$query;
		$result = $userName;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = substr($resultRow->firstName,0,1).'. '.$resultRow->lastName;
			}
		}

	return $result;

}

function sendOfferSignedEmail($dbSingleUse,$siteShortName, $lotNumber) {
	
	$offerInfo = getOfferDetailRecord($dbSingleUse,$siteShortName, $lotNumber) 	;
	echo '<br>Creating OFFER SIGNED email for lot:'.$lotNumber;

   	$currentSettingCheck = 'Offer Accepted Email File';
	
	$messageFile = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$inputFile = "uploadedItems/offerDocumentTemplates/".$messageFile;
	$fileContents = file_get_contents($inputFile, true);
	$subject = "An Offer Has Been Accepted (".$siteShortName.'-'.$lotNumber.")";
//	echo '<br>Calling sendOfferEventEmail';
	sendOfferEventEmail($dbSingleUse,$offerInfo,$subject,$fileContents) ;

	return true;
}
function sendWorkCreditSignedEmail($dbSingleUse,$id) {
	
	$table = 'offerWorkCredits';
	$detailRow = getRecordById($dbSingleUse,$table, $id) ;
	$siteShortName = $detailRow->siteShortName;
	$lotNumber = $detailRow->lotNumber;
	$offerInfo = getOfferDetailRecord($dbSingleUse,$siteShortName, $lotNumber) 	;
	echo '<br>Creating WORK CREDIT email for lot:'.$lotNumber;

   	$currentSettingCheck = 'Work Credit Accepted Email File';
	
	$messageFile = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$inputFile = "uploadedItems/offerDocumentTemplates/".$messageFile;
	$fileContents = file_get_contents($inputFile, true);
	$subject = "A Work Credit Has Been Accepted (".$siteShortName.'-'.$lotNumber.")";
//	echo '<br>Calling sendOfferEventEmail';
	sendOfferEventEmail($dbSingleUse,$offerInfo,$subject,$fileContents) ;

	return true;
}
function sendChangeOrderSignedEmail($dbSingleUse,$id) {
	
	$table = 'offerChangeOrders';
	$detailRow = getRecordById($dbSingleUse,$table, $id) ;
	$siteShortName = $detailRow->siteShortName;
	$lotNumber = $detailRow->lotNumber;
	$offerInfo = getOfferDetailRecord($dbSingleUse,$siteShortName, $lotNumber) 	;
	echo '<br>Creating CHANGE ORDER email for lot:'.$lotNumber;

   	$currentSettingCheck = 'Change Order Accepted Email File';
	
	$messageFile = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$inputFile = "uploadedItems/offerDocumentTemplates/".$messageFile;
	$fileContents = file_get_contents($inputFile, true);
	$subject = "A Change Order Has Been Accepted (".$siteShortName.'-'.$lotNumber.")";
//	echo '<br>Calling sendOfferEventEmail';
	sendOfferEventEmail($dbSingleUse,$offerInfo,$subject,$fileContents) ;

	return true;
}
function sendAmendmentSignedEmail($dbSingleUse,$id) {
	
	$table = 'offerAmendments';
	$detailRow = getRecordById($dbSingleUse,$table, $id) ;
	$siteShortName = $detailRow->siteShortName;
	$lotNumber = $detailRow->lotNumber;
	$offerInfo = getOfferDetailRecord($dbSingleUse,$siteShortName, $lotNumber) 	;
	echo '<br>Creating AMENDMENT email for lot:'.$lotNumber;

   	$currentSettingCheck = 'Amendment Accepted Email File';
	
	$messageFile = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$inputFile = "uploadedItems/offerDocumentTemplates/".$messageFile;
	$fileContents = file_get_contents($inputFile, true);
	$subject = "An Amendment Has Been Accepted (".$siteShortName.'-'.$lotNumber.")";
//	echo '<br>Calling sendOfferEventEmail';
	sendOfferEventEmail($dbSingleUse,$offerInfo,$subject,$fileContents) ;

	return true;
}

function sendOfferEventEmail($dbSingleUse,$offerInfo,$subject,$fileContents) {

	$currentSettingCheck = 'Customer Alert Email BCC Addresses for Offer Events';
	$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$bcc = $settingValue;
	if (strpos($bcc,'@') == false) {
		$currentSettingCheck = 'Customer Alert Email BCC Addresses';
		$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
		$bcc = $settingValue;
	}

	$currentSettingCheck = 'Customer Alert Email CC Addresses for Offer Events';
	$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$cc = $settingValue;

	if (strpos($cc,'@') == false) {
		$currentSettingCheck = 'Customer Alert Email CC Addresses';
		$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
		$cc = $settingValue;
	}
//	$bcc = "doug@pratthomes.ca;mvhintum2@softmv.com;Lcoulter@pratthomes.ca";
//	$bcc = "njlockyer@hotmail.com";
//	$cc = "noreply@pratthomes.ca";
	//echo '<br>SettingValue:'.$settingValue;
//	echo '<br>File Before:'.$fileContents;
	$formattedMessage = replaceTextInDocument($dbSingleUse, $offerInfo, $fileContents) ;
//	echo '<br>File After:'.$formattedMessage;
	$to = $offerInfo->email1;
//	$to = 'mvhintum@hotmail.com';
//	$to = 'doug@pratthomes.ca';
	insertCustomerEmailDetails($dbSingleUse,$subject, $formattedMessage, $to, $cc, $bcc);
	processCustomerEmails($dbSingleUse);
}

function getRecordById($dbSingleUse,$tableName, $id) {
	$result = "";
	$query = 'select * from '.$tableName.'	where id = '.$id;

	//printf( '<tr><td>'.$query.'</td></tr>');
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row()) {
			$result =  $resultRow;
		}
	}
	
	return $result;
}


function replaceTextInDocument($dbSingleUse, $offerInfo, $inputText) {

	$fileContents = $inputText;
//	$replaceText = getOfferText($offerInfo,'PURCHASERNAMEFULL',$dbSingleUse);
	
	$query = 'select * from searchAndReplace'; 
	$query = $query.' where 1=1 ';
	$query = $query.' and searchText not like "[2ndPayment%" ';
	$query = $query.' and searchText not like "[3rdPayment%" ';
	$query = $query.' and searchText not like "[4thPayment%" ';
	$query = $query.' and searchText not like "[5thPayment%" ';
	$query = $query.' order by searchText desc ';
	$x=0;
	$textArray = $dbSingleUse->QueryArray($query);
	//print_r($$textArray);
	foreach ($textArray as $i => $row) 
	{ 
		$x=$x+1;
		$code = $row->searchText;
		$replaceText = getOfferText($offerInfo,substr($row["searchText"],1,strlen($row["searchText"]) - 2),$dbSingleUse);
		//echo '<br>'.$row["searchText"].'-'.$replaceText;
		$pos = strpos($replaceText, '&');
		if ($pos > 0) {
			//alertBox('An & was found in the text for tag '.$row->searchText.'.  It was replace with the word "and".');
			$replaceText = str_ireplace('&', 'and' , $replaceText);
		}
		$fileContents = str_ireplace($row["searchText"], $replaceText, $fileContents);
	}

	
	return $fileContents;
}

function getOfferDetailRecord($dbSingleUse,$siteShortName, $lotNumber) {
	$result = "";
	$query = 'select * from offerDetailView	where siteShortName = "'.$siteShortName.'" and lotNumber ='.$lotNumber;

	//printf( '<tr><td>'.$query.'</td></tr>');
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row()) {
			$result =  $resultRow;
		}
	}
	
	return $result;
}
function getSettingValue($dbSingleUse, $settingName) {
	$result = "";
	$query = "select `settings`.`SettingValue` from `settings` where `settings`.`settingName` = '".$settingName."'";
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->SettingValue;
		}
	}
	return $result;

}

function doBuildResultFollowup($dbSingleUse,$siteShortName, $lotNumber,$buildAction) {
	
	$currentSettingCheck = 'Customer Alert Email BCC Addresses';
	$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
//	$bcc = "doug@pratthomes.ca;mvhintum2@softmv.com;Lcoulter@pratthomes.ca";
	$bcc = $settingValue;
//	$bcc = "njlockyer@hotmail.com";
	$currentSettingCheck = 'Customer Alert Email CC Addresses';
	$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$cc = $settingValue;
//	$cc = "noreply@pratthomes.ca";
	$currentSequence = getBuildActionSequence($dbSingleUse, $buildAction,$lotNumber,$siteShortName) ;
	//echo "<br>buildAction:".$buildAction.'-'.$currentSequence;
	$currentSettingCheck = 'Sequence for Excavation Message';
	$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	//echo '<br>SettingValue:'.$settingValue;
	if ($currentSequence == $settingValue) {
		echo "<br>Sending Construction Email to Client.";
		$currentSettingCheck = 'Commencement of Construction Message File';
		$messageFile = getSettingValue($dbSingleUse, $currentSettingCheck) ;
		$inputFile = "uploadedItems/offerDocumentTemplates/".$messageFile;
		$fileContents = file_get_contents($inputFile, true);
		//echo '<br>File Before:'.$fileContents;
		$offerInfo = getOfferDetailRecord($dbSingleUse,$siteShortName, $lotNumber);
		$formattedMessage = replaceTextInDocument($dbSingleUse, $offerInfo, $fileContents) ;
		//echo '<br>File After:'.$formattedMessage;
		$subject = "Commencement of Construction (".$siteShortName.'-'.$lotNumber.")";
		$to = $offerInfo->email1;
		insertCustomerEmailDetails($dbSingleUse,$subject, $formattedMessage, $to, $cc, $bcc);
		processCustomerEmails($dbSingleUse);
	}
	$currentSettingCheck = 'Sequence for Occupancy Certification Message';
	$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	//echo '<br>SettingValue:'.$settingValue;
	if ($currentSequence == $settingValue) {
		echo "<br>Sending Occupancy Email to Client.";
		$currentSettingCheck = 'Occupancy Certification Message File';
		$messageFile = getSettingValue($dbSingleUse, $currentSettingCheck) ;
		$inputFile = "uploadedItems/offerDocumentTemplates/".$messageFile;
		//echo '<br>'.$messageFile;
		$fileContents = file_get_contents($inputFile, true);
		//echo '<br>File Before:'.$fileContents;
		$offerInfo = getOfferDetailRecord($dbSingleUse,$siteShortName, $lotNumber);
		$formattedMessage = replaceTextInDocument($dbSingleUse, $offerInfo, $fileContents) ;
		//echo '<br>File After:'.$formattedMessage;
		$subject = "Confirming Readiness for Occupation (".$siteShortName.'-'.$lotNumber.")";
		$to = $offerInfo->email1;
		insertCustomerEmailDetails($dbSingleUse,$subject, $formattedMessage, $to, $cc, $bcc);
		processCustomerEmails($dbSingleUse);
	}
	return true;
}


function processCustomerEmails($dbSingleUse) {
	$query = "select * from emailProcessingLog where emailSent = 0 order by 1";;
	$emailArray = $dbSingleUse->QueryArray($query);
	//print_r($$textArray);
	foreach ($emailArray as $i => $row) 
	{ 
		if ($row["to"] > '' or $row["cc"]  > '' or $row["bcc"] > '') {
			//echo $row["message"];
			sendCustomerEmail($dbSingleUse,$row["subject"], $row["message"], $row["to"], $row["cc"], $row["bcc"]);
		}
		$query = "update emailProcessingLog set emailSent = 1 where id = ".$row["id"];
		$numberOfRows = $dbSingleUse->Query($query);
	}

	return true;
}

function insertCustomerEmailDetails($dbSingleUse,$inSubject, $inMessage, $inTo, $inCc, $inBcc) {
	$query = 'INSERT INTO `emailProcessingLog` (id, `subject`, `message`, `to`, `cc`, `bcc`, `createDate`, `emailSent`, `relatedBuildSequence`) values (null, "'.$inSubject.'", "'.mysql_real_escape_string($inMessage).'", "'.$inTo.'","'.$inCc.'","'.$inBcc.'", null, 0, null)';
	//echo '<br>'.$query;
	$numberOfRows = $dbSingleUse->Query($query);
}

function sendCustomerEmail($dbSingleUse,$inSubject, $inMessage, $inTo, $inCc, $inBcc) {
	$emailTo = $inTo;
//	$emailTo = "mike.vanhintum@rogers.com";
//	$emailTo = "doug@pratthomes.ca";
			// Additional headers
	$emailHeaders  = 'MIME-Version: 1.0' . "\r\n";
	$emailHeaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$currentSettingCheck = 'Customer Alert Email From Addresses';
	$settingValue = getSettingValue($dbSingleUse, $currentSettingCheck) ;
	$emailHeaders .= 'From: '.$settingValue. "\r\n";
//	$emailHeaders .= 'From: Pratt Homes Innisfil <noreply@pratthomes.ca>' . "\r\n";
	if ($inCc > '') {
		$emailHeaders .= 'Cc: '.$inCc . "\r\n";
	}
	if ($inBcc > '') {
		$emailHeaders .= 'Bcc: '.$inBcc . "\r\n";
	}
	$emailSubject = $inSubject;
	$emailMessage = $inMessage;
	$emailMessage .= "<br><br><small>".date("Y-m-d H:i:s", strtotime ("+3 hour"))."</small>";
	echo '<br>Sending email now';
	//logic here to prevent emailing when using softmv.com
	$serverStringPos = strpos(strtoupper($_SERVER["DOCUMENT_ROOT"]), 'SOFTMV');
	if ( $serverStringPos > 0) {
		echo '<br>test server, not sending email';
		echo "<br>".$inSubject." eMail would have been sent to ".$emailTo.', '.$inCc.', '.$inBcc;
	}
	else {
		echo '<br>sending email';
		$send_contact = mail($emailTo, $emailSubject, $emailMessage, $emailHeaders);
		echo "<br>".$inSubject." eMail sent to ".$emailTo.', '.$inCc.', '.$inBcc;

	}
		

	if ($send_contact) {
//		echo 'email Successful';
	}
	
}

function excavationStartedMessage($dbSingleUse,$lotNumber, $siteShortName) {

	$result = "";
	$query = "select distinct `lbr`.`siteShortName` AS `siteShortName`,`lbr`.`lotNumber` AS `lotNumber` from `lotBuildResultsView` `lbr` where (`lbr`.`sequence` = (select `settings`.`SettingValue` from `settings` where (`settings`.`settingName` = 'Sequence for Excavation Message'))) ";
	$query .=  'and lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->HasRecords($query)) {
		$query = "select SettingValue from settings where settingName = 'Excavation Started Message'";
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = '<table border="0" width="100%"><tr><td bgcolor="green" align="center"><font color="#FFFFFF">';
				$result .= $resultRow->SettingValue;
				$result .= '</font></td></tr></table>';
			}
		}
	}
	return $result;
}

function noOfferChangesAllowedMessage($dbSingleUse,$lotNumber, $siteShortName) {

	$result = "";
	if (areOfferChangesAllowed($dbSingleUse, $lotNumber, $siteShortName) == false) {
		$query = "select SettingValue from settings where settingName = 'No Offer Changes Message'";
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = '<table border="0" width="100%"><tr><td bgcolor="yellow" align="center"><font color="#000000">';
				$result .= $resultRow->SettingValue;
				$result .= '</font></td></tr></table>';
			}
		}
	}
	return $result;
}

function getLotBuildPercent($dbSingleUse,$lotNumber, $siteShortName,$timelineMasterID) {

	$result = 0;
	$query =  'select sum(percentOfBuild) as buildPercentTotal  from lotBuildResults lbr
join buildTimeline tl on lbr.buildAction = tl.buildAction and tl.sequenceIsActive = 1
and tl.timelineMasterID = '.$timelineMasterID.' WHERE lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->buildPercentTotal;
		}
	}
	return $result;
}

function getNumberOfUnsignedItems($dbSingleUse,$table, $lotNumber, $siteShortName) {
	$result = 0;
	$query =  'SELECT count(*) as theTotal from '.$table.' WHERE (dateDocumentSigned IS NULL OR dateDocumentSigned = "0000-00-00") and lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->theTotal;
		}
	}
	return $result;
}



function getFileNameFromId($dbSingleUse,$id) {
	$result = -1;
	
		$query = 'select fileName from fileLocations where id = '.$id;

		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = $resultRow->fileName;
			}
		}

	
	return $result;
}

function formatDateForHTML($input, $defaultWhenNotValid = NULL, $outputDateFormat = NULL) {
	//echo "<br>".$input;
	if($input == "0000-00-00") {
		$formattedDate = $defaultWhenNotValid;
		//echo "<br>1-".$formattedDate;
	}
	else
	if ($input == NULL) {
		$formattedDate = $defaultWhenNotValid;
		//echo "<br>2-".$formattedDate;
	}
	else
	{
		$formattedDate = date('d-M-Y',strtotime($input));
		//echo "<br>3-".$formattedDate;
	}
	
	//echo "<br>".$formattedDate;
	return $formattedDate;
}

function checkRowIdExists($dbSingleUse,$table,$column,$idValue) {
	
	$rowCount = 0;
	$query = 'select count(*) as howMany from '.$table.' where '.$column.' = '.$idValue;
	//echo $query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$rowCount = $resultRow->howMany;
		}
	}
	if ($rowCount > 0) {
		$result = true;
	}
	else
	{
		$result = false;
	}
	return $result;
	
}

function getNextId ($dbSingleUse, $userName, $description , $sessionId) {
	$result = -1;
	
	$query = 'insert into sequenceValues (userName, description, sessionValue) values ("'.$userName.'", "'.$description.'","'.$sessionId.'")';
//	echo $query;
	$numberOfRows = $dbSingleUse->Query($query);
	if ($numberOfRows > 0) {
		$query = 'select max(id) as myValue from sequenceValues where userName = "'.$userName.'" and description = "'.$description.'" and sessionValue = "'.$sessionId.'"';

		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = $resultRow->myValue;
			}
		}

	}
	
	return $result;
}

function calcSumOfFeatures($dbSingleUse,$lotNumber, $siteShortName) {
	$result = 0;
	$query =  'SELECT sum(featureResalePrice) as theTotal from offerFeatures where  lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->theTotal;
		}
	}
	return $result;
}function calcSumOfAmendments($dbSingleUse,$lotNumber, $siteShortName) {
	$result = 0;
	$query =  'SELECT sum(amendmentResalePrice) as theTotal from offerAmendments where  lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->theTotal;
		}
	}
	return $result;
}
function calcSumOfFeaturesAllowingDiscount($dbSingleUse,$lotNumber, $siteShortName) {
	$result = 0;
	$query =  'SELECT sum(featureResalePrice) as theTotal from offerFeatures where  featureDiscountAllowed = 1 and  lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->theTotal;
		}
	}
	return $result;
}

function getAvailableSiteDiscount($dbSingleUse, $siteShortName) {
	$result = 0;
	$query =  'SELECT availableSiteDiscount from sites where  siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->availableSiteDiscount;
			//alertbox($result);
		}
	}
	return $result;
}
function getAvailableSiteDiscountInteger($dbSingleUse, $siteShortName) {
	$result = 0;
	$query =  'SELECT availableSiteDiscount from sites where  siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			$result = $resultRow->availableSiteDiscount;
			//alertbox($result);
		}
	}
	return number_format($result, 0,'','');
}


function getOfferDatePlusDays($dbSingleUse, $lotNumber, $siteShortName,$numberOfDays) {
	$result = 0;
	$query =  'SELECT DATE_ADD(offerDate , interval '.$numberOfDays.' day) as newOfferDate from offers where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	
	
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			//alertBox($resultRow->newOfferDate);
			$result = $resultRow->newOfferDate;
			//alertbox($result);
		}
	}
	return $result;
}
function getIrrevocableDatePlusDays($dbSingleUse, $lotNumber, $siteShortName,$numberOfDays) {
	$result = 0;
	$query =  'SELECT DATE_ADD(irrevocableDate , interval '.$numberOfDays.' day) as newIrrevocableDate from offers where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	
	
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			//alertBox($resultRow->newIrrevocableDate);
			$result = $resultRow->newIrrevocableDate;
			//alertbox($result);
		}
	}
	return $result;
}

function getOfferDatePlusMonths($dbSingleUse, $lotNumber, $siteShortName,$numberOfMonths) {
	$result = 0;
	$query =  'SELECT DATE_ADD(offerDate , interval '.$numberOfMonths.' month) as newOfferDate from offers where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	
	
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			//alertBox($resultRow->newOfferDate);
			$result = $resultRow->newOfferDate;
			//alertbox($result);
		}
	}
	return $result;
}

function areOfferChangesAllowed($dbSingleUse, $lotNumber, $siteShortName) {
	$result = true;
	$query =  'SELECT dateOverrideOfferChangesAllowed, dateDocumentSigned, date_sub(curdate(),interval 0 day) as todayDate, date_sub(curdate(),interval 60 day) as todayLessSixty from offers where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  ';
	//echo '<br>'.$query;
	
	
	if ($dbSingleUse->Query($query)) { 
		while ($resultRow = $dbSingleUse->Row() ) {	
			//alertBox($resultRow->newOfferDate);
			$dateOverrideOfferChangesAllowed = $resultRow->dateOverrideOfferChangesAllowed;
			$dateDocumentSigned = $resultRow->dateDocumentSigned;
			$todayLessSixty = $resultRow->todayLessSixty;
			$todayDate = $resultRow->todayDate;
			//alertbox($result);
		}
	}
	
	//echo $offerDate.' or '.$todayLessSixty;
	$result = true;
	if (isset($dateDocumentSigned) && $dateDocumentSigned > '0000-00-00') {
		if ($dateDocumentSigned < $todayLessSixty) {
			if (isset($dateOverrideOfferChangesAllowed ) && $dateOverrideOfferChangesAllowed > '0000-00-00') {
				if ($dateOverrideOfferChangesAllowed < $todayDate) {
					//past ovverride date, set to false
					$result =  false;
				}
			}
			else {
				//no override has been set, set to false
				$result =  false;
			}
			// no changes allowed
		}
	}
	return $result;
}



function OLDcreateBuildActionComboBox($dbSingleUse, $selectedSequence) {

	$result = '	<select name="noteBuildSequence" id="noteBuildSequence">';
	$query =  'SELECT * from buildTimeline order by sequence ';
		//echo '<br>'.$query;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = $result.'<option ';
				if ($resultRow->sequence == $selectedSequence) {
					$result = $result.' selected="selected" ';
				}
				$result = $result.' value="'.$resultRow->sequence.'">'.$resultRow->buildAction.'</option>';
			}
		}
        
      $result = $result.'</select>  ';
	
	return $result;
}
function createBuildActionComboBox($dbSingleUse, $selectedSequence,$lotNumber, $siteShortName) {

	$result = '	<select name="noteBuildSequence" id="noteBuildSequence">';
	$query =  'SELECT * from buildTimeline where
	timeLineMasterID in
			(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")
	order by moveInDateOffset,sequence ';
		//echo '<br>'.$query;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = $result.'<option ';
				if ($resultRow->sequence == $selectedSequence) {
					$result = $result.' selected="selected" ';
				}
				$result = $result.' value="'.$resultRow->sequence.'">'.$resultRow->buildAction.'</option>';
			}
		}
        
      $result = $result.'</select>  ';
	
	return $result;
}


function findBuildResultNotesText($dbSingleUse,$lotNumber, $siteShortName, $buildAction) {

		$query =  'SELECT * from lotBuildResultsNotes where  buildAction = "'.$buildAction.'" and lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'" order by noteDate desc ';
		//echo '<br>'.$query;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = trim($result.'<br>'.$resultRow->noteText.'<br>('.substr($resultRow->noteDate,0,10).')' ,'<br>');
			}
		}
	return $result;
	}

function printCurrentDateLong() {
		echo  date('l, F dS, Y');

	}
function nullToChar($inputValue, $replaceChar) {
	if (isset($inputValue)) {
		return $inputValue;
	}
	else
	{
		return $replaceChar;
	}
}

function alertBox($inText) {

	echo "<script>alert('".$inText."')</script>";

}

function getBuildActionName($dbSingleUse, $sequence, $lotNumber, $siteShortName) {

	$query =  'SELECT buildAction FROM buildTimeline bt  where sequence = '.$sequence.'  and timeLineMasterID in
			(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")';
		//echo '<br>'.$query;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = $resultRow->buildAction;
			}
		}
	return $result;
}
function getBuildActionSequence($dbSingleUse, $buildAction, $lotNumber, $siteShortName) {

	$query =  'SELECT sequence FROM buildTimeline bt  where buildAction= "'.$buildAction.'"  and timeLineMasterID in
			(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")';
		//echo '<br>'.$query;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$result = $resultRow->sequence;
			}
		}
	return $result;
}

function getBuildActionColor($inDate){

	$value =  "white";
	
	if (isset($inDate)) {
		$inDateTimestamp = strtotime($inDate);
		$todayPlusSeven = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " +"."7"." day");
		$todays_date = date("Y-m-d");
		$todayTimestamp = strtotime($todays_date);
		if ($todayTimestamp > $inDateTimestamp ) {
		
			$value =  "red";
		}
		else if  ($todayPlusSeven > $inDateTimestamp ){
			$value =  "yellow";
		}
		else {
			$value =  "white";
		}
		
	}
	return $value;
}


function OLDgetExpectedDateForBuildAction($dbSingleUse,$lotNumber, $siteShortName, $sequenceToCheck){
		$query =  'SELECT * from buildTimeline where sequence = '.$sequenceToCheck;
		//echo '<br>'.$query;
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$isPostBuildItem =  $resultRow->isPostBuildItem;
		}

		$query =  'SELECT moveInDate from offerDetailView where  lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'" ';
		//echo '<br>'.$query;
		$resultCount = 0;
		$buildActionDate = '-';
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$closingDate =  $resultRow->moveInDate;
		}

		if ($isPostBuildItem == 1) {
			$query =  'select 0 - sum(numberOfDays) as numberOfDays from buildTimeline bt2 where isPostBuildItem = 1 and bt2.sequence >= '.$sequenceToCheck;
		}
		else {
		$query =  'select sum(numberOfDays) as numberOfDays from buildTimeline bt2 where isPostBuildItem = 0 and bt2.sequence >= '.$sequenceToCheck;
		}
		//echo '<br>'.$query;
		$resultCount = 0;
		$buildActionDate = '-';
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$numberOfDays =  $resultRow->numberOfDays;
			$foundRow = true;
		}


		if ($closingDate > '2001-01-01') {			
			if ($isPostBuildItem == 1) {
				$tempDate = strtotime(date("Y-m-d", strtotime($closingDate)) . " +".$numberOfDays." day");
			}
			else {
				$tempDate = strtotime(date("Y-m-d", strtotime($closingDate)) . " -".$numberOfDays." day");
			}
			$expectedDate = date('Y-m-d', $tempDate);
			//$expiration_date = strtotime($expectedDate);
		}
		else
		{
			if ($isPostBuildItem == 1) {
				$tempDate = strtotime(date("Y-m-d", strtotime('2001-01-01')) . " +".$numberOfDays." day");
			}
			else {
				$tempDate = strtotime(date("Y-m-d", strtotime('2001-01-01')) . " -".$numberOfDays." day");
			}
			$expectedDate = date('Y-m-d', $tempDate);
		}
		
	return $expectedDate;
}

function getExpectedDateForBuildAction($dbSingleUse,$lotNumber, $siteShortName, $sequenceToCheck){
		$query =  'SELECT * from buildTimeline where 
		timeLineMasterID in	(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")
		and sequence = '.$sequenceToCheck;
		//echo '<br>'.$query;
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$isPostBuildItem =  $resultRow->isPostBuildItem;
			$moveInDateOffset =  $resultRow->moveInDateOffset;
		}

		$query =  'SELECT calculatedBuildCompletionDate from offerDetailView where  lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'" ';
		//echo '<br>'.$query;
		$resultCount = 0;
		$buildActionDate = '-';
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$closingDate =  $resultRow->calculatedBuildCompletionDate;
		}

		if ($closingDate > '2001-01-01') {			
			$tempDate = strtotime(date("Y-m-d", strtotime($closingDate)) . " +".$moveInDateOffset." day");
			$expectedDate = date('Y-m-d', $tempDate);
			//$expiration_date = strtotime($expectedDate);
		}
		else
		{
			$tempDate = strtotime(date("Y-m-d", strtotime('2001-01-01')) . " +".$moveInDateOffset." day");
			$expectedDate = date('Y-m-d', $tempDate);
		}
		
	return $expectedDate;
}

function OLDgetLotNextActivity($dbSingleUse,$lotNumber, $siteShortName, $location, $startSequence){
	
		$query =  'SELECT min( `sequence` ) as nextSequence FROM buildTimeline WHERE buildAction NOT IN ( select buildAction from lotBuildResults where  lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'") ';
		if (isset($location)) {
			$query = $query.' and location = "'.$location.'" ';
		}
		//echo '<br>'.$query;
				//alertBox($query);
		$resultCount = 0;
		$buildActionDate = '-';
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$answer =  $resultRow->nextSequence;
		}
	return $answer;
}

function getLotNextActivity($dbSingleUse,$lotNumber, $siteShortName, $location, $startSequence){
	
	    //get the minimum sequence for the minimum offeset days
		
		$query =  'SELECT min( `sequence` ) as nextSequence FROM buildTimeline  bt1 WHERE 
		bt1.sequenceIsActive  = 1
		and bt1.timeLineMasterID =(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")
		and bt1.buildAction NOT IN ( select buildAction from lotBuildResults where  lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'")
		and bt1.moveInDateOffset = (
				select min(bt2.moveInDateOffset) from buildTimeline bt2 WHERE 
							bt2.sequenceIsActive = 1 ';
		if (isset($location)) {
			$query = $query.' and bt2.location = "'.$location.'" ';
		}
		$query .=	'						
						and	bt2.buildAction NOT IN ( select buildAction 
															from lotBuildResults lbr 
															where  lbr.lotNumber =  '.$lotNumber.' and lbr.siteShortName = "'.$siteShortName.'") 
		and bt2.timeLineMasterID =(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")
															
		)'; 
		if (isset($location)) {
			$query = $query.' and bt1.location = "'.$location.'" ';
		}
//		if ($lotNumber == 13) {
//		echo '<br>testing<br>'.$query;
//		}
					//alertBox($query);
		$resultCount = 0;
		$buildActionDate = '-';
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$answer =  $resultRow->nextSequence;
		}
	return $answer;
}

function getLotBuildStatusColor ($dbSingleUse,$lotNumber, $siteShortName, $location) {
	
		//first get the lots next expected sequence
		$nextSequence = getLotNextActivity($dbSingleUse,$lotNumber, $siteShortName, $location, $startSequence);
//		if ($lotNumber == 2) {
//			alertBox($nextSequence);
//		}
		if (isset($nextSequence)) {
			$expectedDateForActivity = getExpectedDateForBuildAction($dbSingleUse,$lotNumber, $siteShortName, $nextSequence);
			$statusColor = getBuildActionColor($expectedDateForActivity);
		}
		else {
			$statusColor = "green";
		}
		return $statusColor;
}


function buildActionDate ($dbSingleUse,$lotNumber, $siteShortName, $buildAction) {

	$query =  'SELECT date(buildDate) as dateFormatted FROM lotBuildResults where buildAction = "'.$buildAction.'" and lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'" limit 1';
		//echo '<br>'.$query;
		$resultCount = 0;
		$buildActionDate = '-';
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$buildActionDate =  $resultRow->dateFormatted;
///			$buildActionDate =  date('Y-m-d',$resultRow->buildDate);
		}
	return $buildActionDate;
}
function mostRecentBuildAction ($dbSingleUse,$lotNumber, $siteShortName) {

	$query =  'SELECT * FROM lotBuildResults where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'"  order by buildDate desc limit 1';
		//echo '<br>'.$query;
		$resultCount = 0;
		$buildAction = '-';
		if ($dbSingleUse->Query($query)) { 
			$resultRow = $dbSingleUse->Row(); 	
			$buildAction = $resultRow->buildAction;
		}
	return $buildAction;
}

function OLDgetExpectedCountForLocation($dbSingleUse, $location) {

	$query =  'SELECT count(*) as howMany FROM buildTimeline bt  where location = "'.$location.'"';
		//echo '<br>'.$query;
		$resultCount = 0;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$resultCount = $resultRow->howMany;
			}
		}
	return $resultCount;
}
function getExpectedCountForLotLocation($dbSingleUse, $location,$lotNumber, $siteShortName) {

	$query =  'SELECT count(*) as howMany FROM buildTimeline bt  where sequenceIsActive = 1 and location = "'.$location.'" and timeLineMasterID =
			(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")';
		//echo '<br>'.$query;
		$resultCount = 0;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$resultCount = $resultRow->howMany;
			}
		}
	return $resultCount;
}


function getCompletedCountForLot($dbSingleUse,$lotNumber, $siteShortName, $location, $buildAction) {

	$query =  'SELECT count(*) as howMany FROM lotBuildResults lbr join buildTimeline bt on  bt.buildAction = lbr.buildAction where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'" and location = "'.$location.' "
		and bt.sequenceIsActive = 1 
		and bt.timelineMasterID = 	(select timelineMasterID from lots where lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'")';
		//echo '<br>'.$query;
		$resultCount = 0;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				$resultCount = $resultRow->howMany;
			}
		}

	return $resultCount;

}

function getlotWatchCheckBox($db, $lotNumber, $siteShortName, $userName, $formAction) {
	$query = "select * from lotWatchList where userName = '".$userName."' and siteShortName = '".$siteShortName."' and lotnumber = ".$lotNumber;

	if ($db->Query($query)) { 
		while ($resultRow = $db->Row()) {
			$checked = 'checked="checked"';
		}
	}	

	echo '<form action="'.$formAction.'" method="post" name="form1" target="_self" id="form1">
			  	<input '.$checked.'  name="watchLot" type="checkbox" id="watchLot" value="watchIt" onclick="this.form.submit();"/>
  				<label for="watch"></label>
  				<input name="updateLotWatch" type="hidden" id="updateLotWatch" value="'.$lotNumber.'" />
  				<input name="siteShortName" type="hidden" id="siteShortName" value="'.$siteShortName.'" /></form>';

}


function setLotWatch($dbSingleUse,$siteShortName, $lotNumber,$watchLot, $userName) {
	echo "setting Watch on Lot Number:".$lotNumber." for user ".$userName;
	if ($watchLot == 'watchIt') {
		$query = 'insert into lotWatchList (userName, siteShortName, lotNumber) values ("'.$userName.'", "'.$siteShortName.'", '.$lotNumber.')';
	}
	else
	{
		$query = 'delete from lotWatchList where userName = "'.$userName.'" and lotNumber = '.$lotNumber.' and siteShortName = "'.$siteShortName.'"';
	}
	$numberOfRows = $dbSingleUse->Query($query);
	
	//echo "<br>".$query;
	//echo "<br>Number of Rows Affected:".$numberOfRows;
	return $numberOfRows;
}
function setLotClearingStatus($dbSingleUse,$siteShortName, $lotNumber,$buildAction, $statusCheckBox, $userName) {
	$numberOfRows = 0;
	if ($statusCheckBox == 'on') {
		echo "<br><b>Setting to COMPLETE</b> -- build action:".$buildAction.", on Lot Number:".$lotNumber.", for user:".$userName;
		$query =  'SELECT count(*) as howMany FROM lotBuildResults where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'" and buildAction = "'.$buildAction.'"';
		//echo '<br>'.$query;
		$okToSet = false;
		if ($dbSingleUse->Query($query)) { 
			while ($resultRow = $dbSingleUse->Row() ) {	
				if ($resultRow->howMany > 0){
					echo "<br><b>ERROR -- Already Complete: Setting to COMPLETE</b> -- Clearing Status for build action ".$buildAction." on Lot Number:".$lotNumber." for user ".$userName;
					$okToSet = false;
				}
				else {
					$okToSet = true;
				}
			}
		}
		if ($okToSet){
			$query = 'insert into lotBuildResults (userName, siteShortName, lotNumber, buildAction) values ("'.$userName.'", "'.$siteShortName.'", '.$lotNumber.',"'.$buildAction.'")';
			//echo '<br>'.$query;
			$numberOfRows = $dbSingleUse->Query($query);
			if ($numberOfRows < 1) {
				echo "<br><b>ERROR - Try Again - : Setting to COMPLETE</b> -- Clearing Status for build action ".$buildAction." on Lot Number:".$lotNumber." for user ".		$userName;
			}
			else {
				doBuildResultFollowup($dbSingleUse,$siteShortName, $lotNumber,$buildAction);
			}
			
		}
	}
	else
	{
		echo "<br><b>Setting to INCOMPLETE</b> -- Clearing Status for build action ".$buildAction." on Lot Number:".$lotNumber." for user ".$userName;
		$query =  'delete  FROM lotBuildResults where lotNumber =  '.$lotNumber.' and siteShortName = "'.$siteShortName.'" and buildAction = "'.$buildAction.'"';
		//echo "<br>".$query;
		$numberOfRows = $dbSingleUse->Query($query);
	}
	//echo "<br>Number of Rows Affected:".$numberOfRows;
	return $numberOfRows;
}

function translateToWords($number) 
    {
    /*****
         * A recursive function to turn digits into words
         * Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.    
         *
         *  (C) 2010 Peter Ajtai
         *    This program is free software: you can redistribute it and/or modify
         *    it under the terms of the GNU General Public License as published by
         *    the Free Software Foundation, either version 3 of the License, or
         *    (at your option) any later version.
         *
         *    This program is distributed in the hope that it will be useful,
         *    but WITHOUT ANY WARRANTY; without even the implied warranty of
         *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
         *    GNU General Public License for more details.
         *
         *    See the GNU General Public License: <http://www.gnu.org/licenses/>.
         *
         */
        // zero is a special case, it cause problems even with typecasting if we don't deal with it here
        $max_size = pow(10,18);
        if (!$number) return "zero";
        if (is_int($number) && $number < abs($max_size)) 
        {            
            switch ($number) 
            {
                // set up some rules for converting digits to words
                case $number < 0:
                    $prefix = "negative";
                    $suffix = translateToWords(-1*$number);
                    $string = $prefix . " " . $suffix;
                    break;
                case 1:
                    $string = "One";
                    break;
                case 2:
                    $string = "Two";
                    break;
                case 3:
                    $string = "Three";
                    break;
                case 4: 
                    $string = "Four";
                    break;
                case 5:
                    $string = "Five";
                    break;
                case 6:
                    $string = "Six";
                    break;
                case 7:
                    $string = "Seven";
                    break;
                case 8:
                    $string = "Eight";
                    break;
                case 9:
                    $string = "Nine";
                    break;                
                case 10:
                    $string = "Ten";
                    break;            
                case 11:
                    $string = "Eleven";
                    break;            
                case 12:
                    $string = "Twelve";
                    break;            
                case 13:
                    $string = "Thirteen";
                    break;            
                // fourteen handled later
                case 15:
                    $string = "Fifteen";
                    break;            
                case $number < 20:
                    $string = translateToWords($number%10);
                    // eighteen only has one "t"
                    if ($number == 18)
                    {
                    $suffix = "een";
                    } else 
                    {
                    $suffix = "teen";
                    }
                    $string .= $suffix;
                    break;            
                case 20:
                    $string = "Twenty";
                    break;            
                case 30:
                    $string = "Thirty";
                    break;            
                case 40:
                    $string = "Forty";
                    break;            
                case 50:
                    $string = "Fifty";
                    break;            
                case 60:
                    $string = "Sixty";
                    break;            
                case 70:
                    $string = "Seventy";
                    break;            
                case 80:
                    $string = "Eighty";
                    break;            
                case 90:
                    $string = "Ninety";
                    break;                
                case $number < 100:
                    $prefix = translateToWords($number-$number%10);
                    $suffix = translateToWords($number%10);
                    $string = $prefix . "-" . $suffix;
                    break;
                // handles all number 100 to 999
                case $number < pow(10,3):                    
                    // floor return a float not an integer
                    $prefix = translateToWords(intval(floor($number/pow(10,2)))) . " Hundred";
                    if ($number%pow(10,2)) $suffix = " and " . translateToWords($number%pow(10,2));
                    $string = $prefix . $suffix;
                    break;
                case $number < pow(10,6):
                    // floor return a float not an integer
                    $prefix = translateToWords(intval(floor($number/pow(10,3)))) . " Thousand";
                    if ($number%pow(10,3)) $suffix = translateToWords($number%pow(10,3));
                    $string = $prefix . " " . $suffix;
                    break;
                case $number < pow(10,9):
                    // floor return a float not an integer
                    $prefix = translateToWords(intval(floor($number/pow(10,6)))) . " Million";
                    if ($number%pow(10,6)) $suffix = translateToWords($number%pow(10,6));
                    $string = $prefix . " " . $suffix;
                    break;                    
                case $number < pow(10,12):
                    // floor return a float not an integer
                    $prefix = translateToWords(intval(floor($number/pow(10,9)))) . " billion";
                    if ($number%pow(10,9)) $suffix = translateToWords($number%pow(10,9));
                    $string = $prefix . " " . $suffix;    
                    break;
                case $number < pow(10,15):
                    // floor return a float not an integer
                    $prefix = translateToWords(intval(floor($number/pow(10,12)))) . " trillion";
                    if ($number%pow(10,12)) $suffix = translateToWords($number%pow(10,12));
                    $string = $prefix . " " . $suffix;    
                    break;        
                // Be careful not to pass default formatted numbers in the quadrillions+ into this function
                // Default formatting is float and causes errors
                case $number < pow(10,18):
                    // floor return a float not an integer
                    $prefix = translateToWords(intval(floor($number/pow(10,15)))) . " quadrillion";
                    if ($number%pow(10,15)) $suffix = translateToWords($number%pow(10,15));
                    $string = $prefix . " " . $suffix;    
                    break;                    
            }
        } else
        {
            echo "ERROR with - $number<br/> Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
        }
        return $string;    
    }
function prattDebug($value)
	{
		if ($_GET['debug']) 
		{
			print_r($value);
			echo '<br><br>';
			print_r($_SESSION);
		}
	}
?>