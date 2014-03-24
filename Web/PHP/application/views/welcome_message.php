<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>吃货下单</title>
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
		
		$('#makedeal').click(function(){
			$.post('<?php echo site_url('welcome/add_record') ?>', {'ids' : ids}, function(result){
				if(result['code'] == 0){
					//TODO
					window.location.href = '<?php echo site_url('orderlist/index/' . $order_id) ;?>';
				} else {
					//TODO
				}
				console.log(result['code'], ids);
				alert(result['msg']);
				$('#tip').html(result['msg']);
				
			}, 'json');
/* 			alert('下单测试'); */
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

	<h1 class="title"><?php echo anchor(site_url('o/'.$order_id), '查看订单', array('title' => '查看订单')); ?></h1>
	<!-- <h2>order id = <?php echo $order_id; ?></h2> -->

	<div id="tip">
		<?php echo anchor(site_url('menu'), '添加菜谱', array('title' => '添加菜谱  ', 'style' => 'float:right;margin-right:1em')); ?>
		下单时间:
		中午<?php echo $meal_time['lunch'][0] . ' ~ ' . $meal_time['lunch'][1];?>;
		下午<?php echo $meal_time['dinner'][0] . ' ~ ' . $meal_time['dinner'][1];?>.
	</div>

	<div style="float:left;width:45%;">
		<table class="bordered" id="menu">
			    <tr>
			        <th>#</th>        
			        <th>菜名</th>
			        <th>单价</th>
			    </tr>
		<?php foreach($menu_data as $val): ?>
			    <tr val="<?php echo $val->id;?>" class="tb">
			        <td><?php echo $val->id;?></td>        
			        <td><?php echo $val->name;?></td>
			        <td>￥<?php printf('%.2f', $val->price * 0.01);?></td>
			    </tr>
		<?php endforeach; ?>
		</table>
	</div>
	
		
	<div id="dealcontainer">
		<table class="bordered" id="deal">
		</table>
		<button class="large yellow awesome" id="makedeal">下单</button>	
	</div>
	


</body>

</html>
