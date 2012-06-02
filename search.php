<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">
				
					<div class="page-header"><h1><span><?php _e("Buscar resultados para","bonestheme"); ?>:</span> <?php echo esc_attr(get_search_query()); ?></h1></div>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
						<header>
							
							<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							
							<p class="meta"><?php _e("Publicado", "bonestheme"); ?> <time datetime="<?php echo the_time('F-j-Y'); ?>" pubdate><?php the_date(); ?></time> <?php _e("por", "bonestheme"); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php _e("archivado en", "bonestheme"); ?> <?php the_category(', '); ?>.</p>
						
						</header> <!-- fin de la cabecera del artículo -->
					
						<section class="post_content">
							<?php the_excerpt('<span class="read-more">' . __("Leer más sobre","bonestheme") . ' "'.the_title('', '', false).'" &raquo;</span>'); ?>
					
						</section> <!-- fin de la sección del artículo -->
						
						<footer>
					
							
						</footer> <!-- fin del pie del artículo -->
					
					</article> <!-- fin del artículoe -->
					
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
					
					<!-- esta área se muestra si no se encuentran resultados -->
					
					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("No se ha encontrado", "bonestheme"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Lo sentimos, pero el recurso solicitado no se ha encontrado en este sitio.", "bonestheme"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>
					
					<?php endif; ?>
			
				</div> <!-- fin de #main -->
    			
    			<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- fin de #content -->

<?php get_footer(); ?>