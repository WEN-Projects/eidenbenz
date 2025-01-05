<?php
get_header();
?>
    <!-- ---------------------------------------------------------
	  # FIlter Part
   --------------------------------------------------------- -->
    <section class="custom-table-filter">
        <div class="container">
         <!-- Mb Filter Toggler -->
         <div class="mb-filter-toggler">
            <h2 class="mb-filter-title while-open"><?php _e( 'Filter ausblenden', 'eidenbenz' ); ?></h2>
            <h2 class="mb-filter-title while-closed"><?php _e( 'Filteroptionen einblenden', 'eidenbenz' ); ?></h2>
            <span class="svg-toggler">
               <svg width="19" height="10" viewBox="0 0 19 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <line x1="0.353553" y1="0.646447" x2="9.35355" y2="9.64645" stroke="black"></line>
                  <line x1="18.3536" y1="0.353553" x2="9.35355" y2="9.35355" stroke="black"></line>
               </svg>
            </span>
         </div>
         <!-- End of Mb Filter Toggler -->

         <!-- Top FIlter -->
			<?php
			get_template_part( 'template-parts/kundenarchiv/filter', "form" );
			?>

            <!-- Desktop Filtered Data table -->
            <div class="desktop-filter-table filtered-data-table">
                <div class="table">
                    <!-- table Head -->
                    <div class="table-head table-row">
                        <!-- Item -->
                        <div class="table-head-item table-col">
                            <span class="text"><?php _e( 'Name', 'eidenbenz' ); ?></span>
                        </div>
                        <!-- Item -->
                        <div class="table-head-item table-col">
                            <span class="text"><?php _e( 'Adresse', 'eidenbenz' ); ?></span>
                        </div>
                        <!-- Item -->
                        <div class="table-head-item table-col">
                            <span class="text"><?php _e( 'Bereich', 'eidenbenz' ); ?></span>
                        </div>
                        <!-- Item -->
                        <div class="table-head-item table-col">
                            <span class="text"><?php _e( 'Von', 'eidenbenz' ); ?></span>
                        </div>
                        <!-- Item -->
                        <div class="table-head-item table-col">
                            <span class="text"><?php _e( 'Bis', 'eidenbenz' ); ?></span>
                        </div>
                        <!-- Item -->
                        <div class="table-head-item table-col">
                            <span class="text"><?php _e( 'Thema', 'eidenbenz' ); ?></span>
                        </div>
                    </div>
                    <!-- table content -->
                    <div class="table-content">
						<?php if ( have_posts() ) {
							while ( have_posts() ) {
								the_post();
								get_template_part( 'template-parts/kundenarchiv/list-single' );
							}
							?>
                            <div class="filter-pagination">
								<?php
								the_posts_pagination( array(
									'screen_reader_text' => ' ',
									'prev_text'          => __( 'Previous', 'eidenbenz' ),
									'next_text'          => __( 'Next', 'eidenbenz' ),
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( '', 'eidenbenz' ) . ' </span>',
								) );
								?>
                            </div>
							<?php
						} else {
							get_template_part( 'template-parts/kundenarchiv/filter', "no-result" );
						} ?>
                    </div>
                </div>
            </div>
            <!-- End of Desktop Filtered Data table -->
            <div class="mobile-filter-table filtered-data-table"">
               <div class="table">
                  <!-- table Head -->
                  <div class="table-head table-row">
                     <!-- Tabel col -->
                     <div class="table-head-item table-col">
                        <span class="text"><?php _e( 'Name', 'eidenbenz' ); ?></span>
                     </div>
                     <!-- Tabel col -->
                     <div class="table-head-item table-col">
                        <span class="text"><?php _e( 'Von', 'eidenbenz' ); ?></span>
                     </div>
                     <!-- Tabel col -->
                     <div class="table-head-item table-col">
                        <span class="text"><?php _e( 'Bis', 'eidenbenz' ); ?></span>
                     </div>
                  </div>
	               <?php if ( have_posts() ) {
		               while ( have_posts() ) {
			               the_post();
			               get_template_part( 'template-parts/kundenarchiv/list-single-mobile' );
		               }
		               ?>
                       <div class="filter-pagination">
			               <?php
			               the_posts_pagination( array(
				               'screen_reader_text' => ' ',
				               'prev_text'          => __( 'Previous', 'eidenbenz' ),
				               'next_text'          => __( 'Next', 'eidenbenz' ),
				               'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( '', 'eidenbenz' ) . ' </span>',
			               ) );
			               ?>
                       </div>
		               <?php
	               } else {
		               get_template_part( 'template-parts/kundenarchiv/filter', "no-result" );
	               } ?>

                  <!-- End of table content -->
               </div>
            </div>
        </div>
    </section>
<?php
get_footer();