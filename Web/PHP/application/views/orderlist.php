<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>当前订单</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/css/style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url(); ?>static/js/jquery.js"></script>
    <script type="text/javascript">
    
		var mids = [];

	    $(function(){
	
			$('tr.tb').click(function(){
				mids.push($(this).attr('val'))
				if(window.confirm('您确定要删除这个菜么?')){
					var tr = $(this);
					$.post('<?php echo site_url('orderlist/del_record') ?>', {'oid' : <?php echo $order_id;?>, 'mids' : mids}, function(result) {
						if(result['code'] == 0){
							$('#tip').html(result['msg']);
							tr.animate({
								height: "toggle"
							}, 500, function() {
								$(this).hide();
							});
														
						} else {
							$('#tip').html(result['msg']);							
						}
						
						mids = [];
						
					}, 'json');
				}
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
	
	<div id="tip">当前时间 : <?php echo date('Y-m-d H:i', time()); ?> </div>
	
	
	<div>
	<?php if(count($record_data) > 0): ?>
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
	<?php endif; ?>
	</div>

</body>

</html>
