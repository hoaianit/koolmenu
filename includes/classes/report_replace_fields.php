<?php


function getRTOValue($offerInfo, $dbSingleUse, $fieldName, $ordinal ) {


	$currentSettingCheck = 'Show Occupancy Fee on Offer Screen';
	$useOccFeeOnOffer = nullToChar(getSettingValue($dbSingleUse, $currentSettingCheck),0) ;

	$returnValue = '';
	if (isset($offerInfo->rentToOwnSubsequentDeposits)) {
		if ($offerInfo->numberOfPayments >= $ordinal) {
			if ($ordinal == 1) {
				$occFee = 0;
				$depositAmount = $offerInfo->rentToOwnInitialDeposit;
			}
			else {
				$currentSettingCheck = 'Occupancy Field Default Value';
				if ($useOccFeeOnOffer) {
					$occFee = $offerInfo->occupancyFee ;
				} 
				else {
					$occFee = nullToChar(getSettingValue($dbSingleUse, $currentSettingCheck),0) ;
				}
				$depositAmount = $offerInfo->rentToOwnSubsequentDeposits;
			}
			if ($ordinal == 1 or ($ordinal > 1 and $occFee > 0 )) {
				if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
					$occDate = date("F dS, Y", strtotime(date("F dS, Y", strtotime($offerInfo->occupancyDate)) . " +".$ordinal." month"));
				}
				$chequeAmount = $occFee + $depositAmount;
				if ($fieldName == "Occupancy Fee") {
					if ($occFee > 0) {
						$returnValue = money_format('%(#10n',$occFee);
					}
				}
				if ($fieldName == "Cheque Amount") {
						$returnValue = money_format('%(#10n',$chequeAmount);
				}
				if ($fieldName == "Deposit Amount") {
						$returnValue = money_format('%(#10n',$depositAmount);
				}
				if ($fieldName == "Occupancy Date" and $offerInfo->numberOfPayments > $ordinal) {
						$returnValue = $occDate;
				}
			}
			else {
				$returnValue = "Occ Fee not Set";
			}

		}
	}


	return $returnValue;
}


function getTodaysDateFromDatabase($dbSingleUse) {
	$returnValue = ''	;
	$query = "select DATE_FORMAT(NOW(),'%W, %M %e, %Y ') as todaysDate from settings
";
	if ($dbSingleUse->Query($query)) { 
	    $rowValue = $dbSingleUse->Row();
		$returnValue = $rowValue->todaysDate;
	}
	return $returnValue;
}

