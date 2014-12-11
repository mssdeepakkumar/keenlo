<?php
/**
 * HTML for social login report
 */
?>
<div id="poststuff" class="woocommerce-reports-wide wc-social-login-report">
	<table class="wp-list-table widefat fixed social-registrations">
		<thead>
			<tr>
				<th><?php _e( 'Provider', WC_Social_Login::TEXT_DOMAIN ); ?></th>
				<th><?php _e( 'Registrations', WC_Social_Login::TEXT_DOMAIN ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $social_registrations ) ) : ?>
				<?php foreach ( $social_registrations as $data ) : ?>
					<tr>
						<td>
							<span class="chart-legend" style="background-color: <?php echo $data['chart_color']; ?>"></span>
							<?php echo $data['provider_title']; ?>
						</td>
						<td><?php echo $data['linked_accounts']; ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>

	<div class="chart-container">
		<div class="chart-placeholder social-registrations pie-chart" style="height:200px"></div>
	</div>
	<script type="text/javascript">
		jQuery(function(){
			jQuery.plot(
				jQuery('.chart-placeholder.social-registrations'),
				[
					<?php foreach ( $social_registrations as $provider_id => $data ) : ?>
					{
						label: "<?php echo $data['provider_title']; ?>",
						data:  "<?php echo $data['linked_accounts']; ?>",
						color: "<?php echo $data['chart_color']; ?>",
					},
					<?php endforeach; ?>
				],
				{
					grid: {
						hoverable: true
					},
					series: {
							pie: {
								show: true,
								radius: 1,
								innerRadius: 0.6,
								label: {
									show: false
								}
							},
							enable_tooltip: true,
							append_tooltip: "<?php echo ' ' . __( 'linked accounts', WC_Social_Login::TEXT_DOMAIN ); ?>",
					},
					legend: {
							show: false
					}
				}
			);

			jQuery('.chart-placeholder.social-registrations').resize();
		});
	</script>
</div>
