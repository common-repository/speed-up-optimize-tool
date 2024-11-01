<?php
/**
 * Pantheon Environments.
 *
 * @package App Perf
 * @author Carl Alberto
 * @since 1.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pantheon environments
 */
class SUO_Environments {

	/**
	 * Gets environment  data.
	 */
	public function pan_site_summary() {
		$tableid = 'panenvironments';

		$this->include_datatables()->datatable_jquery( $tableid );
		$this->include_datatables()->include_datatables();
		$site_summary_list = $_ENV;
		$html_table        = sprintf(
			'<table id="' . $tableid . '" class="widefat striped ' . $tableid . '"><thead><tr><th scope="col">%s</th><th scope="col">%s</th></tr></thead><tbody>',
			__( 'Name', 'speed-up-optimize' ),
			__( 'Value', 'speed-up-optimize' )
		);

		foreach ( $site_summary_list as $key => $value ) {
			$html_table .= sprintf( '<tr><td>%s</td><td>%s</td></tr>', $key, $value );
		}
		$html_table .= '</tbody></table>';

		echo wp_kses( $html_table, $this->sanitize_thishtml() );

	}

	/**
	 * Gets server variables data.
	 */
	public function pan_server_variables() {
		$tableid = 'pan_server_variables';

		$this->include_datatables()->datatable_jquery( $tableid );
		$this->include_datatables()->include_datatables();
		$site_summary_list = $_SERVER;
		$html_table        = sprintf(
			'<table id="' . $tableid . '" class="widefat striped ' . $tableid . '"><thead><tr><th scope="col">%s</th><th scope="col">%s</th></tr></thead><tbody>',
			__( 'Name', 'speed-up-optimize' ),
			__( 'Value', 'speed-up-optimize' )
		);

		foreach ( $site_summary_list as $key => $value ) {
			$html_table .= sprintf( '<tr><td>%s</td><td>%s</td></tr>', $key, $value );
		}
		$html_table .= '</tbody></table>';

		echo wp_kses( $html_table, $this->sanitize_thishtml() );

	}


	/**
	 * Sanitization
	 *
	 * @return html
	 */
	public function sanitize_thishtml() {
		$sanitisation = new Speed_Up_Optimize_Admin_API();
		return $sanitisation->allowed_htmls;
	}

	/**
	 * Datatables include
	 *
	 * @return html
	 */
	public function include_datatables() {
		$dtinclude = new Speed_Up_Optimize_Admin_API();
		return $dtinclude;
	}

	/**
	 * Add Environment variables summary.
	 *
	 * @return void
	 */
	public function appperf_env_summary() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';
		print '<p>This will show <a href="https://pantheon.io/docs/guides/environment-configuration" target="_blank">Pantheon`s ENVIRONMENT variables</a></p>';

		$this->pan_site_summary();

		print '</div>';

	}

	/**
	 * Add Server variables summary.
	 *
	 * @return void
	 */
	public function appperf_serverenv_summary() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';
		print '<p>This will show <a href="https://pantheon.io/docs/guides/environment-configuration" target="_blank">Pantheon`s SERVER variables</a></p>';

		$this->pan_server_variables();

		print '</div>';

	}

	/**
	 * Get site summary values and store in array
	 *
	 * @return array
	 */
	public function site_summary() {

		return $_ENV;
	}

}
