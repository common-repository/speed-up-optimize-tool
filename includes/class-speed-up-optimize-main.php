<?php
/**
 * Contains the mian functionalities, customization will mainly happen here.
 *
 * @package App Perf \ Main Functionalities
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class used for the main plugin functions.
 */
class Speed_Up_Optimize_Main {

	/**
	 * Diplays the scipts and css in the footer.
	 */
	public function display_scripts() {
		if ( current_user_can( 'manage_options' ) ) {
			global $wp_scripts, $wp_styles;
			echo 'Scripts ( Handle - URL )<br>';
			foreach ( $wp_scripts->queue as $script ) {
				echo sprintf( '<strong>%1s</strong> - %2s <br>', esc_html( $script ), esc_html( $wp_scripts->registered[ $script ]->src ) );
			}
			echo '<br><br>Styles ( Handle - URL )<br>';
			foreach ( $wp_styles->queue as $style ) {
				echo sprintf( '<strong>%1s</strong> - %2s <br>', esc_html( $style ), esc_html( $wp_styles->registered[ $style ]->src ) );
			}
		}

	}

	/**
	 * Register menu items.
	 */
	public function appperf_register_menu() {

		add_menu_page(
			'Pantheon Compatibility Check',
			'Pantheon Check',
			'manage_options',
			'app-perf-check',
			array( $this, 'appperf_mainmenu' ),
			'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjYiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBmaWxsPSIjZmZmIiBmaWxsLXJ1bGU9Im5vbnplcm8iPjxwYXRoIGQ9Ik0xLjc1NTkgMy44MTUzSC4zMDgyYy0uMDIwNyAwLS4wNDItLjAwMTYtLjA2MyAwcy0uMDM0LS4wMTA2LS4wNTUtLjAwODhsLS4wMzI5LS4wMTk3Qy4xMzUyIDMuNzczLjExNzUgMy43NTU5LjEwNTUgMy43Mzc1YS4yMjMuMjIzIDAgMCAwLS4wMjI5LS4wNDU1Yy0uMDA3NC0uMDEzNS0uMDExOS0uMDI3MS0uMDEyNy0uMDQxMSAwLS4wMDQtLjAwNTctLjAwODQtLjAxLS4wMTQyLS4wMDMzLS4wMTMyLjAwNTYtLjAyODktLjAxMTctLjA0MjV2LS4wMzg3bC0uMDEyMy0uMDExOHYtLjA1NGwtLjAxMTctLjAxMDV2LS4wODIxTC4wMTE5IDMuMzg2di0uMTMyMkwwIDMuMjQyNXYtLjgxMDdsLjAxMTUtLjAxMzNWMi4yOGwuMDExNy0uMDEwMnYtLjA3NmwuMDExNC0uMDEwNXYtLjA1OTljLjAxOTYtLjAxNjcuMDA4Ni0uMDM0OS4wMTI5LS4wNTE2bC4wMTA3LS4wMTAxdi0uMDMxMmMuMDE3My0uMDA5NS4wMDgtLjAyNDIuMDE3LS4wMzYxcy4wMTUtLjAyNjcuMDIwMy0uMDM5LjAxNDgtLjAyMzcuMDI0NC0uMDM0OWMuMDEyOC0uMDI0My4wNDE2LS4wNDQ4LjA3ODctLjA1NTdsLjA2OTYtLjAxMDhoMS42MjczYy4wMTYyLjAwNjcuMDI2Ny4wMTc1LjAyOTcuMDI5NXMuMDA5LjAxNzguMDE2NS4wMjYzYy4wMTY1LjAxODguMDIzOC4wNDA3LjA0MTguMDU5NC4wMDI3LjAyMTYuMDMzNy4wMzY2LjAzNTcuMDU4MS4wMDIuMDA1Ni4wMDU0LjAxMDUuMDExMS4wMTU2LjAxMTYuMDEwOS4wMTk2LjAyMjEuMDIzOS4wMzQ5cy4wMi4wMjE2LjAyMy4wMzQ3YzAgLjAwNzguMDEyNy4wMTQxLjAxNjcuMDIyM3MuMDE1Ni4wMTUyLjAxNzMuMDI1Ny4wMDc0LjAxNTQuMDE1LjAyMjhhLjMyMi4zMjIgMCAwIDEgLjAzNjUuMDUzNy40NDMuNDQzIDAgMCAwIC4wMzk1LjA1MTdjLS4wMDMuMDA5My4wMDcuMDE1Ny4wMTE3LjAyMzFsLjAxNjMuMDIxOGMuMDAzOC4wMDc0LjAwODUuMDE1MS4wMTQ0LjAyMjFhLjI1NS4yNTUgMCAwIDEgLjAyNDYuMDM4OC4xNDguMTQ4IDAgMCAxIC4wMjc0LjA0MTJjLjAwMzYuMDEzLjAyMjkuMDI0LjAyOTMuMDM3cy4wMTYuMDIzNi4wMjIzLjAzNTYuMDE0NC4wMjMzLjAyMy4wMzUuMDE0Ny4wMjEuMDIwMy4wMzE0LjAyMjcuMDIyNi4wMjY0LjAzNDYuMDE3My4wMzAyLjAyOC4wNDUuMDI2My4wMjgzLjAzMi4wNDM0LjAyMjcuMDI5LjAyOTguMDQ0N2wuMDE3NS4wMzI2di4wMDY3YzAgLjAwMjMtLjAwNjUuMDAzLS4wMDkzLjAwM2gtLjcxMTdjLS4wMTg3LS4wMjI5LS4wMjk2LS4wNDkyLS4wNTE2LS4wNzItLjAwMTEtLjAxMDItLjAwNzQtLjAxOTgtLjAxOC0uMDI4NHMwLS4wMTk4LS4wMTY0LS4wMjZjLS4wMTYzLS4wMjA5LS4wMjUtLjA0NDYtLjA0NC0uMDYzNS0uMDAzNi0uMDIzMy0uMDM1Ni0uMDQxLS4wMzgzLS4wNjRhLjIxNi4yMTYgMCAwIDEtLjAzODctLjA1MjRjLS4wMDctLjAxMjktLjAxNzktLjAyNTYtLjAyNTctLjAzODVzLS4wMi0uMDI3NC0uMDI4LS4wNDIyLS4wMTczLS4wMjU0LS4wMjgtLjAzNzRhLjYyNy42MjcgMCAwIDAtLjA1MTMtLjA3NjVsLS4wMTQyLS4wMTRoLS4xNTI1Yy0uMDExNi4wMDQyLS4wMDgzLjAxMi0uMDAyOS4wMTc0LjAxNi4wMTk1LjAyODYuMDM5OC4wNDIuMDZzLjAyNTYuMDQwOC4wNDIuMDU5N2MuMDAyOS4wMTA2LjAwOC4wMjA1LjAxNjEuMDI5NnMuMDE4OC4wMTU1LjAyLjAyNDIuMDA5OS4wMTk5LjAxOTkuMDI4NC4wMDQ5LjAxOC4wMTU2LjAyNTZhLjA2OS4wNjkgMCAwIDEgLjAyMTcuMDI4Ni4xNDIuMTQyIDAgMCAwIC4wMTY3LjAyODZjLjAwNDYuMDA4OC4wMTg3LjAxNjQuMDE5Ny4wMjVzLjAwOTYuMDE5OC4wMTg5LjAyODYuMDA0My4wMTc5LjAxNi4wMjYxLjAxODMuMDE3Ny4wMjEuMDI3OGMuMDA3LjAxNTMuMDE2NS4wMzAzLjAyOTcuMDQ0My4wMDY3LjAxNDYuMDE2LjAyODMuMDI4My4wNDE2LjAwNS4wMDQ0LjAwNS4wMTA3IDAgLjAxNi0uMDAyNyAwLS4wMDM2LjAwMjQtLjAwNS4wMDI0aC0uNTUyNmMtLjAwNzEuMDAzOS0uMDAzOS4wMDc0IDAgLjAxMjNhLjE0Ni4xNDYgMCAwIDEgLjAyOTMuMDQxMWMuMDAzOC4wMTM1LjAyMjcuMDIzNy4wMjQzLjAzODcuMDAxNS4wMDQ5LjAwNTMuMDEwNy4wMTE1LjAxNTUuMDE4My4wMTc1LjAyMjkuMDM5LjA0MTguMDU3LjAxMTEuMDE3NS4wMjQuMDM0NC4wMzgyLjA1MTUgMCAuMDExNS4wMTAyLjAyLjAxNjIuMDI5NXMuMDE1OC4wMjEuMDIxMy4wMzE1YS4wNzUuMDc1IDAgMCAwIC4wMjIuMDI4M2MuMDExNC4wMTA2LjAxMjMuMDIzOS4wMjIuMDM0OWEuMzM3LjMzNyAwIDAgMSAuMDI0My4wMzg1Yy4wMDgyLjAxMTYuMDIyOC4wMjEyLjAyMjguMDM1LjAxNjkuMDE4LjAzMDkuMDM3LjA0MTkuMDU2OGwuMDI1My4wMzc0YS40NDUuNDQ1IDAgMCAxIC4wMjc3LjA0MmMuMDAzNC4wMTM1LjAyMjcuMDI0Mi4wMjg3LjAzNzZzLjAyMDMuMDI5Ni4wMjc4LjA0NS4wMjM4LjAzMTEuMDMzLjA0NjguMDIzOS4wMjk0LjAzMTIuMDQ0NC4wMjA3LjAyOTQuMDI4My4wNDUuMDIzNS4wMzEzLjAzMzMuMDQ3Mi4wMjQuMDI5NC4wMzA3LjA0NDIuMDIxLjAyODkuMDI4LjA0NS4wMjcuMDI4My4wMzIuMDQzNi4wMTkzLjAzLjAzMDQuMDQ0M2MuMDA0Ni4wMTMuMDExNi4wMjM3LjAxOTYuMDM4NXoiIGZpbGw9IiMwMTAxMDEiLz48cGF0aCBkPSJNMi45OTY5IDUuNjU0NmgtLjAxOGMtLjAwMTYtLjAwNDItLjAwNDctLjAwODYtLjAwOS0uMDEyYS43NTQuNzU0IDAgMCAxLS4wNzY2LS4wNTY4Yy0uMDE0LS4wMDg4LS4wMjQtLjAyMDctLjAzOC0uMDI5OXMtLjAyMi0uMDE4Ny0uMDM0LS4wMjczLS4wMjgtLjAxOTItLjAzOC0uMDMwNWMtLjAwMzQtLjAwNTEtLjAxMjctLjAwODUtLjAxOTQtLjAxMzFzLS4wMjUtLjAxMy0uMDI5Ny0uMDIxMS0uMDE0LS4wMTM2LS4wMjM2LS4wMTkxLS4wMjM3LS4wMTItLjAyNjQtLjAyMjhjMC0uMDAyNi0uMDA3My0uMDA0OS0uMDExNS0uMDA3N2wtLjA2MTQtLjA0NTJjLS4wMTY3LS4wMTU3LS4wMzY0LS4wMzAzLS4wNTgtLjA0MzMtLjAxMTQtLjAxNS0uMDI4Ny0uMDI3OS0uMDQ5OS0uMDM4LS4wMTMyLS4wMDg1LS4wMTcyLS4wMjA2LS4wMzI4LS4wMjg1cy0uMDIzNy0uMDE1OC0uMDMwNC0uMDI1OS0uMDIxNi0uMDEzOS0uMDMxMy0uMDIxLS4wMTM2LS4wMTM5LS4wMjE2LS4wMTk5bC0uMDcxMy0uMDUxN2MtLjAxMjctLjAwODctLjAxODctLjAxOTktLjAzMjctLjAyODZzLS4wMjk0LS4wMTgtLjAzOTQtLjAyOTMtLjAyOTctLjAxNjItLjAzNzctLjAyNTgtLjAzNDItLjAyMjMtLjA0Ni0uMDM1Ni0uMDI2Mi0uMDIyNi0uMDQyLS4wMzI1LS4wMTU2LS4wMTgzLS4wMjkzLS4wMjYxLS4wMjQzLS4wMTQ2LS4wMzA1LS4wMjQ5YzAtLjAwMzktLjAxLS4wMDY4LS4wMTU4LS4wMS0uMDE3My0uMDExLS4wMzI3LS4wMjI5LS4wNDYtLjAzNTVzLS4wMzE5LS4wMTg3LS4wNDItLjAzMjVjLS4wMDU3LS4wMDgyLS4wMjEzLS4wMTM3LS4wMzA3LS4wMjFzLS4wMTQtLjAxNDEtLjAyMi0uMDE5N2wtLjA3MTMtLjA1MjNjLS4wMTI0LS4wMDgyLS4wMTg0LS4wMTk3LS4wMzI3LS4wMjc5YS4xMy4xMyAwIDAgMS0uMDM5My0uMDI5NWMtLjAwOC0uMDEwMy0uMDI5Ny0uMDE2My0uMDM3OS0uMDI1OHMtLjAzMzgtLjAyMjctLjA0NTQtLjAzNTVhLjI1Mi4yNTIgMCAwIDAtLjA0Mi0uMDMyNWMtLjAxMTMtLjAwOC0uMDE1NC0uMDE4NS0uMDI5NC0uMDI2MmEuMDcyLjA3MiAwIDAgMS0uMDMwNi0uMDI0NmMtLjAwMi0uMDA0Mi0uMDEtLjAwNzItLjAxNTEtLjAxMDktLjAxNzYtLjAxMDEtLjAzMzMtLjAyMTktLjA0NjMtLjAzNDhTMS40ODAyIDQuNSAxLjQ3IDQuNDg2OHMtLjAyMTEtLjAxNC0uMDMxMS0uMDIxLS4wMTM1LS4wMTQyLS4wMjE5LS4wMmwtLjA3MTEtLjA1MThjLS4wMTI2LS4wMDg4LS4wMTg2LS4wMi0uMDMzLS4wMjg1cy0uMDI5LS4wMTgtLjAzOS0uMDI5My0uMDI3My0uMDE2OC0uMDM4LS4wMjYtLjAxNjYtLjAxNTItLjAyNi0uMDIyNC0uMDIxLS4wMTM2LS4wMjczLS4wMjIyYS4wOTYuMDk2IDAgMCAwLS4wMzA3LS4wMjA4Yy0uMDE0LS4wMDgtLjAxNy0uMDIwOC0uMDMzMy0uMDI3N3MtLjAyNDQtLjAyMDctLjAzNzctLjAzMDJhLjI5LjI5IDAgMCAxLS4wMzktLjAyNTljLS4wMTI2LS4wMTQ1LS4wMzMzLS4wMjMxLS4wNDYtLjAzNmEuMzc4LjM3OCAwIDAgMC0uMDQxNy0uMDMyNUMuOTQzOSA0LjA4NDkuOTM1IDQuMDc1OC45MjQ2IDQuMDY2OWEuMjAzLjIwMyAwIDAgMS0uMDM0NC0uMDI3N2MtLjAwNzYtLjAwOS0uMDI2OS0uMDE0My0uMDM0LS4wMjM0cy0uMDI2LS4wMjMxLS4wNDE4LS4wMzI5TC43MjY3IDMuOTEyYy4wMDMyIDAgLjAwNDItLjAwMTguMDA1OS0uMDAyMXMuMDA0LS4wMDA0LjAwNTYgMGgxLjI0MTdsLjAwNy0uMDAxNmMwLS4wMDI2LjAwMy0uMDA2NCAwLS4wMDlhLjE0Ny4xNDcgMCAwIDEtLjAzMjctLjA0MjljLS4wMDQzLS4wMTQ2LS4wMjU2LS4wMjYxLS4wMjQ5LS4wNDE1IDAtLjAwNi0uMDEwNy0uMDEyLS4wMTQ3LS4wMTgxcy0uMDE0LS4wMTg2LS4wMTk3LS4wMjg4LS4wMTA5LS4wMjE0LS4wMjI1LS4wMzAzLS4wMDg1LS4wMTk4LS4wMTcxLS4wMjk0LS4wMjA3LS4wMTY0LS4wMTcxLS4wMjg0YzAtLjAwMTktLjAwMzYtLjAwMzYtLjAwNTUtLjAwNi0uMDA4Ny0uMDEzOS0uMDIyMS0uMDI2LS4wMjk0LS4wNDAxcy0uMDIyNy0uMDI1OS0uMDI4Ny0uMDQwNS0uMDIyLS4wMjkzLS4wMjg3LS4wNDQzLS4wMTg2LS4wMy0uMDMyLS4wNDMyYy4wMDI3LS4wMTE1LS4wMTEtLjAxOTUtLjAxNTktLjAyOTNzLS4wMTYxLS4wMTgyLS4wMjA3LS4wMjc3LS4wMTU0LS4wMTg1LS4wMTk0LS4wMjg1Yy0uMDA4LS4wMTc0LS4wMjQ1LS4wMzMzLS4wMzQ1LS4wNDk3cy0uMDIzMi0uMDMzMi0uMDM0MS0uMDUwM2wtLjAyMjMtLjAzNTQtLjAxOTEtLjAzMTZhLjA3MS4wNzEgMCAwIDEtLjAyMi0uMDM0OWMwLS4wMDI4LS4wMDktLjAwNTUtLjAxLS4wMDg1LS4wMDM3LS4wMTM5LS4wMjE3LS4wMjM3LS4wMjQtLjAzOHMtLjAyNTktLjAyMjktLjAyMy0uMDM4M2MwIDAgMC0uMDAxNy0uMDAyOS0uMDAyOC0uMDEyMS0uMDEyOC0uMDIyMS0uMDI2Mi0uMDMwMS0uMDQwM3MtLjAyMi0uMDI0LS4wMjU1LS4wMzc1Yy0uMDE0NS0uMDA2LS4wMDY0LS4wMTc3LS4wMTY1LS4wMjYxcy0uMDE0Ni0uMDEzMy0uMDE1OS0uMDIxNS0uMDEzLS4wMTU4LS4wMTYtLjAyNjItLjAxNzMtLjAxMzQtLjAxOC0uMDIxYzAtLjAxNjQtLjAyMTEtLjAyOTMtLjAyOC0uMDQ0MyAwLS4wMDM0LS4wMDg3LS4wMDY3LS4wMDc2LS4wMDkuMDA0Mi0uMDA5Ny0uMDEzLS4wMTQxLS4wMTE4LS4wMjI2IDAgMCAwLS4wMDIxLjAwMjMtLjAwMy4wNDkzLS4wMDMuMjkwNC0uMDA0NC4zOTY0IDAgMCAuMDA5LjAxNDYuMDE0OC4wMTY2LjAyNTlhLjEuMSAwIDAgMCAuMDE5NS4wMjgxYy4wMDU5LjAwNzYuMDE4OC4wMTU1LjAxNDUuMDI2MWEuMTYuMTYgMCAwIDEgLjAzNjMuMDUyYy4wMTg3LjAxNDcuMDE5Ny4wMzQ0LjAzNDcuMDUwMnMuMDE4NS4wMjQ1LjAyNTcuMDM3My4wMjM2LjAyMjEuMDI2My4wMzMzLjAxNy4wMzA2LjAyNzcuMDQ0OGMuMDA1My4wMTQ0LjAyMzMuMDI2My4wMjg3LjA0MDhzLjAxNzQuMDMuMDI5NC4wNDM1LjAxMjYuMDMxOC4wMzE5LjA0NDZjMCAuMDE4MS4wMjI3LjAzMTEuMDMuMDQ3MnMuMDE3My4wMjk5LjAyOTQuMDQzOC4wMDk5LjAyNjEuMDIyOS4wMzQ4LjAxMi4wMjM2LjAyMTcuMDM0OS4wMjA3LjAyNDIuMDI1Ni4wMzc0LjAyNDQuMDI0LjAyODguMDM2OS4wMjEyLjAyODguMDI4My4wNDQxLjAyMTYuMDI2My4wMjg5LjA0MDkuMDI2LjAzMjkuMDM0LjA0OTljLjAxNDQuMDE2NS4wMjI3LjAzNDEuMDI5Ny4wNTIxLjAwMjMuMDA1My4wMDYzLjAxMDEuMDEyMy4wMTVhLjIyOC4yMjggMCAwIDEgLjAyODIuMDQwMWMuMDExNS4wMTIuMDIwMi4wMjQzLjAyNjUuMDM3OXMuMDI3Ny4wMjYuMDIzNy4wNDE5bC4wNDIuMDQ4NWguNDkzM2MuMDE0Ny4wMDYgMCAuMDE2OS4wMTUuMDIzMWEuMDQ4LjA0OCAwIDAgMSAuMDE1Ny4wMTguMDMxLjAzMSAwIDAgMSAuMDEwNy4wMTg5YzAgLjAwOTQuMDE2Ny4wMTMyLjAxNC4wMjI1LjAwODYuMDA0OS4wMTI2LjAxMjEuMDEwOS4wMTkzIDAgLjAwMTcuMDA0NS4wMDMyLjAwNTcuMDA2LjAwNjguMDE0MS4wMjMuMDI2MS4wMjkuMDRzLjAyMzMuMDI2Mi4wMjk1LjA0MDcuMDIyMi4wMjgyLjAyNzguMDQ0MS4wMjYuMDI4NS4wMzE3LjA0NDFhLjE1OS4xNTkgMCAwIDAgLjAyNjMuMDQxMS4xNTQuMTU0IDAgMCAwIC4wMjguMDQwNGMuMDEuMDA3NyAwIC4wMTguMDE1OC4wMjYzcy4wMTA0LjAxNy4wMTkuMDI0MiAwIC4wMTk0LjAxNi4wMjYxYzAgLjAwOTcuMDE3Ni4wMTU1LjAxMy4wMjU4bC4wMzQyLjA0MTJ2LjAxODhjLS4wMDM2LjAwMTctLjAwNjkuMDAzOS0uMDEuMDAzOUgyLjE5MzNjLS4wMDQ0LjAwMTItLjAwNzQuMDAzNi0uMDA4OS4wMDY2cy0uMDAwNS4wMDYuMDAxOC4wMDg2Yy4wMTI0LjAxMDUuMDEwNy4wMjQxLjAyMjQuMDM0NWwuMDIzNi4wMzgyYS4xMjUuMTI1IDAgMCAxIC4wMjQuMDM0NS4zNjMuMzYzIDAgMCAwIC4wMjg3LjAzNjljLjAwNjQuMDExOS4wMTUuMDIyOC4wMjI0LjAzNTVhLjIzNy4yMzcgMCAwIDAgLjAxOTMuMDMxNC4wNzkuMDc5IDAgMCAxIC4wMjIxLjAzNWMwIC4wMDMxLjAwODYuMDA1Ni4wMDk1LjAwODguMDAzNy4wMTM0LjAyMTcuMDIzMS4wMjQ0LjAzOHMuMDI1My4wMjI2LjAyMjMuMDM4MmMwIDAgMCAuMDAyLjAwMy4wMDI5YS4xNjkuMTY5IDAgMCAxIC4wMy4wNGMuMDA0Ny4wMTQxLjAyMjMuMDIzOS4wMjU0LjAzNzYuMDE1My4wMDYuMDA2Ni4wMTc4LjAxNjYuMDI2M3MuMDE0My4wMTMxLjAxNi4wMjEuMDEzMS4wMTYyLjAxNi4wMjYuMDE3LjAxMzcuMDE4LjAyMWMuMDA0My4wMTQ0LjAxMy4wMjg3LjAyNTUuMDQxMi4wMDU5LjAxMi4wMTM1LjAyMzUuMDIyNS4wMzUxcy4wMTI1LjAyMzIuMDIyMy4wMzUzLjAyMDQuMDI0NC4wMjQ4LjAzNzYuMDI1Mi4wMjM5LjAyOTYuMDM2Mi4wMjA3LjAyOTMuMDI3Ni4wNDQ4LjAyMjcuMDI2MS4wMjkxLjA0MDQuMDE3MS4wMy4wMjkzLjA0MzYuMDEyNC4wMzE4LjAzMTMuMDQ0NWEuMTY0LjE2NCAwIDAgMCAuMDMwNS4wNDc2Yy4wMDg5LjAxNTkuMDIwOS4wMzEuMDMxNS4wNDY3LjAxNS4wMDYuMDA2My4wMTcyLjAxNTQuMDI2MnMuMDE2Ni4wMTguMDE4LjAyODQuMDE3My4wMTU2LjAyLjAyMzYuMDE5Ni4wMTU0LjAxMzYuMDI2YzAgLjAwMTQuMDA0NC4wMDM4LjAwNTcuMDA2LjAxMDcuMDEzNC4wMjAzLjAyNjYuMDI4OC4wNDA0cy4wMjE1LjAyNTkuMDI1My4wNDE0LjAxMjIuMDIxNi4wMjQyLjAzMDFjLjAwNjQuMDA3Mi4wMDkuMDE1NS4wMDc1LjAyMzl6IiBmaWxsPSIjZjBkMjAyIi8+PHBhdGggZD0iTS40Mjc0LjAwNTRsLjAxNC4wMDVjLjAxNjguMDA2NS4wMjA0LjAxOS4wMzMyLjAyNzZTLjUwNS4wNTIzLjUwOTkuMDY0MmMwIC4wMDQuMDA5MS4wMDcyLjAxNDcuMDEwMi4wMTU5LjAxMDYuMDI4Ny4wMjEuMDQxOS4wMzNzLjAzMTcuMDE3LjAzNzcuMDNjMCAuMDAyMy4wMDUyLjAwMzUuMDA3Ni4wMDU3Qy42MzA2LjE1NDMuNjQ3OS4xNjcuNjYyNS4xODFTLjcwMS4yMDMuNzExLjIxODlhLjg0Mi44NDIgMCAwIDEgLjA2OTMuMDUyMkMuNzkyNi4yNzk3LjgwNC4yODkuODE0LjI5ODNzLjAyNy4wMTI5LjAzLjAyNjJjMCAuMDAzMi4wMDc0LjAwNTEuMDExNC4wMDc3QS4yNzkuMjc5IDAgMCAxIC45MDYuMzY5N2MuMDEyLjAxMjYuMDM2My4wMTk5LjA0NDYuMDM1OEEuNzIyLjcyMiAwIDAgMSAxLjAyLjQ1NzFsLjAzNDMuMDI3NmMuMDExMS4wMDg3LjAyODMuMDE1NS4wMzMxLjAyNzQgMCAuMDAyMi4wMDUyLjAwMzMuMDA3Ni4wMDU0LjAxOTMuMDExNS4wMzY0LjAyMzkuMDUxMy4wMzhzLjAzODMuMDIxOS4wNDguMDM3OWMuMDI5NS4wMTQzLjA0Mi4wMzU3LjA2OTUuMDUyNC4wMTI0LjAwODEuMDIzNi4wMTc3LjAzNDIuMDI3MnMuMDI2Ni4wMTMuMDMuMDI1NGMwIC4wMDMyLjAwNy4wMDU4LjAxMS4wMDg2LjAxOTMuMDExMS4wMzYuMDIzNy4wNTEuMDM3NXMuMDM2Ni4wMTk5LjA0NDMuMDM2Yy4wMjQ3LjAxNjIuMDQ4LjAzMzcuMDY5MS4wNTE3LjAxMjYuMDA4OC4wMjMyLjAxOC4wMzQuMDI3MnMuMDI5Mi4wMTUzLjAzNC4wMjc3YzAgLjAwMjEuMDA0OS4wMDMzLjAwNzYuMDA1NGEuMzAyLjMwMiAwIDAgMSAuMDUxLjAzOGMuMDEyMi4wMTM3LjAzODMuMDIxOS4wNDgzLjAzNzkuMDI0Ny4wMTY2LjA0NzcuMDM0MS4wNjkzLjA1MjIuMDEyNC4wMDc4LjAyMzQuMDE2Ny4wMzQuMDI1OHMuMDI3LjAxMzMuMDMuMDI2MmMwIC4wMDI4LjAwNzUuMDA1NC4wMTE1LjAwNzkuMDE4OS4wMTA5LjAzNTUuMDI0LjA1MDUuMDM3NnMuMDM2Ny4wMjAzLjA0NC4wMzU5Yy4wMjUuMDE2NS4wNDg0LjAzMzUuMDY5NS4wNTE0bC4wMzM1LjAyMjZjLjAxMTcuMDA5LjAyOTQuMDE1LjAzNC4wMjcyIDAgLjAwMjMuMDA1LjAwMzMuMDA3Ny4wMDUzYS4yOTcuMjk3IDAgMCAxIC4wNTAzLjAzNzZjLjAxMy4wMTQxLjAzOS4wMjI4LjA0OS4wMzg1bC4wNjg2LjA1MThjLjAxMjQuMDA4Ny4wMjQuMDE3OC4wMzQuMDI3cy4wMjc0LjAxMzYuMDMwMy4wMjY0YzAgLjAwMzMuMDA3Ny4wMDU0LjAxMTcuMDA4My4wMTg0LjAxMTUuMDM1MS4wMjQuMDQ5MS4wMzc1cy4wMzcyLjAyMDYuMDQ0OS4wMzU5YS44ODkuODg5IDAgMCAxIC4wNjk4LjA1MjVjLjAxNTYuMDA5NS4wMjc1LjAyMTUuMDQxNS4wMzI2cy4wMzIuMDE2Ni4wMzc1LjAzMDRjLjAyMzIuMDE1MS4wNDUyLjAzMTIuMDY1Ni4wNDhzLjAzOS4wMzQyLjA2NS4wNDg5Yy4wMDguMDA2My4wMTQuMDE0MS4wMTc5LjAyMTYtLjAwNS4wMDIxLS4wMDk5LjAwMy0uMDE1OS4wMDQ2SC41NTAyYy0uMDIyNC0uMDEwMi0uMDM3Ni0uMDI1My0uMDQxNy0uMDQxOWEuMDY5LjA2OSAwIDAgMC0uMDE5MS0uMDI0MmMtLjAwNjUtLjAwNzYgMC0uMDE3NS0uMDEyOC0uMDIyOC0uMDAzMy0uMDEzNi0uMDIyLS4wMjM1LS4wMjU2LS4wMzczcy0uMDItLjAyNjQtLjAyNDctLjA0MTctLjAyNDktLjAyMzYtLjAyOTctLjAzNjMtLjAxNjctLjAzLS4wMjg3LS4wNDQ0Qy4zNjExIDEuNDk5Mi4zNTE4IDEuNDg1OS4zMzkgMS40NzI4YS4wNjcuMDY3IDAgMCAwLS4wMTg3LS4wMzE4Yy0uMDA4OS0uMDEwOS0uMDE2NC0uMDIyNy0uMDIyNC0uMDM0NlMuMjg0NiAxLjM4NTIuMjczIDEuMzc2Mi4yNjg2IDEuMzU4LjI2MyAxLjM1MWEuMDUzLjA1MyAwIDAgMS0uMDE4OC0uMDI1OC4wNjMuMDYzIDAgMCAwLS4wMTM2LS4wMjIyYy0uMDA2MS0uMDA3My0uMDE2My0uMDEzOC0uMDE4My0uMDIxYS4wODYuMDg2IDAgMCAwLS4wMjI5LS4wMzQ5Yy0uMDAxNS0uMDAzNi0uMDAxNS0uMDA2OSAwLS4wMTAxcy4wMDI1LS4wMDU4LjAwNDktLjAwODJoMS4wNDgzYzAtLjAwNDkuMDAzNC0uMDA5MyAwLS4wMTEzLS4wMTcyLS4wMTA1LS4wMTcyLS4wMjc3LS4wMy0uMDQycy0uMDIzMi0uMDI1OC0uMDI1Mi0uMDQwN2MwLS4wMDQ0LS4wMDgtLjAwOC0uMDEwNC0uMDExOC0uMDA5LS4wMTI1LS4wMjYtLjAyMzItLjAyMzYtLjAzODQtLjAxMzQtLjAwODgtLjAyMTQtLjAyMTYtLjAyMzEtLjAzNTQgMC0uMDAxNy0uMDA0My0uMDA0LS4wMDU3LS4wMDYtLjAwNzYtLjAxNDUtLjAyMjYtLjAyNTctLjAyOTYtLjA0MDJTMS4wNzM0Ljk3NjcgMS4wNjYuOTYyNEEuMjI4LjIyOCAwIDAgMCAxLjA0MzMuOTI4TDEuMDI0Ni44OTYyYS4wNzIuMDcyIDAgMCAxLS4wMjIzLS4wMzQ3YzAtLjAwNDQtLjAwNy0uMDA4My0uMDEtLjAxMTlBLjI1NC4yNTQgMCAwIDEgLjk3MS44MjQ3Qy45NjY5LjgxNzQuOTY0Ni44MDk3Ljk1OS44MDI0Uy45Mzg5Ljc4NzQuOTQ2Ljc3NjJDLjk0Ni43NzUuOTQwNi43NzMxLjkzOTQuNzcwNC45MzI2Ljc1NjUuOTE2Ni43NDQ4LjkxMDUuNzMwM1MuODg2Ni43MDQyLjg4MS42ODk2Ljg1ODYuNjYxNC44NTM0LjY0NTguODI3NC42MTcxLjgyMTQuNjAyMi44MDYzLjU3NDQuNzk1LjU2MTcuNzg2LjUzNTQuNzcyNi41MjY3Ljc2MDYuNTAzMS43NTAzLjQ5MTZBLjA5NS4wOTUgMCAwIDEgLjcyNTQuNDU0MUMuNzIyNi40NDE1LjcwMDYuNDMwNS42OTYzLjQxNzdTLjY3NTQuMzg4My42NjgyLjM3MzIuNjQ3My4zNDcxLjYzOTMuMzMyNEMuNjMzOC4zMjMxLjYyOTQuMzEzMS42MjI1LjMwNEEuMTYuMTYgMCAwIDEgLjU5OTQuMjcyOUMuNTk1My4yNjMyLjU4MjYuMjU0NS41Nzk4LjI0NTJBLjMxLjMxIDAgMCAwIC41NDg2LjE5NzdDLjUzOTguMTgxOS41Mjc4LjE2NjMuNTE3My4xNTEuNTAyMi4xNDUuNTExLjEzMzMuNTAxOS4xMjVTLjQ4NDkuMTA2OC40ODM5LjA5NjUuNDY2Ni4wODA5LjQ2MzguMDcyNy40NDcuMDU3NS40NDk0LjA0NjMuNDQzNC4wMzI1LjQzNS4wMjgxLjQyODMuMDEzLjQyNzQuMDA0N3oiIGZpbGw9IiNmMGQyMDMiLz48cGF0aCBkPSJNMy43Nzk0IDMuMTkzOGwtLjAxMTUuMDEwNHYuMDMxNmMtLjAxNi4wMDg3LS4wMS4wMjI0LS4wMjE0LjAzMjJzLS4wMTI3LjAyMTctLjAyODkuMDI5NWwtLjAwNDguMDAxNEgyLjE2MzljLS4wMjA3LS4wMDQyLS4wMTk0LS4wMTg3LS4wMzE4LS4wMjcxIDAtLjAxNTMtLjAxNjktLjAyNTctLjAyMzktLjAzODdzLS4wMTMtLjAyMzktLjAyMzItLjAzNDVjLS4wMTg5LS4wMjAxLS4wMjM0LS4wNDQxLS4wNDUyLS4wNjI5IDAtLjAyMzItLjAzNTktLjAzODUtLjAzNTktLjA2MTYtLjAxNDctLjAxNjUtLjAyODEtLjAzNDEtLjAzOS0uMDUxOWwtLjAyNzMtLjA0MTdjLS4wMTA3LS4wMTItLjAxOTgtLjAyNDgtLjAyNjQtLjAzODRhLjIuMiAwIDAgMC0uMDMxLS4wMzk5LjAzNC4wMzQgMCAwIDEtLjAwMjQtLjAxNTNjLjAyNDEtLjAwMjQuMDQ5MS0uMDAzLjA3MzgtLjAwMjFoMS43NTMybC4wMjg0LjAxNjdjLjAxLjAwNTUuMDEuMDEyMi4wMTcuMDE3N3MuMDA1NC4wMTU1LjAwOC4wMjM0LjAxMjkuMDExMi4wMTEuMDE5M2EuMDk5LjA5OSAwIDAgMCAwIC4wMjQzbC4wMTAyLjAxMDh6IiBmaWxsPSIjMDEwMTAxIi8+PHBhdGggZD0iTTIuMzU4NCAyLjI2ODFjLS4wMTItLjAxMDQtLjAyMTQtLjAyMTgtLjAyNzgtLjAzMzhhLjExMi4xMTIgMCAwIDAtLjAyNTYtLjAzODdjLS4wMS0uMDEwOS0uMDExOC0uMDI0LS4wMjItLjAzNDktLjAxNTctLjAxODYtLjAyNTctLjAzODQtLjAzOTQtLjA1N2wtLjAzNzEtLjA1MjNhLjI1Ni4yNTYgMCAwIDEtLjAyMzItLjAzNDdjLS4wMDY0LS4wMTItLjAxNDEtLjAyMzgtLjAyMjctLjAzNTRhLjI0Mi4yNDIgMCAwIDEtLjAyLS4wMzE3Yy0uMDA2MS0uMDEyLS4wMjE0LS4wMjIyLS4wMjY5LS4wMzQ0cy0uMDEzMS0uMDI1Ni0uMDIyOC0uMDM3Ni0uMDA1OS0uMDE1NSAwLS4wMjI0YzAgMCAuMDAzMy0uMDAyMy4wMDQ4LS4wMDIzaDEuNDgyNmMuMDE5My4wMDgzLjAzNS4wMTk4LjA0NDcuMDMzMmEuMDkuMDkgMCAwIDEgLjAxOTcuMDQ0MWMwIC4wMTQ1LjAxNi4wMjU5LjAxMi4wNDA0cy0uMDAxNy4wMjY3IDAgLjAzOTV2LjE2MzFjLS4wMDU0LjAxMDEtLjAxMTcuMDE2MS0uMDEwMy4wMjExLjAwNDMuMDE0OS0uMDE0OS4wMjY0LS4wMTI5LjA0MDMtLjAxMjguMDExNy0uMDE4Mi4wMjYzLS4wNDcyLjAzNDZ6IiBmaWxsPSIjMDIwMjAyIi8+PHBhdGggZD0iTTMuNTc1MyAzLjM5OTdsLjAyOC4wMDg2YS4xNjkuMTY5IDAgMCAxIC4wMjc3LjAzNzYuMTguMTggMCAwIDEgLjAxMjcuMDM0MWMuMDA0OC4wMTUuMDA4NC4wMjk2LjAxMDMuMDQ0NXYuMTg2YzAgLjAwOTgtLjAxNTYuMDE1OC0uMDExLjAyNTlzLS4wMDEyLjAxOTEtLjAxMTIuMDI2Yy4wMDE1LjAyMDctLjAxNDUuMDQtLjA0MTguMDUySDIuNTA3M2EuMjg5LjI4OSAwIDAgMS0uMDM3OC0uMDQ2N2MtLjAwOTEtLjAxNzctLjAyMTEtLjAzNDYtLjAzNi0uMDUwNSAwLS4wMTgyLS4wMjU3LS4wMzA3LS4wMjU3LS4wNDg3YS42NzEuNjcxIDAgMCAxLS4wNTE4LS4wNzIuMTYzLjE2MyAwIDAgMS0uMDI0Ny0uMDM4M2MtLjAwNTgtLjAxMjItLjAyMTYtLjAyMTItLjAyNC0uMDM0OHMtLjAxOTMtLjAyNDItLjAyNC0uMDM4OS0uMDE4LS4wMjUyLS4wMjgzLS4wMzcyYS4zMjUuMzI1IDAgMCAwLS4wMjQ2LS4wMzQ4Yy0uMDAyMy0uMDAzLS4wMDM0LS4wMDYtLjAwNDYtLjAwOTEuMDA0Ni0uMDAxMy4wMDgtLjAwMy4wMTE1LS4wMDN6IiBmaWxsPSIjMDEwMTAxIi8+PHBhdGggZD0iTTIuNzAzMSAyLjc4MzRjLS4wMDYxLS4wMTI5LS4wMTQ3LS4wMjU3LS4wMjU1LS4wMzg1cy0uMDE0NS0uMDI1Ny0uMDI1Mi0uMDM3Ny0uMDE0OS0uMDI2LS4wMjM4LS4wMzg2LS4wMTktLjAyNDYtLjAyNTUtLjAzODItLjAyNDQtLjAyNC0uMDI5NS0uMDM3LS4wMjA1LS4wMjYtLjAyNTctLjA0MTUtLjAyLS4wMjY1LS4wMjYzLS4wMzg1LS4wMTI5LS4wMjEyLS4wMjA1LS4wMzEzLS4wMTgtLjAyMjktLjAyMzYtLjAzNDktLjAxNjgtLjAyMDgtLjAyMTYtLjAzMTUtLjAxNDEtLjAyMTItLjAyMjktLjAzMTdjLS4wMDQzLS4wMDQtLjAwNDMtLjAwOTEgMC0uMDEzYS4wMzIuMDMyIDAgMCAxIC4wMTA2LS4wMDIzaDEuMjU1NWMuMDI1My4wMDk3LjA0NDQuMDI0My4wNTUuMDQxNi0uMDAzNy4wMTU3LjAxNDYuMDI5Mi4wMTI2LjA0NDdhLjA3NC4wNzQgMCAwIDAgLjAxMDQuMDI1NnYuMTk3NmwtLjAwOTMuMDA5MmEuMTcyLjE3MiAwIDAgMS0uMDA2Ny4wMzgzYy0uMDA3Mi4wMTU1LS4wMTcyLjAzMDQtLjAzMDEuMDQ0NGwtLjAxNzEuMDEzNXoiIGZpbGw9IiMwMjAyMDIiLz48cGF0aCBkPSJNMi45OTcgNS42NTQ3Yy4wMTM5LjAwNTUuMDEzOS4wMDU1IDAgLjAxNTN6IiBmaWxsPSIjZjBkMjAyIi8+PHBhdGggZD0iTS40Mjc4LjAwNTRMLjQxODMuMDAyNi40MjM1IDBsLjAwNDEuMDA2MnoiIGZpbGw9IiNmMGQyMDMiLz48L3N2Zz4='
		);

		add_submenu_page(
			'app-perf-check',
			'Filesystem',
			'Filesystem',
			'manage_options',
			'admin.php?page=fs_check',
			array( $this, 'fs_check' ),
		);

		add_submenu_page(
			'app-perf-check',
			'Database',
			'Database',
			'manage_options',
			'admin.php?page=db_check',
			array( $this, 'db_check' ),
			''
		);

		add_submenu_page(
			'app-perf-check',
			'WP Options Check',
			'WP Options Check',
			'manage_options',
			'admin.php?page=autoload_check',
			array( $this, 'autoloadcheck' ),
		);

		add_submenu_page(
			'app-perf-check',
			'Cron',
			'Cron',
			'manage_options',
			'admin.php?page=cron_check',
			array( $this, 'cron_check' ),
		);

		add_submenu_page(
			'app-perf-check',
			'Plugins',
			'Plugins',
			'manage_options',
			'admin.php?page=plugin_check',
			array( $this, 'appperf_pluginsummary' ),
		);

		add_submenu_page(
			'app-perf-check',
			'Users',
			'Users',
			'manage_options',
			'admin.php?page=users_check',
			array( $this, 'appperf_usersummary' ),
		);

		add_submenu_page(
			'app-perf-check',
			'Posts Table',
			'Posts Table',
			'manage_options',
			'admin.php?page=posts_check',
			array( $this, 'appperf_posts_summary' ),
		);

		add_submenu_page(
			'app-perf-check',
			'Terms Summary',
			'Terms',
			'manage_options',
			'admin.php?page=terms_check',
			array( $this, 'appperf_terms_summary' ),
		);

		if ( isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {
			add_submenu_page(
				'app-perf-check',
				'Pantheon Environment Variables Summary',
				'Env Variables',
				'manage_options',
				'admin.php?page=env_check',
				array( $this, 'panenvironments_html' ),
			);

			add_submenu_page(
				'app-perf-check',
				'Server Vars Summary',
				'Server Variables',
				'manage_options',
				'admin.php?page=server_check',
				array( $this, 'appperf_server_summary' ),
			);
		}

		if ( is_multisite() ) {
			add_submenu_page(
				'app-perf-check',
				'Multisite',
				'Multisite',
				'manage_options',
				'admin.php?page=multisite_check',
				array( $this, 'appperf_multisite_summary' ),
			);
		}
	}

	/**
	 * Add main menu items.
	 *
	 * @return void
	 */
	public function appperf_mainmenu() {
		global $title;
		global $wp_version;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print '<h2>Site Summary</h2>';

		$this->pan_site_summary();

		print '</div>';
	}

	/**
	 * Add user summary.
	 *
	 * @return void
	 */
	public function appperf_usersummary() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print '</div>';
	}

