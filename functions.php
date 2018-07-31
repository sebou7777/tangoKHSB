<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup()
{
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 640;
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'blankslate' ) )
);
}
add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts()
{
    wp_enqueue_script( 'jquery' );
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script()
{
if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return '&rarr;';
} else {
return $title;
}
}
add_filter( 'wp_title', 'blankslate_filter_wp_title' );
function blankslate_filter_wp_title( $title )
{
return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init()
{
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
function blankslate_custom_pings( $comment )
{
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php 
}
add_filter( 'get_comments_number', 'blankslate_comments_number' );
function blankslate_comments_number( $count )
{
if ( !is_admin() ) {
global $id;
$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}





include_once(get_template_directory().'/includes/contact.php');



add_action( 'after_setup_theme', 'mythemeslug_theme_setup' );

if ( ! function_exists( 'mythemeslug_theme_setup' ) ) {
    function mythemeslug_theme_setup(){
        /********* Registers an editor stylesheet for the theme ***********/
//        add_action( 'admin_init', 'mythemeslug_theme_add_editor_styles' );
        /********* TinyMCE Buttons ***********/
        add_action( 'init', 'mythemeslug_buttons' );
    }
}
if ( ! function_exists( 'mythemeslug_buttons' ) ) {
    function mythemeslug_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }

        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }

        add_filter( 'mce_external_plugins', 'mythemeslug_add_buttons' );
        add_filter( 'mce_buttons', 'mythemeslug_register_buttons' );
        add_filter( 'mce_buttons_2', 'mythemeslug_register_buttons_2' );
        add_filter( 'tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
    }
}

if ( ! function_exists( 'mythemeslug_add_buttons' ) ) {
    function mythemeslug_add_buttons( $plugin_array ) {
        $plugin_array['columns2'] = get_template_directory_uri().'/js/tinymce_buttons2.js';
        $plugin_array['columns3'] = get_template_directory_uri().'/js/tinymce_buttons3.js';
        return $plugin_array;
    }
}

if ( ! function_exists( 'mythemeslug_register_buttons' ) ) {
    function mythemeslug_register_buttons( $buttons ) {
        array_push( $buttons, 'columns2' );
        array_push( $buttons, 'columns3' );
        $remove = array('strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'spellchecker', 'wp_adv', 'wp_more');
        foreach ( $buttons as $key => $value ) {
            if (in_array($value, $remove))
                unset($buttons[$key]);
        }

        return $buttons;
    }
    function mythemeslug_register_buttons_2( $buttons ) {
        array_push( $buttons, 'columns2' );
        array_push( $buttons, 'columns3' );
        $remove = array('strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'spellchecker', 'wp_adv', 'wp_more');
        foreach ( $buttons as $key => $value ) {
            if (in_array($value, $remove))
                unset($buttons[$key]);
        }
        $buttons = array();
        return $buttons;
    }
    function tiny_mce_remove_unused_formats($init) {
        // Add block format elements you want to show in dropdown
        $init['block_formats'] = 'Paragraphe=p;Entête 2=h2;Entête 3=h3;Entête 4=h4';
        return $init;
    }
}





/***********************************************************************/
//  Possibilité de dupliquer un article
/***********************************************************************/
function rd_duplicate_post_as_draft(){
    global $wpdb;
    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
        wp_die('No post to duplicate has been supplied!');
    }

    /*
     * Nonce verification
     */
    if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
        return;

    /*
     * get the original post id
     */
    $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
    /*
     * and all the original post data then
     */
    $post = get_post( $post_id );

    /*
     * if you don't want current user to be the new post author,
     * then change next couple of lines to this: $new_post_author = $post->post_author;
     */
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;

    /*
     * if post data exists, create the post duplicate
     */
    if (isset( $post ) && $post != null) {

        /*
         * new post data array
         */
        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft',
            'post_title'     => $post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );

        /*
         * insert the post by wp_insert_post() function
         */
        $new_post_id = wp_insert_post( $args );

        /*
         * get all current post terms ad set them to the new post draft
         */
        $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
        foreach ($taxonomies as $taxonomy) {
            $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
            wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
        }

        /*
         * duplicate all post meta just in two SQL queries
         */
        $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
        if (count($post_meta_infos)!=0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
                $meta_key = $meta_info->meta_key;
                if( $meta_key == '_wp_old_slug' ) continue;
                $meta_value = addslashes($meta_info->meta_value);
                $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query.= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
        }


        /*
         * finally, redirect to the edit post screen for the new draft
         */
        wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
        exit;
    } else {
        wp_die('Post creation failed, could not find original post: ' . $post_id);
    }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );

/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Dupliquer l\'article</a>';
    }
    return $actions;
}

