<?php 
namespace AstraToolbox\Inc\Templates;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\Templates\Partials\AstraCustomizerConfigurationsPartial;
use AstraToolbox\Inc\Templates\Partials\IconPartials;

class PartialsManager extends AbstractSingleton
{
    /** @var string[] */
    private  array $shortcodesNames = [];

    public  function init()
    {
      IconPartials::getInstance()->register();
      AstraCustomizerConfigurationsPartial::getInstance()->register();
    }

}




// /**
//  * Redirect after logged in
//  */
// add_filter( 'woocommerce_login_redirect', function ( $redirect, $user ) {
//     // przekieruj zawsze na stronę główną
//     return home_url('/');
// }, 10, 2 );





// /**
//  * Breadcrumbs customization
//  */
// add_filter('woocommerce_breadcrumb_defaults', function($defaults) {
//     $defaults['home'] = 'SKF';
//     return $defaults;
// });


// /**
//  * Minicart empty message
//  */
// add_action('astra_mini_cart_empty_msg', function() {
//     return __('Twój koszyk jest pusty, zobacz jakie nagrody możesz zdobyć.', 'astra');
// });


// /**
//  * 	My account links
//  * */
// add_filter( 'woocommerce_account_menu_items', 'remove_my_account_tabs' );
// function remove_my_account_tabs( $items ) {
//     if ( isset( $items['dashboard'] ) ) {
//         unset( $items['dashboard'] ); // usuwa "Kokpit"
//     }
//     if ( isset( $items['downloads'] ) ) {
//         unset( $items['downloads'] ); // usuwa "Pobrania"
//     }
//     if ( isset( $items['customer-logout'] ) ) {
//         unset( $items['customer-logout'] ); // usuwa "Wyloguj się"
//     }
	
// 	if ( isset( $items['edit-address'] ) ) {
//         unset( $items['edit-address'] ); // usuwa "Wyloguj się"
//     }
	
// 	if ( isset( $items['orders'] ) ) {
//         unset( $items['orders'] ); // usuwa "Wyloguj się"
//     }
	
// 	if ( isset( $items['ulubione-nagrody'] ) ) {
//         unset( $items['ulubione-nagrody'] ); // usuwa "Wyloguj się"
//     }
	
	
//     return $items;
// }



// function addMojeLageryToMenu(){
// 	// 1️⃣ Rejestracja endpointu// 1️⃣ Rejestracja endpointu
// 	add_action( 'init', function() {
// 		add_rewrite_endpoint( 'ranking_user', EP_PAGES | EP_ROOT );
// 	});

// 	// 2️⃣ Dodanie endpointu do query vars
// 	add_filter( 'query_vars', function( $vars ) {
// 		$vars[] = 'ranking_user';
// 		return $vars;
// 	});

// 	// 3️⃣ Dodanie zakładki "Ranking punkty" do menu Moje konto (przed Wyloguj się)
// 	add_filter( 'woocommerce_account_menu_items', function( $items ) {
// 		$new_item = array( 'ranking_user' => __( 'Ranking użytkowników', 'woocommerce' ) );

// 		// Szukamy pozycji klucza "Wyloguj się" (customer-logout)
// 		$logout_index = array_search( 'customer-logout', array_keys( $items ) );

// 		if ( $logout_index !== false ) {
// 			$items_before = array_slice( $items, 0, $logout_index, true );
// 			$items_after  = array_slice( $items, $logout_index, null, true );
// 			$items = $items_before + $new_item + $items_after;
// 		} else {
// 			$items += $new_item;
// 		}

// 		return $items;
// 	}, 99 );

// 	// 4️⃣ Wyświetlenie zawartości zakładki (Elementor Saved Template ID 2102)
// 	add_action( 'woocommerce_account_ranking_user_endpoint', function() {
// 		echo do_shortcode('[elementor-template id="2102"]'); // ID Twojego szablonu Elementor
// 	});

// 	// 5️⃣ Odśwież rewrite rules po aktywacji motywu/wtyczki
// 	add_action( 'after_switch_theme', function() {
// 		flush_rewrite_rules();
// 	});
// }
// // addMojeLageryToMenu();


// function saldoIHistoriaLagerowPage()
// {

// 	// 1️⃣ Rejestracja endpointu
// 	add_action( 'init', function() {
// 		add_rewrite_endpoint( 'my_points', EP_PAGES | EP_ROOT );
// 	});

// 	// 2️⃣ Dodanie endpointu do query vars
// 	add_filter( 'query_vars', function( $vars ) {
// 		$vars[] = 'my_points';
// 		return $vars;
// 	});

// 	// 3️⃣ Dodanie zakładki "Saldo i historia lagerów" do menu Moje konto (przed Wyloguj się)
// 	add_filter( 'woocommerce_account_menu_items', function( $items ) {
// 		$new_item = array( 'my_points' => __( 'Saldo i historia lagerów', 'woocommerce' ) );

// 		// Szukamy pozycji klucza "Wyloguj się" (customer-logout)
// 		$logout_index = array_search( 'customer-logout', array_keys( $items ) );

// 		if ( $logout_index !== false ) {
// 			$items_before = array_slice( $items, 0, $logout_index, true );
// 			$items_after  = array_slice( $items, $logout_index, null, true );
// 			$items = $items_before + $new_item + $items_after;
// 		} else {
// 			$items += $new_item;
// 		}

// 		return $items;
// 	}, 99 );

// 	// 4️⃣ Wyświetlenie zawartości zakładki (Elementor Saved Template ID 2179)
// 	add_action( 'woocommerce_account_my_points_endpoint', function() {
// 		echo do_shortcode('[elementor-template id="2179"]'); // ID Twojego szablonu Elementor
// 	});

// 	// 5️⃣ Odśwież rewrite rules po aktywacji motywu/wtyczki
// 	add_action( 'after_switch_theme', function() {
// 		flush_rewrite_rules();
// 	});
// }
// // saldoIHistoriaLagerowPage();


// /**
//  * Stortowanie w sklepie
//  */
// add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_remove_sorting_options' );
// add_filter( 'woocommerce_catalog_orderby', 'custom_remove_sorting_options' );

// function custom_remove_sorting_options( $sortby ) {
//     unset( $sortby['popularity'] ); // usuwa "Sortuj według popularności"
//     unset( $sortby['rating'] );     // usuwa "Sortuj według średniej oceny"
// 	 unset( $sortby['date'] ); // usuwa "Sortuj od najnowaszych"
//     return $sortby;
// }



