<?php
global $Kundenarchiv_Filter; //class-object that handles filter functionality, defined in inc/class-kundenarchiv-filter.php
$bereich = $Kundenarchiv_Filter->getSelectoptions( "bereich" ); //get all selected bereich
?>
<!-- Top FIlter -->
<div class="custom-date-filter">
    <form class="table-filter-form kundenarchiv-filter-form"
          action="<?php echo get_post_type_archive_link( 'kundenarchiv' ); ?>" method="get">
        <div class="form-row">
            <!-- Form Cols -->
            <div class="form-col search-col">
                <div class="label-input-wrapper">
                    <label class="form-label"><?php _e( 'Suche', 'eidenbenz' ); ?>:</label>
                    <input type="search" type="search" name="suche"
                           value="<?php echo ! empty( $Kundenarchiv_Filter->suche ) ? $Kundenarchiv_Filter->suche : ''; ?>"
                           placeholder="<?php _e( 'Suchbegriff', 'eidenbenz' ); ?>">
                </div>
            </div>
            <!-- Form Cols -->
            <div class="form-col checkbox-col">
                <div class="label-input-wrapper">
                    <label class="form-label"><?php _e( 'Suche in', 'eidenbenz' ); ?>:</label>
                    <div class="check-list">
                        <ul>
                            <!-- List -->
                            <li>
                                <label>
                                    <input type="checkbox" class="input-checkbox filter-input" name="suchen_in[]"
                                           value="name" <?php echo in_array( "name", $Kundenarchiv_Filter->suchen_in ) ? "checked" : ""; ?>>
                                    <span class="custom-checkbox"></span>
                                    <span class="check-item">
                                    <span class="for-cursor">
                                       <?php _e( 'Name', 'eidenbenz' ); ?>
                                    </span>
                                 </span>
                                </label>
                            </li><!-- List -->
                            <li>
                                <label>
                                    <input type="checkbox" class="input-checkbox filter-input" name="suchen_in[]"
                                           value="adresse" <?php echo in_array( "adresse", $Kundenarchiv_Filter->suchen_in ) ? "checked" : ""; ?>>
                                    <span class="custom-checkbox"></span>
                                    <span class="check-item">
                                    <span class="for-cursor">
                                       <?php _e( 'Adresse', 'eidenbenz' ); ?>
                                    </span>
                                 </span>
                                </label>
                            </li><!-- List -->
                            <li>
                                <label>
                                    <input type="checkbox" class="input-checkbox filter-input" name="suchen_in[]"
                                           value="thema" <?php echo in_array( "thema", $Kundenarchiv_Filter->suchen_in ) ? "checked" : ""; ?>>
                                    <span class="custom-checkbox"></span>
                                    <span class="check-item">
                                    <span class="for-cursor">
                                       <?php _e( 'Thema', 'eidenbenz' ); ?>
                                    </span>
                                 </span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Form Cols -->
            <div class="form-col checkbox-col checkbox-col-dropdown">
                <div class="label-input-wrapper bereich-checklist">
                    <label class="form-label"><?php _e( 'Bereich', 'eidenbenz' ); ?>:</label>
                    <!-- Check Header -->
                    <div class="check-header">
                        <h4 class="check-title" data-label=""></h4>
                        <span class="select-drop">
                  <svg width="19" height="10" viewBox="0 0 19 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <line x1="0.353553" y1="0.646447" x2="9.35355" y2="9.64645" stroke="black"/>
                     <line x1="18.3536" y1="0.353553" x2="9.35355" y2="9.35355" stroke="black"/>
                  </svg>
               </span>
                    </div>
                    <div class="check-list">
                        <ul>
							<?php
							if ( ! empty( $bereich ) ) {
								foreach ( $bereich as $option ) {
									?>
                                    <!-- List -->
                                    <li>
                                        <label>
                                            <input name="bereich[]" class="input-checkbox filter-input" type="checkbox"
                                                   value="<?php echo $option->slug; ?>" <?php echo in_array( $option->slug, $Kundenarchiv_Filter->selected_bereich ) ? "checked" : ""; ?>>
                                            <span class="custom-checkbox"></span>
                                            <span class="check-item"><?php echo $option->name; ?></span>
                                        </label>
                                    </li>
									<?php
								}
							}
							?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Form Cols -->
            <div class="form-col date-cols">
                <div class="date-row">
                    <!-- Date -->
                    <div class="label-input-wrapper">
                        <label class="form-label">Von:</label>
                        <input type="text" name="from"
                               value="<?php echo ! empty( $Kundenarchiv_Filter->from ) ? $Kundenarchiv_Filter->from : ''; ?>"
                               placeholder="<?php _e( "Jahr", "eidenbenz" ); ?>">
                    </div>
                    <!-- Date -->
                    <div class="label-input-wrapper">
                        <label class="form-label">Bis:</label>
                        <input type="text" name="until"
                               value="<?php echo ! empty( $Kundenarchiv_Filter->until ) ? $Kundenarchiv_Filter->until : ''; ?>"
                               placeholder="<?php _e( "Jahr", "eidenbenz" ); ?>">
                    </div>
                </div>
            </div>
            <!-- Letter col -->
            <div class="form-col letter-filter-col">
                <!-- Letter filter -->
                <div class="letter-filter">
                    <div class="letter-filter-head">
                        <label><?php _e( "Nach Anfangsbuchstaben filtern (Name):", "eidenbenz" ); ?> </label>
                        <span class="select-drop">
                     <svg width="19" height="10" viewBox="0 0 19 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="0.353553" y1="0.646447" x2="9.35355" y2="9.64645" stroke="black"/>
                        <line x1="18.3536" y1="0.353553" x2="9.35355" y2="9.35355" stroke="black"/>
                     </svg>
                  </span>
                    </div>
                    <!-- <select name="starts_with"> -->
                    <div class="list-wrapper">
                        <ul>
							<?php
							foreach ( range( 'a', 'z' ) as $v ) {
								?>
                                <li class="list">
                                    <input id="<?php echo $v; ?>-id" type="radio" name="starts_with"
                                           value="<?php echo $v; ?>" <?php echo $Kundenarchiv_Filter->starts_with == $v ? "checked" : "" ?>><label
                                            for="<?php echo $v; ?>-id"
                                            class="letter"><?php echo strtoupper( $v ); ?></label>
                                </li>
								<?php
							}
							?>
                        </ul>
                    </div>
                    <!-- </select> -->
                </div>
            </div>
        </div>
        <div class="buttons-wrapper">
            <input type="submit" class="custom-btn" value="<?php _e( 'anzeigen', 'eidenbenz' ); ?>">
            <button class="custom-btn clear-btn d-none" id="clear_button"
                    type="button"><?php _e( "Alle Filter ausblenden", "eidenbenz" ); ?></button>
        </div>
    </form>
</div>
<!-- End of filter -->
<div class="clear-btn-wrapper">
    <h4 class="clear-btn <?php echo $Kundenarchiv_Filter->isFilterApplied() ? 'clear-visible' : '' ?>" id="clear_button"
        type="button"><?php _e( "Alle Filter ausblenden", "eidenbenz" ); ?></h4>
</div>
