<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo $form_id; ?> um-role-<?php echo um_user('role'); ?> ">

	<?php
	// testikommentti
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
	//echo "act:" . $actual_link;
	if( !isset($_GET["um_action"]) && is_user_logged_in() ){
		if( $_GET["um_action"] != 'edit' ){
			$query = parse_url($actual_link, PHP_URL_QUERY);
			// Returns a string if the URL has parameters or NULL if not
			if ($query) {
			    $actual_link .= "&um_action=edit";
			} else {
			    $actual_link .= "?um_action=edit";
			}
			echo "<div class='beat-functionality-panel'>";
				echo "<a class='beat-edit-button' href='" . $actual_link . "'><i class='um-faicon-cog'></i> Muokkaa profiilia</a>";
			echo "</div>";
		}else{
			$actual_link = parse_url($actual_link);
			parse_str($actual_link, $actual_link_output);
			unset($actual_link_output['um_action']);
			$actual_link = http_build_query($actual_link_output);
			echo "#moroo-----" . $actual_link;
		}
	}	
	?>

	<!-- hide default um-profile-edit-a -->
	<style>
		.um-profile-edit-a{
			display: none;
		}
		.um-editing .um-profile-edit-a{
			display: block;
		}
	</style>

	<div class="um-form">

		<?php do_action('um_profile_before_header', $args ); ?>
		
		<?php if ( um_is_on_edit_profile() ) { ?><form method="post" action=""><?php } ?>
		
			<?php do_action('um_profile_header_cover_area', $args ); ?>
			
			<div class="container">
				<?php do_action('um_profile_header', $args ); ?>
			
			
				<?php do_action('um_profile_navbar', $args ); ?>
				
				<?php
				
				$nav = $ultimatemember->profile->active_tab;
				$subnav = ( get_query_var('subnav') ) ? get_query_var('subnav') : 'default';
					
				print "<div class='um-profile-body $nav $nav-$subnav'>";
					
					// Custom hook to display tabbed content
					do_action("um_profile_content_{$nav}", $args);
					do_action("um_profile_content_{$nav}_{$subnav}", $args);
					
				print "</div>";
					
				?>
			</div>
		
		<?php if ( um_is_on_edit_profile() ) { ?></form><?php } ?>
	</div>
	
</div>