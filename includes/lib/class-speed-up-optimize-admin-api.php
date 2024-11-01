<?php
/**
 * Contains class for the plugin Admin API.
 *
 * @package App Perf \ Admin API
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class used for the Admin API
 */
class Speed_Up_Optimize_Admin_API {

	/**
	 * Constructor function
	 */
	public function __construct() {
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 1 );
	}

	/**
	 * Generate HTML for displaying fields.
	 *
	 * @param  array   $data Container of the values for the settings page.
	 * @param  array   $post If meta will be coming from a post.
	 * @param  boolean $echo  Whether to echo the field HTML or return it.
	 * @return Returns the whole html options.
	 */
	public function display_field( $data = array(), $post = false, $echo = true ) {

		// Get field info.
		if ( isset( $data['field'] ) ) {
			$field = $data['field'];
		} else {
			$field = $data;
		}

		// Check for prefix on option name.
		$option_name = '';
		if ( isset( $data['prefix'] ) ) {
			$option_name = $data['prefix'];
		}

		// Get saved data.
		$data = '';
		if ( $post ) {
			// Get saved field data.
			$option_name .= $field['id'];
			$option       = get_post_meta( $post->ID, $field['id'], true );
			// Get data to display in field.
			if ( isset( $option ) ) {
				$data = $option;
			}
		} else {
			// Get saved option.
			$option_name .= $field['id'];
			$option       = get_option( $option_name );

			// Get data to display in field.
			if ( isset( $option ) ) {
				$data = $option;
			}
		}

		// Show default data if no option saved and default is supplied.
		if ( ( false === $data ) && isset( $field['default'] ) ) {
			$data = $field['default'];
		} elseif ( false === $data ) {
			$data = '';
		}

		$html = '';

		switch ( $field['type'] ) {

			case 'text':
			case 'url':
			case 'email':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . esc_attr( $data ) . '" />' . "\n";
				break;

			case 'password':
			case 'number':
			case 'hidden':
				$min = '';
				if ( isset( $field['min'] ) ) {
					$min = ' min="' . esc_attr( $field['min'] ) . '"';
				}

				$max = '';
				if ( isset( $field['max'] ) ) {
					$max = ' max="' . esc_attr( $field['max'] ) . '"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . esc_attr( $data ) . '"' . $min . '' . $max . '/>' . "\n";
				break;

			case 'text_secret':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="" />' . "\n";
				break;

			case 'textarea':
				$html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . $data . '</textarea><br/>' . "\n";
				break;

			case 'checkbox':
				$checked = '';
				if ( $data && 'on' === $data ) {
					$checked = 'checked="checked"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
				break;

			case 'checkbox_multi':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( in_array( $k, (array) $data, true ) ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '" class="checkbox_multi"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
				break;

			case 'radio':
				foreach ( $field['options'] as $k => $v ) {
					$checked = false;
					if ( $k === $data ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
				break;

			case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( $k === $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
				break;

			case 'select_multi':
				$html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( in_array( $k, (array) $data, true ) ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
				break;

			case 'image':
				$image_thumb = '';
				if ( $data ) {
					$image_thumb = wp_get_attachment_thumb_url( $data );
				}
				$html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
				$html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . __( 'Upload an image', 'speed-up-optimize' ) . '" data-uploader_button_text="' . __( 'Use image', 'speed-up-optimize' ) . '" class="image_upload_button button" value="' . __( 'Upload new image', 'speed-up-optimize' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="' . __( 'Remove image', 'speed-up-optimize' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
				break;

		}

		switch ( $field['type'] ) {

			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$html .= '<br/><span class="description">' . $field['description'] . '</span>';
				break;

			default:
				if ( ! $post ) {
					$html .= '<label for="' . esc_attr( $field['id'] ) . '">' . "\n";
				}

				$html .= '<span class="description">' . $field['description'] . '</span>' . "\n";

				if ( ! $post ) {
					$html .= '</label>' . "\n";
				}
				break;
		}

		if ( ! $echo ) {
			return $html;
		}
		// TODO: Output this properly.
		echo $html; // @codingStandardsIgnoreLine

	}

	/**
	 * Validate form field.
	 *
	 * @param  string $data Submitted value.
	 * @param  string $type Type of field to validate.
	 * @return string       Validated value.
	 */
	public function validate_field( $data = '', $type = 'text' ) {

		switch ( $type ) {
			case 'text':
				$data = esc_attr( $data );
				break;
			case 'url':
				$data = esc_url( $data );
				break;
			case 'email':
				$data = is_email( $data );
				break;
		}

		return $data;
	}

	/**
	 * Add meta box to the dashboard.
	 *
	 * @param string $id            Unique ID for metabox.
	 * @param string $title         Display title of metabox.
	 * @param array  $post_types    Post types to which this metabox applies.
	 * @param string $context       Context in which to display this metabox ('advanced' or 'side').
	 * @param string $priority      Priority of this metabox ('default', 'low' or 'high').
	 * @param array  $callback_args Any axtra arguments that will be passed to the display function for this metabox.
	 * @return void
	 */
	public function add_meta_box( $id = '', $title = '', $post_types = array(), $context = 'advanced', $priority = 'default', $callback_args = null ) {

		// Get post type(s).
		if ( ! is_array( $post_types ) ) {
			$post_types = array( $post_types );
		}

		// Generate each metabox.
		foreach ( $post_types as $post_type ) {
			add_meta_box( $id, $title, array( $this, 'meta_box_content' ), $post_type, $context, $priority, $callback_args );
		}
	}

	/**
	 * Display metabox content.
	 *
	 * @param  object $post Post object.
	 * @param  array  $args Arguments unique to this metabox.
	 * @return void
	 */
	public function meta_box_content( $post, $args ) {

		$fields = apply_filters( $post->post_type . '_custom_fields', array(), $post->post_type );

		if ( ! is_array( $fields ) || 0 === count( $fields ) ) {
			return;
		}

		echo '<div class="custom-field-panel">' . "\n";

		foreach ( $fields as $field ) {

			if ( ! isset( $field['metabox'] ) ) {
				continue;
			}

			if ( ! is_array( $field['metabox'] ) ) {
				$field['metabox'] = array( $field['metabox'] );
			}

			if ( in_array( $args['id'], $field['metabox'], true ) ) {
				$this->display_meta_box_field( $field, $post );
			}
		}

		echo '</div>' . "\n";

	}

	/**
	 * Dispay field in metabox.
	 *
	 * @param  array  $field Field data.
	 * @param  object $post  Post object.
	 * @return void
	 */
	public function display_meta_box_field( $field = array(), $post ) {

		if ( ! is_array( $field ) || 0 === count( $field ) ) {
			return;
		}
		$field = '<p class="form-field"><label for="' . $field['id'] . '">' . $field['label'] . '</label>' . $this->display_field( $field, $post, false ) . '</p>' . "\n";

		echo $field; // @codingStandardsIgnoreLine
	}

	/**
	 * Save metabox fields.
	 *
	 * @param  integer $post_id Post ID.
	 * @return void
	 */
	public function save_meta_boxes( $post_id = 0 ) {

		if ( ! $post_id ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		$fields = apply_filters( $post_type . '_custom_fields', array(), $post_type );

		if ( ! is_array( $fields ) || 0 === count( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {
			// TODO: needs cleanup
			// @codingStandardsIgnoreLine
			if ( isset( $_REQUEST[ $field['id'] ] ) ) {
				update_post_meta(
					$post_id,
					$field['id'],
					// @codingStandardsIgnoreLine
					$this->validate_field( $_REQUEST[ $field['id'] ],
						$field['type']
					)
				);
			} else {
				update_post_meta( $post_id, $field['id'], '' );
			}
		}
	}

	/**
	 * Datatables includes
	 *
	 * @return void
	 */
	public function include_datatables() {
		wp_register_style( 'datatables-cssadmin', 'https:///cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css', array(), $this->parent->version, false );
		wp_enqueue_style( 'datatables-cssadmin' );

		wp_register_script( 'datatables-jsadmin', 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js', 'jquery', $this->parent->version, true );
		wp_enqueue_script( 'datatables-jsadmin' );

	}

	/**
	 * Echoes datatable parameters
	 *
	 * @param [type] $tableid talbe unique id.
	 * @return void
	 */
	public function datatable_jquery( $tableid ) {
		$html = "<script type='text/javascript'>
			jQuery(document).ready( function () {
				jQuery('#" . $tableid . "').DataTable();
			} );
			
		</script>";
		echo wp_kses( $html, $this->allow_scripts );

	}

	/**
	 * Allow scripts.
	 *
	 * @var array
	 */
	public $allow_scripts = array(
		'script' => array(
			'type' => array(),
		),
	);

	/**
	 * Allowed html.
	 *
	 * @var array
	 */
	public $allowed_htmls = array(
		'a'      => array(
			'href'  => array(),
			'title' => array(),
			'class' => array(),
		),
		'h1'     => array(
			'href'  => array(),
			'title' => array(),
			'class' => array(),
		),
		'h2'     => array(
			'href'  => array(),
			'title' => array(),
			'class' => array(),
		),
		'h3'     => array(
			'href'  => array(),
			'title' => array(),
			'class' => array(),
		),
		'h4'     => array(
			'href'  => array(),
			'title' => array(),
			'class' => array(),
		),
		'input'  => array(
			'id'          => array(),
			'type'        => array(),
			'name'        => array(),
			'placeholder' => array(),
			'value'       => array(),
			'class'       => array(),
			'checked'     => array(),
		),
		'select' => array(
			'id'          => array(),
			'type'        => array(),
			'name'        => array(),
			'placeholder' => array(),
			'value'       => array(),
			'multiple'    => array(),
			'style'       => array(),
		),
		'option' => array(
			'id'          => array(),
			'type'        => array(),
			'name'        => array(),
			'placeholder' => array(),
			'value'       => array(),
			'multiple'    => array(),
			'selected'    => array(),
		),
		'label'  => array(
			'for'   => array(),
			'title' => array(),
		),
		'span'   => array(
			'class' => array(),
			'title' => array(),
		),
		'table'  => array(
			'scope' => array(),
			'title' => array(),
			'class' => array(),
			'role'  => array(),
			'id'    => array(),
		),
		'tbody'  => array(
			'scope' => array(),
			'title' => array(),
			'class' => array(),
			'role'  => array(),
		),
		'thead'  => array(
			'scope' => array(),
			'title' => array(),
			'class' => array(),
			'role'  => array(),
		),
		'th'     => array(
			'scope' => array(),
			'title' => array(),
		),
		'tr'     => array(),
		'td'     => array(),
		'p'      => array(),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'th'     => array(),
		'form'   => array(
			'method'      => array(),
			'type'        => array(),
			'name'        => array(),
			'placeholder' => array(),
			'value'       => array(),
			'multiple'    => array(),
			'selected'    => array(),
			'action'      => array(),
			'enctype'     => array(),
		),
		'div'    => array(
			'class' => array(),
			'id'    => array(),
		),
	);

}
