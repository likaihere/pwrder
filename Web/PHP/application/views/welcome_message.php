<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>吃货下单</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/static/css/style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url(); ?>/static/js/jquery.js"></script>
    <script type="text/javascript">
    $(function(){
		$('tr').click(function(){
			var tid = $(this).parents('table').attr('id');
			var to_class = '';
			if(tid == 'deal'){
				to_class = 'clicked_to_left';
			} else if (tid == 'menu') {
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
			alert('下单测试');
		})
    })
    
    </script>
    
</head>


<body>

	<h1 class="title">MENU</h1>

	<div style="float:left;width:40%;">
		<table class="bordered" id="menu">
			    <tr>
			        <th>#</th>        
			        <th>菜名</th>
			        <th>单价</th>
			    </tr>
		<?php foreach($menuData as $val): ?>
			    <tr>
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

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>


<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>
<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>
<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>
<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

<br/>

</body>

</html>
