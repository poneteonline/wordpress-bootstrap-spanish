<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

Aquí es donde puedes poner tus funciones personalizadas o
solo editar cosas como tamaños de las miniaturas, imágenes de cabecera,
barras laterales, comentarios, etc.
*/

// Mantiene el núcleo de Bones en ejecución!
require_once('library/bones.php');            // funciones principales (no eliminar)
require_once('library/plugins.php');          // plugins y funciones extras (opcional)

// Panel de opciones
require_once('library/options-panel.php');

// Shortcodes
require_once('library/shortcodes.php');

// Funciones de administrador (comentados de forma predeterminada)
// require_once('library/admin.php');         // funciones administrativas personalizadas

// Pie del Backend personalizado
function bones_custom_admin_footer() {
  echo '<span id="footer-thankyou">Desarrollado por <a href="http://320press.com" target="_blank">320press</a></span>. Construido usando <a href="http://themble.com/bones" target="_blank">Bones</a>.';
}

// Añadiendolo al área de administración
add_filter('admin_footer_text', 'bones_custom_admin_footer');

// Establecer el ancho del contenido
if ( ! isset( $content_width ) ) $content_width = 580;

/***** OPCIONES DE TAMAÑO PARA LAS MINIATURAS *****/

// Tamaños de miniaturas
add_image_size( 'wpbs-featured', 638, 300, true );
add_image_size( 'wpbs-featured-home', 970, 311, true);
add_image_size( 'bones-thumb-600', 600, 150, false );
add_image_size( 'bones-thumb-300', 300, 100, true );
/* 
para añadir mas tamaños, simplemente copia una de las lineas de arriba
y cambia las dimensiones y el nombre. Mientras
subas una "imagen destacada" tan grande como el mayor
ancho o alto establecido, todos los otros tamaños se
redimensionarán automáticamente.

Para usar un tamaño diferente, simplemente cambia el testo
dentro de la función miniatura.

Por ejemplo, para crear un tamaño de imagen de 300 x 300,
usaríamos la función:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

Puedes cambiar los nombres y las dimensiones del modo
en que prefieras. Diviertete!
*/

/********* BARRAS LATERALES ACTIVAS **************/

