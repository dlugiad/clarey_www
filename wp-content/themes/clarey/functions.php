<?php
// Load up our awesome theme options
require_once ( get_stylesheet_directory() . '/theme-options.php' );

// hide wordpress version --- required for sequrity ---
function hide_version() {
    return '';
}

add_filter('the_generator', 'hide_version');

remove_action('wp_head', 'wp_generator');
// END wordpress version

// enable auto update for plugins
add_filter( 'auto_update_plugin', '__return_true' );

// disable error reporting --- required for sequrity ---
error_reporting (0);
@ini_set ('display_errors', 0);
// END disable error reporting

// disable login error reporting --- required for sequrity ---
add_filter('login_errors',create_function('$a', "return null;"));
// end disable login error reporting

// disable xml-rpc --- required for sequrity ---
add_filter('xmlrpc_enabled', '__return_false');
// end disable xml-rpc


/*rejestracja menu*/
function register_my_menus(){
  register_nav_menus(
    array(
      'footer_first' => __('Menu w stopce 1', 'clarey'),
      'footer_second' => __('Menu w stopce 2', 'clarey'),
      'footer_third' => __('Menu w stopce 3', 'clarey'),
      'footer_fourth' => __('Menu w stopce 4', 'clarey'),
      )
  );
}
add_action('init','register_my_menus');

// Aktywacja miniaturek
add_theme_support( 'post-thumbnails' );

// Limit znaków przycięcia funkcji excerpt
function custom_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Link czytaj więcej w funkcji excerpt
function new_excerpt_more($more) {
       global $post;
	return ' <a href="'. get_permalink($post->ID) . '" class="button-calc">Czytaj więcej</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

//MENU bs
function theboot_menu_user() {
     wp_nav_menu(
       array('theme_location' => 'main-menu',
       'menu' => 'menu_user',
       'menu_class' => 'nav navbar-nav navbar-left',
       'theme_location' => 'menu_user',
       'container' => 'false',
       'fallback_cb' => 'theboot_main_nav_fallback',
       'depth' => '3',
       'walker' => new Bootstrap_Walker()
       )
     );
}

function theboot_menu_user_fallback() {

}


?><?php 
    /* Bootstrap_Walker for Wordpress 
     * Author: George Huger, Illuminati Karate, Inc 
     * More referencje: http://illuminatikarate.com/blog/bootstrap-walker-for-wordpress 
     * 
     * Formats a Wordpress menu to be used as a Bootstrap dropdown menu (http://getbootstrap.com). 
     * 
     * Specifically, it makes these changes to the normal Wordpress menu output to support Bootstrap: 
     * 
     *        - adds a 'dropdown' class to level-0 <li>'s which contain a dropdown 
     *         - adds a 'dropdown-submenu' class to level-1 <li>'s which contain a dropdown 
     *         - adds the 'dropdown-menu' class to level-1 and level-2 <ul>'s 
     * 
     * Supports menus up to 3 levels deep. 
     *  
     */ 
    class Bootstrap_Walker extends Walker_Nav_Menu 
    {     
     
        /* Start of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function start_lvl(&$output, $depth) 
        {
            $tabs = str_repeat("\t", $depth); 
            // If we are about to start the first submenu, we need to give it a dropdown-menu class 
            if ($depth == 0 || $depth == 1) { //really, level-1 or level-2, because $depth is misleading here (see note above) 
                $output .= "\n{$tabs}<ul class=\"dropdown-menu\">\n"; 
            } else { 
                $output .= "\n{$tabs}<ul>\n"; 
            } 
            return;
        } 
         
        /* End of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function end_lvl(&$output, $depth)  
        {
            if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!) 
                 
                // we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now 
                $output .= '<!--.dropdown-->'; 
            } 
            $tabs = str_repeat("\t", $depth); 
            $output .= "\n{$tabs}</ul>\n"; 
            return; 
        }
                 
        /* Output the <li> and the containing <a> 
         * Note: $depth is "correct" at this level 
         */         
        function start_el(&$output, $item, $depth, $args)  
        {    
            global $wp_query; 
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : ''; 
            $class_names = $value = ''; 
            $classes = empty( $item->classes ) ? array() : (array) $item->classes; 

            /* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */ 
            if ($item->hasChildren) { 
                $classes[] = 'dropdown'; 
                // level-1 menus also need the 'dropdown-submenu' class 
                if($depth == 1) { 
                    $classes[] = 'dropdown-submenu'; 
                } 
            } 

            /* This is the stock Wordpress code that builds the <li> with all of its attributes */ 
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ); 
            $class_names = ' class="' . esc_attr( $class_names ) . '"'; 
            $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';             
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ''; 
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : ''; 
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : ''; 
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
            $item_output = $args->before; 
                         
            /* If this item has a dropdown menu, make clicking on this link toggle it */ 
            if ($item->hasChildren && $depth == 0) { 
                $item_output .= '<a'. $attributes .' class="dropdown-toggle disabled" data-toggle="dropdown">'; 
            } else { 
                $item_output .= '<a'. $attributes .'>'; 
            } 
             
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after; 

            /* Output the actual caret for the user to click on to toggle the menu */             
            if ($item->hasChildren && $depth == 0) { 
                $item_output .= '<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>'; 
            } else { 
                $item_output .= '</a>'; 
            } 

            $item_output .= $args->after; 
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); 
            return; 
        }
        
        /* Close the <li> 
         * Note: the <a> is already closed 
         * Note 2: $depth is "correct" at this level 
         */         
        function end_el (&$output, $item, $depth, $args)
        {
            $output .= '</li>'; 
            return;
        } 
         
        /* Add a 'hasChildren' property to the item 
         * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633  
         */ 
        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) 
        { 
            // check whether this item has children, and set $item->hasChildren accordingly 
            $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]); 

            // continue with normal behavior 
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); 
        }         
    } 
    //CF7
    add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );
    function my_deregister_javascript() {
        wp_deregister_script( 'contact-form-7' );
    }

//portfolio

    add_action('init', 'project_custom_init');  
 
/*-- Custom Post Init Begin --*/
function project_custom_init()
{
  $labels = array(
    'name' => _x('Slajdy', 'post type general name'),
    'singular_name' => _x('Slajd', 'post type singular name'),
    'add_new' => _x('Dodaj nowy', 'project'),
    'add_new_item' => __('Dodaj nowy slajd'),
    'edit_item' => __('Edytuj slajd'),
    'new_item' => __('Nowy Slider'),
    'view_item' => __('Zobacz slajder'),
    'search_items' => __('Szukaj'),
    'not_found' =>  __('Nie znaleziono'),
    'not_found_in_trash' => __('Nie znaleziono w koszu'),
    'parent_item_colon' => '',
    'menu_name' => 'Slider'
 
  );
   
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments')
  );
  // The following is the main step where we register the post.
  register_post_type('project',$args);
   
  // Initialize New Taxonomy Labels
  $labels = array(
    'name' => _x( 'Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Types' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => __( 'Parent Tag' ),
    'parent_item_colon' => __( 'Parent Tag:' ),
    'edit_item' => __( 'Edit Tags' ),
    'update_item' => __( 'Update Tag' ),
    'add_new_item' => __( 'Add New Tag' ),
    'new_item_name' => __( 'New Tag Name' ),
  );
    // Custom taxonomy for Project Tags
    register_taxonomy('tagportfolio',array('project'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tag-portfolio' ),
  ));
   
}
/*-- Custom Post Init Ends --*/

/*--- Custom Messages - project_updated_messages ---*/
add_filter('post_updated_messages', 'project_updated_messages');
 