add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
//add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);


/***********************************************************************/
//  Ajout du defer sur certains JS pour les perfs
/***********************************************************************/
function add_defer_attribute($tag, $handle) {
    // add script handles to the array below
    $scripts_to_defer = array('script_theme', 'jquery-core', 'jquery-migrate', 'script_maps', 'validate', 'sticky');

    foreach($scripts_to_defer as $defer_script) {
        if ($defer_script === $handle) {
            return str_replace(' src', ' defer="defer" src', $tag);
        }
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 100, 2);


/***********************************************************************/
//  Gestion AJAX
/***********************************************************************/
add_action('wp_enqueue_scripts', 'add_js_scripts');
add_action( 'wp_ajax_get_content_of_specific_page', 'get_content_of_specific_page' );
add_action( 'wp_ajax_nopriv_get_content_of_specific_page', 'get_content_of_specific_page' );


//add_action( 'parse_request', 'wpcf7_control_init', 20 );
//add_action( 'wp_enqueue_scripts', 'wpcf7_do_enqueue_scripts' );
//add_action( 'wp_enqueue_scripts', 'wpcf7_html5_fallback', 20 );

function add_js_scripts() {
    wp_enqueue_script( 'gallery', get_template_directory_uri().'/js/gallery.js', array('jquery'), '1.0', true);
//    wp_enqueue_script( 'highlight', get_template_directory_uri().'/js/highlight.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script( 'font-awesome', get_template_directory_uri().'/js/font-awesome.js', array('jquery'), '1.0', true);

    wp_enqueue_style('gallery', get_template_directory_uri().'/css/gallery.css');
    wp_enqueue_style('style_seb', get_template_directory_uri().'/css/style-seb.css');
    wp_enqueue_style('bulma', get_template_directory_uri().'/css/bulma.min.css');
    wp_enqueue_style('normalize', get_template_directory_uri().'/css/normalize.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/font-awesome.min.css');
    wp_enqueue_script( 'script_theme', get_template_directory_uri().'/js/scripts.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'sticky', get_template_directory_uri().'/js/sticky.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'validate', get_template_directory_uri().'/js/jquery.validate.min.js', array('jquery'), '1.0', true);
    wp_localize_script('script_theme', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
function get_content_of_specific_page() {
    $param = $_GET['param'];

    $args = array(
        'post_type' => 'page',
        'page_id' => $param
    );
    $ajax_query = new WP_Query($args);
    echo apply_filters('the_content', $ajax_query->posts[0]->post_content);
    die();
}

/***********************************************************************/
//  Gestion des champs en plus dans les pages
/***********************************************************************/
add_action( 'add_meta_boxes', 'add_blocs_hauts' );
add_action( 'save_post', 'save_blocs_hauts' );
function add_blocs_hauts()
{
    add_meta_box( 'bloc_haut_1', 'Bloc Haut 1', 'add_bloc_haut', 'page', 'normal', 'high', array('nb' => 1) );
    add_meta_box( 'bloc_haut_2', 'Bloc Haut 2', 'add_bloc_haut', 'page', 'normal', 'high', array('nb' => 2) );
    add_meta_box( 'bloc_haut_3', 'Bloc Haut 3', 'add_bloc_haut', 'page', 'normal', 'high', array('nb' => 3) );
    add_meta_box( 'bloc_haut_4', 'Bloc Haut 4', 'add_bloc_haut', 'page', 'normal', 'high', array('nb' => 4) );
    wp_enqueue_script( 'add-meta-box-blocs-hauts', get_bloginfo('template_url').'/js/scripts-admin.js', array( 'jquery','media-upload','thickbox' ) );
    add_editor_style('/css/editor-style.css');
}
function save_blocs_hauts( $post_id ) {
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
    if( !current_user_can( 'edit_post' ) ) return;

    $allowed = array('a' => array('href' => array()));

    for($i = 1; $i <= 4; $i++) {
        foreach(array('titre', 'position', 'url', 'image', 'texte', 'ajax') as $field) {
            if(isset($_POST['bloc_haut_'.$field.'_'.$i]))
                update_post_meta($post_id, 'bloc_haut_'.$field.'_'.$i, esc_attr($_POST['bloc_haut_'.$field.'_'.$i], $allowed));
        }
    }
}

function add_bloc_haut( $post, $metabox ) {
    $nb = $metabox['args']['nb'];
    $values = get_post_custom($post->ID);

    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

    $text = isset( $values['bloc_haut_titre_'.$nb] ) ? esc_attr( $values['bloc_haut_titre_'.$nb][0] ) : '';
    $position = isset( $values['bloc_haut_position_'.$nb] ) ? esc_attr( $values['bloc_haut_position_'.$nb][0] ) : '';
    $url = isset( $values['bloc_haut_url_'.$nb] ) ? esc_attr( $values['bloc_haut_url_'.$nb][0] ) : '';
    $ajax = isset( $values['bloc_haut_ajax_'.$nb] ) ? esc_attr( $values['bloc_haut_ajax_'.$nb][0] ) : '';
    $image = isset( $values['bloc_haut_image_'.$nb] ) ? esc_attr( $values['bloc_haut_image_'.$nb][0] ) : '';
    $texte = isset( $values['bloc_haut_texte_'.$nb] ) ? esc_attr( $values['bloc_haut_texte_'.$nb][0] ) : '';
    ?>
    <p>
        <input type="text" name="bloc_haut_titre_<?php echo $nb ?>" id="bloc_haut_titre_<?php echo $nb ?>" placeholder="Titre du bloc" value="<?php echo $text; ?>" />
        <input type="text" name="bloc_haut_position_<?php echo $nb ?>" id="bloc_haut_position_<?php echo $nb ?>" placeholder="Position du bloc" value="<?php echo $position; ?>" />
        <input type="text" name="bloc_haut_url_<?php echo $nb ?>" id="bloc_haut_url_<?php echo $nb ?>" placeholder="URL du bloc" value="<?php echo $url; ?>" />
        <input type="checkbox" name="bloc_haut_ajax_<?php echo $nb ?>" id="bloc_haut_ajax_<?php echo $nb ?>" placeholder="Ajax" value="1" <?php echo (($ajax) ? 'checked="checked"' : ''); ?> />
        <input id="bloc_haut_image_<?php echo $nb ?>" style="width: 450px;" type="text" name="bloc_haut_image_<?php echo $nb ?>" value="<?php echo esc_url( $image ); ?>" />
        <input id="bloc_haut_image_upload_<?php echo $nb ?>" data-input="bloc_haut_image_<?php echo $nb ?>" class="button-secondary bloc_haut_image_upload" type="button" value="Choisir image" />
    </p>

    <p>
        <textarea name="bloc_haut_texte_<?php echo $nb ?>" id="bloc_haut_texte_<?php echo $nb ?>" placeholder="Texte du bloc" style="resize:both;width:100%;height:5em;"><?php echo $texte; ?></textarea>
    </p>

    <?php
}

function get_blocs_hauts()
{
    $fields = get_post_custom();
    $blocs = array();
//    var_dump(get_post());
    for($i = 1; $i <= 4; $i++) {
        foreach(array('titre', 'position', 'url', 'image', 'texte', 'ajax') as $field) {
            if(isset($fields['bloc_haut_'.$field.'_'.$i]) && $fields['bloc_haut_'.$field.'_'.$i][0]) {
                if(!isset($blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]]))
                    $blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]] = array();
                $blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]][$field] = $fields['bloc_haut_'.$field.'_'.$i][0];
            }
        }
        if($blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]]['url']) {
            if(preg_match("/".get_post()->post_name."$/", $blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]]['url'])) {
                $blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]]['is_selected'] = true;
            }
            $postName = explode('/', $blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]]['url']);
            $postName = $postName[count($postName) - 1];
            if ($posts = get_posts( array('name' => $postName, 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1))){
                $blocs['bloc_'.$fields['bloc_haut_position_'.$i][0]]['id'] =  $posts[0]->ID;
            }
        }
    }
    ksort($blocs);

    return $blocs;
}

