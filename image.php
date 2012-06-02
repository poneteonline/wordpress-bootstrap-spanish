<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						<header>
							
							<div class="page-header"><h1 class="single-title" itemprop="headline"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h1></div>
							
							<p class="meta"><?php _e("Publicado", "bonestheme"); ?> <time datetime="<?php echo the_time('F-j-Y'); ?>" pubdate><?php the_date(); ?></time> <?php _e("por", "bonestheme"); ?> <?php the_author_posts_link(); ?>.</p>
						
						</header> <!-- fin de la cabecera del artículo -->
					
						<section class="post_content clearfix" itemprop="articleBody">
							
							<!-- Para mostrar la imagen actual en la galería fotográfica -->
							<div class="attachment-img">
							      <a href="<?php echo wp_get_attachment_url($post->ID); ?>">
							      							      
							      <?php 
							      	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); 
							       
								      if ($image) : ?>
								          <img src="<?php echo $image[0]; ?>" alt="" />
								      <?php endif; ?>
							      
							      </a>
							</div>
							
							<!-- Para mostrar la miniatura de la anterior y próxima imagen en la galería fotográfica -->
							<ul id="gallery-nav" class="clearfix">
								<li class="next pull-left"><?php next_image_link() ?></li>
								<li class="previous pull-right"><?php previous_image_link() ?></li>
							</ul>
							
						</section> <!-- fin de la sección del artículo -->
						
						<footer>
			
							<?php the_tags('<p class="tags"><span class="tags-title">' . __("Etiquetas","bonestheme") . ':</span> ', ' ', '</p>'); ?>
							
						</footer> <!-- fin del pie del artículo -->
					
					</article> <!-- fin del artículo -->
					
					<?php comments_template(); ?>
					
					<?php endwhile; ?>			
					
					<?php else : ?>
					
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
				
				<div id="sidebar1" class="span4 fluid-sidebar sidebar" role="complementary">
				
					<?php if ( !empty($post->post_excerpt) ) { ?> 
					<p class="alert alert-block success"><?php echo get_the_excerpt(); ?></p>
					<?php } ?>
								
					<!-- Usando las funciones de WordPress para obtener la información EXIF extraída desde la base de datos -->
					<div class="well">
					
						<h3><?php _e("Meta-información de la imagen","bonestheme"); ?></h3>
					
					   <?php
					      $imgmeta = wp_get_attachment_metadata( $id );
					
					// Convierte la velocidad del obturador obtenida desde la base de datos en una fracción
					      if ((1 / $imgmeta['image_meta']['shutter_speed']) > 1)
					      {
					         if ((number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1)) == 1.3
					         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.5
					         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.6
					         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 2.5){
					            $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1, '.', '') . " second";
					         }
					         else{
					           $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 0, '.', '') . " second";
					         }
					      }
					      else{
					         $pshutter = $imgmeta['image_meta']['shutter_speed'] . " seconds";
					       }
					
					// Se inicia para mostrar la información EXIF e IPTC de la fotografía digital
					       echo __("Date Taken","bonestheme") . ": " . date("d-M-Y H:i:s", $imgmeta['image_meta']['created_timestamp'])."<br />";
					       echo __("Copyright","bonestheme") . ": " . $imgmeta['image_meta']['copyright']."<br />";
					       echo __("Credit","bonestheme") . ": " . $imgmeta['image_meta']['credit']."<br />";
					       echo __("Title","bonestheme") . ": " . $imgmeta['image_meta']['title']."<br />";
					       echo __("Caption","bonestheme") . ": " . $imgmeta['image_meta']['caption']."<br />";
					       echo __("Camera","bonestheme") . ": " . $imgmeta['image_meta']['camera']."<br />";
					       echo __("Focal Length","bonestheme") . ": " . $imgmeta['image_meta']['focal_length']."mm<br />";
					       echo __("Aperture","bonestheme") . ": f/" . $imgmeta['image_meta']['aperture']."<br />";
					       echo __("ISO","bonestheme") . ": " . $imgmeta['image_meta']['iso']."<br />";
					       echo __("Shutter Speed","bonestheme") . ": " . $pshutter . "<br />"
					   ?>
					</div>
					
				</div>
    
			</div> <!-- fin de #content -->

<?php get_footer(); ?>