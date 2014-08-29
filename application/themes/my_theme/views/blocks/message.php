<?php
if(!isset($message) or !is_array($message)) $message =[];

if(!isset($message['nonAjax']))
	$message['nonAjax'] = 0;
switch (strtolower($this->session->flashdata('messageTitle')[0])) {
	case 'w':
	$alert = 'alert-warning';
	break;
	case 's':
	$alert = 'alert-success';
	break;
	case '':
	$alert = 'hidden';
	break;
	default:
	$alert = 'alert-danger';
	break;
}
?>
<div class="row">
	<div class="col-lg-offset-1 col-lg-10">
		<div id="message" class="alert <?php echo $alert ?>">
			<strong><p id="messageTitle"><?php echo $this->session->flashdata('messageTitle'); ?></p></strong>

			<div id="messageBody"><?php echo $this->session->flashdata('messageBody') ?></div>
		</div>
	</div>
</div>

<?php if($message['nonAjax']): ?>
<div class="row">
	<div class="col-lg-offset-1 col-lg-10">
		<div id="message" class="alert <?php echo $message['messageClass']; ?>">
			<strong><p id="messageTitle"><?php echo $message['messageTitle']; ?></p></strong>

			<div id="messageBody"><?php echo $message['messageBody']; ?></div>
		</div>
	</div>
</div>
<?php endif; ?>

<script type="text/javascript">
	$(document).ready(function ()
	{
		$(this).removeSuccessMessage();
	});
</script>
