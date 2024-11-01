<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wrap">
	<h2><?php echo __('Google Integration of Google Analytics and Google Tag Manager', 'google-integration'); ?></h2>
	<div class="content_wrapper">
		<div class="left">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('cn-gi-settings-group'); ?>
				<h3><?php echo __('Data Privacy', 'google-integration'); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php echo __('Consider DSGVO/GDPR', 'google-integration'); ?></th>
						<td><input <?php echo ($satmig_privacy_apply_to_menu == 1) ? 'checked="checked"' : ''; ?> type="checkbox" name="satmig_privacy_apply_to_menu" id="satmig_privacy_apply_to_menu" value="1" /><br />
							<em><?php echo __('Highly recommended for websites within the EU. Tracking code will be adjusted to anonymize IP address and Opt-Out-Cookie ', 'google-integration'); ?></em></td>
					</tr>
				</table>
				<h3><?php echo __('Google Analytics Settings', 'google-integration'); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php echo __('Activate Google Analytics', 'google-integration'); ?></th>
						<td><input <?php echo ($satmig_ganalytics_apply_to_menu == 1) ? 'checked="checked"' : ''; ?> type="checkbox" name="satmig_ganalytics_apply_to_menu" id="satmig_ganalytics_apply_to_menu" value="1" /><br />
							<em><?php echo __('If you check this box then Google Analytics Tracking code will be added to your website.', 'google-integration'); ?></em></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo __('Google Analytics Tracking ID', 'google-integration'); ?></th>
						<td><input type="text" name="satmig_ganalytics_tid" id="satmig_ganalytics_tid" class="large-text" placeholder="UA-xxxxxxxxx-1" value="<?php echo $satmig_ganalytics_tid; ?>" max="50">
							<br /><em><?php echo __('Your Google Analytics Tracking ID should have a similar format like ', 'google-integration'); ?> <code>UA-xxxxxxxxx-1</code></em></td>
					</tr>
				</table>
				<h3><?php echo __('Google Tag Manager Settings', 'google-integration'); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php echo __('Activate Google Tag Manager', 'google-integration'); ?></th>
						<td><input <?php echo ($satmig_tagmg_apply_to_menu == 1) ? 'checked="checked"' : ''; ?> type="checkbox" name="satmig_tagmg_apply_to_menu" id="satmig_tagmg_apply_to_menu" value="1" /><br />
							<em><?php echo __('If you check this box then Google Tag Manager Tracking code will be added to your website.', 'google-integration'); ?></em></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo __('Google Tag Manager Tracking ID', 'google-integration'); ?></th>
						<td><input type="text" name="satmig_tagmg_tid" id="satmig_tagmg_tid" class="large-text" placeholder="GTM-xxxxxxx" value="<?php echo $satmig_tagmg_tid; ?>" width="50">
							<br /><em><?php echo __('Your Google Tag Manager Tracking ID should have a similar format like ', 'google-integration'); ?> <code>GTM-xxxxxxx</code></em></td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
			<h3><?php echo __('Where to find Tracking IDs?', 'google-integration'); ?></h3>
			<table class="form-table">
				<tr>
					<td>
						<h4><?php echo __('Google Analytics', 'google-integration'); ?></h4>
					</td>
					<td>
						<h4><?php echo __('Google Tag Manager', 'google-integration'); ?></h4>
					</td>
				</tr>
				<tr>
					<td><code>Google Analytics > Login > Admin > Property Settings > Tracking ID</code></td>
					<td><code>Google Tag Manager > Login > Tracking ID</code></td>
</tr>
				<tr><?php satmig_admin_sidebar(); ?></tr>
			</table>
		</div>
	</div>
</div>