function formatExtras($offerInfo, $dbSingleUse,$showPrice ) {
	$siteShortName = $offerInfo->siteShortName;
	$lotNumber = $offerInfo->lotNumber;
	include("offer_discount_values.php");
// This is the function I am currently working in
    $returnValue = '';
	$query = 'select *';
	$query = $query.' from offerFeatures where  siteShortName = "'.$offerInfo->siteShortName.'" and lotNumber ='.$offerInfo->lotNumber;
	$query = $query.' order by id ';
//	echo '<br>'.$tableName.'-'.$itemNumber.'-'.$query;
	if ($dbSingleUse->Query($query)) { 
	    while ($rowValue = $dbSingleUse->Row()) {
			if ($rowNum == 0) {
				$returnValue .= '<w:tbl>';
				$returnValue .='<w:tblPr>
<w:tblStyle w:val="TableGrid"/><w:tblW w:w="0" w:type="auto"/>
<w:tblLook w:val="04A0" w:firstRow="1" w:lastRow="0" w:firstColumn="1" w:lastColumn="0" w:noHBand="0" w:noVBand="1"/>
</w:tblPr>';
//				$returnValue .= '<w:tblGrid><w:gridCol w:w="4788"/><w:gridCol w:w="4788"/></w:tblGrid>';
				$returnValue .= '<w:tr>';
	//			$returnValue .= '<w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:sz w:val="32"/>';
	
				$returnValue .= '<w:tc>';
				$returnValue .= '<w:tcPr><w:tcW w:w="600" w:type="dxa"/>';
				$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="nil"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
	//			$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="nil"/><w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:right w:val="nil"/></w:tcBorders>';
				$returnValue .= '</w:tcPr>';
				$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="22"/></w:rPr><w:t>ITEM</w:t></w:r></w:p>';
				$returnValue .= '</w:tc>';
	
				$returnValue .= '<w:tc>';
				$returnValue .= '<w:tcPr><w:tcW w:w="7600" w:type="dxa"/>';
				$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="single"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
				$returnValue .= '</w:tcPr>';
				$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="28"/></w:rPr><w:t>EXTRA DETAIL:</w:t></w:r></w:p>';
				$returnValue .= '</w:tc>';
	
				if ($showPrice == true) {
					$returnValue .= '<w:tc>';
					$returnValue .= '<w:tcPr><w:tcW w:w="900" w:type="dxa"/>';
					$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="single"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
					$returnValue .= '</w:tcPr>';
					$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="28"/></w:rPr><w:t>MSRP</w:t></w:r></w:p>';
					$returnValue .= '</w:tc>';
					$returnValue .= '<w:tc>';
					$returnValue .= '<w:tcPr><w:tcW w:w="900" w:type="dxa"/>';
					$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="single"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
					$returnValue .= '</w:tcPr>';
					$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="28"/></w:rPr><w:t>PRICE</w:t></w:r></w:p>';
					$returnValue .= '</w:tc>';
				}
	//			$returnValue .= '<w:tc><w:p><w:r><w:t>'.$rowValue->featureResalePrice.'</w:t></w:r></w:p></w:tc>';
	
				$returnValue .= '</w:tr>';

			}
			$rowNum = $rowNum  + 1;

			$featureAfterDiscount = 0;
			if ($sumResalePriceDiscoutAllowed > 0 and $rowValue->featureDiscountAllowed == 1) {
				$featureAfterDiscount = $rowValue->featureResalePrice - ( $offerDiscountAmount*($rowValue->featureResalePrice/$sumResalePriceDiscoutAllowed)) ;
			}
			else {
				$featureAfterDiscount = $rowValue->featureResalePrice ;
			}
			$sumDiscounts = $sumDiscounts + $featureAfterDiscount;			

			$returnValue .= '<w:tr>';
//			$returnValue .= '<w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:sz w:val="32"/>';

			$returnValue .= '<w:tc>';
			$returnValue .= '<w:tcPr><w:tcW w:w="600" w:type="dxa"/>';
			$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="nil"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
//			$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="nil"/><w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:right w:val="nil"/></w:tcBorders>';
			$returnValue .= '</w:tcPr>';
			$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="28"/></w:rPr><w:t>'.$rowNum.'</w:t></w:r></w:p>';
	    	$returnValue .= '</w:tc>';

			$returnValue .= '<w:tc>';
			$returnValue .= '<w:tcPr><w:tcW w:w="7600" w:type="dxa"/>';
			$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="single"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
			$returnValue .= '</w:tcPr>';
			$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="22"/></w:rPr><w:t>'.$rowValue->featureText.'</w:t></w:r></w:p>';
			$returnValue .= '</w:tc>';

			if ($showPrice == true) {
				$returnValue .= '<w:tc>';
				$returnValue .= '<w:tcPr><w:tcW w:w="900" w:type="dxa"/>';
				$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="single"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
				$returnValue .= '</w:tcPr>';
				$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="22"/></w:rPr><w:t>$'.$rowValue->featureResalePrice.'</w:t></w:r></w:p>';
				$returnValue .= '</w:tc>';
				$returnValue .= '<w:tc>';
				$returnValue .= '<w:tcPr><w:tcW w:w="900" w:type="dxa"/>';
				$returnValue .= '<w:tcBorders><w:top w:val="single"/><w:left w:val="single"/><w:bottom w:val="nil"/><w:right w:val="nil"/></w:tcBorders>';
				$returnValue .= '</w:tcPr>';
				$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="22"/></w:rPr><w:t>'.money_format('%.2n',$featureAfterDiscount).'</w:t></w:r></w:p>';
				$returnValue .= '</w:tc>';
			}
//			$returnValue .= '<w:tc><w:p><w:r><w:t>'.$rowValue->featureResalePrice.'</w:t></w:r></w:p></w:tc>';

			$returnValue .= '</w:tr>';

			$returnValue .= '<w:tr>';

			$returnValue .= '<w:tc>';
			$returnValue .= '<w:tcPr><w:tcW w:w="600" w:type="dxa"/>';
			$returnValue .= '<w:tcBorders><w:top w:val="nil"/><w:left w:val="nil"/><w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:right w:val="single"/></w:tcBorders>';
			$returnValue .= '</w:tcPr>';
			$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="28"/></w:rPr><w:t></w:t></w:r></w:p>';
	    	$returnValue .= '</w:tc>';
			
			$returnValue .= '<w:tc>';
			$returnValue .= '<w:tcPr><w:tcW w:w="7600" w:type="dxa"/>';
//			$returnValue .= '<w:tcPr><w:tcW w:w="4000" w:type="dxa"/>';
			$returnValue .= '<w:tcBorders><w:top w:val="nil"/><w:left w:val="single"/><w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:right w:val="nil"/></w:tcBorders>';
			$returnValue .= '</w:tcPr>';
			$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="off"/><w:sz w:val="16"/></w:rPr><w:t>'.$rowValue->featureSubText.'</w:t></w:r></w:p>';
			$returnValue .= '</w:tc>';

			if ($showPrice == true) {
				$returnValue .= '<w:tc>';
				$returnValue .= '<w:tcPr><w:tcW w:w="900" w:type="dxa"/>';
				$returnValue .= '<w:tcBorders><w:top w:val="nil"/><w:left w:val="single"/><w:bottom w:val="single"/><w:right w:val="nil"/></w:tcBorders>';
				$returnValue .= '</w:tcPr>';
				$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="22"/></w:rPr><w:t></w:t></w:r></w:p>';
				$returnValue .= '</w:tc>';
				$returnValue .= '<w:tc>';
				$returnValue .= '<w:tcPr><w:tcW w:w="900" w:type="dxa"/>';
				$returnValue .= '<w:tcBorders><w:top w:val="nil"/><w:left w:val="single"/><w:bottom w:val="single"/><w:right w:val="nil"/></w:tcBorders>';
				$returnValue .= '</w:tcPr>';
				$returnValue .= '<w:p><w:r><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/><w:rPr><w:b w:val="on"/><w:sz w:val="22"/></w:rPr><w:t></w:t></w:r></w:p>';
				$returnValue .= '</w:tc>';
			}
			$returnValue .= '</w:tr>';
		}
	}
	if ($rowNum > 0) {
		$returnValue .= '</w:tbl>';
	}
	//echo $returnValue;
	return $returnValue;
}