function project_updated_messages( $messages ) {
  global $post, $post_ID;
 
  $messages['project'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Project updated. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Project updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Project published. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Project saved.'),
    8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
 
  return $messages;
}
 
/*--- #end SECTION - project_updated_messages ---*/

/*--- Demo URL meta box ---*/
 
// add_action('admin_init','portfolio_meta_init');
 
// function portfolio_meta_init()
// {
//     // add a meta box for WordPress 'project' type
//     add_meta_box('portfolio_meta', 'Project referencjes', 'portfolio_meta_setup', 'project', 'side', 'low');
  
//     // add a callback function to save any data a user enters in
//     add_action('save_post','portfolio_meta_save');
// }
 
function portfolio_meta_setup()
{
    global $post;
      
    ?>
        <div class="portfolio_meta_control">
            <label>URL</label>
            <p>
                <input type="text" name="_url" value="<?php echo get_post_meta($post->ID,'_url',TRUE); ?>" style="width: 100%;" />
            </p>
        </div>
    <?php
 
    // create for validation
    echo '<input type="hidden" name="meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
 
function portfolio_meta_save($post_id) 
{
    // check nonce
    if (!isset($_POST['meta_noncename']) || !wp_verify_nonce($_POST['meta_noncename'], __FILE__)) {
    return $post_id;
    }
 
    // check capabilities
    if ('post' == $_POST['post_type']) {
    if (!current_user_can('edit_post', $post_id)) {
    return $post_id;
    }
    } elseif (!current_user_can('edit_page', $post_id)) {
    return $post_id;
    }
 
    // exit on autosave
    if (defined('DOING_AUTOSAVE') == DOING_AUTOSAVE) {
    return $post_id;
    }
 
    if(isset($_POST['_url'])) 
    {
        update_post_meta($post_id, '_url', $_POST['_url']);
    } else
    {
        delete_post_meta($post_id, '_url');
    }
}



//referencje-custom post type

    add_action('init', 'referencje_custom_init');  
 
/*-- Custom Post Init Begin --*/
function referencje_custom_init()
{
  $labels = array(
    'name' => _x('Referencje', 'post type general name'),
    'singular_name' => _x('Referencje', 'post type singular name'),
    'add_new' => _x('Dodaj nową', 'referencje'),
    'add_new_item' => __('Dodaj nową referencje'),
    'edit_item' => __('Edytuj referencje'),
    'new_item' => __('Nowa referencja'),
    'view_item' => __('Zobacz referencje'),
    'search_items' => __('Szukaj'),
    'not_found' =>  __('Nie znaleziono'),
    'not_found_in_trash' => __('Nie znaleziono w koszu'),
    'parent_item_colon' => '',
    'menu_name' => 'Referencje'
 
  );
   
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments')
  );
  // The following is the main step where we register the post.
  register_post_type('referencje',$args);
   
  // Initialize New Taxonomy Labels
  // $labels = array(
  //   'name' => _x( 'Tags', 'taxonomy general name' ),
  //   'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
  //   'search_items' =>  __( 'Search Types' ),
  //   'all_items' => __( 'All Tags' ),
  //   'parent_item' => __( 'Parent Tag' ),
  //   'parent_item_colon' => __( 'Parent Tag:' ),
  //   'edit_item' => __( 'Edit Tags' ),
  //   'update_item' => __( 'Update Tag' ),
  //   'add_new_item' => __( 'Add New Tag' ),
  //   'new_item_name' => __( 'New Tag Name' ),
  // );
    // Custom taxonomy for referencje Tags
  //   register_taxonomy('tagreferencje',array('referencje'), array(
  //   'hierarchical' => true,
  //   'labels' => $labels,
  //   'show_ui' => true,
  //   'query_var' => true,
  //   'rewrite' => array( 'slug' => 'tag-referencje' ),
  // ));
   
}
/*-- Custom Post Init Ends --*/

/*--- Custom Messages - referencje_updated_messages ---*/
add_filter('post_updated_messages', 'referencje_updated_messages');
 
function referencje_updated_messages( $messages ) {
  global $post, $post_ID;
 
  $messages['referencje'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('referencje updated. <a href="%s">View referencje</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('referencje updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('referencje restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('referencje published. <a href="%s">View referencje</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('referencje saved.'),
    8 => sprintf( __('referencje submitted. <a target="_blank" href="%s">Preview referencje</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('referencje scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview referencje</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('referencje draft updated. <a target="_blank" href="%s">Preview referencje</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
 
  return $messages;
}
 
/*--- #end SECTION - referencje_updated_messages ---*/

/*--- Demo URL meta box ---*/
 
// add_action('admin_init','referencje_meta_init');
 
// function referencje_meta_init()
// {
//     // add a meta box for WordPress 'referencje' type
//     add_meta_box('referencje_meta', 'referencje referencjes', 'referencje_meta_setup', 'referencje', 'side', 'low');
  
//     // add a callback function to save any data a user enters in
//     add_action('save_post','referencje_meta_save');
// }
 
function referencje_meta_setup()
{
    global $post;
      
    ?>
        <div class="referencje_meta_control">
            <label>URL</label>
            <p>
                <input type="text" name="_url" value="<?php echo get_post_meta($post->ID,'_url',TRUE); ?>" style="width: 100%;" />
            </p>
        </div>
    <?php
 
    // create for validation
    echo '<input type="hidden" name="meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
 
function referencje_meta_save($post_id) 
{
    // check nonce
    if (!isset($_POST['meta_noncename']) || !wp_verify_nonce($_POST['meta_noncename'], __FILE__)) {
    return $post_id;
    }
 
    // check capabilities
    if ('post' == $_POST['post_type']) {
    if (!current_user_can('edit_post', $post_id)) {
    return $post_id;
    }
    } elseif (!current_user_can('edit_page', $post_id)) {
    return $post_id;
    }
 
    // exit on autosave
    if (defined('DOING_AUTOSAVE') == DOING_AUTOSAVE) {
    return $post_id;
    }
 
    if(isset($_POST['_url'])) 
    {
        update_post_meta($post_id, '_url', $_POST['_url']);
    } else
    {
        delete_post_meta($post_id, '_url');
    }
}

//cennik

    add_action('init', 'cennik_custom_init');  
 
/*-- Custom Post Init Begin --*/
function cennik_custom_init()
{
  $labels = array(
    'name' => _x('cennik', 'post type general name'),
    'singular_name' => _x('cennik', 'post type singular name'),
    'add_new' => _x('Dodaj nowy', 'cennik'),
    'add_new_item' => __('Dodaj nowy cennik'),
    'edit_item' => __('Edytuj cennik'),
    'new_item' => __('Nowy Cennik'),
    'view_item' => __('Zobacz cennik'),
    'search_items' => __('Szukaj'),
    'not_found' =>  __('Nie znaleziono'),
    'not_found_in_trash' => __('Nie znaleziono w koszu'),
    'parent_item_colon' => '',
    'menu_name' => 'Cennik'
 
  );
   
 $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments')
  );
  // The following is the main step where we register the post.
  register_post_type('cennik',$args);
   
   
}
/*-- Custom Post Init Ends --*/

/*--- Custom Messages - cennik_updated_messages ---*/
add_filter('post_updated_messages', 'cennik_updated_messages');
 
function cennik_updated_messages( $messages ) {
  global $post, $post_ID;
 
  $messages['cennik'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('cennik updated. <a href="%s">View cennik</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('cennik updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('cennik restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('cennik published. <a href="%s">View cennik</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('cennik saved.'),
    8 => sprintf( __('cennik submitted. <a target="_blank" href="%s">Preview cennik</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('cennik scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview cennik</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('cennik draft updated. <a target="_blank" href="%s">Preview cennik</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
 
  return $messages;
}
 
/*--- #end SECTION - cennik_updated_messages ---*/

/*--- Demo URL meta box ---*/
 
// add_action('admin_init','cenniksy_meta_init');
 
// function cenniksy_meta_init()
// {
//     // add a meta box for WordPress 'cennik' type
//     add_meta_box('cenniksy_meta', 'cennik referencjes', 'cenniksy_meta_setup', 'cennik', 'side', 'low');
  
//     // add a callback function to save any data a user enters in
//     add_action('save_post','cenniksy_meta_save');
// }
 
function cenniksy_meta_setup()
{
    global $post;
      
    ?>
        <div class="cenniksy_meta_control">
            <label>URL</label>
            <p>
                <input type="text" name="_url" value="<?php echo get_post_meta($post->ID,'_url',TRUE); ?>" style="width: 100%;" />
            </p>
        </div>
    <?php
 
    // create for validation
    echo '<input type="hidden" name="meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
 
function cenniksy_meta_save($post_id) 
{
    // check nonce
    if (!isset($_POST['meta_noncename']) || !wp_verify_nonce($_POST['meta_noncename'], __FILE__)) {
    return $post_id;
    }
 
    // check capabilities
    if ('post' == $_POST['post_type']) {
    if (!current_user_can('edit_post', $post_id)) {
    return $post_id;
    }
    } elseif (!current_user_can('edit_page', $post_id)) {
    return $post_id;
    }
 
    // exit on autosave
    if (defined('DOING_AUTOSAVE') == DOING_AUTOSAVE) {
    return $post_id;
    }
 
    if(isset($_POST['_url'])) 
    {
        update_post_meta($post_id, '_url', $_POST['_url']);
    } else
    {
        delete_post_meta($post_id, '_url');
    }
}


//shortcodes

function triple_divider_green_function() {
   return '     <div class="row">
        <div class="triple-divider">
          <div class="width-35 dark-grey"></div>
          <div class="width-30 light-grey"></div>
          <div class="width-35 bg-green"></div>
        </div>
      </div>';
}
add_shortcode('triple_divider_green', 'triple_divider_green_function');

function triple_divider_green_short_function() {
   return '     <div class="container_full_disp">
        <div class="triple-divider">
          <div class="width-35 dark-grey"></div>
          <div class="width-30 light-grey"></div>
          <div class="width-35 bg-green"></div>
        </div>
      </div>';
}
add_shortcode('triple_divider_green_short', 'triple_divider_green_short_function');

function triple_divider_green_hidden_function() {
   return '     <div class="row">
        <div class="triple-divider hidden-xs hidden-sm">
          <div class="width-35 dark-grey"></div>
          <div class="width-30 light-grey"></div>
          <div class="width-35 bg-green"></div>
        </div>
      </div>';
}
add_shortcode('triple_divider_green_hidden', 'triple_divider_green_hidden_function');

function triple_divider_orange_function() {
   return '     <div class="row">
        <div class="triple-divider">
          <div class="width-35 dark-grey"></div>
          <div class="width-30 light-grey"></div>
          <div class="width-35 bg-orange"></div>
        </div>
      </div>';
}
add_shortcode('triple_divider_orange', 'triple_divider_orange_function');

function grey_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-header text-center">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('grey_divider_with_text', 'grey_divider_with_text_function');

function dark_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-dark text-left pad-385">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('dark_divider_with_text', 'dark_divider_with_text_function');

function coral_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-coral text-center">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('coral_divider_with_text', 'coral_divider_with_text_function');

function coral_divider_with_text_short_function( $atts, $content = null ) {
   return '<div class="container_full_disp">
      <h2 class="step-coral text-center">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('coral_divider_with_text_short', 'coral_divider_with_text_short_function');

function orange_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-orange text-left pad-385">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('orange_divider_with_text', 'orange_divider_with_text_function');

function blue_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-blue text-center">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('blue_divider_with_text', 'blue_divider_with_text_function');

function blue_left_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-blue text-left pad-385">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('blue_left_divider_with_text', 'blue_left_divider_with_text_function');

function green_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-green text-center">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('green_divider_with_text', 'green_divider_with_text_function');

function coral_divider_with_text_know_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-coral text-center hidden-xs">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('coral_divider_with_text_know', 'coral_divider_with_text_know_function');

function green_divider_with_text_know_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-green text-center hidden-xs">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('green_divider_with_text_know', 'green_divider_with_text_know_function');

function grey2_divider_with_text_function( $atts, $content = null ) {
   return '<div class="row">
      <h2 class="step-grey text-center">'.do_shortcode($content).'</h2>
      </div>';
}
add_shortcode('grey2_divider_with_text', 'grey2_divider_with_text_function');

function main_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h2_txt" => '',
      "h3_txt" => '',
      "paragraf_txt" => '',
      "button_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "additional_class" => 'col-sm-7',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 main-banner" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.'">
                <h2 class="color-'.$main_color.'">'.$h2_txt.'</h2>
                <h3>'.$h3_txt.'</h3>
                <p>'.$paragraf_txt.'</p>
                <a href="'.$btn_link.'" class="button button-'.$btn_color.'">'.$button_txt.'</a>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("main_section", "main_section_function");

function only_button_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "button_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "additional_class" => 'col-sm-7',
      "btn_link" => '#',
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 button-center">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.'">
                <a href="'.$btn_link.'" class="button button-'.$btn_color.'">'.$button_txt.'</a>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("only_button", "only_button_function");

function main_section_contact_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h2_txt" => '',
      "h3_txt" => '',
      "paragraf_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-7',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 main-banner-contact" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.'">
                <h2 class="color-'.$main_color.'">'.$h2_txt.'</h2>
                <h3>'.$h3_txt.'</h3>
                <p>'.$paragraf_txt.'</p>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';                                                                                                                                                                                                             
}
add_shortcode("main_section_contact", "main_section_contact_function");

function know1_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h1_txt" => '',
      "h2_txt" => '',
      "h3_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 check-1" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.' pad-35 col-xs-12">
                <h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
                <h2>'.$h2_txt.'</h2>
                <p>'.$h3_txt.'</p>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("know1_section", "know1_section_function");

function know2_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h1_txt" => '',
      "h2_txt" => '',
      "h3_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-xs-offset-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="check-2 hidden-sm hidden-xs" style="background-image: url('.$bgimage_link.');">
          <div class="container"> 
            <div class="row">
              <div class="'.$additional_class.'">
                <h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
                <h2>'.$h2_txt.'</h2>
                <p>'.$h3_txt.'</p>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("know2_section", "know2_section_function");

function know3_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h2_txt" => '',
      "h3_txt" => '',
      "h1_txt" => '',
      "button_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "additional_class" => 'col-sm-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 check-3" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.' pad-35 col-xs-12">
                <h2>'.$h2_txt.'</h2>
                <p>'.$h3_txt.'</p>
                <h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
                <a href="'.$btn_link.'" class="button button-'.$btn_color.'">'.$button_txt.'</a>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("know3_section", "know3_section_function");

function know4_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h3_txt" => '',
      "h1_txt" => '',
      "h2_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-xs-offset-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="check-4 hidden-sm hidden-xs" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="'.$additional_class.'">
                <p>'.$h3_txt.'</p>
                <h1 class="color-green">'.$h1_txt.'</h1>
                <h2>'.$h2_txt.'</h2>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("know4_section", "know4_section_function");

function know5_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h3_txt" => '',
      "h2_txt" => '',
      "h1_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-7',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 check-5" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.' pad-35 col-xs-12">
                <p>'.$h3_txt.'</p>
                <h2>'.$h2_txt.'</h2>
                <h1 class="color-coral">'.$h1_txt.'</h1>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("know5_section", "know5_section_function");

function know6_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h2_txt" => '',
      "h3_txt" => '',
      "h1_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-xs-offset-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="check-6 hidden-sm hidden-xs" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="'.$additional_class.'">
                <h2>'.$h3_txt.'</h2>
                <p>'.$h2_txt.'</p>
                <h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("know6_section", "know6_section_function");

function start1_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h1_txt" => '',
      "h3_txt" => '',
      "h2_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row bg-image-start1">
        <div class="col-xs-12 check-1" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.' pad-35 col-xs-12">
                <h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
                <p>'.$h3_txt.'</p>
				<h2>'.$h2_txt.'</h2>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("start1_section", "start1_section_function");

function start2_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h3_txt" => '',
      "h2_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-12',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row bg-image-start2">
        <div class="col-xs-12 start-2" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.' pad-35 col-xs-12">
				<h2>'.$h2_txt.'</h2>
                <p>'.$h3_txt.'</p>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("start2_section", "start2_section_function");

function start3_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h2_txt" => '',
      "h3_txt" => '',
      "h1_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 check-3" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.' pad-35 col-xs-12">
                <h2>'.$h2_txt.'</h2>
                <p>'.$h3_txt.'</p>
                <h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("start3_section", "start3_section_function");

function start4_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h3_txt" => '',
      "h1_txt" => '',
      "h2_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-xs-offset-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="check-4 hidden-sm hidden-xs" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="'.$additional_class.'">
                <p>'.$h3_txt.'</p>
                <h1 class="color-coral">'.$h1_txt.'</h1>
                <h2>'.$h2_txt.'</h2>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("start4_section", "start4_section_function");

function start5_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h3_txt" => '',
      "h2_txt" => '',
      "h1_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-7',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 check-5" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.' pad-35 col-xs-12">
                <p>'.$h3_txt.'</p>
                <h2>'.$h2_txt.'</h2>
                <h1 class="color-coral">'.$h1_txt.'</h1>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("start5_section", "start5_section_function");


function check_1_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h1_txt" => '',
      "h2_txt" => '',
      "h3_txt" => '',
      "h4_txt" => '',
      "h7_txt" => '',
      "paragraf_txt" => '',
      "button_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "additional_class" => 'col-sm-7',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 check-1" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.'">
                <h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
                <h7>'.$h7_txt.'</h7>
				<h3>'.$h3_txt.'</h3>
                <p>'.$paragraf_txt.'</p>
                <a href="'.$btn_link.'" class="button button-'.$btn_color.'">'.$button_txt.'</a>
              </div>                                                                                                                                                                                                                    
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("check_1", "check_1_function");

function numbers_section_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h3_txt_1" => '',
      "p_txt_1" => '',
      "strong_txt_1" => '',
      "h3_txt_2" => '',
      "p_txt_2" => '',
      "strong_txt_2" => '',
      "h3_txt_3" => '',
      "p_txt_3" => '',
      "strong_txt_3" => '',
      "h3_txt_4" => '',
      "p_txt_4" => '',
      "strong_txt_4" => '',
      "type" => '',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row visible-lg">
        <div class="step-content '.$type.'">
          <div class="numbers visible-lg">
            <img src="'.$bgimage_link.'" alt="">
          </div>
          <div class="container">
            <div class="row">
              <div class="step-1">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/one_1_small.png"></span>
		<h3>'.$h3_txt_1.'</h3>
                <p>'.$p_txt_1.'</p>
                <p><strong>'.$strong_txt_1.'</strong></p>
              </div>
              <div class="step-2">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/two_2_small.png"></span>               
		<h3>'.$h3_txt_2.'</h3>
                <p>'.$p_txt_2.'</p>
                <p><strong>'.$strong_txt_2.'</strong></p>
              </div>
            </div>
            <div class="row">
              <div class="step-3">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/three_3_small.png"></span>
                <h3>'.$h3_txt_3.'</h3>
                <p>'.$p_txt_3.'</p>
                <p><strong>'.$strong_txt_3.'</strong></p>
              </div>
            <div class="step-4">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/four_4_small.png"></span>
                <h3>'.$h3_txt_4.'</h3>
                <p>'.$p_txt_4.'</p>
                <p><strong>'.$strong_txt_4.'</strong></p>
              </div>
            </div>
          </div>  
        </div>
      </div>
      <div class="row hidden-lg">
        <div class="step-content '.$type.'">
          <div class="container">
            <div class="row">
              <div class="step-1">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/one_1_small.png"></span>
		<h3>'.$h3_txt_1.'</h3>
                <p>'.$p_txt_1.'</p>
                <p><strong>'.$strong_txt_1.'</strong></p>
              </div>
              <div class="step-2">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/two_2_small.png"></span>
                <h3>'.$h3_txt_3.'</h3>
                <p>'.$p_txt_3.'</p>
                <p><strong>'.$strong_txt_3.'</strong></p>
              </div>
            </div>
            <div class="row">
              <div class="step-3">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/three_3_small.png"></span>
                <h3>'.$h3_txt_4.'</h3>
                <p>'.$p_txt_4.'</p>
                <p><strong>'.$strong_txt_4.'</strong></p>
              </div>
            <div class="step-4">
                <span class="hidden-lg-inline"><img src="wp-content/uploads/2017/06/four_4_small.png"></span>
                <h3>'.$h3_txt_2.'</h3>
                <p>'.$p_txt_2.'</p>
                <p><strong>'.$strong_txt_2.'</strong></p>
              </div>
            </div>
          </div>  
        </div>
      </div>';
}
add_shortcode("numbers_section", "numbers_section_function");

function sm_links_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "small_txt" => '',
      "big_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "btn_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
          <div class="container">
         <img src="wp-content/uploads/2017/06/one_1_small.png">   
        </div>
      </div>';
}
add_shortcode("sm_links", "sm_links_function");

function bgimage_caption_top_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "small_txt" => '',
      "big_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "btn_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-2" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-4">
                <div class="image-caption">
                  <p class="small">'.$small_txt.'</p>
                  <p class="big">'.$big_txt.'</span></p>
                </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$btn_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_top", "bgimage_caption_top_function");

function bgimage_caption_contact_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "big_txt" => '',
      "small_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "btn_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-contact" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-4">
                <div class="image-caption">
                  <p class="big">'.$big_txt.'</p>
                  <p class="small">'.$small_txt.'</span></p>
                </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$btn_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_contact", "bgimage_caption_contact_function");

function bgimage_caption_about_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "small_txt" => '',
      "xsmall_txt" => '',
      "big_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "btn_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-about" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-4">
                <div class="image-caption">
                  <p class="small">'.$small_txt.'</p>
                  <p class="xsmall">'.$xsmall_txt.'</p>
                  <p class="big">'.$big_txt.'</span></p>
                </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$btn_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_about", "bgimage_caption_about_function");

function bgimage_caption_1_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "big_txt" => '',
      "normal_txt" => '',
      "small_txt" => '',
      "xsmall_txt" => '',
      "xxsmall_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "btn_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-check1" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-md-4 col-sm-6">
                <div class="image-caption">
                  <p class="big">'.$big_txt.'</p>
				  <p class="normal">'.$normal_txt.'</p>
                  <p class="small">'.$small_txt.'</p>
                  <p class="xsmall">'.$xsmall_txt.'</p>
                  <p class="xxsmall">'.$xxsmall_txt.'</span></p>
                </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$btn_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_1", "bgimage_caption_1_function");

function bgimage_caption_stripe_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "main_color" => '',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-stripe" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-1">
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$btn_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_stripe", "bgimage_caption_stripe_function");

function bgimage_caption_2_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "big_txt" => '',
      "small_txt" => '',
      "xsmall_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "btn_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-check2" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-1">
                <div class="image-caption">
                  <p class="big">'.$big_txt.'</p>
                  <p class="small">'.$small_txt.'</p>
                  <p class="xsmall">'.$xsmall_txt.'</span></p>
			    </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$btn_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_2", "bgimage_caption_2_function");

function bgimage_caption_3_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "xsmall_txt" => '',
	  "big_txt" => '',
      "small_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "button_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-check3" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-1">
                <div class="image-caption">
				  <p class="xsmall">'.$xsmall_txt.'</p>
                  <p class="big">'.$big_txt.'</p>
				  <p class="small">'.$small_txt.'</span></p>
			    </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$button_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_3", "bgimage_caption_3_function");

function bgimage_caption_4_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "xsmall_txt" => '',
	  "big_txt" => '',
      "small_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "button_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-check4" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-1">
                <div class="image-caption">
				  <p class="xsmall">'.$xsmall_txt.'</p>
                  <p class="big">'.$big_txt.'</p>
				  <p class="small">'.$small_txt.'</span></p>
			    </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$button_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_4", "bgimage_caption_4_function");

function bgimage_caption_5_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "xsmall_txt" => '',
	  "normal_txt" => '',
      "small_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "button_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-check5" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-1">
                <div class="image-caption">
				  <p class="xsmall">'.$xsmall_txt.'</p>
                  <p class="normal">'.$normal_txt.'</p>
				  <p class="small">'.$small_txt.'</span></p>
			    </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$button_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_5", "bgimage_caption_5_function");

function bgimage_caption_6_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "xsmall_txt" => '',
	  "normal_txt" => '',
      "small_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "button_txt" => '',
      "btn_link" => '#',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-check6" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-1">
                <div class="image-caption">
				  <p class="xsmall">'.$xsmall_txt.'</p>
                  <p class="normal">'.$normal_txt.'</p>
				  <p class="small">'.$small_txt.'</span></p>
			    </div>
              </div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$button_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_6", "bgimage_caption_6_function");

function bgimage_caption_pricelist_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h2_txt" => '',
      "h3_txt" => '',
      "h1_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-6', 
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="col-xs-12 main-banner-pricelist" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="'.$additional_class.'">
                <h2 class="color-'.$main_color.'">'.$h2_txt.'</h2>
                <h3>'.$h3_txt.'</h3>
                <h1>'.$h1_txt.'</h1>
              </div>                                                                                                                                                                                                         
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_pricelist", "bgimage_caption_pricelist_function");

function bgimage_caption_center_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "small_txt" => '',
      "big_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "btn_txt" => '',
      "btn_link" => '',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-center" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-4">
                <div class="image-caption">
                  <p class="small">'.$small_txt.'</p>
                  <p class="big">'.$big_txt.'</span></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 col-sm-offset-6">
                <a href="'.$btn_link.'" class="button button-'.$btn_color.'">'.$btn_txt.'</a>
              </div>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_center", "bgimage_caption_center_function");

function bgimage_center_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "bgimage_link" => ''
   ), $atts));
   return '<div class="container_full_disp">
		<div class="bg-image-resp" style="background-image: url('.$bgimage_link.');">
		</div>
	</div>';
}
add_shortcode("bgimage_center", "bgimage_center_function");

function bgimage_center2_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
		<div class="bg-image-resp2" style="background-image: url('.$bgimage_link.');">
		</div>
	</div>';
}
add_shortcode("bgimage_center2", "bgimage_center2_function");

function bgimage_center3_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "bgimage_link" => ''
   ), $atts));
   return '<div class="bg-image-resp3" style="background-image: url('.$bgimage_link.');">
      </div>';
}
add_shortcode("bgimage_center3", "bgimage_center3_function");

function bgimage_caption_center_check1_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "small_txt" => '',
      "big_txt" => '',
      "main_color" => '',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-center-check1" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-sm col-sm-8 col-sm-offset-6">
                <div class="image-caption-check1">
                  <p class="small">'.$small_txt.'</p>
                  <p class="big">'.$big_txt.'</span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_center_check1", "bgimage_caption_center_check1_function");

function bgimage_caption_bottom_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "small_txt" => '',
      "big_txt" => '',
      "main_color" => '',
      "btn_color" => '',
      "button_txt" => '',
      "btn_link" => '#',
      "additional_class" => 'col-sm-8',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-3" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class=" '.$additional_class.'">

                <div class="image-caption">
                  <p class="small">'.$small_txt.'</p>
                  <p class="big">'.$big_txt.'</p>
                </div>

</div>
            </div>
            <div class="row">
              <a href="'.$btn_link.'" class="button center button-'.$btn_color.'">'.$button_txt.'</a>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_caption_bottom", "bgimage_caption_bottom_function");

function double_divider_with_text_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "left_txt" => '',
      "right_txt" => '',
      "main_color" => '',
   ), $atts));
   return '<div class="row overflow-hidden">
        <div class="double-divider divider-with-text container">
          <div class="col-sm-6 dark-grey">
            <p>'.$left_txt.'</p>
          </div>
          <div class="col-sm-6 bg-'.$main_color.'">
            <p>'.$right_txt.'</p>
          </div>
          <div class="colors">
            <div class="dark-grey"></div>
            <div class="bg-'.$main_color.'"></div>
          </div>
        </div>
      </div>';
}
add_shortcode("double_divider_with_text", "double_divider_with_text_function");