function is_blocs_hauts_ajax()
{
    $fields = get_post_custom();
    $blocs = array();

    for($i = 1; $i <= 4; $i++) {
        if(isset($fields['bloc_haut_ajax_'.$i]) && $fields['bloc_haut_ajax_'.$i][0]) {
            return true;
        }
    }

    return false;
}

/***********************************************************************/
//  Gestion des champs en plus dans les posts (pour les stages)
/***********************************************************************/
add_action( 'add_meta_boxes', 'add_bloc_stage' );
add_action( 'save_post', 'save_bloc_stage' );
function add_bloc_stage()
{
    add_meta_box('bloc_stage', "Remplir si c'est un stage OU une alerte", 'add_champs_stage', 'post', 'normal', 'high');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui-datepicker', get_bloginfo('template_url').'/css/datepicker.css');
//    wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/smoothness/jquery-ui.css', array('jquery-ui-core'));
    wp_enqueue_style('jquery-ui-datepicker');
}
function save_bloc_stage($post_id) {
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce')) return;
    if(!current_user_can( 'edit_post')) return;

    $allowed = array('a' => array('href' => array()));

    foreach(array('date', 'starttime', 'endtime', 'adresse', 'codepostal', 'ville', 'telephone', 'description') as $field) {
        if(isset($_POST['bloc_stage_'.$field]) && $_POST['bloc_stage_'.$field])
            update_post_meta($post_id, 'bloc_stage_'.$field, esc_attr($_POST['bloc_stage_'.$field], $allowed));
    }
}

