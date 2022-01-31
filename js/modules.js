if("undefined"==typeof jQuery)throw new Error("Module's JavaScript requires jQuery");
function running(id,param2)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/modules/running')?>',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				location.reload();
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function Uninstall(elmnt)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/modules/uninstall')?>',
		'data':{'module':elmnt},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				location.reload();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}