function double_divider_with_text_contact_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "left_txt" => '',
      "right_txt" => '',
      "main_color" => '',
   ), $atts));
   return '<div class="row overflow-hidden">
        <div class="double-divider divider-with-text container">
              
          <div class="col-sm-6 dark-grey">
            <p>'.$left_txt.'</p>
          </div>
          <div class="col-sm-6 dark-grey">
            <p>'.$right_txt.'</p>
          </div>
          <div class="colors">
            <div class="dark-grey"></div>
            <div class="bg-'.$main_color.'"></div>
          </div>
        </div>
      </div>';
}      
add_shortcode("double_divider_with_text_contact", "double_divider_with_text_contact_function");

function double_divider_with_text_pricelist_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "left_txt" => '',
      "right_txt" => '',
      "main_color" => '',
   ), $atts));
   return '<div class="row overflow-hidden">
        <div class="double-divider divider-with-text container">
          <div class="col-sm-6 bg-orange">
            <p>'.$left_txt.'</p>
          </div>
          <div class="col-sm-6 bg-blue">
            <p>'.$right_txt.'</p>
          </div>
          <div class="colors">
            <div class="bg-orange"></div>
            <div class="bg-blue"></div>
          </div>
        </div>
      </div>';
}
add_shortcode("double_divider_with_text_pricelist", "double_divider_with_text_pricelist_function");

