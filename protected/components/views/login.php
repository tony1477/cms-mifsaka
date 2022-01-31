<script type="text/javascript">
function profileuser()
{
	var x;
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('site/getprofile')?>',
		'data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='useraccessid']").val(data.useraccessid),
				$("input[name='username']").val(data.username),
				$("input[name='realname']").val(data.realname),
				$("input[name='email']").val(data.email),
				$("input[name='phoneno']").val(data.phoneno),
				$("input[name='birthdate']").val(data.birthdate),
				$("textarea[name='useraddress']").val(data.useraddress)
				$('#RegisterDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function registeruser()
{
	var x;
	$('#RegisterDialog').modal();
	return false;
}
function submituser()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('site/login')?>',
		'data':{
			'pptt':$("input[name='pptt']").val(),
			'sstt':$("input[name='sstt']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				location.href="<?php echo Yii::app()->createUrl('')?>";
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('site/saveuser')?>',
		'data':{
			'useraccessid':$("input[name='useraccessid']").val(),
			'username':$("input[name='username']").val(),
			'password':$("input[name='password']").val(),
			'realname':$("input[name='realname']").val(),
			'email':$("input[name='email']").val(),
			'phoneno':$("input[name='phoneno']").val(),
			'birthdate':$("input[name='birthdate']").val(),
			'useraddress':$("textarea[name='useraddress']").val()
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#RegisterDialog').modal('hide');
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}          
$(function() {
	$( "#birthdate" ).datepicker({
		dateFormat: "yy-mm-dd"
	});
	$( ":input[name*='tt']" ).keyup(function(e){
	if(e.keyCode == 13)
	{
		submituser();
	}});
});  
</script>
<div class="panel panel-default">
  <div class="panel-body">
<?php 
if (Yii::app()->user->id == null)
{?>
    <form method="post" action="<?php echo Yii::app()->createUrl('/site/login')?>" role="form">
  <div class="form-group">
    <label for="username"><?php echo $this->getCatalog('username')?></label>
    <input name="pptt" type="text" class="form-control">
  </div>
  <div class="form-group">
    <label for="sstt"><?php echo $this->getCatalog('password')?></label>
    <input name="sstt" type="password" class="form-control">
  </div>
  <div class="checkbox">
    <label><input name="rrmm" type="checkbox"><?php echo $this->getCatalog('rememberme')?></label>
  </div>
	<button name="submit" type="button" class="btn btn-info" onclick="submituser()"><?php echo $this->getCatalog('Login')?></button>
</form>
<?php
}
else
{
	echo "Welcome ".Yii::app()->user->id." (<a href='".Yii::app()->createUrl('site/logout')."'>logout</a>)<br>";
	echo '<button name="profile" onclick="profileuser()">Profile</button>';
}
?>
  </div>
</div>
<div id="RegisterDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('user') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="useraccessid">
				<div class="form-group">
					<label for="username"><?php echo $this->getCatalog('username')?></label>
					<input type="text" class="form-control" name="username">
				</div>
				<div class="form-group">
					<label for="password"><?php echo $this->getCatalog('password')?></label>
					<input type="password" class="form-control" name="password">
				</div>
				<div class="form-group">
					<label for="realname"><?php echo $this->getCatalog('realname')?></label>
					<input type="text" class="form-control" name="realname">
				</div>
				<div class="form-group">
					<label for="email"><?php echo $this->getCatalog('email')?></label>
					<input type="email" class="form-control" name="email">
				</div>
				<div class="form-group">
					<label for="phoneno"><?php echo $this->getCatalog('phoneno')?></label>
					<input type="text" class="form-control" name="phoneno">
				</div>
				<div class="form-group">
					<label for="birthdate"><?php echo $this->getCatalog('birthdate')?></label>
					<input type="text" class="form-control" name="birthdate" id="birthdate">
				</div>
				<div class="form-group">
					<label for="useraddress"><?php echo $this->getCatalog('useraddress')?></label>
					<textarea class="form-control" rows="5" name="useraddress"></textarea>
				</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>