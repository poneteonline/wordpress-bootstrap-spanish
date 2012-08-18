			<footer role="contentinfo">
			
				<div id="inner-footer" class="clearfix">
		          <hr />
		          <div id="widget-footer" class="clearfix row-fluid">
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer1') ) : ?>
		            <?php endif; ?>
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer2') ) : ?>
		            <?php endif; ?>
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer3') ) : ?>
		            <?php endif; ?>
		          </div>
					
					<nav class="clearfix">
						<?php bones_footer_links(); // Ajustar usando la opción Menús en el Administrador de Wordpress ?>
					</nav>
					
					<p class="pull-right"><a href="http://320press.com" id="credit320" title="Por los chicos de 320press">320press</a></p>
			
					<p class="attribution">&copy; <?php bloginfo('name'); ?></p>
				
				</div> <!-- fin #inner-footer -->
				
			</footer> <!-- fin pie de página -->
		
		</div> <!-- fin #container -->

		<!--[if lt IE 7 ]>
  			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
		
		<?php wp_footer(); // los scripts js están insertados usando esta función ?>

	</body>

</html>