function bgimage_with_circle_caption_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => '',
      "fourth_txt" => '',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-4" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-md-4 col-sm-6">
                <p class="circle-caption circle-1"><span>'.$first_txt.'</span></p>
                <p class="circle-caption circle-3"><span>'.$second_txt.'</span></p>
              </div>
              <div class="col-md-4 col-sm-6 col-md-offset-4">
                <p class="circle-caption circle-2"><span>'.$third_txt.'</span></p>
                <p class="circle-caption circle-4"><span>'.$fourth_txt.'</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_with_circle_caption", "bgimage_with_circle_caption_function");

function bgimage_with_circle_caption_pricelist_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => '',
      "fourth_txt" => '',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
        <div class="bg-image-4" style="background-image: url('.$bgimage_link.');">
          <div class="container">
            <div class="row">
              <div class="col-md-4 col-sm-6">
                <div class="circle-caption circle-1-pricelist"><p>'.$first_txt.'</p></div>
                <div class="circle-caption circle-3-pricelist"><p>'.$second_txt.'</p></div>
              </div>
              <div class="col-md-4 col-sm-6 col-md-offset-4">
                <div class="circle-caption circle-2-pricelist"><p>'.$third_txt.'</p></div>
                <div class="circle-caption circle-4-pricelist"><p>'.$fourth_txt.'</p></div>
              </div>
            </div>
          </div>
        </div>
      </div>';
}
add_shortcode("bgimage_with_circle_caption_pricelist", "bgimage_with_circle_caption_pricelist_function");

