<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>menu</title>
<link href="style_menu.css" rel="stylesheet" type="text/css" />
<link href="js/css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>

<script src="js/jquery-2.1.0.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/jquery-migrate-1.2.1.js"></script>
<script src="js/script.js"></script> 
<script src="js/jquery.tooltipster.js"></script>

<script src="js/jquery.ui.totop.js"></script>


<script>

jQuery(document).ready(function() {
  jQuery(".myorder_expand").hide();
  //toggle
  jQuery(".myorder").click(function()
  {
    jQuery(this).next(".myorder_expand").slideToggle(500);
  });
  
  $().UItoTop({ easingType: 'easeOutQuart' });
               $('.tooltip').tooltipster();
			   
});

</script>
</head>
  

<?  
require_once("includes/check_session.php");
require_once ("includes/classes/login_functions.php");
require_once ("includes/classes/misc_functions.php");
include_once("googleanalytics.php");
?>

<?php

//$query='select * from divadeList where id='.$_GET["divadeID"]. ' limit 1';
//$db2->Query($query);
//$row = mysql_fetch_row($db);

//echo $row;
?>
	<body>
	<div id="nav" style="width:960px; margin:0 auto;">
	<h1>Restaurant's logo</h1>
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
    <div id="content" style="width:960px; margin:0 auto;clear:both;">
		<div id="goto" style="width:200px;float:left;clear:both;">
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
		</div>
		<div id="myorder" style="text-align: center;width:560px;margin:0 auto;float:left;margin-top:15px;">
			<div class="myorder"><p style="color:red;font-weight:bold;font-size:1.1em;">My order</p>
			<p style="font-size:10px;text-align: center;margin-top:-20px;">(click to expand/collapse the list)</p>
			</div>
			<div class="myorder_expand" style="width:560px;margin:0 auto;">
				<table style="width:100%;">
					<thead>
						<tr>
							<th>Quantity</th>
							<th>Dish</th>
							<th>Note</th>
							<th>Price</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						<td>1</td>
						<td>Chicken Rice</td>
						<td><input style="width:98%;" id="note_" name="note_" placeholder="Write a note for your dish" value="Hot and Sour"/></td>
						<td>$10</td>
						<td>$10</td>
						</tr>
						<tr>
						<td>1</td>
						<td>Pho</td>
						<td><input style="width:98%;" id="note_" name="note_" placeholder="Write a note for your dish" value=""/></td>
						<td>$10</td>
						<td>$10</td>
						</tr>
						<tr>
						<td>1</td>
						<td>Coke</td>
						<td><input style="width:98%;" id="note_" name="note_" placeholder="Write a note for your dish" value="zero"/></td>
						<td>$10</td>
						<td>$10</td>
						</tr>
						<tr><td colspan="3"><td>Total</td><td>$30.00</td></tr>
				
				</td>
					</tbody>
				</table>
				&nbsp;<button id="confirm_order">Confirm</button>
			</div>
		</div>
		<br><br>
			<div class="category" style="width:960px;clear:both;">
			<hr>
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
						<br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						<br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
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
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
					</div>
				</div>
			</div>
			<div style="width:960px;clear:both;"></div>
    </div>
	<footer></footer>
</body>

</html>