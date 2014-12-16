<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>menu</title>
<link href="style_menu.css" rel="stylesheet" type="text/css" />
<link href="js/css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
<script src="js/jquery-1.6.2.js"></script>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
</head>
  

<?  
require_once("includes/check_session.php");
require_once ("includes/classes/login_functions.php");
require_once ("includes/classes/misc_functions.php");

?>

<?php

//$query='select * from divadeList where id='.$_GET["divadeID"]. ' limit 1';
//$db2->Query($query);
//$row = mysql_fetch_row($db);

//echo $row;
?>
	<body>
	<div id="nav" style="width:960px; margin:0 auto;">
	<h2>Main menu</h2>
	<ul class="tabs">
		<li <? if($_GET["menuStatus"]==0 or !isset($_GET["menuStatus"])) echo 'class="current"'; ?>>
			<a href='index.php?myAction=menu&menuStatus=0'>All dishes</a>
		</li>
		<li <? if($_GET["menuStatus"]==1) echo 'class="current"'; ?>>
			<a href='index.php?myAction=menu&menuStatus=1'>Today special</a>
		</li>
		<li <? if($_GET["menuStatus"]==2) echo 'class="current"'; ?>>
			<a href='index.php?myAction=menu&menuStatus=2'>Top Order</a>
		</li>
	</ul>
	</div>
	<br>
    <div id="content" style="width:960px; margin:0 auto;">
		
		<select style="height:30px;margin-top:10px;">
		<option>
		Go To
		</option>
		<option>
		Soup
		</option>
		<option>
		Fried
		</option>
		<option>
		Noodle
		</option>
		<option>
		Drink
		</option>
		</select>
		<br>
		<hr>
			<div class="category" style="width:960px;clear:both;">
				<h2>Soup</h2>
				<div style="width:960px;">
				<h4>Chicken Rice</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/chicken.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" />
						
						<br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Mushrooms</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/mushroom.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" />
						<br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Won Ton</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/wonton.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Phở Đặc Biệt Phố Xưa</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/pho_soup.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
			</div>
			
			<div class="category" style="width:960px;clear:both;">
			<hr>
				<h2>Noodle</h2>
				<div style="width:960px;">
				<h4>Shanghai Noodles</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/noodle.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>PadThai</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/padthai.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Fried Dry Noodles</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/fried_noodle.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Bun Cha</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/buncha.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
			</div>
			
			<div class="category" style="width:960px;clear:both;">
			<hr>
				<h2>Drink</h2>
				<div style="width:960px;">
				<h4>Wine</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/wine.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Beers</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/beer.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Coke</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/coke.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
				
				<div style="width:960px;clear:both;">
				<h4>Pepsi</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/pepsi.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$10.00</span>
						&nbsp;<button>+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:
					</div>
				</div>
			</div>
			<div style="width:960px;clear:both;"></div>
    </div>
	<footer></footer>
</body>

</html>