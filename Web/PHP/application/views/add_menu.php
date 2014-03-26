<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>添加菜谱</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/style.css" type="text/css" media="screen" />
    
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
		    background: #eee;
			color: #FF2900;
			font-weight: normal;
			font-size: 14px;		
		}
		
		.bordered tr.delete:hover{
			cursor: pointer;
			background: #eee;
		}
    </style>
    
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
						
						var price_all = Math.round(price * 100).toString();
						var priceS = price_all.substr(0, price_all.length - 2);
						var priceE = price_all.substr(-2);
						
						var trHtml = '<tr val="'+result['id']+'" class="delete"><td>'+menu+'</td><td>￥'+ priceS + '.' + priceE+'</td><td></td></tr>';
						$('#menulist').append(trHtml);
						$('tr.delete').unbind('click').bind('click', handle_delete);
													
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
			
			$('tr.delete').bind('click', handle_delete)
			
			function handle_delete(e){
				var mname = $(this).children('td:first').html();
				var ids = [];
				if(window.confirm('您确认要删除 "'+mname+'" 这个菜吗?')) {
					var tr = $(this);
					var id = $(this).attr('val');
					ids.push(id);
					$.post('<?php echo site_url('menu/delete') ?>', {'ids' : ids}, function(result) {
						if(result['code'] == 0){
							alert('删除成功');
							tr.remove();
						} else {
							alert('删除失败');
						}
						
						$('#tip').html(result['msg']);						
						ids = [];
						
					}, 'json');					
				}
			}
			
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
			    
			    <?php foreach($menu_data as $val): ?>
			    <tr val="<?php echo $val->id; ?>" class="delete">
				    <td><?php echo $val->name; ?></td>
				    <td>￥<?php printf('%.2f', $val->price * 0.01); ?></td>
				    <td></td>				    				    
			    </tr>
			    <?php endforeach; ?>

		</table>
	</div>

</body>

</html>
