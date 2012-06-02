<?php
/*
Plugin Name: Options Framework
Plugin URI: http://www.wptheming.com
Description: Un marco de desarrollo para construir las opciones de un tema.
Version: 0.8
Author: Devin Price
Author URI: http://www.wptheming.com
License: GPLv2
*/

/*
Este programa es software libre; puedes distribuirlo y/o modificarlo
bajo los términos de la GNU General Public License como esta
publicada por la Fundación para el Software Libre; cualquier de las
versiones 2 de la licencia, o (tu decisión) cualquier versión posterior.

Este programa es distribuido con la esperanza de que sea útil,
pero SIN NINGUNA GARANTIA; sin incluir siquiera la garantía de
COMERCIALIZACION o IDONEIDAD PARA UN PROPOSITO PARTICULAR.
Dirígete a la GNU General Public License para mas información.

Tu debiste haber recibido una copia de la GNU General Public License
con este programa; si no, escribe a la Free Software Foundation, Inc.
51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/* Definiciones básicas de plugins */

define('OPTIONS_FRAMEWORK_VERSION', '0.9');

/* Se asegura de no exponer ninguna información si es llamada directamente */

if ( !function_exists( 'add_action' ) ) {
	echo "Hola! Yo soy solo un pequeño plugin, no te preocupes por mi.";
	exit;
}

/* Si el usuario no puede editar las opciones del tema, no hay necesidad de correr este plugin */

add_action('init', 'optionsframework_rolescheck' );

function optionsframework_rolescheck () {
	if ( current_user_can( 'edit_theme_options' ) ) {
		// Si el usuario puede editar las opciones del tema, dejemos que la diversión comience!
		add_action( 'admin_menu', 'optionsframework_add_page');
		add_action( 'admin_init', 'optionsframework_init' );
		add_action( 'admin_init', 'optionsframework_mlu_init' );
	}
}

/* Carga el archivo para la limpieza de opciones */

add_action('init', 'optionsframework_load_sanitization' );

function optionsframework_load_sanitization() {
	require_once dirname( __FILE__ ) . '/options-sanitize.php';
}

/* 
 * Crea los ajustes en la base de datos saltando a través de la matriz
 * que proveemos en options.php. Esta es una excelente forma de hacerlo ya que
 * no tenemos que guardar los ajustes para las cabeceras, descripciones o argumentos.
 * 
 * Conoce más acerca de la API Settings en el WordPress codex:
 * http://codex.wordpress.org/Settings_API
 *
 */

function optionsframework_init() {

	// Incluye los archivos necesarios
	require_once dirname( __FILE__ ) . '/options-interface.php';
	require_once dirname( __FILE__ ) . '/options-medialibrary-uploader.php';
	
	// Carga la matriz de opciones desde el tema
	if ( $optionsfile = locate_template( array('options.php') ) ) {
		require_once($optionsfile);
	}
	else if (file_exists( dirname( __FILE__ ) . '/options.php' ) ) {
		require_once dirname( __FILE__ ) . '/options.php';
	}
	
	$optionsframework_settings = get_option('optionsframework' );
	
	// Actualiza el id único de la opción en la base de datos si esta ha cambiado
	optionsframework_option_name();
	
	// Obtiene el id único, entregando el predeterminado si este no esta definido
	if ( isset($optionsframework_settings['id']) ) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	}
	
	// Si la opción no tiene información guardada, carga la predeterminada
	if ( ! get_option($option_name) ) {
		optionsframework_setdefaults();
	}
	
	// Registra los campos de configuración y de devolución de llamada
	register_setting( 'optionsframework', $option_name, 'optionsframework_validate' );
}

/* 
 * Añade opciones predeterminadas a la base de datos si estas no se encuentran ya presentes.
 * Se puede luego actualizar esto para que se cargue por la activación de un plugin o
 * activación del tema, ya que la mayoría de personas no modificaran el archivo options.php
 * de forma regular.
 *
 * http://codex.wordpress.org/Function_Reference/add_option
 *
 */

function optionsframework_setdefaults() {
	
	$optionsframework_settings = get_option('optionsframework');

	// Obtiene el id único de opciones
	$option_name = $optionsframework_settings['id'];
	
	/* 
	 * Se espera que cada tema tenga un id único y todas sus opciones guardadas como 
	 * un grupo separado de opciones. Necesitamos rastrear todos estos grupos de opciones
	 * para que puedan ser fácilmente eliminados si alguien desea eliminar el plugin y
	 * su información asociada. No hay necesidad de desordenar la base de datos.  
	 *
	 */
	
	if ( isset($optionsframework_settings['knownoptions']) ) {
		$knownoptions =  $optionsframework_settings['knownoptions'];
		if ( !in_array($option_name, $knownoptions) ) {
			array_push( $knownoptions, $option_name );
			$optionsframework_settings['knownoptions'] = $knownoptions;
			update_option('optionsframework', $optionsframework_settings);
		}
	} else {
		$newoptionname = array($option_name);
		$optionsframework_settings['knownoptions'] = $newoptionname;
		update_option('optionsframework', $optionsframework_settings);
	}
	
	// Obtiene la información de las opciones predeterminadas desde la matriz en el archivo options.php
	$options = optionsframework_options();
	
	// Si las opciones no han sido incluidas en la base de datos aún, ellas serán incluidas ahora
	$values = of_get_default_values();
	
	if ( isset($values) ) {
		add_option( $option_name, $values ); // Añade la opción con los ajustes predeterminados
	}
}

/* Añade una sub-página llamada "Opciones del tema" al menú apariencia. */