	/**
	 * Add Terms summary.
	 * wp_term_relationships.
	 * wp_term_taxonomy.
	 * wp_termmeta.
	 * wp_terms.
	 *
	 * @return void
	 */
	public function appperf_terms_summary() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print '</div>';
	}

	/**
	 * Add Posts summary.
	 * wp_postss
	 * wp_postmeta
	 *
	 * @return void
	 */
	public function appperf_posts_summary() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print '</div>';
	}

	/**
	 * Add Server variables summary.
	 *
	 * @return void
	 */
	public function appperf_server_summary() {
		$panenvironments = new SUO_Environments();
		$panenvironments->appperf_serverenv_summary();
	}

	/**
	 * Environments summary.
	 *
	 * @return html
	 */
	public function panenvironments_html() {
		$panenvironments = new SUO_Environments();
		return $panenvironments->appperf_env_summary();
	}

	/**
	 * Multisite summary.
	 *
	 * @return void
	 */
	public function appperf_multisite_summary() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print '</div>';
	}

	/**
	 * Plugin summary page.
	 *
	 * @return void
	 */
	public function appperf_pluginsummary() {
		global $title;
		global $wp_version;

		print '<div class="wrap">';
		print '<h1>Plugin Summary</h1>';

		print 'total Plugin count';

		print 'total Plugin drop-ins';

		print 'total Plugin Must-Use';

		print 'total Plugin Active2';

		$this->pan_plugin_summary();

		print '</div>';
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
	 * Gets Summary data.
	 */
	public function pan_site_summary() {
		$site_summary_list = $this->site_summary();
		$html_table        = sprintf(
			'<table id="pluginlist" class="widefat striped"><thead><tr><th scope="col">%s</th><th scope="col">%s</th></tr></thead><tbody>',
			__( 'Name', 'speed-up-optimize' ),
			__( 'Value', 'speed-up-optimize' )
		);

		foreach ( $site_summary_list as $key => $value ) {
			$html_table .= sprintf( '<tr><td>%s</td><td>%s</td></tr>', $key, $value['value'] );
		}
		$html_table .= '</tbody></table>';

		echo wp_kses( $html_table, $this->sanitize_thishtml() );

	}

	/**
	 * Get site summary values and store in array
	 *
	 * @return array
	 */
	public function site_summary() {
		global $wp_version;

		$return = array(
			'WP version from wp-includes/version.php / global variable $wp_version' =>
				array(
					'value' => $wp_version,
				),
			'WP version from wp_options > _site_transient_update_core' =>
				array(
					'value' => '',
				),
			'WP db version from wp-includes/version.php' =>
				array(
					'value' => '',
				),
			'WP db version from wp_options > _site_transient_update_core' =>
				array(
					'value' => '',
				),
			'DEFINE WP_DEBUG_LOG'                        =>
				array(
					'value' => '',
				),
			'DEFINE WP_HOME'                             =>
				array(
					'value' => '',
				),
			'DEFINE WP_SITEURL'                          =>
				array(
					'value' => '',
				),
			'DB wp_options > home'                       =>
				array(
					'value' => '',
				),
			'DB wp_options > siteurl'                    =>
				array(
					'value' => '',
				),
			'Multisite'                                  =>
				array(
					'value' => '',
				),
			'Total plugins'                              =>
				array(
					'value' => '',
				),
			'Total Active plugins'                       =>
				array(
					'value' => '',
				),
			'Total Must-Use plugins'                     =>
				array(
					'value' => '',
				),
			'Total Drop-in plugins'                      =>
				array(
					'value' => '',
				),
			'Pantheon Environment'                       =>
				array(
					'value' => '',
				),
			'Pantheon IP'                                =>
				array(
					'value' => '',
				),
			'Pantheon UUID'                              =>
				array(
					'value' => '',
				),
			'PHP Version'                                =>
				array(
					'value' => '',
				),
			'Cron event count'                           =>
				array(
					'value' => '',
				),
			'User count'                                 =>
				array(
					'value' => '',
				),
			'Uncompressed DB size'                       =>
				array(
					'value' => '',
				),
		);

		$result = $return;
		return $result;
	}

	/**
	 * Get Plugin Summary data.
	 */
	public function pan_plugin_summary() {
		$plugin_summary_list = $this->plugin_summary();
		$html_table          = sprintf(
			'<table class="widefat striped"><thead><tr><th scope="col">%s</th><th scope="col">%s</th><th scope="col">%s</th></tr></thead><tbody>',
			__( 'Plugin Name', 'speed-up-optimize' ),
			__( 'Status', 'speed-up-optimize' ),
			__( 'Guide', 'speed-up-optimize' )
		);

		foreach ( $plugin_summary_list as $key => $value ) {
			$html_table .= sprintf( '<tr><td>%s</td><td></td><td><a href="%s" target="_blank">%s</a></td></tr>', $value['name'], $value['guide'], $value['guide'] );
		}
		$html_table .= '</tbody></table>';

		echo wp_kses( $html_table, $this->sanitize_thishtml() );

	}

	/**
	 * Get site summary values and store in array
	 *
	 * @return array
	 */
	public function plugin_summary() {

		$return = array(
			'wordfence'     =>
				array(
					'name'  => 'Wordfence',
					'guide' => 'https://pantheon.io/docs/plugins-known-issues#wordfence',
				),
			'wordpress-seo' =>
				array(
					'name'  => 'Yoast',
					'guide' => 'https://pantheon.io/docs/plugins-known-issues#yoast-seo',
				),
		);
		return $return;
	}

	/**
	 * Gets formatted plugin list with known issues.
	 */
	public function peflab_aao_plugin_list_known_issues_table() {
		$plugin_list = $this->perflab_aao_plugin_list_known_issues();
		$html_table  = sprintf(
			'<table class="widefat striped"><thead><tr><th scope="col">%s</th><th scope="col">%s</th><th scope="col">%s</th></tr></thead><tbody>',
			__( 'Plugin Name', 'speed-up-optimize' ),
			__( 'Status', 'speed-up-optimize' ),
			__( 'Guide', 'speed-up-optimize' )
		);

		foreach ( $plugin_list as $key => $value ) {
			$html_table .= sprintf( '<tr><td>%s</td><td></td><td><a href="%s" target="_blank">%s</a></td></tr>', $value['name'], $value['guide'], $value['guide'] );
		}
		$html_table .= '</tbody></table>';

		echo wp_kses( $html_table, $this->sanitize_thishtml() );

	}

	/**
	 * Display autoloaded items.
	 *
	 * @return void
	 */
	public function autoloadcheck() {
		global $title;
		global $wpdb;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print '<p>WP Options Total Item count:</p>';
		print '<p>WP Options Total size:</p>';

		print '<p>Index enabled:</p>';

		print '<p>WP Options Autoloaded Item count:</p>';
		print '<p>WP Options Autoloaded size: ' . esc_html( array( $this, 'perflab_aao_autoloaded_options_size' ) ) . ' bytes </p>';

		print '<p>Your top 50 autoload:</p>';

		echo esc_html( $this->perflab_aao_get_autoloaded_options_table() );

		print '<p>Your top 50 largest wp_options entries autoload:</p>';

		print '</div>';

		print '<p>Your top 50 largest wp_options entries autoload:</p>';
	}

	/**
	 * Display database items.
	 *
	 * @return void
	 */
	public function db_check() {
		global $title;
		global $wpdb;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print '<p>DB size:</p>';
		print '<p>WP Options Total size:</p>';

		print '<p>Index enabled:</p>';

		print '<p>WP Options Autoloaded Item count:</p>';
		print '<p>WP Options Autoloaded size: ' . esc_html( array( $this, 'perflab_aao_autoloaded_options_size' ) ) . ' bytes </p>';

		print '<p>Your top 50 autoload:</p>';

		print '<p>Your top 50 largest wp_options entries autoload:</p>';

		print '</div>';

		print '<p>Your top 50 largest wp_options entries autoload:</p>';
	}

	/**
	 * Show DB performance check.
	 *
	 * @return void
	 */
	public function fs_check() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print "<p class='description'>Add code for Filesystems here</p>";
		print "<p class='description'>themes, file size</p>";

		print '</div>';
	}

	/**
	 * Show CRON check.
	 *
	 * @return void
	 */
	public function cron_check() {
		global $title;

		print '<div class="wrap">';
		print '<h1>' . esc_html( $title ) . '</h1>';

		print "<p class='description'>Add code for Filesystems here</p>";

		print '</div>';
	}

	/**
	 * Display autoloaded options.
	 *
	 * @return string
	 */
	public function perflab_aao_query_autoloaded_options() {
		global $wpdb;

		/**
		 * Filters the threshold for an autoloaded option to be considered large.
		 *
		 * The Site Health report will show users a notice if any of their autoloaded
		 * options exceed the threshold for being considered large. This filters the value
		 * for what is considered a large option.
		 *
		 * @since 1.5.0
		 *
		 * @param int $option_threshold Threshold for an option's value to be considered
		 *                              large, in bytes. Default 100.
		 */
		$option_threshold = apply_filters( 'perflab_aao_autoloaded_options_table_threshold', 100 );

		return $wpdb->get_results( $wpdb->prepare( "SELECT option_name, LENGTH(option_value) AS option_value_length FROM {$wpdb->options} WHERE autoload='yes' AND LENGTH(option_value) > %d ORDER BY option_value_length DESC LIMIT 20", $option_threshold ) ); // @codingStandardsIgnoreLine
	}

	/**
	 * Gets formatted autoload options table.
	 *
	 * @since 1.5.0
	 */
	public function perflab_aao_get_autoloaded_options_table() {
		$autoload_summary = $this->perflab_aao_query_autoloaded_options();

		$html_table = sprintf(
			'<table class="widefat striped"><thead><tr><th scope="col">%s</th><th scope="col">%s</th></tr></thead><tbody>',
			__( 'Option Name', 'performance-lab' ),
			__( 'Size', 'performance-lab' )
		);

		foreach ( $autoload_summary as $value ) {
			$html_table .= sprintf( '<tr><td>%s</td><td>%s</td></tr>', $value->option_name, size_format( $value->option_value_length, 2 ) );
		}
		$html_table .= '</tbody></table>';

		echo wp_kses( $html_table, $this->sanitize_thishtml() );

	}

	/**
	 * Display autoloaded options size.
	 *
	 * @return array
	 */
	public function perflab_aao_autoloaded_options_size() {
		global $wpdb;
		$return = (int) $wpdb->get_var( 'SELECT SUM(LENGTH(option_value)) FROM ' . $wpdb->prefix . 'options WHERE autoload = \'yes\'' ); // @codingStandardsIgnoreLine

		return $return;

	}

	/**
	 * Plugin list with known issues on Pantheon
	 */
	public function perflab_aao_plugin_list_known_issues() {
		global $wpdb;
		// list of known problematic plugins.
		$plugin_slug = array(
			'wordfence'     =>
				array(
					'name'  => 'Wordfence',
					'guide' => 'https://pantheon.io/docs/plugins-known-issues#wordfence',
				),
			'wordpress-seo' =>
				array(
					'name'  => 'Yoast',
					'guide' => 'https://pantheon.io/docs/plugins-known-issues#yoast-seo',
				),
		);
		// list of known problematic themes.
		$theme_slug        = array( 'divi' );
		$installed_plugins = get_plugins();
		return $plugin_slug;
	}

}

















