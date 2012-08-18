<?php
/* Bienvenido a Bones :)
Este es el núcleo de Bones donde la mayoría de las
funciones y características principales residen. Si tienes
algunas funciones personalizadas, lo mejor es ponerlas
en el archivo functions.php.

Desarrollado por: Eddie Machado
URL: http://themble.com/bones/
*/

// Añadiendo opciones de traducción
load_theme_textdomain( 'bonestheme', TEMPLATEPATH.'/languages' );
$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);

// Limpiando la cabecera de Wordpress
function bones_head_cleanup() {
	// eliminar los enlaces de la cabecera
	remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Feeds de categorías
	remove_action( 'wp_head', 'feed_links', 2 );                          // Feeds de entradas y comentarios
	remove_action( 'wp_head', 'rsd_link' );                               // Enlace EditarURI
	remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                         // Enlace index
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // Enlace anterior
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // Enlace comenzar
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Enlaces para entradas adyacentes
	remove_action( 'wp_head', 'wp_generator' );                           // Versión de WP
	if (!is_admin()) {
		wp_deregister_script('jquery');                                   // De-Register jQuery
		wp_register_script('jquery', '', '', '', true);                   // Ya se encuentra en la cabecera
	}	
}
	// lanzando la operación limpieza
	add_action('init', 'bones_head_cleanup');
	// eliminar la versión de WP del RSS
	function bones_rss_version() { return ''; }
	add_filter('the_generator', 'bones_rss_version');
	
// cargando elementos de respuesta jquery en páginas únicas automáticamente
function bones_queue_js(){ if (!is_admin()){ if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script( 'comment-reply' ); }
}
	// script para respuesta de comentarios
	add_action('wp_print_scripts', 'bones_queue_js');

// Reparando el Leer más en los extractos
// Esto elimina los molestos [...] en el enlace Leer más
function bones_excerpt_more($more) {
	global $post;
	// edita aquí si lo deseas
	return '...  <a href="'. get_permalink($post->ID) . '" class="more-link" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
}
add_filter('excerpt_more', 'bones_excerpt_more');
	
// Añadir funciones y soporte de temas WP 3+
function bones_theme_support() {
	add_theme_support('post-thumbnails');      // miniaturas wp (tamaños controlados desde functions.php)
	set_post_thumbnail_size(125, 125, true);   // tamaño de miniaturas predeterminado
	add_theme_support( 'custom-background' );  // fondo de wp personalizado
	add_theme_support('automatic-feed-links'); // cosita rss
	// para incluir soporte para imagen de cabecera visitar: http://themble.com/support/adding-header-background-image-support/
	// añadiendo soporte para formato de entrada
	/*add_theme_support( 'post-formats',      // formatos de entrada
		array( 
			'aside',   // titulo menos común
			'gallery', // galería de imágenes
			'link',    // enlace rápido a otro sitio
			'image',   // una imagen
			'quote',   // una cita rápida
			'status',  // una actualización de estado como las de Facebook
			'video',   // video 
			'audio',   // audio
			'chat'     // transcripción de chat 
		)
	);	*/
	add_theme_support( 'menus' );            // menús wp
	register_nav_menus(                      // menús wp3+
		array( 
			'main_nav' => 'El menú principal',   // barra de navegación principal en la cabecera
			'footer_links' => 'Enlaces de pie de página' // barra de navegación secundaria en el pie de página
		)
	);	
}

	// lanzado esto después de la configuración del tema
	add_action('after_setup_theme','bones_theme_support');	
	// añadiendo barras laterales a Wordpress (estas están creadas en functions.php)
	add_action( 'widgets_init', 'bones_register_sidebars' );
	//añadiendo el formulario de búsqueda de bones (creado en functions.php)
	add_filter( 'get_search_form', 'bones_wpsearch' );
	

 
function bones_main_nav() {
	// mostrar el menú de wp3 si esta disponible
    wp_nav_menu( 
    	array( 
    		'menu' => 'main_nav', /* menu name */
    		'menu_class' => 'nav',
    		'theme_location' => 'main_nav', /* where in the theme it's assigned */
    		'container' => 'false', /* container class */
    		'fallback_cb' => 'bones_main_nav_fallback', /* menu fallback */
    		'depth' => '2', /* suppress lower levels for now */
    		'walker' => new description_walker()
    	)
    );
}

function bones_footer_links() { 
	// mostrar el menú de wp3 si esta disponible
    wp_nav_menu(
    	array(
    		'menu' => 'footer_links', /* nombre del menú */
    		'theme_location' => 'footer_links', /* donde se encuentra asignado en el tema */
    		'container_class' => 'footer-links clearfix', /* clase container */
    		'fallback_cb' => 'bones_footer_links_fallback' /* menú de reserva */
    	)
	);
}
 
// esta es la reserva para el menú de la cabecera
function bones_main_nav_fallback() { 
	// Encontrar la forma de hacer de esta salida html amistosa para bootstrap
	//wp_page_menu( 'show_home=Home&menu_class=nav' );
}

// esta es la reserva para el menú del pie de página
function bones_footer_links_fallback() { 
	/* puedes colocar un menú predeterminado aquí si lo deseas */ 
}


/****************** PLUGINS & CARACTERISTICAS EXTRAS **************************/
	
// Funciones relativas a las entradas (llamar usando bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* puedes cambiar esto para mostrar más */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<li class="related_post">
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; } 
	    else { ?>
            <li class="no_related_post">No hay entradas relacionadas aún!</li>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
}

// Navegación por páginas numeradas (incluido en el tema de forma predeterminada)
function page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
		
	echo $before.'<div class="pagination"><ul class="clearfix">'."";
	if ($paged > 1) {
		$first_page_text = "&laquo";
		echo '<li class="prev"><a href="'.get_pagenum_link().'" title="Primero">'.$first_page_text.'</a></li>';
	}
		
	$prevposts = get_previous_posts_link('&larr; Anterior');
	if($prevposts) { echo '<li>' . $prevposts  . '</li>'; }
	else { echo '<li class="disabled"><a href="#">&larr; Anterior</a></li>'; }
	
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="active"><a href="#">'.$i.'</a></li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="">';
	next_posts_link('Siguiente &rarr;');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = "&raquo;";
		echo '<li class="next"><a href="'.get_pagenum_link($max_page).'" title="Ultimo">'.$last_page_text.'</a></li>';
	}
	echo '</ul></div>'.$after."";
}

// eliminar p alrededor de los imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');

?>