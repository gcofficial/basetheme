<?php
/**
 * Fucking comments_template!!!
 * We need this hack 
 * because comments_teamplate function 
 * initializing wp_query->have_comments 
 * and have_comments() doesn't work without call comments_template()
 */
echo  \View\View::make('blocks/comments');