if ( !function_exists( 'optionsframework_add_page' ) ) {
function optionsframework_add_page() {

	$of_page = add_theme_page('Opciones del tema', 'Opciones del tema', 'edit_theme_options', 'options-framework','optionsframework_page');
	
	// Agrega acciones de enganche en el css y javascript requeridos
	add_action("admin_print_styles-$of_page",'optionsframework_load_styles');
	add_action("admin_print_scripts-$of_page", 'optionsframework_load_scripts');
	
}
}

/* Carga las CSS */

function optionsframework_load_styles() {
	wp_enqueue_style('admin-style', OPTIONS_FRAMEWORK_DIRECTORY.'css/admin-style.css');
	wp_enqueue_style('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'css/colorpicker.css');
}	

/* Carga el javascript */

function optionsframework_load_scripts() {

	// Scripts en linea del archivo options-interface.php
	add_action('admin_head', 'of_admin_head');
	
	// Scripts en cola
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('options-custom', OPTIONS_FRAMEWORK_DIRECTORY.'js/options-custom.js', array('jquery'));
}

function of_admin_head() {

	// Gancho para agregar scripts personalizados
	do_action( 'optionsframework_custom_scripts' );
}

/* 
 * Construye el panel de opciones.
 * 
 * Si estuviéramos usando la API Settings como esta diseñada usuarios aquí
 * do_settings_sections. Pero como no queremos los ajustes envueltos en una tabla,
 * llamamos nuestro propio optionsframework_fields. Dirigete a options-interface.php
 * para conocer los detalles de como cada campo individual es generado.
 * 
 * Esta previsto que Nonces use el campo settings_fields()
 *
 */

if ( !function_exists( 'optionsframework_page' ) ) {
function optionsframework_page() {
	$return = optionsframework_fields();
	settings_errors();
	?>
    
	<div class="wrap">
	<div class="icon32" id="options_ico"><br /></div>
    <?php //screen_icon( 'themes' ); 
    ?>
    <h2 class="nav-tab-wrapper">
        <?php echo $return[1]; ?>
    </h2>
    
    <div class="metabox-holder">
    <div id="optionsframework" class="postbox">
		<form action="options.php" method="post">
		<?php settings_fields('optionsframework'); ?>

		<?php echo $return[0]; /* Ajustes */ ?>
        
        <div id="optionsframework-submit">
			<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Guardar ajustes' ); ?>" />
            <input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restaurar opciones predeterminadas' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Haz click en "OK" para restaurar los cambios. Cualquier configuración anterior se perderá!','optionsframework' ) ); ?>' );" />
            <div class="clear"></div>
		</div>
	</form>
</div> <!-- / #container -->

</div>
</div> <!-- / .wrap -->

<?php
}
}

/** 
 * Validar opciones.
 *
 * Esto corre después de que el botón enviar/restaurar ha sido presionado y
 * valida los ingresos.
 *
 * @uses $_POST['reset']
 * @uses $_POST['update']
 */
function optionsframework_validate( $input ) {

	/*
	 * Restaurar opciones predeterminadas.
	 *
	 * En el caso de que el usuario presione el botón "Restaurar
	 * opciones predeterminadas", las opciones definidas en el archivo
	 * options.php del tema serán usadas para la opción en el tema activo.
	 */
	 
	if ( isset( $_POST['reset'] ) ) {
		add_settings_error( 'options-framework', 'restore_defaults', __( 'Opciones predeterminadas restauradas.', 'optionsframework' ), 'updated fade' );
		return of_get_default_values();
	}

	/*
	 * Actualizar ajustes.
	 */
	 
	if ( isset( $_POST['update'] ) ) {
		$clean = array();
		$options = optionsframework_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Establece la casilla de verificación a falso si no se ha enviado en el $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = '0';
			}

			// Establece cada opción de la lista de selección múltiple como falso si no se ha enviado en el $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = '0';
				}
			}

			// Para que un valor sea enviado a la base de datos debe primero pasar a través de un filtro de desinfección
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		add_settings_error( 'options-framework', 'save_options', __( 'Opciones guardadas.', 'optionsframework' ), 'updated fade' );
		return $clean;
	}

	/*
	 * No se reconoce la solicitud.
	 */
	
	return of_get_default_values();
}

/**
 * Configuración de formato de la matriz.
 *
 * Obtiene una matriz de todos los valores predeterminados como están establecidos en el
 * options.php. Las claves 'id', 'std' y 'type' necesitan ser
 * definidas en la matriz de configuración. En caso de
 * que estas claves no se encuentren presentes la opción
 * no será incluida en la salida de esta función.
 *
 * @return    array     Rey-keyed options configuration array.
 *
 * @access    private
 */
 
function of_get_default_values() {
	$output = array();
	$config = optionsframework_options();
	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
			$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
		}
	}
	return $output;
}

/**
 * Agrega el menú Opciones del tema a la barra de administración.
 */
 
add_action( 'wp_before_admin_bar_render', 'optionsframework_adminbar' );

function optionsframework_adminbar() {
	
	global $wp_admin_bar;
	
	$wp_admin_bar->add_menu( array(
		'parent' => 'appearance',
		'id' => 'of_theme_options',
		'title' => __( 'Opciones del tema','optionsframework' ),
		'href' => admin_url( 'themes.php?page=options-framework' )
  ));
}

if ( ! function_exists( 'of_get_option' ) ) {

	/**
	 * Opción Get.
	 *
	 * Función de ayuda para obtener el valor de la opción del tema.
	 * Si no se establece un valor, regresa $default.
	 * Es necesario porque las opciones son guardadas como cadenas serializadas.
	 */
	 
	function of_get_option( $name, $default = false ) {
		$config = get_option( 'optionsframework' );

		if ( ! isset( $config['id'] ) ) {
			return $default;
		}

		$options = get_option( $config['id'] );

		if ( isset( $options[$name] ) ) {
			return $options[$name];
		}

		return $default;
	}
}