function triple_divider_with_icons_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => ''
   ), $atts));
   $templ = get_template_directory_uri();
   return '<div class="row">
        <div class="triple-divider-2 divider-with-icons bg-green">
          <div class="container">
            <div class="row">
              <div class="col-sm-4 triple-divider-item triple-divider-item-1">
                <p>'.$first_txt.'</p>
                <img src="'.$templ.'/img/buy.png" alt="Kupuj co chcesz">
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-2">
                <p>'.$second_txt.'</p>
                <img src="'.$templ.'/img/time.png" alt="Małe przyjemności">
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-3">
                <p>'.$third_txt.'</p>
                <img src="'.$templ.'/img/active.png" alt="aktywność">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
}
add_shortcode("triple_divider_with_icons", "triple_divider_with_icons_function");

function triple_divider_with_icons_grey_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => ''
   ), $atts));
   $templ = get_template_directory_uri();
   return '<div class="row">
        <div class="triple-divider-3 divider-with-icons bg-grey-ultralight">
          <div class="container">
            <div class="row">
              <div class="col-sm-4 triple-divider-item triple-divider-item-1">
                <img src="'.$templ.'/img/oko.png">
                <p>'.$first_txt.'</p>
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-2">
                <img src="'.$templ.'/img/zdj.png">
                <p>'.$second_txt.'</p>
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-3">
                <img src="'.$templ.'/img/koszulki.png">
				<p>'.$third_txt.'</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
}
add_shortcode("triple_divider_with_icons_grey", "triple_divider_with_icons_grey_function");

function triple_divider_with_icons_white_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => ''
   ), $atts));
   $templ = get_template_directory_uri();
   return '<div class="row">
        <div class="triple-divider-1 divider-with-icons bg-white">
          <div class="container">
            <div class="row">
              <div class="col-sm-4 triple-divider-item triple-divider-item-1">
                <img src="'.$templ.'/img/lupa.png">
                <p>'.$first_txt.'</p>
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-2">
                <img src="'.$templ.'/img/aparat.png">
                <p>'.$second_txt.'</p>
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-3">
                <img src="'.$templ.'/img/oferty.png">
				<p>'.$third_txt.'</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
}
add_shortcode("triple_divider_with_icons_white", "triple_divider_with_icons_white_function");

function quadruple_divider_with_icons_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => '',
      "fourth_txt" => ''
   ), $atts));
   $templ = get_template_directory_uri();
   return '<div class="row">
        <div class="triple-divider-3 bg-grey-ultralight">
          <div class="container">
            <div class="row">
              <div class="col-sm-3 triple-divider-item-new triple-divider-item-1">
                <img src="'.$templ.'/img/oko.png" alt="Oglądasz">
				<p>'.$first_txt.'</p>
              </div>
              <div class="col-sm-3 triple-divider-item-new triple-divider-item-2">
                <img src="'.$templ.'/img/zdj.png" alt="Fotografujesz">
				<p>'.$second_txt.'</p>
              </div>
              <div class="col-sm-3 triple-divider-item-new triple-divider-item-3">
                <img src="'.$templ.'/img/koszulki.png" alt="Publikujesz">
                <p>'.$third_txt.'</p>
              </div>
              <div class="col-sm-3 triple-divider-item-new triple-divider-item-4">
                <img src="'.$templ.'/img/wozek.png" alt="Kupujesz">
                <p>'.$fourth_txt.'</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
}
add_shortcode("quadruple_divider_with_icons", "quadruple_divider_with_icons_function");

