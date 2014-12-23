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
  // expand or collapse My order list
  jQuery(".myorder_expand").hide();
  //toggle
  jQuery(".myorder").click(function()
  {
    jQuery(this).next(".myorder_expand").slideToggle(500);
  });
  // hide or show a Category
  jQuery(".categoryLink").click(function()
  {
	//jQuery(".myorder_expand").hide();
    var categoryLink = $(this).text();
	//console.log(categoryLink);
	jQuery(".category").hide();
	jQuery("#"+categoryLink).show();
	$(".categoryLink").parent().attr("class","");
	$(this).parent().attr("class","current");
  });
  
  $().UItoTop({ easingType: 'easeOutQuart' });
               $('.tooltip').tooltipster();
			   
});

			$(document).ready(function(){		
				var lineNumber = $("#lineNumber").val();
				
				
				var total = 0;
				var subtotal = 0;
				var tax = 0;
				$('.orderDish').live('click',function(){
					//$(this).val('Delete');
					jQuery(".myorder_expand").show();
					//$(this).attr('class','del');
					lineNumber++;
					var dish = $(this).parent().parent().find('h4').text();
					//console.log(dish);
					var price= parseFloat($(this).parent().find('.price').text());
						console.log(price);
					//console.log(lineNumber);
					var appendTxt = '<tr>'+
					'<td align="center">1<input type="hidden" name="quantity_'+lineNumber+'" value ="1" />'+
					'</td><td>'+dish+'<input type="hidden" placeholder="Dish" name="dish_'+lineNumber+'" value ="" />'+
					'</td><td><input type="text" style="width:97%;" name="note_'+lineNumber+'" placeholder="Write a note for your dish"  value ="" /></td>'+
					'<td>$'+price+'<input type="hidden" name="price_'+lineNumber+'" value ="'+price+'" /></td>'+
					'<td>$'+price+'<input type="hidden" name="total_'+lineNumber+'" value ="'+price+'" /><a title="Delete" class="del" href="#" ><img style="width:20px; float:right;" src="images/restaurant_pic/del.png" /></a></td>'+
					'</tr>';
					$("tr:last").prev().prev().prev().after(appendTxt);
					subtotal= subtotal + price;
					tax= subtotal*0.13;
					total= tax + subtotal;
					//console.log(total);
					$("#lineNumber").val(lineNumber);
					$("#tax").html('$'+tax.toFixed(2)+'<input type="hidden" name="tax" value="'+tax.toFixed(2)+'" />');
					$("#subtotal").html('$'+subtotal.toFixed(2)+'<input type="hidden" name="subtotal" value="'+subtotal.toFixed(2)+'" />');
					$("#total").html('$'+total.toFixed(2)+'<input type="hidden" name="total" value="'+total.toFixed(2)+'" />');
					
				}); 
				
				$('.del').live('click',function(){
					// just hide the row, if delete the row, it will mess up database when saving
					$(this).parent().parent().hide();
					// set quantity = 0, when an order is sent, should check this value
					$(this).parent().parent().find("td:first-child input").val(0);
					var thisprice= $(this).prev().val();
					 subtotal = $("#subtotal input").val() - thisprice;
					 //fix minus Float number when calculating
					 if(subtotal<= 0.02) subtotal=0;
					 tax = $("#tax input").val() - thisprice*0.13;
					 //fix minus Float number when calculating
					 if(tax<= 0.02) tax=0;
					 total = subtotal + tax;
					console.log(subtotal);
					//console.log($("#total").text());
					$("#subtotal").html("$"+subtotal.toFixed(2)+'<input type="hidden" name="tax" value="'+subtotal.toFixed(2)+'" />');
					$("#tax").html("$"+tax.toFixed(2)+'<input type="hidden" name="tax" value="'+tax.toFixed(2)+'" />');
					$("#total").html("$"+total.toFixed(2)+'<input type="hidden" name="tax" value="'+total.toFixed(2)+'" />');
					//lineNumber--;
					//console.log(lineNumber);
					$("#lineNumber").val(lineNumber);
				});			
			});
		</script>

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
	<!--<ul class="tabs">
		<li <? if($_GET["menuStatus"]==0 or !isset($_GET["menuStatus"])) echo 'class="current"'; ?>>
			<a href='index.php?myAction=menu&menuStatus=0'>All dishes</a>
		</li>
		<li <? if($_GET["menuStatus"]==1) echo 'class="current"'; ?>>
			<a href='index.php?myAction=menu&menuStatus=1'>Today special</a>
		</li>
		<li <? if($_GET["menuStatus"]==2) echo 'class="current"'; ?>>
			<a href='index.php?myAction=menu&menuStatus=2'>Top Order</a>
		</li>
	</ul> -->
	</div>
    <div id="content" style="width:960px; margin:0 auto;clear:both;">
		<!--<div id="goto" style="width:200px;float:left;clear:both;">
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
		</div> -->
		
		<ul class="tabs">
		<li class="current">
			<a class="categoryLink" href='#'>Soup</a>
		</li>
		<li class="">
			<a class="categoryLink" href='#'>Noodle</a>
		</li>
		<li class="">
			<a class="categoryLink" href='#'>Drink</a>
		</li>
	</ul>
	<br><br>
		<div id="myorder" style="width:960px;float:left;margin-top:15px;">
			<div class="myorder"><span style="color:red;font-weight:bold;font-size:1.1em;">My order</span>
			<span style="font-size:10px;margin-top:-20px;">(click to expand/collapse the list)</span>
			</div>
			<div class="myorder_expand" style="width:560px;">
				<table style="width:615px;">
					<thead>
						<tr>
							<th style="width:75px !important;">Quantity</th>
							<th style="width:190px !important;">Dish</th>
							<th style="width:200px !important;">Note</th>
							<th style="width:55px !important;">Price</th>
							<th style="width:90px !important;">Total</th>
						</tr>
					</thead>
					<tbody>
						<!--<tr>
						<td>1</td>
						<td>Chicken Rice</td>
						<td><input style="width:97%;" id="note_" name="note_" placeholder="Write a note for your dish" value="Hot and Sour"/></td>
						<td>$10</td>
						<td>$10</td>
						</tr>
						<tr>
						<td>1</td>
						<td>Pho</td>
						<td><input style="width:97%;" id="note_" name="note_" placeholder="Write a note for your dish" value=""/></td>
						<td>$10</td>
						<td>$10</td>
						</tr>
						<tr>
						<td>1</td>
						<td>Coke</td>
						<td><input style="width:97%;" id="note_" name="note_" placeholder="Write a note for your dish" value="zero"/></td>
						<td>$10</td>
						<td>$10</td> 
						</tr>-->
						<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						</tr>
						<tr><td colspan="3"><td>SubTotal</td><td id="subtotal">$0.00</td></tr>
						<tr><td colspan="3"><td>Tax</td><td id="tax">$0.00</td></tr>
						<tr><input type="hidden" name="lineNumber" id="lineNumber" value="0" /><td colspan="3"><td>Total</td><td id="total">$0.00<input type="hidden" name="total" value="0"/></td></tr>
						
				</td>
					</tbody>
				</table>
				&nbsp;<button style="font-weight:bold;" id="confirm_order">Send Order</button>
			</div>
		</div>
		<br><br>
		<div class="" style="width:960px;clear:both;">
			<hr>
			</div>
		
		
			<div class="category" id="Soup" style="width:960px;clear:both;">
				<!--<h2>Soup</h2>-->
				<div id="chicken" style="width:960px;">
				<h4>Chicken Rice</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/chicken.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">7</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">10.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">6.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">10.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
					</div>
				</div>
			</div>
			
			<div class="category" id="Noodle" style="width:960px;clear:both;display:none;">
			<!--<hr>-->
				<!--<h2>Noodle</h2> -->
				<div style="width:960px;">
				<h4>Shanghai Noodles</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/noodle.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">12</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">10.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">10.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">11.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
						<br>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
					<div class="reReviews">
						Reviews: &nbsp;<img style="width:120px;margin-bottom:-4px;" src="images/restaurant_pic/3stars.jpg" /><br><br>Comment:&nbsp;<input id="comment_" name="comment_" placeholder="Write your comment here"/>
					</div>
				</div>
			</div>
			
			<div class="category" id="Drink" style="width:960px;clear:both;display:none;">
			<!--<hr>-->
				<!--<h2>Drink</h2>-->
				<div style="width:960px;">
				<h4>Wine</h4>
					<div class="menu_pic">
						<img style="width:300px;" src="images/restaurant_pic/wine.jpg" />
					</div>
					<div class="main_content">
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">9</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">10</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">1.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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
						Price: <span style="color:red;font-weight:bold;">$</span><span class="price" style="color:red;font-weight:bold;">1.50</span>
						&nbsp;<button type="button" href="#" class="orderDish">+Order</button>
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