// Barras laterales y zonas para widgets
function bones_register_sidebars() {
    register_sidebar(array(
      'id' => 'sidebar1',
      'name' => 'Barra lateral principal',
      'description' => 'Usada en todas las páginas EXCEPTO en la plantilla de la página de inicio',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
      'id' => 'sidebar2',
      'name' => 'Barra lateral de la página de inicio',
      'description' => 'Usada solamente en la plantilla de la página de inicio.',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
      'id' => 'footer1',
      'name' => 'Pie de página 1',
      'before_widget' => '<div id="%1$s" class="widget span4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));

    register_sidebar(array(
      'id' => 'footer2',
      'name' => 'Pie de página 2',
      'before_widget' => '<div id="%1$s" class="widget span4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));

    register_sidebar(array(
      'id' => 'footer3',
      'name' => 'Pie de página 3',
      'before_widget' => '<div id="%1$s" class="widget span4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));
    
    
    /* 
    para añadir mas barras laterales o zonas para widgets, solo copia
    y edita el código de arriba para la barra lateral. Para llamar
    tu nueva barra lateral solo usa el siguiente código:
    
    Solo cambia el nombre al que será tu nuevo id
    de la barra lateral, por ejemplo:
    
    
    
    Para llamar la barra lateral en tu plantilla, puedes copiar
    el archivo sidebar.php y cambiar su nombre al nombre de la barra lateral.
    Así que usando el ejemplo anterior, sería:
    sidebar-sidebar2.php
    
    */
} // no elimine esta llave!

/********** DISEÑO DE LOS COMENTARIOS **************/
    
// Diseño de los comentarios
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?>>
    <article id="comment-<?php comment_ID(); ?>" class="clearfix">
      <div class="comment-author vcard row-fluid clearfix">
        <div class="avatar span2">
          <?php echo get_avatar($comment,$size='75',$default='<path_to_url>' ); ?>
        </div>
        <div class="span10 comment-text">
          <?php printf(__('<h4>%s</h4>','bonestheme'), get_comment_author_link()) ?>
          <?php edit_comment_link(__('Editar','bonestheme'),'<span class="edit-comment btn btn-small btn-info"><i class="icon-white icon-pencil"></i>','</span>') ?>
                    
                    <?php if ($comment->comment_approved == '0') : ?>
                <div class="alert-message success">
                  <p><?php _e('Tu comentario está pendiente de moderación.','bonestheme') ?></p>
                  </div>
          <?php endif; ?>
                    
                    <?php comment_text() ?>
                    
                    <time datetime="<?php echo comment_time('F-j-Y'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
                    
          <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
      </div>
    </article>
    <!-- </li> es añadido por wordpress automáticamente -->
<?php
} // no elimine esta llave!

// Función de devolución de llamada que muestra los trackbacks/pings
function list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
?>
        <li id="comment-<?php comment_ID(); ?>"><i class="icon icon-share-alt"></i>&nbsp;<?php comment_author_link(); ?>
<?php 

}

// Solo muestra los comentarios en el contador de comentarios (los cuales actualmente no se muestran en wp-bootstrap, pero lo estoy poniendo ahora para no olvidarlo luego)
add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count ) {
  if ( ! is_admin() ) {
    global $id;
      $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
      return count($comments_by_type['comment']);
  } else {
      return $count;
  }
}

/******* DISEÑO DEL FORMULARIO DE BUSQUEDA ********/

// Formulario de busqueda
function bones_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Buscar por:', 'bonestheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Buscar el sitio..." />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Buscar','bonestheme') .'" />
    </form>';
    return $form;
} // no elimine esta llave!

/*************** formulario de entrada protegida *****/

add_filter( 'the_password_form', 'custom_password_form' );

function custom_password_form() {
  global $post;
  $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
  $o = '<div class="clearfix"><form class="protected-post-form" action="' . get_option('siteurl') . '/wp-pass.php" method="post">
  ' . __( "<p>Esta entrada está protegida. Introduce la contraseña para poder ver la entrada.</p>" ,'bonestheme') . '
  <label for="' . $label . '">' . __( "Contraseña:" ,'bonestheme') . ' </label><div class="input"><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" class="btn btn-primary" value="' . esc_attr__( "Enviar",'bonestheme' ) . '" /></div>
  </form></div>
  ';
  return $o;
}

/***** actualizar el widget de nube de etiquetas estándar de wp para que se vea mejor *****/

add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );

function my_widget_tag_cloud_args( $args ) {
  $args['number'] = 20; // mostrar menos etiquetas
  $args['largest'] = 9.75; // hace que el grande y el pequeño se vean igual - no me gusta como se ve la variación en el tamaño de la fuente
  $args['smallest'] = 9.75;
  $args['unit'] = 'px';
  return $args;
}



// filtra la salida de la nube de etiquetas para que pueda ser modificada por medio de CSS
function add_tag_class( $taglinks ) {
    $tags = explode('</a>', $taglinks);
    $regex = "#(.*tag-link[-])(.*)(' title.*)#e";
        foreach( $tags as $tag ) {
          $tagn[] = preg_replace($regex, "('$1$2 label tag-'.get_tag($2)->slug.'$3')", $tag );
        }
    $taglinks = implode('</a>', $tagn);
    return $taglinks;
}

add_action('wp_tag_cloud', 'add_tag_class');

add_filter('wp_tag_cloud','wp_tag_cloud_filter', 10, 2);

function wp_tag_cloud_filter($return, $args)
{
  return '<div id="tag-cloud">'.$return.'</div>';
}

// Habilita los shortcodes en los widgets
add_filter('widget_text', 'do_shortcode');

// Deshabilita el enlace ‘leer más’
function remove_more_jump_link($link) {
  $offset = strpos($link, '#more-');
  if ($offset) {
    $end = strpos($link, '"',$offset);
  }
  if ($end) {
    $link = substr_replace($link, '', $offset, $end-$offset);
  }
  return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');

// Elimina los atributos alto/ancho en las imágenes para que puedan ser adaptables
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

// Añade la caja Meta a la plantilla de la página de inicio
function add_homepage_meta_box() {  
  
  // Solamente añade la caja meta a la página de inicio si la plantilla que se está usando en la plantilla de la página de inicio
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
  $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
  if ($template_file == 'page-homepage.php')
  {
      add_meta_box(  
          'homepage_meta_box', // $id  
          'Optional Homepage Tagline', // $title  
          'show_homepage_meta_box', // $callback  
          'page', // $page  
          'normal', // $context  
          'high'); // $priority  
    }
}  
add_action('add_meta_boxes', 'add_homepage_meta_box');

// Arreglo de campo  
$prefix = 'custom_';  
$custom_meta_fields = array(  
    array(  
        'label'=> 'Area de descripción de la página de inicio',  
        'desc'  => 'Mostrado debajo del titulo de la página. Solamente se usa en la plantilla de la página de inicio. Se puede usar HTML.',  
        'id'    => $prefix.'tagline',  
        'type'  => 'textarea' 
    )  
);  

// Devolución de llamada para la caja Meta en la página de inicio  
function show_homepage_meta_box() {  
global $custom_meta_fields, $post;  
// Utilice nonce para la verificación  
  wp_nonce_field( basename( __FILE__ ), 'wpbs_nonce' );
    
    // Comienza el campo de table y el loop  
    echo '<table class="form-table">';  
    foreach ($custom_meta_fields as $field) {  
        // obtiene un valor de este campo si existe para esta entrada  
        $meta = get_post_meta($post->ID, $field['id'], true);  
        // comienza una fila de table con  
        echo '<tr> 
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th> 
                <td>';  
                switch($field['type']) {  
                    // texo  
                    case 'text':  
                        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="60" /> 
                            <br /><span class="description">'.$field['desc'].'</span>';  
                    break;
                    
                    // textarea  
                    case 'textarea':  
                        echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="80" rows="4">'.$meta.'</textarea> 
                            <br /><span class="description">'.$field['desc'].'</span>';  
                    break;  
                } // terminar switch  
        echo '</td></tr>';  
    } // terminar foreach  
    echo '</table>'; // terminar table  
}  

// Guardar la información  
function save_homepage_meta($post_id) {  
    global $custom_meta_fields;  
  
    // verificar nonce  
    if (!isset( $_POST['wpbs_nonce'] ) || !wp_verify_nonce($_POST['wpbs_nonce'], basename(__FILE__)))  
        return $post_id;  
    // comprobar autosave  
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
        return $post_id;  
    // check permissions  
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }  
  
    // serpentea a través de la información y guarda los datos  
    foreach ($custom_meta_fields as $field) {  
        $old = get_post_meta($post_id, $field['id'], true);  
        $new = $_POST[$field['id']];  
        if ($new && $new != $old) {  
            update_post_meta($post_id, $field['id'], $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id, $field['id'], $old);  
        }  
    } // termina foreach  
}  
add_action('save_post', 'save_homepage_meta');  

// Añade la clase thumbnail a los enlaces de miniaturas
function add_class_attachment_link($html){
    $postid = get_the_ID();
    $html = str_replace('<a','<a class="thumbnail"',$html);
    return $html;
}
add_filter('wp_get_attachment_link','add_class_attachment_link',10,1);

// Mods del menú de salida
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
      global $wp_query;
      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
      
      $class_names = $value = '';
      
      // Si el elemento tiene hijos, añade la clase dropdown para bootstrap
      if ( $args->has_children ) {
        $class_names = "dropdown ";
      }
      
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      
      $class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
      $class_names = ' class="'. esc_attr( $class_names ) . '"';
           
            $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            //  Si el elemento tiene hijos añade estos dos tributos a la etiqueta ancla
            if ( $args->has_children ) {
        $attributes .= 'class="dropdown-toggle" data-toggle="dropdown"';
      }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            // Si el elemento tiene hijos añade el signo de intercalación justo antes de cerrar la etiqueta ancla
            if ( $args->has_children ) {
              $item_output .= '<b class="caret"></b></a>';
            }
            else{
              $item_output .= '</a>';
            }
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
            
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
        }
            
        function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
            {
                $id_field = $this->db_fields['id'];
                if ( is_object( $args[0] ) ) {
                    $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
                }
                return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
            }
        
            
}