function add_champs_stage_time_select($type, $value) {
    echo '<select name="bloc_stage_'.$type.'" style="width:70px" id="bloc_stage_"'.$type.'>';
    for($h = 8; $h <= 23; $h++) {
        foreach(array('00', '30') as $m) {
            echo '<option value="'.$h.':'.$m.'"'.(($h.':'.$m == $value) ? 'selected="selected"' : '').'>'.$h.'h'.$m.'</option>';
        }
    }
    echo '</select>';

}

function add_champs_stage($post) {
    $values = get_post_custom($post->ID);

    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');

    $infos = array();
    $infos['date'] = isset($values['bloc_stage_date']) ? esc_attr($values['bloc_stage_date'][0]) : '';
    $infos['starttime'] = isset($values['bloc_stage_starttime']) ? esc_attr($values['bloc_stage_starttime'][0]) : '';
    $infos['endtime'] = isset($values['bloc_stage_endtime']) ? esc_attr($values['bloc_stage_endtime'][0]) : '';
    $infos['adresse'] = isset($values['bloc_stage_adresse']) ? esc_attr($values['bloc_stage_adresse'][0]) : '35 rue Jussieu';
    $infos['codepostal'] = isset($values['bloc_stage_codepostal']) ? esc_attr($values['bloc_stage_codepostal'][0]) : '75005';
    $infos['ville'] = isset($values['bloc_stage_ville']) ? esc_attr($values['bloc_stage_ville'][0]) : 'Paris';
    $infos['telephone'] = isset($values['bloc_stage_telephone']) ? esc_attr($values['bloc_stage_telephone'][0]) : '06 12 06 87 51';
    $infos['description'] = isset($values['bloc_stage_description']) ? esc_attr($values['bloc_stage_description'][0]) : '';
    ?>
    <p>
        <div style="width:80px;display:inline-block;">Le </div><input style="width:100px" autocomplete="off" tabindex="2000" placeholder="jour" class="hasdatepicker" name="bloc_stage_date" id="bloc_stage_date" value="<?php echo $infos['date'] ?>" type="text" />
        de <?php add_champs_stage_time_select('starttime', $infos['starttime']); ?> à <?php add_champs_stage_time_select('endtime', $infos['endtime']); ?>
    </p>
    <p>
        <div style="width:80px;display:inline-block;">Lieu :  </div><input  placeholder="adresse" tabindex="2000" name="bloc_stage_adresse" id="bloc_stage_adresse" value="<?php echo $infos['adresse'] ?>" type="text" />
        <input style="width:55px" placeholder="code postal" tabindex="2000" name="bloc_stage_codepostal" id="bloc_stage_codepostal" value="<?php echo $infos['codepostal'] ?>" type="text" />
        <input  placeholder="ville" tabindex="2000" name="bloc_stage_ville" id="bloc_stage_ville" value="<?php echo $infos['ville'] ?>" type="text" />
    </p>
    <p>
        <div style="width:80px;display:inline-block;">Téléphone : </div><input style="width:108px" placeholder="téléphone" tabindex="2000" name="bloc_stage_telephone" id="bloc_stage_telephone" value="<?php echo $infos['telephone'] ?>" type="text" />
    </p>
    <p>
    <div style="vertical-align:top;width:80px;display:inline-block;">Description : </div><textarea style="resize:both;width:100%;height:5em;" placeholder="Description" tabindex="2000" name="bloc_stage_description" id="bloc_stage_description"><?php echo $infos['description'] ?></textarea>
    </p>
    <?php
}

