<?php

$sumResalePrice = 0;
$sumResalePriceDiscountAllowed = 0;
$sumDiscounts = 0;
$offerDiscountAmount = 0;
$featureAfterDiscount = 0;

$query = 'select sum(featureResalePrice) as sumResalePrice
			from offerFeatures 	
				where siteShortName = "'.$siteShortName.'" and lotNumber ='.$lotNumber;
//echo '<br>'.$query;				
if ($dbSingleUse->Query($query)) { 
	while ($rowFeatures = $dbSingleUse->Row()) {
		$sumResalePrice = $rowFeatures->sumResalePrice;
	}
}

$query = 'select sum(featureResalePrice) as sumResalePriceDiscountAllowed
			from offerFeatures 	
				where featureDiscountAllowed = 1 and siteShortName = "'.$siteShortName.'" and lotNumber ='.$lotNumber;
				
if ($dbSingleUse->Query($query)) { 
	while ($rowFeatures = $dbSingleUse->Row()) {
		$sumResalePriceDiscoutAllowed = $rowFeatures->sumResalePriceDiscountAllowed;
	}
}
$query = 'select offerDiscountAmount
			from offers
				where siteShortName = "'.$siteShortName.'" and lotNumber ='.$lotNumber;
if ($dbSingleUse->Query($query)) { 
	while ($rowFeatures = $dbSingleUse->Row()) {
		if ($rowFeatures->offerDiscountAmount > 0) {
			$offerDiscountAmount = $rowFeatures->offerDiscountAmount;
		}
	}
}
?>