add_editor_style('editor-style.css');

// Añadir el nombre de clase 'active' estándar de Twitter Bootstrap al enlace activo de la barra de navegación

add_filter('nav_menu_css_class', 'add_active_class', 10, 2 );
function add_active_class($classes, $item) {
  if($item->menu_item_parent == 0 && in_array('current-menu-item', $classes)) {
        $classes[] = "active";
  }
    return $classes;
}

// encolar estilos

function theme_styles()  
{ 
    // Este es el archivo css compilado por LESS
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '1.0', 'all' );
    wp_register_style( 'bootstrap-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1.0', 'all' );
    wp_register_style( 'wp-bootstrap', get_template_directory_uri() . '/style.css', array(), '1.0', 'all' );
    
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'bootstrap-responsive' );
    wp_enqueue_style( 'wp-bootstrap');
}
add_action('wp_enqueue_scripts', 'theme_styles');

// encolar javascript

function theme_js(){
  wp_deregister_script('jquery'); // iniciar la función  
  wp_register_script('jquery', get_template_directory_uri().'/library/js/libs/jquery-1.7.1.min.js', false, '1.7.1');
  wp_register_script('bootstrap-js', get_template_directory_uri().'/library/js/bootstrap.min.js');
  wp_register_script('wpbs-scripts', get_template_directory_uri().'/library/js/scripts.js');
  wp_register_script('modernizr', get_template_directory_uri().'/library/js/modernizr.full.min.js');

  wp_enqueue_script('jquery');
  wp_enqueue_script('bootstrap-js', array('jQuery'), '1.1', true);
  wp_enqueue_script('wpbs-scripts', array('jQuery'), '1.1', true);
  wp_enqueue_script('modernizr', array('jQuery'), '1.1', true);
}
add_action('wp_enqueue_scripts', 'theme_js');


