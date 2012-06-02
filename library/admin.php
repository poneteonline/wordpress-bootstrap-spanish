<?php
/* 
Este archivo maneja las áreas de administración y funciones.
Puedes usar este archivo para realizar cambios a el
dashboard. Las actualizaciones a esta página vendrán pronto.
Esta apagado de forma predeterminada, pero puedes llamarlo
por medio del archivo de funciones.

Desarrollado por: Eddie Machado
URL: http://themble.com/bones/

Agradecimientos especiales por código & inspiración a:
@jackmcconnell - http://www.voltronik.co.uk/
Digging into WP - http://digwp.com/2010/10/customize-wordpress-dashboard/

*/

/************* WIDGETS DEL DASHBOARD *****************/

// deshabilitar los widgets predeterminados del dashboard
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         // 
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //
	
	// removing plugin dashboard boxes 
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
	
	/* 
	existen más plugins o widgets que quisieras eliminar?
	compártelos con nosotros para que hagamos una lista de
	los más comúnmente usados. :D
	https://github.com/eddiemachado/bones/issues
	*/
}

/*
Ahora hablemos acerca de incluir tus propios widgets para el Dashboard.
Algunas veces quieres mostrar feeds relativos al contenido
de tu sitio. Por ejemplo, el feed the NBA.com para un sitio
de deportes. A continuación verás un ejemplo de un widget para el Dashboard
que muestra las entradas recientes de un feed RSS.

Para mas información sobre crear widgets para el Dashboard mira:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// Widget RSS del Dashboard 
function bones_rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // incluye el archivo requerido
		$feed = fetch_feed('http://themble.com/feed/rss/');        // especifica la fuente del feed
		$limit = $feed->get_item_quantity(7);                      // especifica el número de elementos
		$items = $feed->get_items(0, $limit);                      // crea un arreglo de elementos
	}
	if ($limit == 0) echo '<div>El Feed RSS está vacío o no se encuentra disponible</div>';   // mensaje de reserva 
	else foreach ($items as $item) : ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo $item->get_date('j F Y @ g:i a'); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?> 
	</p>
	<?php endforeach; 
}

// llamando todos los widgets personalizados del dashboard
function bones_custom_dashboard_widgets() {
	wp_add_dashboard_widget('bones_rss_dashboard_widget', 'Recientemente en Themble (Personalizar en admin.php)', 'bones_rss_dashboard_widget');
	/*
	Asegurate de incluir cualquier otro widget del Dashboard creado
	en esta función y todos serán cargados.
	*/
}


// eliminando los widgets del dashboard
add_action('admin_menu', 'disable_default_dashboard_widgets');
// incluyendo cualquier widget personalizado
add_action('wp_dashboard_setup', 'bones_custom_dashboard_widgets');


/************* PAGINA PERSONALIZADA DE INGRESO *****************/

// llamando tu propia hoja de estilo para la página de ingreso para que puedas modificarla 
function bones_login_css() {
	/* no pude hacer funcionar wp_enqueue_style :( */
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/library/css/login.css">';
}

// cambiando el logo enlace de wordpress.org por el de tu sitio 
function bones_login_url() { echo bloginfo('url'); }

// cambiando el texto alternativo del logo para mostrar el nombre de tu sitio 
function bones_login_title() { echo get_option('blogname'); }

// llamándolo solo para la página de ingreso
add_action('login_head', 'bones_login_css');
add_filter('login_headerurl', 'bones_login_url');
add_filter('login_headertitle', 'bones_login_title');


/************* ADMINISTRACION PERSONALIZADA *******************/

/*
Yo realmente no recomiendo editar mucho la página de administración
puesto que las cosas pueden resultar mal si Wordpress se actualiza. Aquí
hay algunas funciones que puedes elegir usar si así lo deseas.
*/

// Backend Footer personalizado
function bones_custom_admin_footer() {
	echo '<span id="footer-thankyou">Desarrollado por <a href="http://tusitio.com" target="_blank">El nombre de tu sitio</a></span>. Construído usando <a href="http://themble.com/bones" target="_blank">Bones</a>.';
}

// incluyéndolo en el área de administración
add_filter('admin_footer_text', 'bones_custom_admin_footer');