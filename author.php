<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">
				
					<div class="page-header"><h1 class="archive_title h2">
						<span><?php _e("Entradas de:", "bonestheme"); ?></span> 
						<?php 
							// si el campo de perfil de google esta rellenado en el perfil del autor, enlaza la página del autor a su perfil en google+
							$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
							$google_profile = get_the_author_meta( 'google_profile', $curauth->ID );
							if ( $google_profile ) {
								echo '<a href="' . esc_url( $google_profile ) . '" rel="me">' . $curauth->display_name . '</a>'; 
						?>
						<?php 
							} else {
								echo get_the_author_meta('display_name', $curauth->ID);
							}
						?>
					</h1></div>
					
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
						<header>
							
							<h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							
							<p class="meta"><?php _e("Publicado", "bonestheme"); ?> <time datetime="<?php echo the_time('F-j-Y'); ?>" pubdate><?php the_date(); ?></time> <?php _e("por", "bonestheme"); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php _e("archivado en", "bonestheme"); ?> <?php the_category(', '); ?>.</p>
						
						</header> <!-- fin de la cabecera del artículo -->
					
						<section class="post_content">
						
							<?php the_post_thumbnail( 'wpbs-featured' ); ?>
						
							<?php the_excerpt(); ?>
					
						</section> <!-- fin de la sección del artículo -->
						
						<footer>
							
						</footer> <!-- fin del pie del artículo -->
					
					</article> <!-- fin del artículo -->
					
					<?php endwhile; ?>	
					
					<?php if (function_exists('page_navi')) { // si la característica experimental esta activa ?>
						
						<?php page_navi(); // usa la función de navegación de página ?>

					<?php } else { // si esta esta deshabitada, muestra los enlaces predeterminados anterior & siguiente de wp ?>
						<nav class="wp-prev-next">
							<ul class="clearfix">
								<li class="prev-link"><?php next_posts_link(_e('&laquo; Entradas antiguas', "bonestheme")) ?></li>
								<li class="next-link"><?php previous_posts_link(_e('Entradas recientes &raquo;', "bonestheme")) ?></li>
							</ul>
						</nav>
					<?php } ?>
								
					
					<?php else : ?>
					
					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("No existen entradas aún", "bonestheme"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Lo sentimos, lo que estás buscando no se encuentra aquí.", "bonestheme"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>
					
					<?php endif; ?>
			
				</div> <!-- fin de #mainn -->
    
				<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- fin de #content -->

<?php get_footer(); ?>