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
					
					<p class="pull-right"><a href="http://www.poneteonline.com.ar" id="credit320" title="Ponete Online"> </a></p>
			
					<p class="attribution">&copy; <?php bloginfo('name'); ?></p>
				
				</div> <!-- fin #inner-footer -->
				
			</footer> <!-- fin pie de página -->
		
		</div> <!-- fin #container -->

		<!--[if lt IE 7 ]>
  			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
  			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
		
		<?php wp_footer(); // los scripts js están insertados usando esta función ?>
<script src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/bootstrap-alert.js"></script>	
<script type="text/javascript" src="/js/bootstrap-button.js"></script>
<script type="text/javascript" src="/js/bootstrap-carousel.js"></script>
<script type="text/javascript" src="/js/bootstrap-collapse.js"></script>
<script type="text/javascript" src="/js/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="/js/bootstrap-popover.js"></script>
<script type="text/javascript" src="/js/bootstrap-scrollspy.js"></script>
<script type="text/javascript" src="/js/bootstrap-tab.js"></script>
<script type="text/javascript" src="/js/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="/js/bootstrap-transition.js"></script>
<script type="text/javascript" src="/js/bootstrap-typeahead.js"></script>
	</body>

</html>