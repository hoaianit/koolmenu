<?php
session_start();
require_once("classes/misc_functions.php");
require_once("vars.php");
if ($debug == "Yes")
	{	
 echo "<br>This is the get array:";
 print_r($_GET);	
 echo "<br>This is the session array:";
 print_r($_SESSION);
 echo "<br>Your PHPSESSID is:".  session_id(); 
 echo "<br>session userName = ".$_SESSION["userName"];
 echo "<br>session validUser = ".$_SESSION["validUser"];
 echo "<br>session validUserCheck = ".$_SESSION["validUserCheck"];
	}
//for myAction --> the POST takes precedence
if (isset($_POST['myAction'])) {
	$myAction = $_POST['myAction'];
	$_SESSION["myAction"] = $myAction;
}
else
{
	$myAction = $_GET["myAction"];
}

//for myEditAction --> the POST takes precedence
if (isset($_POST['myEditAction'])) {
	$myEditAction = $_POST['myEditAction'];
	$_SESSION["myEditAction"] = $myEditAction;
}
else
{
	$myEditAction = $_GET["myEditAction"];
}

if ($myAction == "APSDetails" or $myAction == "ColourChart") {
	$printingFormat = "Yes";
}
else
{
	$printingFormat = "No";
}

if (isset($_GET['siteShortName'])) {
	$siteShortName = $_GET['siteShortName'];
	$_SESSION["siteShortName"] = $siteShortName;
}
elseif (isset($_POST['siteShortName'])) {
	$siteShortName = $_POST['siteShortName'];
	$_SESSION["siteShortName"] = $siteShortName;
}
else
{
	$siteShortName = $_SESSION["siteShortName"];
}

if (isset($_GET['siteName'])) {
	$siteName = $_GET['siteName'];
	$_SESSION["siteName"] = $siteName;
}
elseif (isset($_POST['siteName'])) {
	$siteName = $_POST['siteName'];
	$_SESSION["siteName"] = $siteName;
}
else
{
	$siteName = $_SESSION["siteName"];
}

if ($siteShortName ==  'All') {
	$siteShortName = '';
}
if (isset($_GET['lotNumber'])) {
	$lotNumber = $_GET['lotNumber'];
	$_SESSION["lotNumber"] = $lotNumber;
}
elseif (isset($_SESSION['lotNumber']))
{
	$lotNumber = $_SESSION['lotNumber'];
}
else
{
	$lotNumber = $_POST['lotNumber'];
}

if (isset($_GET['updateLotWatch'])) {
	$updatelotNumber = $_GET['updateLotWatch'];
	$_SESSION["updateLotWatch"] = $updateLotWatch;
}
else
{
	$updateLotWatch = $_POST['updateLotWatch'];
}

if (isset($_GET['watchLot'])) {
	$watchLot = $_GET['watchLot'];
	$_SESSION["watchLot"] = $watchLot;
}
else
{
	$watchLot = $_POST['watchLot'];
}


if (isset($_GET['updateLotClearingStatus'])) {
	$updateLotClearingStatus = $_GET['updateLotClearingStatus'];
	$_SESSION["updateLotClearingStatus"] = $updateLotClearingStatus;
}
else
{
	$updateLotClearingStatus = $_POST['updateLotClearingStatus'];
}

if (isset($_GET['statusCheckBox'])) {
	$statusCheckBox = $_GET['statusCheckBox'];
	$_SESSION["statusCheckBox"] = $statusCheckBox;
}
else
{
	$statusCheckBox = $_POST['statusCheckBox'];
}

if (isset($_POST['filterOfferStatusGroup'])) {
	$filterOfferStatusGroup = $_POST['filterOfferStatusGroup'];
	$_SESSION["filterOfferStatusGroup"] = $filterOfferStatusGroup;
}
else
{
	$filterOfferStatusGroup = 'All';
}

if (!isset($filterOfferStatusGroup)) {
	$filterOfferStatusGroup = 'All';
	//$filterOfferStatusGroup = 'With Offers';
}

if (isset($_POST['filterClosingStatusGroup'])) {
	$filterClosingStatusGroup = $_POST['filterClosingStatusGroup'];
	$_SESSION["filterClosingStatusGroup"] = $filterClosingStatusGroup;
}
else
{
	$filterClosingStatusGroup = 'All';
}