function quadruple2_divider_with_icons_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => '',
      "fourth_txt" => ''
   ), $atts));
   $templ = get_template_directory_uri();
   return '<div class="row">
        <div class="triple-divider-4 divider-with-icons">
          <div class="container">
            <div class="row">
              <div class="col-sm-3 triple-divider-item triple-divider-item-1">
                <img src="'.$templ.'/img/lupa.png" alt="Oglądasz">
				<p>'.$first_txt.'</p>
              </div>
              <div class="col-sm-3 triple-divider-item triple-divider-item-2">
                <img src="'.$templ.'/img/aparat.png" alt="Fotografujesz">
				<p>'.$second_txt.'</p>
              </div>
              <div class="col-sm-3 triple-divider-item triple-divider-item-3">
                <img src="'.$templ.'/img/zegar.png" alt="Publikujesz">
                <p>'.$third_txt.'</p>
              </div>
              <div class="col-sm-3 triple-divider-item triple-divider-item-4">
                <img src="'.$templ.'/img/oferty.png" alt="Kupujesz">
                <p>'.$fourth_txt.'</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
}
add_shortcode("quadruple2_divider_with_icons", "quadruple2_divider_with_icons_function");

function triple_divider_contact_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "second_txt" => '',
      "third_txt" => ''
   ), $atts));
   $templ = get_template_directory_uri();
   return '<div class="row">
        <div class="triple-divider-2 bg-green">
          <div class="container">
            <div class="row">
              <div class="col-sm-4 triple-divider-item triple-divider-item-1">
                <p>'.$first_txt.'</p>
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-2">
                <p>'.$second_txt.'</p>
              </div>
              <div class="col-sm-4 triple-divider-item triple-divider-item-3">
                <p>'.$third_txt.'</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
}
add_shortcode("triple_divider_contact", "triple_divider_contact_function");

function metro_start_function($atts, $content = null) {
   return '<div class="row">
        <div class="container">
          <div class="content-section">';
}
add_shortcode("metro_start", "metro_start_function");

function metro_introduce_start_function($atts, $content = null) {
   return '<div class="row">
          <div class="content-section">';
}
add_shortcode("metro_introduce_start", "metro_introduce_start_function");

function metro_end_function($atts, $content = null) {
   return '</div>
        </div>
      </div>';
}
add_shortcode("metro_end", "metro_end_function");

function metro_introduce_end_function($atts, $content = null) {
   return '</div>
      </div>';
}
add_shortcode("metro_introduce_end", "metro_introduce_end_function");

function metro_header_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "head_txt" => ''
   ), $atts));
   return '<div class="row">
              <div class="col-xs-12 nop">
                <h2>'.$head_txt.'</h2>
              </div>
            </div>';
}
add_shortcode("metro_header", "metro_header_function");

function metro_button_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "head_txt" => ''
   ), $atts));
   return '<div class="row">
                <p>'.$head_txt.'</p>
            </div>';
}
add_shortcode("metro_button", "metro_button_function");

function metro_title_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "head_txt" => ''
   ), $atts));
   return '<div class="row">
              <div class="col-xs-12 center bg-txt-margin">
                <h2>'.$head_txt.'</h2>
              </div>
            </div>';
}
add_shortcode("metro_title", "metro_title_function");

function metro_title_short_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "head_txt" => ''
   ), $atts));
   return '<div class="row">
              <div class="col-xs-12 center bg-txt-margin-short">
                <h2>'.$head_txt.'</h2>
              </div>
            </div>';
}
add_shortcode("metro_title_short", "metro_title_short_function");

function metro_title_know_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "head_txt" => ''
   ), $atts));
   return '<div class="row">
              <div class="col-xs-12-know center">
                <h2>'.$head_txt.'</h2>
              </div>
            </div>';
}
add_shortcode("metro_title_know", "metro_title_know_function");

function metro_first_row_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_txt1" => '',
      "q1_txt2" => '',
      "q1_bgcolor" => 'orange',
      "q2_bgimage" => '',
      "q3_txt1" => '',
      "q3_txt2" => '',
      "q3_bgcolor" => 'blue',
      "q4_bgimage" => '',

   ), $atts));
   return '<div class="row first-row">
              <div class="nop width-61">
                <div class="bg-'.$q1_bgcolor.' content-1 content-with-text pad-35 col-xs-12 with-border">
                  <div class="content">
                    <h3>'.$q1_txt1.'</h3>
                  <p>'.$q1_txt2.'</p>
                </div>
                </div>
                <div class="nop col-md-7 content-with-image content-2 hidden-sm hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q2_bgimage.');"></div>
                </div>
                <div class="pad-10 with-border col-md-5 bg-'.$q3_bgcolor.' content-with-text content-3">
                  <div class="content">
                    <p>'.$q3_txt1.'</p>
                    <p><strong>'.$q3_txt2.'</strong></p>
                  </div>  
                </div>
              </div>
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-4">
                  <div class="bg-image with-border" style="background-image: url('.$q4_bgimage.');"></div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_first_row", "metro_first_row_function");

function metro_second_row_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_txt2_color" => 'blue',
      "q2_bgcolor" => 'grey-lighter'
   ), $atts));
   return '<div class="row second-row">
              <div class="nop width-61">
                <div class="nop col-xs-12 content-with-image content-5 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
              <div class="nop width-39 bg-'.$q2_bgcolor.'">
                <div class="nop with-border pad-35 col-xs-12 content-6 content-with-text">
                  <div class="content">
                    <p class="color-grey-dark"><strong>'.$q2_txt1.'</strong></p>
                    <p class="color-'.$q2_txt2_color.'"><strong>'.$q2_txt2.'</strong></p>
                  </div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_second_row", "metro_second_row_function");

function metro_third_row_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_btn_text" => '',
      "q2_btn_link" => '',
      "q2_btncolor" => 'blue',
      "q2_bgcolor" => 'orange',
   ), $atts));
   return '<div class="row third-row">
             <div class="nop width-61">
                <div class="nop col-xs-12 content-with-image content-5 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
              <div class="nop width-39">
                <div class="nop with-border col-xs-12 content-6 bg-'.$q2_bgcolor.' content-with-text pad-35">
                  <div class="content">
                      <p><strong>'.$q2_txt1.'</strong></p>
                      <p>'.$q2_txt2.'</p>
                      <a href="'.$q2_btn_link.'" class="button button-'.$q2_btncolor.' button-small">'.$q2_btn_text.'</a>                     
                  </div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_third_row", "metro_third_row_function");

function metro_fourth_row_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_txt1" => '',
      "q1_txt2" => '',
      "q1_txt3" => '',
      "q1_txt1_color" => 'blue',
      "q1_bgcolor" => 'grey_lighter',
      "q2_bgimage" => '',
   ), $atts));
   return '<div class="row fourth-row">
              <div class="nop width-61">
                <div class="pad-70 with-border col-xs-12 content-9 bg-'.$q1_bgcolor.' content-with-text">
                  <div class="content">
                      <h3 class="color-'.$q1_txt1_color.'">'.$q1_txt1.'</h3>
                      <p class="color-grey-dark">'.$q1_txt2.'</p>
                      <p class="color-grey-dark"><strong>'.$q1_txt3.'</strong></p>
                  </div>
                </div>
              </div>
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-10">
                  <div class="bg-image with-border" style="background-image: url('.$q2_bgimage.');"></div>
                </div>
                <!-- </div> -->
              </div>
            </div>';
}
add_shortcode("metro_fourth_row", "metro_fourth_row_function");

