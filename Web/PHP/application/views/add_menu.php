<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>添加菜谱</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url(); ?>static/js/jquery.js"></script>
    <script type="text/javascript">

	    $(function(){
			var menu_name = [];
			var menu_price = [];
			
			$('#add_button').click(function(){
				var menu = $('input[name="menu_name[]"]').val();
				var price = $('input[name="menu_price[]"]').val();
			
				if(!checkField(menu, price)){
					return;
				}
				
				$('add_button').attr('disable', 'true');
				
				menu_name.push(menu);
				menu_price.push(price);				
				
				$.post('<?php echo site_url('menu/add') ?>', {'names' : menu_name, 'prices' : menu_price}, function(result) {
					if(result['code'] == 0){
						$('#tip').html(result['msg']);
						
						var trHtml = '<tr><td>'+menu+'</td><td>￥'+price+'</td><td></td></tr>';
						$('#menulist').append(trHtml);
													
					} else {
						$('#tip').html(result['msg']);							
					}
					
					$('add_button').attr('disable', 'false');
					menu_name = [];
					menu_price = [];		
					$('input[name="menu_name[]"]').val('');
					$('input[name="menu_price[]"]').val('');							
						
				}, 'json');
				
			});
			
			function checkField(menu, price){
				var msg = '';
				var hot;
				
				if ($.trim(menu).length <= 0) {
					msg = '请填写菜名';
					hot = $('input[name="menu_name[]"]').focus();
				} else if(/^\d+(\.\d*)*$/g.test(price) === false){
					msg = '单价输入有误,请检查';
					hot = $('input[name="menu_price[]"]').focus();
				} 
				
				if(msg.length > 0){
					alert(msg);					
					hot.focus();
					return false;
				}
				
				return true;
			}
	    })
    </script>
    
    <style type="text/css">
		.bordered tr{
			transition:none;
			-webkit-transition:none;
			-moz-transition:none;
			-o-transition:none;
		}
		
		.bordered tr:hover{
		    background: white;
		}
		
		.bordered tr:hover td:nth-child(3){
		    background: white;
			color: #FF2900;
			font-weight: normal;
			font-size: 14px;		
		}
    </style>
    
</head>


<body>

	<h1 class="title"><?php echo anchor(site_url('welcome'), '点菜', array('title' => '点菜')); ?></h1>
	<!-- <h2>order id = <?php echo $order_id; ?></h2> -->
	
	<div id="tip">添加菜谱</div>
	
	<div>
		<table class="bordered" id="menulist">
			    <tr>
			        <th>菜名</th>
			        <th>单价</th>
			        <th>操作</th>			        
			    </tr>
			    <tr>
			        <td><input name="menu_name[]" value="" style="width:300px;" /></td>
			        <td>￥ <input name="menu_price[]" value="" style="width:60px;" /> 元</td>
					<td><button class="green awesome" id="add_button" type="submit">添加</button></td>			        
			    </tr>
			    
<!--
TODO
			    <tr>
				    <td></td>
				    <td></td>
				    <td></td>				    				    
			    </tr>
-->

		</table>
	</div>

</body>

</html>
