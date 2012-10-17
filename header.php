<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php bloginfo('name'); ?> <?php wp_title( '&raquo;', true, 'left'); ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- iconos & favicons -->
        <!-- Para iPhone 4 -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/h/apple-touch-icon.png">
        <!-- Para iPad 1-->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/m/apple-touch-icon.png">
        <!-- Para iPhone 3G, iPod Touch y Android -->
        <link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/l/apple-touch-icon-precomposed.png">
        <!-- Para Nokia -->
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/library/images/icons/l/apple-touch-icon.png">
        <!-- Para todo lo demás -->
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">

        <!-- media-queries.js (de reserva) -->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
        <![endif]-->

        <!-- html5.js -->
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link rel=”alternate” type=”*application/rss+xml” title=”Ponete Online Feed” href=”<?php bloginfo('rss2_url'); ?>” />
        <link rel="canonical" href="<?php the_permalink(); ?>"/>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="/css/docs.css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" type="text/css" href="/css/font-awesome.css" />

        <!-- funciones de la cabecera de wordpress -->
        <?php wp_head(); ?>
        <!-- fin de la cabecera de wordpress -->

        <!-- opciones del tema desde el panel de opciones  --> 
        <?php // get_wpbs_theme_options(); ?>

        <?php
        // comprueba el nivel del usuario wp
        get_currentuserinfo();
        // almacena para usar después
        global $user_level;

        // obtener la lista de los nombres de entrada para usarlos en el plugin 'typeahead' para la barra de búsqueda
        if (of_get_option('search_bar', '1')) { // solamente hacer esto si estamos mostrando la barra de búsqueda en la barra de navegación
            global $post;
            $tmp_post = $post;
            $get_num_posts = 40; // volver y obtener esta cantidad de títulos de entrada
            $args = array('numberposts' => $get_num_posts);
            $myposts = get_posts($args);
            $post_num = 0;

            global $typeahead_data;
            $typeahead_data = "[";

            foreach ($myposts as $post) : setup_postdata($post);
                $typeahead_data .= '"' . get_the_title() . '",';
            endforeach;

            $typeahead_data = substr($typeahead_data, 0, strlen($typeahead_data) - 1);

            $typeahead_data .= "]";

            $post = $tmp_post;
        } // terminar si la barra de búsqueda es usada
        ?>

    </head>

    <body <?php body_class(); ?> data-spy="scroll" data-target=".subnav" data-offset="50">

        <header role="banner">	
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <nav role="navigation">
                            <a class="brand" id="logo" title="<?php echo get_bloginfo('description'); ?>" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <div class="nav-collapse collapse">
<?php bones_main_nav(); // Ajusta usando Menús en el administrador de Wordpress  ?>
<?php if (of_get_option('search_bar', '1')) { ?>
                                    <form class="navbar-search pull-right" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                                        <input name="s" id="s" type="text" class="search-query" autocomplete="off" placeholder="<?php _e('Buscar', 'bonestheme'); ?>" data-provide="typeahead" data-items="7" data-source='<?php echo $typeahead_data; ?>' data-minLength="1">
                                    </form>
                                <?php } ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header> <!-- fin de la cabecera -->

        <div class="container-fluid">