function metro_fifth_row_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_bgcolor" => 'blue',
      "q3_txt1" => '',
      "q3_txt2" => '',
      "q3_txt3" => '',
      "q3_bgcolor" => 'orange',
      "q4_bgimage" => '',
   ), $atts));
   return '<div class="row fifth-row">
              <div class="nop width-44">
                <div class="nop col-xs-12 content-with-image content-11 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
              <div class="nop width-56">
                <div class="bg-'.$q2_bgcolor.' content-12 content-with-text pad-35 with-border col-xs-12">
                  <div class="content">
                      <h3>'.$q2_txt1.'</h3>
                      <p>'.$q2_txt2.'</p>
                  </div>
                </div>
                <div class="pad-35 with-border col-sm-7 bg-'.$q3_bgcolor.' content-13 content-with-text">
                                <div class="content">
                                    <p><strong>'.$q3_txt1.'</strong></p>
                                    <p>'.$q3_txt2.'</p>
                                    '.$q3_txt3.'
                                </div>
                </div>
                <div class="nop col-sm-5 content-with-image-company1 content-14">
                  <div class="bg-image with-border" style="background-image: url('.$q4_bgimage.');"></div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_fifth_row", "metro_fifth_row_function");

function metro_first_row_know_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "h1_txt" => '',
      "h2_txt" => '',
      "h3_txt" => '',
      "main_color" => '',
      "additional_class" => 'col-sm-6',
      "bgimage_link" => ''
   ), $atts));
   return '<div class="row">
			<div class="nop width-61">
				<div class="check-1">
				 
				<div class="bg-image-check1" style="background-image: url('.$bgimage_link.');">	
				</div>
			
					<div class="container">
						<div class="row">
							<div class="'.$additional_class.'">
								<h1 class="color-'.$main_color.'">'.$h1_txt.'</h1>
								<h2>'.$h2_txt.'</h2>
								<p>'.$h3_txt.'</p>
							</div>
						</div>
					</div>	
				</div>
			</div>
            <div class="nop width-30">
				<div class="bg-image-check1" style="background-image: url('.$bgimage_link.');">	
				</div>
			</div>
         </div>';
}
add_shortcode("metro_first_row_know", "metro_first_row_know_function");

function metro_second_row_know_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_txt2_color" => 'blue',
      "q2_bgcolor" => 'grey-lighter'
   ), $atts));
   return '<div class="row second-row">
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-5 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
              <div class="nop width-61 bg-'.$q2_bgcolor.'">
                <div class="nop with-border pad-35 col-xs-12 content-6 content-with-text">
                  <div class="content">
                    <p class="color-grey-dark"><strong>'.$q2_txt1.'</strong></p>
                    <p class="color-'.$q2_txt2_color.'"><strong>'.$q2_txt2.'</strong></p>
                  </div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_second_row_know", "metro_second_row_know_function");

function metro_third_row_know_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_txt2_color" => 'blue',
      "q2_bgcolor" => 'grey-lighter'
   ), $atts));
   return '<div class="row third-row">
              <div class="nop width-61 bg-'.$q2_bgcolor.'">
                <div class="nop with-border pad-35 col-xs-12 content-6 content-with-text">
                  <div class="content">
                    <p class="color-grey-dark"><strong>'.$q2_txt1.'</strong></p>
                    <p class="color-'.$q2_txt2_color.'"><strong>'.$q2_txt2.'</strong></p>
                  </div>
                </div>
              </div>
			<div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-5 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_third_row_know", "metro_third_row_know_function");

function metro_fourth_row_know_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_txt2_color" => 'blue',
      "q2_bgcolor" => 'grey-lighter'
   ), $atts));
   return '<div class="row fourth-row">
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-5 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
              <div class="nop width-61 bg-'.$q2_bgcolor.'">
                <div class="nop with-border pad-35 col-xs-12 content-6 content-with-text">
                  <div class="content">
                    <p class="color-grey-dark"><strong>'.$q2_txt1.'</strong></p>
                    <p class="color-'.$q2_txt2_color.'"><strong>'.$q2_txt2.'</strong></p>
                  </div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_fourth_row_know", "metro_fourth_row_know_function");

function metro_fifth_row_know_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_txt2_color" => 'blue',
      "q2_bgcolor" => 'grey-lighter'
   ), $atts));
   return '<div class="row fifth-row">
              <div class="nop width-61 bg-'.$q2_bgcolor.'">
                <div class="nop with-border pad-35 col-xs-12 content-6 content-with-text">
                  <div class="content">
                    <p class="color-grey-dark"><strong>'.$q2_txt1.'</strong></p>
                    <p class="color-'.$q2_txt2_color.'"><strong>'.$q2_txt2.'</strong></p>
                  </div>
                </div>
              </div>
			  <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-5 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_fifth_row_know", "metro_fifth_row_know_function");

function metro_sixth_row_know_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_txt1" => '',
      "q2_txt2" => '',
      "q2_txt2_color" => 'blue',
      "q2_bgcolor" => 'grey-lighter'
   ), $atts));
   return '<div class="row sixth-row">
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-5 hidden-xs">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>
              <div class="nop width-61 bg-'.$q2_bgcolor.'">
                <div class="nop with-border pad-35 col-xs-12 content-6 content-with-text">
                  <div class="content">
                    <p class="color-grey-dark"><strong>'.$q2_txt1.'</strong></p>
                    <p class="color-'.$q2_txt2_color.'"><strong>'.$q2_txt2.'</strong></p>
                  </div>
                </div>
              </div>
            </div>';
}
add_shortcode("metro_sixth_row_know", "metro_sixth_row_know_function");

function metro_first_row_site_map_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_header" => '',
      "q1_href_txt" => '',
      "q1_href" => '',
      "q1_bgimage" => '',
      "q2_header" => '',
      "q2_href_txt" => '',
      "q2_href" => '',
      "q2_bgimage" => '',
      "q3_bgimage" => '',

   ), $atts));
    //wydrukuj zmienna na ekranie
//   var_dump($atts);
    // wydrukuj nowa linie na ekranie
//   echo "<br>";
      
   $return_str ='
           <div class="row first-row">
              <div class="nop width-61">
				<div class="bg-image with-border content-1 content-with-text pad-35 col-xs-12 with-border" style="background-image: url('.$q1_bgimage.');">              
                  <div class="content">
                    <h3>'.$q1_header.'</h3>';
   
   $your_txt = explode("</br>", $q1_href_txt);
   $your_href = explode("</br>",$q1_href);
   // loop by the all $your_txt array
   // where $key is an array index
   // $value is an array value
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
   $return_str .= '
                </div>
                </div>              
				<div class="bg-image with-border content-1 content-with-text pad-35 col-xs-12 with-border" style="background-image: url('.$q2_bgimage.');">              
                  <div class="content">
                    <h3>'.$q2_header.'</h3>';
                    
   $your_txt = explode("</br>", $q2_href_txt);
   $your_href = explode("</br>",$q2_href);
   // loop by the all $your_txt array
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
    $return_str .= '
                  </div>  
                </div> 
              </div>
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-4-site-map">
                  <div class="bg-image with-border" style="background-image: url('.$q3_bgimage.');"></div>
                </div>
              </div>
            </div>';
      return $return_str;
}
add_shortcode("metro_first_row_site_map", "metro_first_row_site_map_function");

function metro_second_row_site_map_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q4_bgimage" => '',
      "q5_header" => '',
      "q5_href_txt" => '',
      "q5_href" => '',
      "q5_bgimage" => '',
      "q6_header" => '',
      "q6_href_txt" => '',
      "q6_href" => '',
      "q6_bgimage" => '',
   ), $atts));
   
      $return_str ='
           <div class="row second-row">

              <div class="nop width-61">
                <div class="nop col-xs-12 content-with-image content-4-site-map">
                  <div class="bg-image with-border" style="background-image: url('.$q4_bgimage.');"></div>
                </div>
              </div>      
              <div class="nop width-39">    
                <div class="bg-image with-border content-1 content-with-text pad-35 col-xs-12 with-border" style="background-image: url('.$q5_bgimage.');">
                  <div class="content">
                    <h3>'.$q5_header.'</h3>';
   
   $your_txt = explode("</br>", $q5_href_txt);
   $your_href = explode("</br>",$q5_href);
   // loop by the all $your_txt array
   // where $key is an array index
   // $value is an array value
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
   $return_str .= '
                </div>
                </div>      
                <div class="bg-image with-border content-1 content-with-text pad-35 col-xs-12 with-border" style="background-image: url('.$q6_bgimage.');">
                  <div class="content">
                    <h3>'.$q6_header.'</h3>';
                    
   $your_txt = explode("</br>", $q6_href_txt);
   $your_href = explode("</br>",$q6_href);
   // loop by the all $your_txt array
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
    $return_str .= '
                  </div>  
                </div> 
                
                
              </div>
              
              

              
              
            </div>';
      return $return_str;
}
add_shortcode("metro_second_row_site_map", "metro_second_row_site_map_function");

