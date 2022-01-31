<script>
function saveprofile()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/useraccess/saveprofile')?>',
		'data':{
			'useraccessid':$("input[name='useraccessid']").val(),
			'username':$("input[name='username']").val(),
			'realname':$("input[name='realname']").val(),
			'password':$("input[name='password']").val(),
			'email':$("input[name='email']").val(),
			'phoneno':$("input[name='phoneno']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiListView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
</script>
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">User Profile</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">	
		<input type="hidden" class="form-control" name="useraccessid" value="<?php echo $useraccessid ?>">
		<div class="row">
			<div class="col-md-4">
				<label for="username"><?php echo $this->getCatalog('username')?></label>
			</div>
			<div class="col-md-7">
				<input type="text" class="form-control" name="username" value ="<?php echo $username ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="password"><?php echo $this->getCatalog('password')?></label>
			</div>
			<div class="col-md-7">
				<input type="text" class="form-control" name="password" value ="<?php echo $password ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="realname"><?php echo $this->getCatalog('realname')?></label>
			</div>
			<div class="col-md-7">
				<input type="text" class="form-control" name="realname" value ="<?php echo $realname ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="email"><?php echo $this->getCatalog('email')?></label>
			</div>
			<div class="col-md-7">
				<input type="text" class="form-control" name="email" value ="<?php echo $email ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="phoneno"><?php echo $this->getCatalog('phoneno')?></label>
			</div>
			<div class="col-md-7">
				<input type="text" class="form-control" name="phoneno" value ="<?php echo $phoneno ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<button type="submit" class="btn btn-success" onclick="saveprofile()"><?php echo $this->getCatalog('save') ?></button>
			</div>
		</div>
	</div>
</div>