function get_is_stage($id = null)
{
    foreach(get_the_category($id) as $categ) {
        if(in_array($categ->category_nicename, array('stages', 'alerte'))) {
            return true;
            break;
        }
    }
    return false;
}

add_action('wp_enqueue_scripts', 'add_js_maps');
function add_js_maps() {
    wp_enqueue_script( 'script_maps', get_template_directory_uri().'/js/maps.js', array('jquery'), '1.0', true );
}

function get_bloc_stage($id = null)
{
    $fields = get_post_custom($id);
    $infos = array();

    if(get_is_stage($id)) {
        foreach (array('date', 'starttime', 'endtime', 'adresse', 'codepostal', 'ville', 'telephone', 'description') as $field) {
            if (isset($fields['bloc_stage_' . $field]) && $fields['bloc_stage_' . $field][0]) {
                $infos[$field] = $fields['bloc_stage_' . $field][0];
            }
        }
        $parts = explode('/', $infos['date']);
        $infos['date'] = $parts[2].'-'.$parts[1].'-'.$parts[0];
        $infos['starttime'] = str_replace(':', 'h', $infos['starttime']);
        $infos['endtime'] = str_replace(':', 'h', $infos['endtime']);
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        $infos['date_format'] = strftime('%d %B %Y', strtotime($infos['date']));
        $infos['time_format'] = 'de '.$infos['starttime'].' à '.$infos['endtime'];
        $infos['datetime_format'] = strftime('%d %B %Y', strtotime($infos['date'])).' de '.$infos['starttime'].' à '.$infos['endtime'];
        $infos['url'] = '/'.get_post($id)->post_name;
    }
    return $infos;
}

