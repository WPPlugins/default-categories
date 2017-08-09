<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>

<h3><?php _e( 'Default Categories', 'default-categories' ); ?></h3>

<?php wp_nonce_field( 'default-categories', '_dc_nonce' ); ?>

<table class="form-table">
	<tbody>	
		<tr>
			<th scope="row"><?php _e( 'Select your default categories' ); ?></th>
			<td>
				<ul><?php wp_category_checklist( null, null, $default_categories ); ?></ul>
			</td>
		</tr>
	</tbody>
</table>