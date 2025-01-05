<?php
$post_id = get_the_ID();
$name    = get_post_meta( $post_id, "name", true );
$adresse = get_post_meta( $post_id, "adresse", true );
$von     = get_post_meta( $post_id, "von", true );
$bis     = get_post_meta( $post_id, "bis", true );
$thema   = get_post_meta( $post_id, "thema", true );
$bereich = get_the_terms( $post_id, "bereich" );
?>
<!-- Content reapeater -->
<div class="table-content-repeater">
    <!-- First Visible Row -->
    <div class="table-content">
        <div class="table-content-inner first-table-row table-row">
            <!-- Item -->
            <div class="table-content-item table-col">
                <span class="text"><?php the_title(); ?></span>
                <span class="toggler-opener">
                                 <svg width="19" height="10" viewBox="0 0 19 10" fill="none"
                                      xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0.353553" y1="0.646447" x2="9.35355" y2="9.64645" stroke="black"></line>
                                    <line x1="18.3536" y1="0.353553" x2="9.35355" y2="9.35355" stroke="black"></line>
                                 </svg>
                              </span>
            </div>
            <!-- Item -->
            <div class="table-content-item table-col">
                <span class="text"><?php echo $von; ?></span>
            </div>
            <!-- Item -->
            <div class="table-content-item table-col">
                <span class="text"><?php echo $bis; ?></span>
            </div>
        </div>
    </div>
    <!-- Table Content Row -->
    <div class="toggle-content-wrapper">
        <!-- Repeat full width -->
		<?php
		if ( $adresse ) {
			?>
            <div class="repeat-full-width">
                <!-- Full width head repeat -->
                <div class="table-head table-row">
                    <div class="table-head-item table-col">
                        <span class="text"><?php _e( 'Adresse', 'eidenbenz' ); ?></span>
                    </div>
                </div>
                <!-- Full width repeater -->
                <div class="table-content-inner table-row">
                    <!-- Item -->
                    <div class="table-content-item table-col">
                        <span class="text"><?php echo $adresse; ?></span>
                    </div>
                </div>
            </div>
			<?php
		}
		if ( $bereich ) {
			?>
            <!-- Repeat full width -->
            <div class="repeat-full-width">
                <!-- Full width head repeat -->
                <div class="table-head table-row">
                    <div class="table-head-item table-col">
                        <span class="text"><?php _e( 'Bereich', 'eidenbenz' ); ?></span>
                    </div>
                </div>
                <!-- Full width repeater -->
                <div class="table-content-inner table-row">
                    <!-- Item -->
                    <div class="table-content-item table-col">
					<span class="text"><?php
						if ( ! empty( $bereich ) ) {
							foreach ( $bereich as $key => $term ) {
								echo $key == 0 ? $term->name : ", " . $term->name; // if multiple terms are set, concat with comma
							}
						}
						?></span>
                    </div>
                </div>
            </div>
			<?php
		}
		if ( $thema ) {
			?>
            <!-- Repeat full width -->
            <div class="repeat-full-width">
                <!-- Full width head repeat -->
                <div class="table-head table-row">
                    <div class="table-head-item table-col">
                        <span class="text"><?php _e( 'Thema', 'eidenbenz' ); ?></span>
                    </div>
                </div>
                <!-- Full width repeater -->
                <div class="table-content-inner table-row">
                    <!-- Item -->
                    <div class="table-content-item table-col">
                        <span class="text"><?php echo $thema; ?></span>
                    </div>
                </div>
            </div>
			<?php
		}
		?>
    </div>
    <!-- End of togllter -->
</div>