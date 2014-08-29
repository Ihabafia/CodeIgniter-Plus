<script type="text/javascript">
	/* <![CDATA[ */
	var global_baseurl = "<?php echo base_url(); ?>";
	<?php if($this->session->userdata('user_id')): ?>
	var xxx = <?php echo $this->session->userdata('user_id'); ?>;
	<?php endif; ?>
	var d = 0<?php echo $this->session->userdata('ba_discount'); ?>;
	/* ]]> */
</script>
