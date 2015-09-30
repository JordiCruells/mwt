

                        </div>
                        <?php if (hasSecondarySidebar()) get_sidebar('secondary'); ?>
                    </div>
                </div>
            </div><footer class="mmb-footer"><?php get_sidebar('footer'); ?></footer>

    </div>
	

	</div>
	
    <p class="mmb-page-footer">
        <span id="mmb-footnote-links">Funciona amb el <a href="http://wordpress.org/" target="_blank">WordPress</a></a> </span>
    </p>
</div>


<div id="wp-footer">
	<?php wp_footer(); ?>
	<!-- <?php printf(__('%d queries. %s seconds.', THEME_NS), get_num_queries(), timer_stop(0, 3)); ?> -->
</div>
</body>
</html>