function getAmendmentPrintItem($tableName, $offerInfo, $dbSingleUse, $itemNumber, $columnName) {

	$query = 'select ';
	if ($itemNumber  == 99) {
		$offset = 0;
		$query = $query.' sum('.$columnName.') as '.$columnName;
	}
	else {
		$offset = $itemNumber - 1;
		$query = $query.' * ';
	}
	$query = $query.' from '.$tableName.' where  siteShortName = "'.$offerInfo->siteShortName.'" and lotNumber ='.$offerInfo->lotNumber;
	if ($tableName <> 'offerFeatures') {
		$query = $query.' and printThisItem = true  ';
	}
	$query = $query.' order by id ';
	$query = $query.' limit '.$offset.', 1';
//	echo '<br>'.$tableName.'-'.$itemNumber.'-'.$query;
	if ($dbSingleUse->Query($query)) { 
	    $rowValue = $dbSingleUse->Row();
		if (strtoupper($columnName) == 'AMDADDDAYTH1') {
				$returnValue = date('dS',strtotime($rowValue->amendmentAddedDate));
		}
		elseif (strtoupper($columnName) == 'AMDSGNDAYTH1') {
				$returnValue = date('dS',strtotime($rowValue->dateDocumentSigned));
		}
		elseif (strtoupper($columnName) == 'AMDADDMONTHTEXT1') {
				$returnValue = date('F',strtotime($rowValue->amendmentAddedDate));
		}
		elseif (strtoupper($columnName) == 'AMDSGNMONTHTEXT1') {
				$returnValue = date('F',strtotime($rowValue->dateDocumentSigned));
		}
		elseif (strtoupper($columnName) == 'AMDADD1YR2') {
				$returnValue = date('y',strtotime($rowValue->amendmentAddedDate));
		}
		elseif (strtoupper($columnName) == 'AMDSGN1YR2') {
				$returnValue = date('y',strtotime($rowValue->dateDocumentSigned));
		}
		else {
				$returnValue = $rowValue->$columnName;
		}
	}


	return $returnValue;
}
function getDepositPrintItem($offerInfo, $dbSingleUse, $itemNumber) {

	$query = 'select  * from offerDeposits';
	$offset = $itemNumber - 1;
	$query = $query.' where  siteShortName = "'.$offerInfo->siteShortName.'" and lotNumber ='.$offerInfo->lotNumber;
	$query = $query.' order by dueDate ';
	$query = $query.' limit '.$offset.', 1';
	//echo '<br>'.$tableName.'-'.$itemNumber.'-'.$query;
	if ($dbSingleUse->Query($query)) { 
	    $rowValue = $dbSingleUse->Row();
		$returnValue = $rowValue->expectedAmount;
	}
	return $returnValue;
}
function calcDepositSumOfAmounts($offerInfo, $dbSingleUse, $howManyItems) {

	$query = 'select  * from offerDeposits';
	$offset = $itemNumber - 1;
	$query = $query.' where  siteShortName = "'.$offerInfo->siteShortName.'" and lotNumber ='.$offerInfo->lotNumber;
	$query = $query.' order by dueDate ';
	$query = $query.' limit '.$howManyItems;
	//echo '<br>'.$tableName.'-'.$itemNumber.'-'.$query;
	$returnValue = 0;
	if ($dbSingleUse->Query($query)) { 
 	    while ($rowValue = $dbSingleUse->Row()) {
			$returnValue = $returnValue + $rowValue->expectedAmount;
		}
	}
	return $returnValue;
}

