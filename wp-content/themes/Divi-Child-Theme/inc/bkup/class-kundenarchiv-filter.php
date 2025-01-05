<?php

if ( ! class_exists( "Kundenarchiv_Filter" ) ) { // class that handles the filter functionality
	class Kundenarchiv_Filter {
		public $suche, $suchen_in, $selected_bereich, $from, $until, $starts_with; // variables to store the forms input states

		public function __construct() {
			$this->suche            = isset( $_GET["suche"] ) && ! empty( $_GET["suche"] ) ? $_GET["suche"] : array(); // search text if it is set
			$this->suchen_in        = isset( $_GET["suchen_in"] ) && ! empty( $_GET["suchen_in"] ) ? $_GET["suchen_in"] : array(); // search in options if it is set
			$this->selected_bereich = isset( $_GET["bereich"] ) && ! empty( $_GET["bereich"] ) ? $_GET["bereich"] : array(); // selected bereich
			$this->from             = isset( $_GET["from"] ) && ! empty( $_GET["from"] ) ? $_GET["from"] : ""; // from year
			$this->until            = isset( $_GET["until"] ) && ! empty( $_GET["until"] ) ? $_GET["until"] : ""; // until year
			$this->starts_with      = isset( $_GET["starts_with"] ) && ! empty( $_GET["starts_with"] ) ? $_GET["starts_with"] : ""; // starting alphabet
			add_action( 'pre_get_posts', array(
				$this,
				'custom_query_vars'
			), 9999 ); // customize the query for post type kundenarchiv
			add_filter( 'posts_join', function ( $join ) {
				global $wpdb;
				if ( ! empty( $this->from ) || ! empty( $this->until ) ) {
					$join .= "LEFT JOIN $wpdb->postmeta as meta_1 ON $wpdb->posts.ID = meta_1.post_id LEFT JOIN $wpdb->postmeta as meta_2 ON $wpdb->posts.ID = meta_2.post_id";
				}

				return $join;
			} );

			add_filter( 'posts_where', function ( $where = '' ) {
				if ( ! empty( $this->from ) && ! empty( $this->until ) ) {
					$where .= " AND ((meta_1.meta_key = 'von' AND meta_1.meta_value >= $this->from AND meta_2.meta_key = 'bis' AND meta_2.meta_value >= $this->from AND (meta_1.meta_value != '' AND meta_1.meta_value != 'undatiert' AND meta_2.meta_value != '' AND meta_2.meta_value != 'undatiert') AND meta_1.meta_key = 'von' AND meta_1.meta_value <= $this->until AND meta_2.meta_key = 'bis' AND meta_2.meta_value <= $this->until AND (meta_1.meta_value != '' AND meta_1.meta_value != 'undatiert' AND meta_2.meta_value != '' AND meta_2.meta_value != 'undatiert')) OR
                        (meta_1.meta_key = 'von' AND  meta_2.meta_key = 'bis' AND  meta_1.meta_value >= $this->from AND meta_1.meta_value <= $this->until AND (meta_2.meta_value = '' OR meta_2.meta_value = 'undatiert')) OR
                        (meta_1.meta_key = 'von' AND meta_2.meta_key = 'bis' AND meta_2.meta_value >= $this->from AND meta_2.meta_value <= $this->until AND (meta_1.meta_value = '' OR meta_1.meta_value = 'undatiert'))
						)";
				} else {
					if ( ! empty( $this->from ) ) {
						$where .= " AND ((meta_1.meta_key = 'von' AND meta_1.meta_value >= $this->from AND meta_2.meta_key = 'bis' AND meta_2.meta_value >= $this->from AND (meta_1.meta_value != '' AND meta_1.meta_value != 'undatiert' AND meta_2.meta_value != '' AND meta_2.meta_value != 'undatiert')) OR (meta_1.meta_key = 'von' AND meta_1.meta_value >= $this->from AND  meta_2.meta_key = 'bis' AND  (meta_2.meta_value = '' OR meta_2.meta_value = 'undatiert')) OR
						(meta_2.meta_key = 'bis' AND meta_2.meta_value >= $this->from AND  meta_1.meta_key = 'von' AND  (meta_1.meta_value = '' OR meta_1.meta_value = 'undatiert'))
						)";
					}
					if ( ! empty( $this->until ) ) {
//						$where .= " AND meta_1.meta_key = 'bis' AND meta_1.meta_value <= $this->until";
						$where .= " AND ((meta_1.meta_key = 'von' AND meta_1.meta_value <= $this->until AND meta_2.meta_key = 'bis' AND meta_2.meta_value <= $this->until AND (meta_1.meta_value != '' AND meta_1.meta_value != 'undatiert' AND meta_2.meta_value != '' AND meta_2.meta_value != 'undatiert')) OR (meta_1.meta_value > 0 AND meta_1.meta_key = 'von' AND meta_1.meta_value <= $this->until AND  meta_2.meta_key = 'bis' AND  (meta_2.meta_value = '' OR meta_2.meta_value = 'undatiert')) OR
						(meta_2.meta_value > 0 AND meta_2.meta_key = 'bis' AND meta_2.meta_value <= $this->until AND  meta_1.meta_key = 'von' AND  (meta_1.meta_value = '' OR meta_1.meta_value = 'undatiert')))";
					}
				}

				return $where;
			} );
		}

		public function custom_query_vars( $query ) {
			if ( is_admin() || ! $query->is_main_query() || $query->get( 'post_type' ) != "kundenarchiv" ) { // customize query for only "kundenarchiv" post type
				return;
			}
			$query->set( 'posts_per_page', 15 ); // set posts per page
			$query->set( 'order', 'ASC' );
			if ( ! empty( $this->selected_bereich ) ) { // if selected bereich is not empty customize the wp query accordingly.
				$tax_query   = array();
				$tax_query[] = array(
					array(
						'taxonomy' => 'bereich',
						'field'    => 'slug',
						'terms'    => $this->selected_bereich,
						'operator' => 'IN'
					)
				);
				$query->set( 'tax_query', $tax_query );
			}
			if ( ! empty( $this->starts_with ) ) { //if start_with filter is applied.
				$query->set( 'starts_with', $this->starts_with );
			}
		}

		public function getSelectoptions( $taxonomy = "" ) { // get all selected terms from the taxonomy
			$terms = get_terms( [
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			] );

			return ! is_wp_error( $terms ) ? $terms : array();
		}

		public function isFilterApplied() { //function that checks if the filter is already applied.
			if ( ! empty( $this->suche ) || ! empty( $this->suchen_in ) || ! empty( $this->selected_bereich ) || ! empty( $this->from ) || ! empty( $this->until ) || ! empty( $this->starts_with ) ) {
				return true;
			}

			return false;
		}
	}

	global $Kundenarchiv_Filter; // globally defining object so that it can be accessed from anywhere in the project file
	$Kundenarchiv_Filter = new Kundenarchiv_Filter();
}