/***********************************************************************/
//  Gestion du "lire plus" dans les listes d'articles
/***********************************************************************/
function wpdocs_excerpt_more( $more ) {
    return sprintf( '... <a class="button read-more" href="%1$s">%2$s</a>', get_permalink( get_the_ID() ), 'Lire plus');
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/***********************************************************************/
//  Récupération du dernier stage et de la dernière alerte
/***********************************************************************/
function next_stage() {
    $args = array(
        'post_type' => 'post',
//        'posts_per_page' => 1, // we need only the latest post, so get that post only
        'cat' => 18, // Use the category id, can also replace with category_name which uses category slug
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $posts = get_posts($args);
    $infos = null;

    if(count($posts)) {
        foreach($posts as $post) {
            $temp = get_bloc_stage($post->ID);
            $temp['post_title'] = $post->post_title;
            $temp['post_url'] = get_the_permalink($post);
            if(strtotime($temp['date'].' '.str_replace('h', ':', $temp['endtime']).':00') < time()) {
                break;
            }
            if(!$infos) $infos = $temp;
            if($infos && strtotime($temp['date'].' '.str_replace('h', ':', $temp['endtime']).':00') < strtotime($infos['date'].' '.str_replace('h', ':', $infos['endtime']).':00')) {
                $infos = $temp;
            }
        }
    }
    return $infos;
}

function next_alerte() {
    $args = array(
        'post_type' => 'post',
//        'numberposts' => 1, // we need only the latest post, so get that post only
        'category' => 1, // Use the category id, can also replace with category_name which uses category slug
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $posts = get_posts($args);
    $infos = null;

    if(count($posts)) {
        foreach($posts as $post) {
            $temp = get_bloc_stage($post->ID);
            $temp['post_title'] = $post->post_title;
            if(strtotime($temp['date'].' '.str_replace('h', ':', $temp['endtime']).':00') < time()) {
                break;
            }
            if(!$infos) $infos = $temp;
            if($infos && strtotime($temp['date'].' '.str_replace('h', ':', $temp['endtime']).':00') < strtotime($infos['date'].' '.str_replace('h', ':', $infos['endtime']).':00')) {
                $infos = $temp;
            }
        }
    }
    return $infos;
}

function last_edito() {
    $args = array(
        'post_type' => 'post',
        'numberposts' => 1, // we need only the latest post, so get that post only
        'category' => 14, // Use the category id, can also replace with category_name which uses category slug
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $posts = get_posts($args);
    $infos = null;

    if(count($posts)) {
        $post = $posts[0];
        $post->post_url = get_the_permalink($post);
    }
    return $post;
}

add_shortcode('next_stage', 'next_stage');
add_shortcode('next_alerte', 'next_alerte');

/***********************************************************************/
//  Récupération du précédent/suivant post de la bonne catégorie
/***********************************************************************/
function get_pagination() {
//    $fields = get_the_ID();var_dump($fields);
    $category = get_the_category();
    $args = array(
        'post_type' => 'post',
//        'numberposts' => 1, // we need only the latest post, so get that post only
        'category' => $category[0]->cat_ID, // Use the category id, can also replace with category_name which uses category slug
        'orderby' => 'date',
        'order' => 'ASC',
        'post_status'     => 'publish',
//        'meta_key'      => 'bloc_stage_date',
//        'meta_value'    => time(),
//        'meta_compare' => '>',
//        'orderby' => 'meta_value',
//        'order' => 'ASC'
    );

    $posts = get_posts($args);

    $prev = null; $next = null;
    if(count($posts)) {
        foreach($posts as $i => $post) {
            if($post->ID == get_the_ID()) {

                if(isset($posts[$i - 1])) {
                    $prev = $posts[$i - 1];
                    $prev->post_url = get_the_permalink($prev);
                }
                if(isset($posts[$i + 1])) {
                    $next = $posts[$i + 1];
                    $next->post_url = get_the_permalink($next);
                }
            }
        }
        return array($prev, $next);
    }
    return array($prev, $next);
}

function tango_menu() {
    $locations = get_nav_menu_locations();
    $menu_items = wp_get_nav_menu_items( $locations['main-menu'], array( 'update_post_term_cache' => false ) );
    foreach($menu_items as $i => $item) {
        $post = explode('/', $_SERVER['REQUEST_URI']);
        if($post[count($post) - 1] && preg_match("/\/".$post[count($post) - 1]."($|\/)/", $item->url))
            $item->is_selected = true;
        if(!$item->is_selected && isset($post[count($post) - 2]) && $post[count($post) - 2] && preg_match("/\/".$post[count($post) - 2]."$/", $item->url))
            $item->is_selected = true;
        $item->submenu = array();
        if($key = array_search($item->menu_item_parent, array_column($menu_items, 'ID'))) {
            $menu_items[$key]->submenu[] = $item;
            unset($menu_items[$i]);
        }

    }
    return $menu_items;
}
function tango_menu_footer() {
    $menu_items = wp_get_nav_menu_items( 'menu-footer', array( 'update_post_term_cache' => false ) );
//    var_dump($menu_items);
    $toDelete = array();
    foreach($menu_items as $i => $item) {
        $postName = explode('/', $_SERVER['REQUEST_URI']);
        $postName = $postName[count($postName) - 1];
        if(preg_match("/\/".$postName."$/", $item->url))
            $item->is_selected = true;
        $item->submenu = array();
        if(array_search($item->menu_item_parent, array_column($menu_items, 'ID')) !== false) {
            $key = array_search($item->menu_item_parent, array_column($menu_items, 'ID'));
            $menu_items[$key]->submenu[] = $item;
            $toDelete[] = $i;
        }
    }
    foreach($toDelete as $del) {
        unset($menu_items[$del]);
    }
    return $menu_items;
}

function is_contact() {
    $post = get_post();
    return $post->ID == 65;
}
function is_gallery() {
    $post = get_post();
    return $post->ID == 63;
}
function get_gallery() {
    $post = get_post();
    $ids = explode(',', explode('"', $post->post_content)[1]);
    $imgs = array();
    foreach($ids as $id) {
        $thumb = wp_get_attachment_image_src($id, 'medium')[0];
        $full = wp_get_attachment_image_src($id, 'large')[0];
        $descr = get_post_field('post_excerpt', $id);
        $meta = get_post_meta($id, '_wp_attachment_image_alt', true);
        $imgs[] = array('thumb' => $thumb, 'full' => $full, 'meta' => $meta, 'descr' => $descr);
    }

    return $imgs;
}

function tango_get_top_image()
{
    $post = get_post();
    if($test = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' )) {
        $image = $test;
    } else {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(219), 'full' );
    }

    return $image;
}
function tango_get_top_title()
{
    $post = get_post();
    switch($post->post_type) {
        case 'page':
            return get_the_title();
        case 'post':
            if(is_singular()) {
                return get_the_title();
            } else {
                return get_the_category()[0]->name;
            }
            break;
        default:
            return get_the_title();
    }

return $post->post_title;


    return $title;
}

/***********************************************************************/
//  SIDEBAR
/***********************************************************************/
function tango_get_categories()
{
    $categories = get_categories(array('orderby' => 'name', 'order' => 'ASC'));
    $actual = get_the_category(get_post()->ID)[0];
    $list = array();
    foreach($categories as $category) {
        if(in_array($category->category_nicename, array('conseils-pratiques', 'edito', 'stages'))) {
            if($actual->category_nicename == $category->category_nicename)
                $category->is_selected = true;
            $list[] = $category;
        }
    }
    return $list;
}
function tango_get_recents()
{
    $args = array(
        'post_type' => 'post',
        'numberposts' => 5, // we need only the latest post, so get that post only
        'category' => array(14, 16, 18), // Use the category id, can also replace with category_name which uses category slug
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $posts = get_posts($args);
    foreach($posts as $post) {
        $post->post_url = get_the_permalink($post);//get_category_link(get_the_category($post->ID)[0]).'/'.$post->post_name;
//        $post->post_url = '/'.$post->post_name;
    }

    return $posts;
}