function getOfferText($offerInfo, $textToReplace,$dbSingleUse = null){
	setlocale(LC_MONETARY, "en_US");
 
	$returnValue = "need to add logic - mike";

	$query = '';

	$textToReplaceOriginal = $textToReplace;
	$textToReplace = strtoupper($textToReplace);

	if (
	 	$textToReplaceOriginal == 'elevation'
	or	$textToReplacOriginale == 'lotNumber'
	or 	$textToReplaceOriginal == 'lotSize'
	or 	$textToReplaceOriginal == 'modelName'
	or 	$textToReplaceOriginal == 'munStreetAddress'
	or 	$textToReplaceOriginal == 'munStreetNumber'
	or 	$textToReplaceOriginal == 'numberOfBedrooms'
	or 	$textToReplaceOriginal == 'planNumber'
	or 	$textToReplaceOriginal == 'postalCode'
	or 	$textToReplaceOriginal == 'siteName'
	or 	$textToReplaceOriginal == 'siteShortName'
	or 	$textToReplaceOriginal == 'amendedClosingText'
	or 	$textToReplaceOriginal == 'amendedOccupancyText'
	or 	$textToReplaceOriginal == 'homePhone'
	or 	$textToReplaceOriginal == 'workPhone'
	or 	$textToReplaceOriginal == 'otherPhone'
	or 	$textToReplaceOriginal == 'email1'
	or 	$textToReplaceOriginal == 'clientAddress'
	or 	$textToReplaceOriginal == 'clientCity'
	or 	$textToReplaceOriginal == 'clientProvince'
	or 	$textToReplaceOriginal == 'parkingNumber'
	or 	$textToReplaceOriginal == 'clientPostalCode'
	or 	$textToReplaceOriginal == 'frontDoor'
	or 	$textToReplaceOriginal == 'garageSize'

	) {
	$returnValue =  $offerInfo->$textToReplaceOriginal;
	}

	elseif (
	 	$textToReplaceOriginal == 'amendedClosingDate'
	or	$textToReplaceOriginal == 'calculatedClosingDate'
	or	$textToReplaceOriginal == 'calculatedOccupancyDate'
	or	$textToReplaceOriginal == 'moveInDate'
	or	$textToReplaceOriginal == 'calculatedClosingDate'
	or 	$textToReplaceOriginal == 'closingDate'
	or 	$textToReplaceOriginal == 'occupancyDate'
	or 	$textToReplaceOriginal == 'offerDate'
	) {
		if (isset($offerInfo->$textToReplaceOriginal)  &&  $offerInfo->$textToReplaceOriginal > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->$textToReplaceOriginal));
		}
		else {
			$returnValue =  '-';
		}
	}
	elseif ($textToReplace == strtoupper('BIRTHDATE1')) {
		$returnValue = '';
		if (isset($offerInfo->birthDate1)  &&  $offerInfo->birthDate1 > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->birthDate1));
		}
	}
	elseif ($textToReplace == strtoupper('BIRTHDATE2')) {
		$returnValue = '';
		if (isset($offerInfo->birthDate2)  &&  $offerInfo->birthDate2 > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->birthDate2));
		}
	}
	elseif ($textToReplace == strtoupper('BIRTHDATE3')) {
		$returnValue = '';
		if (isset($offerInfo->birthDate3)  &&  $offerInfo->birthDate3 > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->birthDate3));
		}
	}
	elseif ($textToReplace == strtoupper('allBirthDates')) {
		$returnValue = '';
		if (isset($offerInfo->birthDate1)  &&  $offerInfo->birthDate1 > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->birthDate1));
		}
		if ($returnValue > '' and isset($offerInfo->birthDate2) && $offerInfo->birthDate2 > '0000-00-00') { 
			$returnValue = $returnValue.' and ';
		}
		if (isset($offerInfo->birthDate2) && $offerInfo->birthDate2 > '0000-00-00') { 
			$returnValue =  $returnValue.date('F dS, Y',strtotime($offerInfo->birthDate2));
		}
		if ($returnValue > '' and isset($offerInfo->birthDate3) && $offerInfo->birthDate3 > '0000-00-00') { 
			$returnValue = $returnValue.' and ';
		}
		if (isset($offerInfo->birthDate3) && $offerInfo->birthDate3 > '0000-00-00') { 
			$returnValue =  $returnValue.date('F dS, Y',strtotime($offerInfo->birthDate3));
		}
	}
	elseif ($textToReplace == strtoupper('offerBaseAmount')) {
		$returnValue = '';
		$number = $offerInfo->offerPrice;
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('offerDollarsInText')) {
		$returnValue = '';
		$number = $offerInfo->offerPrice + calcSumOfFeatures($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) - $offerInfo->offerDiscountAmount;
		$returnValue = translateToWords(intval($number));
	}
	
	elseif ($textToReplace == strtoupper('offerAmount')) {
		$returnValue = '';
		$number = $offerInfo->offerPrice + calcSumOfFeatures($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) - $offerInfo->offerDiscountAmount;
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('offerAmountWithAmendments')) {
		$returnValue = '';
		$number = $offerInfo->offerPrice 
						+ calcSumOfFeatures($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) 
						+ calcSumOfAmendments($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) 
								- $offerInfo->offerDiscountAmount;
		$returnValue = money_format('%(#10n',$number);
	}
	
	elseif ($textToReplace == strtoupper('discountActual')) {
		$returnValue = '';
		$number = $offerInfo->offerDiscountAmount;
		$returnValue = money_format('%(#10n',$number);
	}
	
	elseif ($textToReplace == strtoupper('discountAllowable')) {
		$returnValue = '';
		$number = 	getAvailableSiteDiscount($dbSingleUse,$offerInfo->siteShortName) * calcSumOfFeaturesAllowingDiscount($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) / 100;
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('discountAllowableInteger')) {
		$returnValue = '';
		$number = 	getAvailableSiteDiscount($dbSingleUse,$offerInfo->siteShortName) * calcSumOfFeaturesAllowingDiscount($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) / 100;
		$returnValue = number_format($number, 0,'','');
	}
	elseif ($textToReplace == strtoupper('amendmentsSum')) {
		$returnValue = '';
		$number = 	calcSumOfAmendments($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName);
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('extrasSum')) {
		$returnValue = '';
		$number = 	calcSumOfFeatures($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName);
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('extrasSumAllowingDiscount')) {
		$returnValue = '';
		$number = 	calcSumOfFeaturesAllowingDiscount($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName);
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('extrasSumAllowingDiscountInteger')) {
		$returnValue = '';
		$number = 	calcSumOfFeaturesAllowingDiscount($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName);
		$returnValue = number_format($number, 0,'','');
	}
	
	elseif ($textToReplace == strtoupper('MSRP')) {
		$returnValue = '';
		$number = 	calcSumOfFeatures($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) + $offerInfo->offerPrice;
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('rtoSubsequentDeposits')) {
		$returnValue = '';
		$number = 0;
		if ($offerInfo->rentToOwnSubsequentDeposits > 0 ) {
				$number = 	$offerInfo->rentToOwnSubsequentDeposits ;
		}
		$returnValue = money_format('%(#10n',$number);
		if ($number == 0) {
			$returnValue = '';
		}
	}
	elseif ($textToReplace == strtoupper('sumOfRtoDeposits') || $textToReplace == strtoupper('RtoTotalDeposits')) {
		$returnValue = '';
		$number = 0;
		if (isset($offerInfo->numberOfPayments)) {
			if ($offerInfo->rentToOwnInitialDeposit > 0 ) {
				$number = 	$offerInfo->rentToOwnInitialDeposit + ($offerInfo->rentToOwnSubsequentDeposits * ($offerInfo->numberOfPayments - 1));
			}
		}
		$returnValue = money_format('%(#10n',$number);
		if ($number == 0) {
			$returnValue = '-';
		}
	}
	elseif (
	 	$textToReplace == strtoupper('ParkingNumber')) {
			$returnValue  = $offerInfo->parkingNumber;
	}
	elseif (
	 	$textToReplace == strtoupper('pCity')) {
			
			$returnValue  = $offerInfo->clientCity;
	}
	elseif (
	 	$textToReplace == strtoupper('pProv')) {
			
			$returnValue  = $offerInfo->clientProvince;
	}
	elseif (
	 	$textToReplace == strtoupper('pPostal')) {
			
			$returnValue  = $offerInfo->clientPostalCode;
	}
	elseif (
	 	$textToReplace == strtoupper('pStreet')) {
			
			$returnValue  = $offerInfo->clientAddress;
	}
	elseif (
	 	substr($textToReplace,0,13) == strtoupper('AmendmentItem')) {
			$ordinal = substr($textToReplace, 13,2);
			$returnValue =  getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse,$ordinal, "amendmentDescription" );
	}
	elseif (
	 	substr($textToReplace,0,7) == strtoupper('AmendPr')) {
			$ordinal = substr($textToReplace, 7,2);
			$returnValue =  getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse,$ordinal, "amendmentResalePrice" );
			if ($returnValue > '') {
				$returnValue = money_format('%.2n',floatval($returnValue));
			}
	}
	elseif (
	 	substr($textToReplace,0,11) == strtoupper('AmendSigned')) {
			$ordinal = substr($textToReplace, 11,2);
			$returnValue =  getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse,$ordinal, "dateDocumentSigned" );
    		if ($returnValue > '0000-00-00') {
				$returnValue =  date('F dS, Y',strtotime($returnValue));
			}
	}
	elseif (
	 	$textToReplace == strtoupper('AmendTot')) {
			$returnValue =   money_format('%.2n',getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse, 99, "amendmentResalePrice" ));
	}
	elseif (
	 	$textToReplace == strtoupper('AmdAddDayth1')) {
			$returnValue =   getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse, 1, $textToReplace );
	}
	elseif (
	 	$textToReplace == strtoupper('AmdAddMonthText1')) {
			$returnValue =   getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse, 1, $textToReplace );
	}
	elseif (
	 	$textToReplace == strtoupper('AmdAdd1Yr2')) {
			$returnValue =   getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse, 1, $textToReplace );
	}
	elseif (
	 	$textToReplace == strtoupper('AmdSgnDayth1')) {
			$returnValue =   getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse, 1, $textToReplace );
	}
	elseif (
	 	$textToReplace == strtoupper('AmdSgnMonthText1')) {
			$returnValue =   getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse, 1, $textToReplace );
	}
	elseif (
	 	$textToReplace == strtoupper('AmdSgn1Yr2')) {
			$returnValue =   getAmendmentPrintItem("offerAmendments",$offerInfo, $dbSingleUse, 1, $textToReplace );
	}
	elseif (
	 	$textToReplace == strtoupper('Bd')) {
			
			$returnValue  = $offerInfo->numberOfBedrooms;
	}
	elseif (
	 	$textToReplace == strtoupper('Bedroom')) {
			
			$returnValue  = $offerInfo->numberOfBedrooms;
	}
	elseif (
	 	substr($textToReplace,0,15) == strtoupper('ChangeOrderItem')) {
			$returnValue =  getAmendmentPrintItem("offerChangeOrders",$offerInfo, $dbSingleUse,substr($textToReplace, strlen($textToReplace) -1,1), "changeDescription" );
	}
	elseif (
	 	substr($textToReplace,0,8) == strtoupper('ChgOrdPr')) {
			$returnValue =  getAmendmentPrintItem("offerChangeOrders",$offerInfo, $dbSingleUse,substr($textToReplace, strlen($textToReplace) -1,1), "changePrice" );
			if ($returnValue > '') {
				$returnValue = money_format('%.2n',floatval($returnValue));
			}
	}
	elseif (
	 	substr($textToReplace,0,12) == strtoupper('ChgOrdSigned')) {
			$returnValue =  getAmendmentPrintItem("offerChangeOrders",$offerInfo, $dbSingleUse,substr($textToReplace, strlen($textToReplace) -1,1), "dateDocumentSigned" );
    		if ($returnValue > '0000-00-00') {
				$returnValue =  date('F dS, Y',strtotime($returnValue));
			}
	}
	elseif (
	 	$textToReplace == strtoupper('ChgOrdTot')) {
			$returnValue =   money_format('%.2n',getAmendmentPrintItem("offerChangeOrders",$offerInfo, $dbSingleUse, 99, "changePrice" ));
	}
	elseif (
	 	$textToReplace == strtoupper('CloseDate')) {
		$returnValue = '';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->closingDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CalculatedCloseDate')) {
		$returnValue = '';
		if (isset($offerInfo->calculatedClosingDate)  &&  $offerInfo->calculatedClosingDate > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->calculatedClosingDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CloseDateTarion')) {
		$returnValue = 'the ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('dS',strtotime($offerInfo->closingDate));
		}
		$returnValue = $returnValue.' of ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('F',strtotime($offerInfo->closingDate));
		}
		$returnValue = $returnValue.', ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('Y',strtotime($offerInfo->closingDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CloseDateTarionPlus365')) {
		$returnValue = 'the ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('dS',strtotime($offerInfo->closingDate. " +365 day")) ;
		}
		$returnValue = $returnValue.' of ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('F',strtotime($offerInfo->closingDate. " +365 day")) ;
		}
		$returnValue = $returnValue.', ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('Y',strtotime($offerInfo->closingDate. " +365 day"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CloseDateTarionPlus395')) {
		$returnValue = 'the ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('dS',strtotime($offerInfo->closingDate. " +395 day")) ;
		}
		$returnValue = $returnValue.' of ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('F',strtotime($offerInfo->closingDate. " +395 day")) ;
		}
		$returnValue = $returnValue.', ';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  $returnValue.date('Y',strtotime($offerInfo->closingDate. " +395 day"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CloseDateAmended')) {
		$returnValue = '';
		if (isset($offerInfo->amendedClosingDate)  &&  $offerInfo->amendedClosingDate > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->amendedClosingDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CloseDayTH')) {
		$returnValue = '';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  date('dS',strtotime($offerInfo->closingDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CloseMonthText')) {
		$returnValue = '';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  date('F',strtotime($offerInfo->closingDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('CurrentDate')) {
			$returnValue =  date('F dS, Y');
	}
	elseif (
	 	$textToReplace == strtoupper('Cyr2')) {
		$returnValue = '';
		if (isset($offerInfo->closingDate)  &&  $offerInfo->closingDate > '0000-00-00') {
			$returnValue =  date('y',strtotime($offerInfo->closingDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('Elev')) {
			
			$returnValue  = $offerInfo->elevation;
	}
	elseif (
	 	$textToReplace == strtoupper('Elevation')) {
			
			$returnValue  = $offerInfo->elevation;
	}
	elseif (
	 	$textToReplace == strtoupper('email')) {
			
			$returnValue  = $offerInfo->email1;
	}
	elseif (
	 	$textToReplace == strtoupper('ExtrasAll')) {
			
			$returnValue  = formatExtras($offerInfo, $dbSingleUse, false );
	}
	elseif (
	 	$textToReplace == strtoupper('ExtrasAllWithPrice')) {
			
			$returnValue  = formatExtras($offerInfo, $dbSingleUse, true );
	}
	elseif (
	 	substr($textToReplace,0,8) == strtoupper('ExtraNot')) {
			if (substr($textToReplace,10,5) == strtoupper('Price') || substr($textToReplace,9,5) == strtoupper('Price') ) {
				$ordinal = substr($textToReplace, 8,2);
				if (is_numeric($ordinal)) {
					// 0k - because the ordinal is two digits long
				}
				else {
					$ordinal = substr($ordinal,0,1);
				}
				$returnValue =  getAmendmentPrintItem("offerFeatures",$offerInfo, $dbSingleUse,$ordinal, "featureResalePrice" );
				if ($returnValue > '') {
				$returnValue = money_format('%.2n',floatval($returnValue));
				}
			}
			elseif (substr($textToReplace,10,7) == strtoupper('Subtext') || substr($textToReplace,9,7) == strtoupper('Subtext') ) {
				$ordinal = substr($textToReplace, 8,2);
				if (is_numeric($ordinal)) {
					// 0k - because the ordinal is two digits long
				}
				else {
					$ordinal = substr($ordinal,0,1);
				}
				$returnValue =  getAmendmentPrintItem("offerFeatures",$offerInfo, $dbSingleUse,$ordinal, "featureSubText" );
			}
			else {
				$ordinal = substr($textToReplace, 8,2);
				if (is_numeric($ordinal)) {
					// 0k - because the ordinal is two digits long
				}
				else {
					$ordinal = substr($ordinal,0,1);
				}
				$returnValue =  getAmendmentPrintItem("offerFeatures",$offerInfo, $dbSingleUse,$ordinal, "featureText" );
			}
	}
	elseif (
	 	$textToReplace == strtoupper('FrontDoor')) {
			
			$returnValue  = $offerInfo->frontDoor;
	}
	elseif (
	 	$textToReplace == strtoupper('GarageSize')) {
			
			$returnValue  = $offerInfo->garageSize;
	}
	elseif (
	 	$textToReplace == strtoupper('OfferDayTH')) {
		$returnValue = '';
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$returnValue =  date('dS',strtotime($offerInfo->offerDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('IrrevDayTH')) {
		$returnValue = '';
		if (isset($offerInfo->irrevocableDate)  &&  $offerInfo->irrevocableDate > '0000-00-00') {
			$returnValue =  date('dS',strtotime($offerInfo->irrevocableDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OfferMonthText')) {
		$returnValue = '';
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$returnValue =  date('F',strtotime($offerInfo->offerDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('IrrevMonthText')) {
		$returnValue = '';
		if (isset($offerInfo->irrevocableDate)  &&  $offerInfo->irrevocableDate > '0000-00-00') {
			$returnValue =  date('F',strtotime($offerInfo->irrevocableDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('irrevYr2')) {
		$returnValue = '';
		if (isset($offerInfo->irrevocableDate)  &&  $offerInfo->irrevocableDate > '0000-00-00') {
			$returnValue =  date('y',strtotime($offerInfo->irrevocableDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('oYr2')) {
		$returnValue = '';
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$returnValue =  date('y',strtotime($offerInfo->offerDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('irrevPlus60Days')) {
		if (isset($offerInfo->irrevocableDate)  &&  $offerInfo->irrevocableDate > '0000-00-00') {
			$newDate = getIrrevocableDatePlusDays($dbSingleUse, $offerInfo->lotNumber, $offerInfo->siteShortName,60);
			$returnValue =  date('F dS, Y',strtotime($newDate));
		}
		else {
			$returnValue =  '-';
		}
	}
	elseif (
	 	$textToReplace == strtoupper('Lawyer')) {
			
			$returnValue  = $offerInfo->lawyer;
	}
	elseif (
	 	$textToReplace == strtoupper('LotCity')) {
			
			$returnValue  = $offerInfo->city;
	}
	elseif (
	 	$textToReplace == strtoupper('LotNum')) {
			
			$returnValue  = $offerInfo->lotNumber;
	}
	elseif (
	 	$textToReplace == strtoupper('LotPostal')) {
			
			$returnValue  = $offerInfo->postalCode;
	}
	elseif (
	 	$textToReplace == strtoupper('LotSize')) {
			
			$returnValue  = $offerInfo->lotSize;
	}
	elseif (
	 	$textToReplace == strtoupper('Model')) {
			
			$returnValue  = $offerInfo->modelName;
	}
	elseif (
	 	$textToReplace == strtoupper('MunicipalAddress')) {
			
			$returnValue  = $offerInfo->munStreetAddress;
			$returnValue = trim($offerInfo->munStreetNumber.' '.$offerInfo->munStreetAddress);
	}
	elseif (
	 	$textToReplace == strtoupper('PurchaserAddress')) {
			
			$returnValue = trim($offerInfo->clientAddress.'  '.$offerInfo->clientCity).', '.$offerInfo->clientProvince;
	}
	elseif (
	 	$textToReplace == strtoupper('OccDate')) {
		$returnValue = '';
		if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->occupancyDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OccDatePlus1M')) {
		$returnValue = '';
		if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
			$returnValue = date("F dS, Y", strtotime(date("F dS, Y", strtotime($offerInfo->occupancyDate)) . " +1 month"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OccDatePlus2M')) {
		$returnValue = '';
		if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
			$returnValue = date("F dS, Y", strtotime(date("F dS, Y", strtotime($offerInfo->occupancyDate)) . " +2 month"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OccDatePlus3M')) {
		$returnValue = '';
		if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
			$returnValue = date("F dS, Y", strtotime(date("F dS, Y", strtotime($offerInfo->occupancyDate)) . " +3 month"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OccDatePlus4M')) {
		$returnValue = '';
		if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
			$returnValue = date("F dS, Y", strtotime(date("F dS, Y", strtotime($offerInfo->occupancyDate)) . " +4 month"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OccDatePlus5M')) {
		$returnValue = '';
		if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
			$returnValue = date("F dS, Y", strtotime(date("F dS, Y", strtotime($offerInfo->occupancyDate)) . " +5 month"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OccDatePlus5M')) {
		$returnValue = '';
		if (isset($offerInfo->occupancyDate)  &&  $offerInfo->occupancyDate > '0000-00-00') {
			$returnValue = date("F dS, Y", strtotime(date("F dS, Y", strtotime($offerInfo->occupancyDate)) . " +5 month"));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OfferDateFull')) {
		$returnValue = '';
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->offerDate));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('offerPlus1Mth')) {
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$newDate = getOfferDatePlusMonths($dbSingleUse, $offerInfo->lotNumber, $offerInfo->siteShortName,1);
			$returnValue =  date('F dS, Y',strtotime($newDate));

		}
		else {
			$returnValue =  '-';
		}
	}
	elseif (
	 	$textToReplace == strtoupper('offerPlus2Mth')) {
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$newDate = getOfferDatePlusMonths($dbSingleUse, $offerInfo->lotNumber, $offerInfo->siteShortName,2);
			$returnValue =  date('F dS, Y',strtotime($newDate));

		}
		else {
			$returnValue =  '-';
		}
	}
	elseif (
	 	$textToReplace == strtoupper('offerPlus30Days')) {
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$newDate = getOfferDatePlusDays($dbSingleUse, $offerInfo->lotNumber, $offerInfo->siteShortName,30);
			$returnValue =  date('F dS, Y',strtotime($newDate));
		}
		else {
			$returnValue =  '-';
		}
	}
	elseif (
	 	$textToReplace == strtoupper('offerPlus60Days')) {
		if (isset($offerInfo->offerDate)  &&  $offerInfo->offerDate > '0000-00-00') {
			$newDate = getOfferDatePlusDays($dbSingleUse, $offerInfo->lotNumber, $offerInfo->siteShortName,60);
			$returnValue =  date('F dS, Y',strtotime($newDate));
		}
		else {
			$returnValue =  '-';
		}
	}
	elseif (
	 	$textToReplace == strtoupper('OfferSignedDate')) {
		$returnValue = '';
		if (isset($offerInfo->dateDocumentSigned)  &&  $offerInfo->offerDate > '0000-00-00') {
			$returnValue =  date('F dS, Y',strtotime($offerInfo->dateDocumentSigned));
		}
	}
	elseif (
	 	$textToReplace == strtoupper('PaintClean')) {
		if ($offerInfo->paintAndClean) {
			$returnValue =  'Yes';
		}
		else {
			$returnValue =  'No';
		}
	}
	elseif (
	 	$textToReplace == strtoupper('PhoneHome')) {
			
			$returnValue  = $offerInfo->homePhone;
	}
	elseif (
	 	$textToReplace == strtoupper('PhoneOther')) {
			
			$returnValue  = $offerInfo->otherPhone;
	}
	elseif (
	 	$textToReplace == strtoupper('PhoneWork')) {
			
			$returnValue  = $offerInfo->workPhone;
	}
	elseif (
	 	$textToReplace == strtoupper('PlanNum')) {
			
			$returnValue  = $offerInfo->planNumber;
	}
	elseif ($textToReplace == strtoupper('LastNames')) {
		$returnValue = '';
		$returnValue = trim($offerInfo->lastName1);
		if ($returnValue > '' && $offerInfo->lastName2 > '') {
			$returnValue = $returnValue.' and ';
		}
		$returnValue = $returnValue.$offerInfo->lastName2;
		if ($returnValue > '' && $offerInfo->lastName3 > '') {
			$returnValue = $returnValue.' and ';
		}
		$returnValue = $returnValue.$offerInfo->lastName3;
	}
	elseif ($textToReplace == strtoupper('PURCHASERNAMEFULL')) {
		$returnValue = '';
		$returnValue = trim($offerInfo->personPrefix1.' '.$offerInfo->firstName1.' '.$offerInfo->lastName1);
		if ($returnValue > '' && trim($offerInfo->personPrefix2.' '.$offerInfo->firstName2.' '.$offerInfo->lastName2) > '') {
			$returnValue = $returnValue.' and ';
		}
		$returnValue = $returnValue.trim($offerInfo->personPrefix2.' '.$offerInfo->firstName2.' '.$offerInfo->lastName2);
		if ($returnValue > '' && trim($offerInfo->personPrefix3.' '.$offerInfo->firstName3.' '.$offerInfo->lastName3) > '') {
			$returnValue = $returnValue.' and ';
		}
		$returnValue = $returnValue.trim($offerInfo->personPrefix3.' '.$offerInfo->firstName3.' '.$offerInfo->lastName3);
	}
	elseif ($textToReplace == strtoupper('PurchaserName1stPersonFull')) {
		$returnValue = '';
		$returnValue = trim($offerInfo->personPrefix1.' '.$offerInfo->firstName1.' '.$offerInfo->lastName1);
	}
	elseif ($textToReplace == strtoupper('PurchaserName2ndPersonFull')) {
		$returnValue = '';
		$returnValue = trim($offerInfo->personPrefix2.' '.$offerInfo->firstName2.' '.$offerInfo->lastName2);
	}
	elseif (
	 	$textToReplace == strtoupper('SiteName')) {
			
			$returnValue  = $offerInfo->siteName;
	}
	elseif (
	 	$textToReplace == strtoupper('StreetName')) {
			
			$returnValue  = $offerInfo->munStreetAddress;
	}
	elseif (
	 	$textToReplace == strtoupper('StreetSide')) {
			
			$returnValue  = $offerInfo->streetSide;
	}
	elseif (
	 	$textToReplace == strtoupper('TodaysDateFullText')) {
			
			$returnValue  = getTodaysDateFromDatabase($dbSingleUse);
	}
	elseif (
	 	$textToReplace == strtoupper('FirstPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 1));
	}
	elseif (
	 	$textToReplace == strtoupper('SecondPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 2));
	}
	elseif (
	 	$textToReplace == strtoupper('ThirdPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 3));
	}
	elseif (
	 	$textToReplace == strtoupper('FourthPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 4));
	}
	elseif (
	 	$textToReplace == strtoupper('FifthPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 5));
	}
	elseif (
	 	$textToReplace == strtoupper('SixthPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 6));
	}
	elseif (
	 	$textToReplace == strtoupper('SeventhPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 7));
	}
	elseif (
	 	$textToReplace == strtoupper('EighthPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 8));
	}
	elseif (
	 	$textToReplace == strtoupper('NinthPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 9));
	}
	elseif (
	 	$textToReplace == strtoupper('TenthPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 10));
	}
	elseif (
	 	$textToReplace == strtoupper('EleventhPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 11));
	}
	elseif (
	 	$textToReplace == strtoupper('TwelfthPayment')) {
			
			$returnValue =   money_format('%.2n',getDepositPrintItem($offerInfo, $dbSingleUse, 12));
	}
	elseif ($textToReplace == strtoupper('FivePercentMinus3Payments')) {
		$returnValue = '';
		$number = 	calcSumOfFeatures($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) + $offerInfo->offerPrice;
		$number = .05 * $number;
		$number = $number - calcDepositSumOfAmounts($offerInfo, $dbSingleUse, 3);
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('OfferMinus5Percent')) {
		$returnValue = '';
		$number = 	calcSumOfFeatures($dbSingleUse,$offerInfo->lotNumber, $offerInfo->siteShortName) + $offerInfo->offerPrice;
		$number = .95 * $number;
		$returnValue = money_format('%(#10n',$number);
	}
	elseif ($textToReplace == strtoupper('WorkCredTot')) {
			$returnValue =   money_format('%.2n',getAmendmentPrintItem("offerWorkCredits",$offerInfo, $dbSingleUse, 99, "workCreditPrice" ));
	}
	elseif (
	 	substr($textToReplace,0,8) == strtoupper('WorkCred')) {
			if (substr($textToReplace,8,2) == strtoupper('PR')) {
				$ordinal = substr($textToReplace, 10,2);
				if (is_numeric($ordinal)) {
					// 0k - because the ordinal is two digits long
				}
				else {
					$ordinal = substr($ordinal,0,1);
				}
				$returnValue =  getAmendmentPrintItem("offerWorkCredits",$offerInfo, $dbSingleUse,$ordinal, "workCreditPrice" );
				if ($returnValue > '') {
				$returnValue = money_format('%.2n',floatval($returnValue));
				}
			}
			else {
				$ordinal = substr($textToReplace, 12,2);
				if (is_numeric($ordinal)) {
					// 0k - because the ordinal is two digits long
				}
				else {
					$ordinal = substr($ordinal,0,1);
				}
				$returnValue =  getAmendmentPrintItem("offerWorkCredits",$offerInfo, $dbSingleUse,$ordinal, "workCreditDescription" );
			}
	}
	elseif (substr($textToReplace,0,6) == strtoupper('OccFee')) {
		if (strlen($textToReplace) == 6) {
			 $ordinal = 1;
		}
		elseif (strlen($textToReplace) == 7) {
			 $ordinal = substr($textToReplace,6,1) ;
		}
		else {
			 $ordinal = substr($textToReplace,6,2) ;
		}
		$returnValue =  getRTOValue($offerInfo, $dbSingleUse, 'Occupancy Fee', $ordinal ) ;
	}
	elseif (substr($textToReplace,0,12) == strtoupper('RTOChequeAmt')) {
		if (strlen($textToReplace) == 12) {
			 $ordinal = 1;
		}
		elseif (strlen($textToReplace) == 13) {
			 $ordinal = substr($textToReplace,12,1) ;
		}
		else {
			 $ordinal = substr($textToReplace,12,2) ;
		}
		$returnValue =  getRTOValue($offerInfo, $dbSingleUse, 'Cheque Amount', $ordinal ) ;
	}
	elseif (substr($textToReplace,0,10) == strtoupper('RTODeposit')) {
		if (strlen($textToReplace) == 10) {
			 $ordinal = 1;
		}
		elseif (strlen($textToReplace) == 11) {
			 $ordinal = substr($textToReplace,10,1) ;
		}
		else {
			 $ordinal = substr($textToReplace,10,2) ;
		}
		$returnValue =  getRTOValue($offerInfo, $dbSingleUse, 'Deposit Amount', $ordinal ) ;
	}
	elseif (substr($textToReplace,0,11) == strtoupper('OccDatePlus')
			and (substr($textToReplace,12,4) == strtoupper('MRTO') or substr($textToReplace,13,4) == strtoupper('MRTO') )) {
		if (strlen($textToReplace) == 16) {
			 $ordinal = substr($textToReplace,11,1) ;
		}
		else {
			 $ordinal = substr($textToReplace,11,2) ;
		}
		$returnValue =  getRTOValue($offerInfo, $dbSingleUse, 'Occupancy Date', $ordinal ) ;
	}
	//echo '<br>'.$textToReplace.'-'.$returnValue;

	if ($returnValue == '') {
	//	$returnValue = '-';
	}

	return $returnValue;
}
?>