function metro_third_row_site_map_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q7_header" => '',
      "q7_href_txt" => '',
      "q7_href" => '',
      "q7_bgimage" => '',
      "q8_header" => '',
      "q8_href_txt" => '',
      "q8_href" => '',
      "q8_bgimage" => '',
      "q9_bgimage" => '',

   ), $atts));
    //wydrukuj zmienna na ekranie
//   var_dump($atts);
    // wydrukuj nowa linie na ekranie
//   echo "<br>";
      
   $return_str ='
           <div class="row first-row">
              <div class="nop width-61">
                <div class="bg-image with-border content-1 content-with-text pad-35 col-xs-12 with-border" style="background-image: url('.$q7_bgimage.');">
                  <div class="content">
                    <h3>'.$q7_header.'</h3>';
   
   $your_txt = explode("</br>", $q7_href_txt);
   $your_href = explode("</br>",$q7_href);
   // loop by the all $your_txt array
   // where $key is an array index
   // $value is an array value
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
   $return_str .= '
                </div>
                </div>              
                <div class="bg-image with-border content-1 content-with-text pad-35 col-xs-12 with-border" style="background-image: url('.$q8_bgimage.');">
                  <div class="content">
                    <h3>'.$q8_header.'</h3>';
                    
   $your_txt = explode("</br>", $q8_href_txt);
   $your_href = explode("</br>",$q8_href);
   // loop by the all $your_txt array
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
    $return_str .= '
                  </div>  
                </div> 
              </div>
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-4-site-map">
                  <div class="bg-image with-border" style="background-image: url('.$q9_bgimage.');"></div>
                </div>
              </div>
            </div>';
      return $return_str;
}
add_shortcode("metro_third_row_site_map", "metro_third_row_site_map_function");

function metro_first_row_pricelist_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q1_bgimage" => '',
      "q2_bgimage" => '',
      "q3_bgimage" => '',

   ), $atts));
    //wydrukuj zmienna na ekranie
//   var_dump($atts);
    // wydrukuj nowa linie na ekranie
//   echo "<br>";
      
   $return_str ='
           <div class="row first-row-pricelist">

              
                   <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image-pricelist content-4-pricelist">
                  <div class="bg-image with-border" style="background-image: url('.$q1_bgimage.');"></div>
                </div>
              </div>        
                
                   <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image-pricelist content-4-pricelist">
                  <div class="bg-image with-border" style="background-image: url('.$q2_bgimage.');"></div>
                </div>
              </div>  
              
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image-pricelist content-4-pricelist">
                  <div class="bg-image with-border" style="background-image: url('.$q3_bgimage.');"></div>
                </div>
              </div>     
              

              
            </div>';
      return $return_str;
}
add_shortcode("metro_first_row_pricelist", "metro_first_row_pricelist_function");



function metro_second_row_pricelist_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q4_bgimage" => '',
      "q5_header" => '',
      "q5_href_txt" => '',
      "q5_href" => '',
      "q5_bgcolor" => '',
      "q5_bgimage" => '',
      "q6_header" => '',
      "q6_href_txt" => '',
      "q6_href" => '',
      "q6_bgcolor" => '',
   ), $atts));
   
      $return_str ='
           <div class="row second-row">

              <div class="nop width-61">
                <div class="nop col-xs-12 content-with-image content-4-site-map">
                  <div class="bg-image with-border" style="background-image: url('.$q4_bgimage.');"></div>
                </div>
              </div>
              
              <div class="nop width-39">
              
                
                <div class="bg-'.$q5_bgcolor.' content-1 content-with-text pad-35 col-xs-12 with-border">
                  <div class="content">
                    <h3>'.$q5_header.'</h3>';
   
   $your_txt = explode("</br>", $q5_href_txt);
   $your_href = explode("</br>",$q5_href);
   // loop by the all $your_txt array
   // where $key is an array index
   // $value is an array value
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
   $return_str .= '
                </div>
                </div>      
                
                
                
                        
                <div class="bg-'.$q6_bgcolor.' content-1 content-with-text pad-35 col-xs-12 with-border">
                  <div class="content">
                    <h3>'.$q6_header.'</h3>';
                    
   $your_txt = explode("</br>", $q6_href_txt);
   $your_href = explode("</br>",$q6_href);
   // loop by the all $your_txt array
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
    $return_str .= '
                  </div>  
                </div> 
                
                
              </div>
              
              

              
              
            </div>';
      return $return_str;
}
add_shortcode("metro_second_row_pricelist", "metro_second_row_pricelist_function");




function metro_third_row_pricelist_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "q7_header" => '',
      "q7_href_txt" => '',
      "q7_href" => '',
      "q7_bgcolor" => '',
      "q7_bgimage" => '',
      "q8_header" => '',
      "q8_href_txt" => '',
      "q8_href" => '',
      "q8_bgcolor" => '',
      "q9_bgimage" => '',

   ), $atts));
    //wydrukuj zmienna na ekranie
//   var_dump($atts);
    // wydrukuj nowa linie na ekranie
//   echo "<br>";
      
   $return_str ='
           <div class="row first-row">
              <div class="nop width-61">
              
                <div class="bg-'.$q7_bgcolor.' content-1 content-with-text pad-35 col-xs-12 with-border">
                  <div class="content">
                    <h3>'.$q7_header.'</h3>';
   
   $your_txt = explode("</br>", $q7_href_txt);
   $your_href = explode("</br>",$q7_href);
   // loop by the all $your_txt array
   // where $key is an array index
   // $value is an array value
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
   $return_str .= '
                </div>
                </div>              
                <div class="bg-'.$q8_bgcolor.' content-1 content-with-text pad-35 col-xs-12 with-border">
                  <div class="content">
                    <h3>'.$q8_header.'</h3>';
                    
   $your_txt = explode("</br>", $q8_href_txt);
   $your_href = explode("</br>",$q8_href);
   // loop by the all $your_txt array
   foreach($your_txt as $key => $value)
   {
      $return_str .= '<p><a class="a_white" href="'.$your_href[$key].'">'.$your_txt[$key].'</a></p>';
   }                 
    $return_str .= '
                  </div>  
                </div> 
              </div>
              <div class="nop width-39">
                <div class="nop col-xs-12 content-with-image content-4-site-map">
                  <div class="bg-image with-border" style="background-image: url('.$q9_bgimage.');"></div>
                </div>
              </div>
            </div>';
      return $return_str;
}
add_shortcode("metro_third_row_pricelist", "metro_third_row_pricelist_function");

function header_with_button_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
      "btn_txt" => '',
      "btn_link" => '#',
      "btn_color" => 'blue'
   ), $atts));
   return '<div class="row join-us">
        <div class="text-center">
            <h2>'.$first_txt.'</h2>
            <a href="'.$btn_link.'" class="button button-'.$btn_color.'">'.$btn_txt.'</a>
          </div>
      </div>';
}
add_shortcode("header_with_button", "header_with_button_function");

function header_without_button_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "first_txt" => '',
   ), $atts));
   return '<div class="row join-us">
        <div class="text-center">
            <h3>'.$first_txt.'</h3>
          </div>
      </div>';
}
add_shortcode("header_without_button", "header_without_button_function");


function button_pricelist_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "btn_txt" => '',
      "btn_link" => '#',
      "btn_color" => ''
   ), $atts));
   return '<div class="row join-us">
        <div class="text-center">
            <a href="'.$btn_link.'" class="button_pricelist button-'.$btn_color.'">'.$btn_txt.'</a>
          </div>
      </div>';
}
add_shortcode("button_pricelist", "button_pricelist_function");

function menu_color_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "color" => 'green'
   ), $atts));
   return '<div id="js-menu-color" style="display:none;visibility:hidden;" data-color="'.$color.'"></div>';
}
add_shortcode("menu_color", "menu_color_function");

remove_filter('the_content', 'wpautop');

function facebook_frame_function()
{ // BEGIN function facebook_frame
  return '	
  <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fpatrznaprodukt%2F&tabs=timeline&width=375&height=375&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="375" height="375" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
  ';
}
add_shortcode("facebook_frame", "facebook_frame_function"); // END function facebook_frame
?>