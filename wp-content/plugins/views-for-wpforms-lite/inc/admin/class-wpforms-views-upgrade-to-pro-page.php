<?php
class WPForms_Views_Upgrade_to_Pro_Page {

	function __construct(){
		add_action('admin_menu', array( $this,'add_page') );
		if( isset($_GET['page']) && ($_GET['page'] == 'wpforms-views-get-pro' )){
			add_filter('wpforms_admin_header', '__return_false');
			add_filter('wpforms_admin_flyoutmenu', '__return_false');
		}

	}

	function add_page(){
		add_submenu_page(
			'edit.php?post_type=wpforms-views',
			__( 'Get Pro', 'textdomain' ),
			__( '<strong style="color: #FCB214;">Get Pro</strong>', 'textdomain' ),
			'manage_options',
			'wpforms-views-get-pro',
			array( $this, 'upgrade_to_pro_page')
		);
	}

	function upgrade_to_pro_page(){
		?>
		<style>
			#wpforms-views-upgrade-section{
				margin: 32px;
				font-size: 1rem;
			}
			#wpforms-views-upgrade-section h2{
				font-size: 1.88em;
				line-height: 2.5rem;
				margin-bottom: 1.2rem;
			}
			.wpforms-views-heading-highlight {
				color: #cd631d;
				font-weight: 600;
			}
			.wpforms-views-pro-benefits li {
				list-style: none!important;
				position: relative;
				padding-left: 1.2533333333rem;
				height: 30px;
			}
			.wpforms-views-pro-benefits span{
				line-height: 30px;
			}
			.wpforms-views-pro-benefits .dashicons-yes{
				color:green;
				font-size:32px;
			}
			.wpforms-views-pro-benefits__title {
				font-weight: 600;
				padding-left: 10px;
			}
			.wpforms-views-pro-benefits__description:before {
				content: "– ";
			}
			.wpforms-views-upsell{
				display: inline-flex;
				align-items: center;
				justify-content: center;
				box-sizing: border-box;
				min-height: 48px;
				padding: 8px 1em;
				font-size: 16px;
				line-height: 1.5;
				font-family: Arial,sans-serif;
				color: #ffffff;
				border-radius: 4px;
				box-shadow: inset 0 -4px 0 rgba(0,0,0,.2);
				filter: drop-shadow(0 2px 4px rgba(0,0,0,.2));
				text-decoration: none;
				background-color: #FF9800 ;
			}
		</style>

		<div id="wpforms-views-upgrade-section">
			<h2><span class="wpforms-views-heading-highlight">Views for WPForms Pro</span>, take your Views to next level!</h2>
			<ul class="wpforms-views-pro-benefits ">
					<li class="wpforms-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="wpforms-views-pro-benefits__title">Edit Entries</span>
						<span class="wpforms-views-pro-benefits__description">allow users to edit wpforms entries from site frontend.</span>
					</li>
					<li class="wpforms-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="wpforms-views-pro-benefits__title">Filter & Sorting</span>
						<span class="wpforms-views-pro-benefits__description">filter & sort view by form field values.</span>
					</li>
					<li class="wpforms-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="wpforms-views-pro-benefits__title">List & DataTable View</span>
						<span class="wpforms-views-pro-benefits__description">display entries in List View or DataTable View.</span>
					</li>
					<li class="wpforms-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="wpforms-views-pro-benefits__title">Single Entry View</span>
						<span class="wpforms-views-pro-benefits__description">display Entry details on single page.</span>
					</li>
					<li class="wpforms-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="wpforms-views-pro-benefits__title">Search</span>
						<span class="wpforms-views-pro-benefits__description">allow users to search data in view.</span>
					</li>
					<li class="wpforms-views-pro-benefits__item">
						<span class="dashicons dashicons-yes"></span>
						<span class="wpforms-views-pro-benefits__title">Premium Support</span>
						<span class="wpforms-views-pro-benefits__description">access to premium support.</span>
					</li>
				</ul>
				<a class="wpforms-views-upsell" href="https://formviewswp.com/pricing/?utm_source=wordpress-plugin-dashboard&utm_medium=wpforms-views-upgrade-page&utm_campaign=wpforms-views-lite-version"> Buy Views for WPForms Pro</a>
		</div>

		<?php
	}


}
new WPForms_Views_Upgrade_to_Pro_Page();