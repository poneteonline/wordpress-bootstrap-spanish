<?php
/**
 * Un identificador único es creado para almacenar las opciones en la base de datos y referenciarlas desde el tema.
 * De forma predeterminada usa el nombre del tema en minúscula y sin espacios, pero esto se puede cambiar si es necesario.
 * Si el identificador cambia, aparecerá como si las opciones se hubieran restablecido.
 * 
 */

function optionsframework_option_name() {

	// Esto toma el nombre del tema desde la hoja de estilos (en minúscula y sin espacios)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Define un arreglo de opciones que serán usadas para generar la pagina de ajustes y guardarlos en la base de datos.
 * Cuándo se estén creando los campos "id", asegurate de usar todas las letras en minúscula y sin espacios.
 *  
 */

function optionsframework_options() {

	$themesPath = dirname(__FILE__) . '/admin/themes';
	
	// Insertar la opción predeterminada
	$theList['default'] = OPTIONS_FRAMEWORK_DIRECTORY . '/themes/default-thumbnail-100x60.png';
	
	if ($handle = opendir( $themesPath )) {
	    while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'css')
	        {
	        	$name = substr($file, 0, strlen($file) - 4);
				$thumb = OPTIONS_FRAMEWORK_DIRECTORY . '/themes/' . $name . '-thumbnail-100x60.png';
				$theList[$name] = $thumb;
	        }
	    }
	    closedir($handle);
	}
	
	//print_r($theList);
	
	// posición fija o de desplazamiento
	$fixed_scroll = array("fixed" => "Fija","scroll" => "Desplazable");
	
	// Opciones predeterminadas de Multicheck
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Opciones predeterminadas de Background Defaults
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	// Pone todas las categorías en un arreglo
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pone todas las páginas en un arreglo
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Selecciona una página:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// Si se esta usando botones radiales en imagen, define una ruta al directorio
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
		
	$options[] = array( "name" => "Tipografía",
						"type" => "heading");
						
	$options[] = array( "name" => "Cabeceras",
						"desc" => "Usado en etiquetas H1, H2, H3, H4, H5 & H6",
						"id" => "heading_typography",
						"std" => array('face' => '"Helvetica Neue",Helvetica,Arial,sans-serif','style' => 'bold','color' => '#404040'),
						"type" => "wpbs_typography");
						
	$options[] = array( "name" => "Texto principal del cuerpo",
						"desc" => "Usado en etiquetas P",
						"id" => "main_body_typography",
						"std" => array('face' => '"Helvetica Neue",Helvetica,Arial,sans-serif','style' => 'normal','color' => '#404040'),
						"type" => "wpbs_typography");
						
	$options[] = array( "name" => "Color del enlace",
						"desc" => "Predeterminado si ningún color es seleccionado.",
						"id" => "link_color",
						"std" => "",
						"type" => "color");
					
	$options[] = array( "name" => "Color del enlace:hover",
						"desc" => "Predeterminado si ningún color es seleccionado.",
						"id" => "link_hover_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Color del enlace:active",
						"desc" => "Predeterminado si ningún color es seleccionado.",
						"id" => "link_active_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Barra de navegación superior",
						"type" => "heading");
						
	$options[] = array( "name" => "Posición",
						"desc" => "Fija a la parte superior de la ventana o desplazable con el contenido.",
						"id" => "nav_position",
						"std" => "fixed",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $fixed_scroll);
						
	$options[] = array( "name" => "Color de fondo de la barra de navegación superior",
						"desc" => "Predeterminado si ningún color es seleccionado.",
						"id" => "top_nav_bg_color",
						"std" => "#222222",
						"type" => "color");
						
	$options[] = array( "name" => "Marcar para usar un degradado para el fondo de la barra de navegación superior",
						"desc" => "Usar un degradado",
						"id" => "showhidden_gradient",
						"std" => "1",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Color del degradado inferior",
						"desc" => "Color de fondo de la barra de navegación superior usado como color degradado principal",
						"id" => "top_nav_bottom_gradient_color",
						"std" => "#333333",
						"class" => "hidden",
						"type" => "color");
						
	$options[] = array( "name" => "Color de los ítems en la barra de navegación superior",
						"desc" => "Color del enlace.",
						"id" => "top_nav_link_color",
						"std" => "#BFBFBF",
						"type" => "color");
						
	$options[] = array( "name" => "Color:hover de los ítems en la barra de navegación superior",
						"desc" => "Color:hover del enlace.",
						"id" => "top_nav_link_hover_color",
						"std" => "#FFFFFF",
						"type" => "color");
						
	$options[] = array( "name" => "Color de los ítems en el menú desplegable de la barra de navegación superior",
						"desc" => "Color de los ítems en el menú desplegable.",
						"id" => "top_nav_dropdown_item",
						"std" => "#555555",
						"type" => "color");
						
	$options[] = array( "name" => "Color:hover de fondo en los ítems del menú desplegable de la barra de navegación superior",
						"desc" => "Color:hover de fondo en los ítems del menú desplegable",
						"id" => "top_nav_dropdown_hover_bg",
						"std" => "#0088CC",
						"type" => "color");
	
	$options[] = array( "name" => "Barra de búsqueda",
						"desc" => "Mostrar la barra de búsqueda en la barra de navegación superior.",
						"id" => "search_bar",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Tema",
						"type" => "heading");
						
	$options[] = array( "name" => "Temas Bootswatch.com",
						"desc" => "Usar los temas de Bootswatch.com. Nota: esto puede sobrescribir otros estilos establecidos en el panel de opciones del tema.",
						"id" => "showhidden_themes",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Selecciona un tema",
						"id" => "wpbs_theme",
						"std" => "default",
						"class" => "hidden",
						"type" => "images",
						"options" => $theList
						);
						
	$options[] = array( "name" => "Actualizar los temas de Bootswatch.com",
						"type" => "themecheck",
						"id" => "themecheck"
						);
						
	$options[] = array( "name" => "Otros ajustes",
						"type" => "heading");
						
	$options[] = array( "name" => "Color de fondo para la plantilla de la página de inicio hero-unit",
						"desc" => "Predeterminado si ningún color es seleccionado",
						"id" => "hero_unit_bg_color",
						"std" => "#F5F5F5",
						"type" => "color");
						
	$options[] = array( "name" => "Mensaje en las páginas 'Los comentarios están cerrados'",
						"desc" => "Eliminar el mensaje 'Los comentarios están cerrados'",
						"id" => "suppress_comments_message",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Página del blog 'hero' unit",
						"desc" => "Mostrar la página del blog hero unit",
						"id" => "blog_hero",
						"std" => "1",
						"type" => "checkbox");
	
	$options[] = array( "name" => "CSS",
						"desc" => "CSS adicional",
						"id" => "wpbs_css",
						"std" => "",
						"type" => "textarea");
									
	return $options;
}

