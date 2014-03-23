<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>当前订单</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url(); ?>static/js/jquery.js"></script>
    <script type="text/javascript">
	var ids = [];

    $(function(){

		$('tr.tb').click(function(){
			var tid = $(this).parents('table').attr('id');
			var to_class = '';
			var mid = $(this).attr('val');
			if(tid == 'deal'){
				ids = arrRemoveItem(ids, mid);
				to_class = 'clicked_to_left';

			} else if (tid == 'menu') {
				ids.push(mid);			
				to_class = 'clicked_to_right';
				if($(this).children('th').size() > 0){
					return;
				}
			} else {
				return;
			}
			
			$(this).addClass(to_class);
			var tr = $(this);
			tr.parent().one('transitionend', function() {
				var list_id = to_class == 'clicked_to_right' ? '#deal' : '#menu';
				tr.removeClass(to_class);
				tr.appendTo(list_id);				
				if(to_class == 'clicked_to_right' && $('#deal').children('tbody').children().size() > 0){
					$('#deal').show().css('width','100%').parent().show().css('width', '400px');
				} else if (to_class == 'clicked_to_left' && $('#deal').children('tbody').children().size() == 0) {
					$('#deal').hide().parent().hide();
				}
			});
		});
		
		function arrRemoveItem(arr, item){
			var index = arr.indexOf(item);
			if(-1 != index) {
				arr.splice(index, 1);
			}
			return arr;
		}
    })
    
    </script>
    
</head>


<body>

	<h1 class="title"><?php echo anchor(site_url('welcome'), '点菜', array('title' => '点菜')); ?></h1>
	<!-- <h2>order id = <?php echo $order_id; ?></h2> -->
	
	<div id="tip"><?php echo date('Y-m-d H:i', time()); ?> </div>
	
	
	<div style="">
		<table class="bordered" id="orderlist">
			    <tr>
			        <th>#</th>        
			        <th>菜名</th>
			        <th>单价</th>
			        <th style="width:160px">下单时间</th>			        			        			        
			    </tr>
		<?php foreach($record_data as $val): ?>
			    <tr val="<?php echo $menu[$val->mid]->id;?>" class="tb">
			        <td><?php echo $menu[$val->mid]->id;?></td>
			        <td><?php echo $menu[$val->mid]->name;?></td>
			        <td>￥<?php printf('%.2f', $val->price * 0.01);?></td>
			        <td><?php echo date('m/d H:i', $val->lastupdate);?></td>			        			        
			    </tr>
		<?php endforeach; ?>
		</table>
	</div>

</body>

</html>