if (isset($_POST['filterOccupancyStatusGroup'])) {
	$filterOccupancyStatusGroup = $_POST['filterOccupancyStatusGroup'];
	$_SESSION["filterOccupancyStatusGroup"] = $filterOccupancyStatusGroup;
}
else
{
	$filterOccupancyStatusGroup = $_SESSION['filterOccupancyStatusGroup'];
}

if (isset($_POST['filterClearingGroup'])) {
	$filterClearingGroup = $_POST['filterClearingGroup'];
	$_SESSION["filterClearingGroup"] = $filterClearingGroup;
}
else
{
	$filterClearingGroup = 'All';
}

if (isset($_POST['lotSortList'])) {
	$lotSortList = $_POST['lotSortList'];
	$_SESSION["lotSortList"] = $lotSortList;
}
else
{
	$lotSortList = $_SESSION['lotSortList'];
}

if (isset($_POST['radioViewOptions'])) {
	$radioViewOptions = $_POST['radioViewOptions'];
	$_SESSION["radioViewOptions"] = $radioViewOptions;
}
else
{
	$radioViewOptions = $_SESSION['radioViewOptions'];
}

if (isset($_GET['buildSequence'])) {
	$buildSequence = $_GET['buildSequence'];
	$_SESSION["buildSequence"] = $buildSequence;
}
else
if (isset($_POST['buildSequence'])) {
	$buildSequence = $_POST['buildSequence'];
	$_SESSION["buildSequence"] = $buildSequence;
}
else
{
	$buildSequence = $_SESSION['buildSequence'];
}

if (isset($_POST['chartNumber'])) {
	$chartNumber = $_POST['chartNumber'];
	$_SESSION["chartNumber"] = $chartNumber;
}
else
{
	$chartNumber = $_GET['chartNumber'];
}

if (isset($_POST['showHideCompletedActivity'])) {
	$showHideCompletedActivity = $_POST['showHideCompletedActivity'];
	$_SESSION["showHideCompletedActivity"] = $showHideCompletedActivity;
}
 $showHideCompletedActivity = $_SESSION["showHideCompletedActivity"];


//	alertBox($buildSequence);



//$siteShortName = getGETPOST('siteShortName');
//$lotNumber = getGETPOST('lotNumber');
$watch=$_POST["watch"];
$loginUserName = strtolower($_POST["loginUserNamePratt"]);
$loginPassword = strtolower($_POST["loginPasswordPratt"]);
$validUser = $_SESSION["validUser"];
$validUserCheck = $_SESSION["validUserCheck"];

//this gets us past a bug with net firms
if ($validUserCheck == "Yes") {
	$validUser = true;
}
$userName = strtolower($_SESSION["userName"]);



if ($debug == "Yes")
	{	
		echo "<br>Checking Session data";
		echo "<br>'$validUser value:".$validUser;
		echo "<br>'$validUser value check:".$validUserCheck;
		echo '<br>getting validUser value to return:'.$_SESSION["validUser"];
		echo '<br>$loginUserName value:'.$loginUserName;
		echo '<br>$userName value:'.$userName;
		echo '<br>$siteShortName value:'.$siteShortName;
		echo '<br>$lotNumber value:'.$lotNumber;
		echo '<br>$watchLot value:'.$watchLot;
		echo '<br>$updateLotWatch value:'.$updateLotWatch;
		echo '<br>$updateLotClearingStatus value:'.$updateLotClearingStatus;
		echo '<br>$statusCheckBox value:'.$statusCheckBox;
		echo '<br>$filterOfferStatusGroup value:'.$filterOfferStatusGroup;
		echo '<br>$filterClosingStatusGroup value:'.$filterClosingStatusGroup;
		echo '<br>$filterOccupancyStatusGroup value:'.$filterOccupancyStatusGroup;
		echo '<br>$filterClearingGroup value:'.$filterClearingGroup;
		echo '<br>$lotSortList value:'.$lotSortList;
		echo '<br>$showHideCompletedActivity value:'.$showHideCompletedActivity;
	}

//alertBox($filterOfferStatusGroup);

?>