add_action('admin_head', 'wpbs_javascript');

function wpbs_javascript() {
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {

	var data = {
		action: 'wpbs_theme_check',
	};

	// Puesto que la versión 2.8 de ajaxurl siempre está definida en la cabecera de administración y apunta a admin-ajax.php
	jQuery('#check-bootswatch').click( function(){ 
		jQuery.post(ajaxurl, data, function(response) {
			alert(response);
		});
	});
});
</script>
<?php
}

add_action('wp_ajax_wpbs_theme_check', 'wpbs_refresh_themes');

function wpbs_refresh_themes() {
	// esto toma el feed xml de thomas park
	$xml_feed_url = 'http://feeds.pinboard.in/rss/u:thomaspark/t:bootswatch/';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $xml_feed_url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$xml = curl_exec($ch);
	curl_close($ch);
	
	$feed = new SimpleXmlElement($xml, LIBXML_NOCDATA);	
	
    $cnt = count($feed->item);
    
    // pasa a través de cada ítem encontrado
    for($i=0; $i<$cnt; $i++)
    {
		$url 	= $feed->item[$i]->link;
		$title 	= strtolower($feed->item[$i]->title);
		$desc = $feed->item[$i]->description;
		
		// obtiene el contenido del archivo css
		$css_url = $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $css_url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$css_contents = curl_exec($ch);
		curl_close($ch);
		
		$thumb_url_prefix = 'http://bootswatch.com/';
		$thumb_url = $thumb_url_prefix . $title . '/thumbnail.png';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $thumb_url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$thumb_contents = curl_exec($ch);
		curl_close($ch);
		
		// crea el archivo usando el titulo del ítem y luego lo cierra
		$template_path = get_template_directory();
		$filenameCSS = $template_path . '/admin/themes/' . $title . '.css';
		$filehandle = fopen($filenameCSS, 'w') or die("no se puede abrir el archivo - " . $filenameCSS);
		fwrite($filehandle, $css_contents);
		fclose($filehandle);
		
		$filenameThumb = $template_path . '/admin/themes/' .$title . '-thumbnail.png';
		$filehandle = fopen($filenameThumb, 'w') or die("no se puede abrir el archivo - " . $filenameThumb);
		fwrite($filehandle, $thumb_contents);
		fclose($filehandle);
		// resize thumb
		$destDirectory = substr( $filenameThumb, 0, strlen( $filenameThumb-14 ) );
		image_resize( $filenameThumb, 100, 60, true, '', $destDirectory, 100 );
		
    }
    
	echo "Temas actualizados.";

	die(); // Esto se necesita para devolver un resultado adecuado
}


?>