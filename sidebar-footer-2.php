<?php if ( is_active_sidebar( 'sidebar-footer-2' ) ):
	?>

	<div class="footer-widget-area  col-1<?php //echo $cols_number . '  ' . $column_width; ?>">
		<aside class="sidebar">
			<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
		</aside>
		<!-- .sidebar -->
	</div><!-- .grid__item -->
<?php endif;