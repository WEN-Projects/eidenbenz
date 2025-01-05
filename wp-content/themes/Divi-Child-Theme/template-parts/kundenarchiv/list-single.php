<?php
$post_id = get_the_ID();
$name    = get_post_meta( $post_id, "name", true );
$adresse = get_post_meta( $post_id, "adresse", true );
$von     = get_post_meta( $post_id, "von", true );
$bis     = get_post_meta( $post_id, "bis", true );
$thema   = get_post_meta( $post_id, "thema", true );
$bereich = get_the_terms( $post_id, "bereich" );
?>
<div class="table-content-inner table-row">
    <!-- Item -->
    <div class="table-content-item table-col">
        <span class="text"><?php the_title(); ?></span>
    </div>
    <!-- Item -->
    <div class="table-content-item table-col">
        <span class="text"><?php echo $adresse; ?></span>
    </div>
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
    <!-- Item -->
    <div class="table-content-item table-col">
        <span class="text"><?php echo $von; ?></span>
    </div>
    <!-- Item -->
    <div class="table-content-item table-col">
        <span class="text"><?php echo $bis; ?></span>
    </div>
    <!-- Item -->
    <div class="table-content-item table-col last-closer">
        <span class="text">
            <span class="text-inner">
               <?php echo $thema; ?>
            </span>
         </span>
        <div class="close-table-content">
            <svg width="19" height="10" viewBox="0 0 19 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <line x1="0.353553" y1="0.646447" x2="9.35355" y2="9.64645" stroke="black"></line>
                  <line x1="18.3536" y1="0.353553" x2="9.35355" y2="9.35355" stroke="black"></line>
               </svg>
        </div>
    </div>
</div>