// Obtener las opciones del tema
function get_wpbs_theme_options(){
  $theme_options_styles = '';
    
      $heading_typography = of_get_option('heading_typography');
      if ($heading_typography) {
        $theme_options_styles .= '
        h1, h2, h3, h4, h5, h6{ 
          font-family: ' . $heading_typography['face'] . '; 
          font-weight: ' . $heading_typography['style'] . '; 
          color: ' . $heading_typography['color'] . '; 
        }';
      }
      
      $main_body_typography = of_get_option('main_body_typography');
      if ($main_body_typography) {
        $theme_options_styles .= '
        body{ 
          font-family: ' . $main_body_typography['face'] . '; 
          font-weight: ' . $main_body_typography['style'] . '; 
          color: ' . $main_body_typography['color'] . '; 
        }';
      }
      
      $link_color = of_get_option('link_color');
      if ($link_color) {
        $theme_options_styles .= '
        a{ 
          color: ' . $link_color . '; 
        }';
      }
      
      $link_hover_color = of_get_option('link_hover_color');
      if ($link_hover_color) {
        $theme_options_styles .= '
        a:hover{ 
          color: ' . $link_hover_color . '; 
        }';
      }
      
      $link_active_color = of_get_option('link_active_color');
      if ($link_active_color) {
        $theme_options_styles .= '
        a:active{ 
          color: ' . $link_active_color . '; 
        }';
      }
      
      $topbar_position = of_get_option('nav_position');
      if ($topbar_position == 'scroll') {
        $theme_options_styles .= '
        .navbar{ 
          position: static; 
        }
        body{
          padding-top: 0;
        }
        ' 
        ;
      }
      
      $topbar_bg_color = of_get_option('top_nav_bg_color');
      if ($topbar_bg_color) {
        $theme_options_styles .= '
        .navbar-inner, .navbar .fill { 
          background-color: '. $topbar_bg_color . ';
        }';
      }
      
      $use_gradient = of_get_option('showhidden_gradient');
      if ($use_gradient) {
        $topbar_bottom_gradient_color = of_get_option('top_nav_bottom_gradient_color');
      
        $theme_options_styles .= '
        .navbar-inner, .navbar .fill {
          background-image: -khtml-gradient(linear, left top, left bottom, from(' . $topbar_bg_color . '), to('. $topbar_bottom_gradient_color . '));
          background-image: -moz-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          background-image: -ms-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ' . $topbar_bg_color . '), color-stop(100%, '. $topbar_bottom_gradient_color . '));
          background-image: -webkit-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . '2);
          background-image: -o-linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          background-image: linear-gradient(top, ' . $topbar_bg_color . ', '. $topbar_bottom_gradient_color . ');
          filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'' . $topbar_bg_color . '\', endColorstr=\''. $topbar_bottom_gradient_color . '2\', GradientType=0);
        }';
      }
      else{
        $theme_options_styles .= '.navbar-inner, .navbar .fill { background-image: none; };';
      } 
      
      $topbar_link_color = of_get_option('top_nav_link_color');
      if ($topbar_link_color) {
        $theme_options_styles .= '
        .navbar .nav li a { 
          color: '. $topbar_link_color . ';
        }';
      }
      
      $topbar_link_hover_color = of_get_option('top_nav_link_hover_color');
      if ($topbar_link_hover_color) {
        $theme_options_styles .= '
        .navbar .nav li a:hover { 
          color: '. $topbar_link_hover_color . ';
        }';
      }
      
      $topbar_dropdown_hover_bg_color = of_get_option('top_nav_dropdown_hover_bg');
      if ($topbar_dropdown_hover_bg_color) {
        $theme_options_styles .= '
          .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover {
            background-color: ' . $topbar_dropdown_hover_bg_color . ';
          }
        ';
      }
      
      $topbar_dropdown_item_color = of_get_option('top_nav_dropdown_item');
      if ($topbar_dropdown_item_color){
        $theme_options_styles .= '
          .dropdown-menu a{
            color: ' . $topbar_dropdown_item_color . ' !important;
          }
        ';
      }
      
      $hero_unit_bg_color = of_get_option('hero_unit_bg_color');
      if ($hero_unit_bg_color) {
        $theme_options_styles .= '
        .hero-unit { 
          background-color: '. $hero_unit_bg_color . ';
        }';
      }
      
      $suppress_comments_message = of_get_option('suppress_comments_message');
      if ($suppress_comments_message){
        $theme_options_styles .= '
        #main article {
          border-bottom: none;
        }';
      }
      
      $additional_css = of_get_option('wpbs_css');
      if( $additional_css ){
        $theme_options_styles .= $additional_css;
      }
          
      if($theme_options_styles){
        echo '<style>' 
        . $theme_options_styles . '
        </style>';
      }
    
      $bootstrap_theme = of_get_option('wpbs_theme');
      $use_theme = of_get_option('showhidden_themes');
      
      if( $bootstrap_theme && $use_theme ){
        if( $bootstrap_theme == 'default' ){}
        else {
          echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/admin/themes/' . $bootstrap_theme . '.css">';
        }
      }
} // end get_wpbs_theme_options function



?>