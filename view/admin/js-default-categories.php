<script type="text/javascript" charset="utf-8">
	dc_default_categories = new Object();
	<?php foreach ( $default_categories AS $category_id ) { ?>
		dc_default_categories[ <?php echo $category_id ?> ] = <?php echo $category_id ?>;
	<?php } ?>
</script>