<?php

class backendframework{
  public $addmenu;
  public $args;



  public function __construct(){

    add_action('after_setup_theme',array($this,'themes_setup'));
    add_action('wp_enqueue_script',array($this,'theme_scripts'));
    add_action('widgets_init', array($this,'add_widget') );

  }

  public function themes_setup(){

    // This theme uses wp_nav_menu() in two locations.
    if(isset($this->addmenu)){
        register_nav_menus($this->addmenu);
    }

  }
  public function addcss($cssname,$cssfile){
      if(!is_admin()){
          wp_enqueue_style($cssname,get_template_directory_uri().'/assets/css/'.$cssfile);
      }

  }

  public function addjs($jsname,$jsfile){
      wp_enqueue_script($jsname,get_template_directory_uri().'/assets/js/'.$jsfile,array('jquery'),'2017',true);
  }
  public function addfont($fontname,$fontlink){
      wp_enqueue_style($fontname,$fontlink);
  }
  public function addgeneralcss(){
      wp_enqueue_style('stylesheet',get_stylesheet_uri());
  }


  public function theme_scripts(){
      $this->addfont();
      $this->addcss();
      $this->addgeneralcss();
      $this->addjs();
  }


  public function add_widget($widget){
      register_sidebar($widget);
  }
  public function custom_post_type(){
      $this->add_post_type();
  }

}

//Class to make post type
class oo_post_type{
    public $singular;
    public $plural;
    public $name;
    public $menu_icon;
    public function __construct($name,$plural,$singular,$menu_icon){
        $this->name=$name;
        $this->plural=$plural;
        $this->singular=$singular;
        $this->menu_icon=$menu_icon;
        add_action( 'init', array($this,'post_type_function') );

    }
    function post_type_function() {
    register_post_type( $this->name,
    array(
      'labels' => array(
        'name' => __( $this->plural ),
        'singular_name' => __( $this->singular )
      ),
      'public' => true,
      'has_archive' => true,
      'menu_icon'=> $this->menu_icon,
      'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
    )
  );
}

}


//create taxonomie

class add_taxonomy{

  public $single_name;
  public $plural_name;
  public $taxonomy_title;
  public $labels;
  public $post_type;
  public $taxonomy_name;
  public function __construct($taxonomy_name,$single_name,$plural_name,$taxonomy_title,$post_type){
    $this->single_name=$single_name;
    $this->plural_name=$plural_name;
    $this->taxonomy_title=$taxonomy_title;
    $this->taxonomy_name=$taxonomy_name;
    $this->post_type=$post_type;
    add_action('init',array($this,'create_guidetheme_taxonomy'),0);
  }
  public function create_guidetheme_taxonomy(){
    $this->labels=array(
    'name' => _x( $this->taxonomy_title, 'taxonomy general name' ),
    'singular_name' => _x( $this->single_name, 'taxonomy singular name' ),
    'search_items' =>  __( 'Search '.$this->plural_name ),
    'all_items' => __( 'All '.$this->plural_name ),
    'parent_item' => __( 'Parent '.$this->plural_name ),
    'parent_item_colon' => __( 'Parent '.$this->plural_name ),
    'edit_item' => __( 'Edit '.$this->plural_name ),
    'update_item' => __( 'Update '.$this->plural_name ),
    'add_new_item' => __( 'Add New '.$this->plural_name ),
    'new_item_name' => __( 'New '.$this->plural_name.' Name' ),
    'menu_name' => __( $this->plural_name ),
  );
  register_taxonomy($this->taxonomy_name,array($this->post_type), array(
    'hierarchical' => true,
    'labels' => $this->labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => $this->single_name ),
  ));
  }

}


//adding image to category

class categoryImage{
  public $taxonomy_name;

  public function __construct($taxonomy_name){
    $this->taxonomy_name=$taxonomy_name;
    $this->load_wp_media_files();
    add_image_size('small','60','60',true);
    add_action( $this->taxonomy_name.'_add_form_fields', array ( $this, 'add_category_image' ), 10, 2 );
    add_action( 'created_'.$this->taxonomy_name, array ( $this, 'save_category_image' ), 10, 2 );
    add_action( $this->taxonomy_name.'_edit_form_fields', array ( $this, 'update_category_image' ), 10, 2 );
    add_action( 'edited_'.$this->taxonomy_name, array ( $this, 'updated_category_image' ), 10, 2 );
     add_action( 'admin_footer', array ( $this, 'add_script' ) );
     add_filter( 'manage_edit-'.$this->taxonomy_name.'_columns', array($this,'jt_edit_term_columns') );
     add_filter( 'manage_'.$this->taxonomy_name.'_custom_column', array($this,'jt_manage_term_custom_column'), 10, 3 );
  }
  //adding picture on categories
function load_wp_media_files() {

wp_enqueue_media();
}
  public function add_category_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="<?php echo $this->taxonomy_name;?>-image-id"><?php _e('Image', 'hero-theme'); ?></label>
     <input type="hidden" id="<?php echo $this->taxonomy_name;?>-image-id" name="<?php echo $this->taxonomy_name;?>-image-id" class="custom_media_url" value="">
     <div id="<?php echo $this->taxonomy_name;?>-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
    </p>
   </div>
 <?php
 }


 /*
  * Save the form field
  * @since 1.0.0
 */
 public function save_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST[$this->taxonomy_name.'-image-id'] ) && '' !== $_POST[$this->taxonomy_name.'-image-id'] ){
     $image = $_POST[$this->taxonomy_name.'-image-id'];
     add_term_meta( $term_id, $this->taxonomy_name.'-image-id', $image, true );
   }
 }

 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_category_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="<?php echo $this->taxonomy_name;?>-image-id"><?php _e( 'Image', 'hero-theme' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, $this->taxonomy_name.'-image-id', true ); ?>
       <input type="hidden" id="<?php echo $this->taxonomy_name;?>-image-id" name="<?php echo $this->taxonomy_name;?>-image-id" value="<?php echo $image_id; ?>">
       <div id="<?php echo $this->taxonomy_name;?>-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'small' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
       </p>
     </td>
   </tr>
 <?php
 }
 /*
 * Update the form field value
 * @since 1.0.0
 */
 public function updated_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST[$this->taxonomy_name.'-image-id'] ) && '' !== $_POST[$this->taxonomy_name.'-image-id'] ){
     $image = $_POST[$this->taxonomy_name.'-image-id'];
     update_term_meta ( $term_id, $this->taxonomy_name.'-image-id', $image );
   } else {
     update_term_meta ( $term_id, $this->taxonomy_name.'-image-id', '' );
   }
 }


//adding image to category list
public function jt_edit_term_columns( $columns ) {

    $columns['image'] = __( 'Image', 'guide' );

    return $columns;
}


public function jt_manage_term_custom_column( $out, $column, $term_id ) {

    if ( 'image' === $column ) {

        $image_id = get_term_meta( $term_id, $this->taxonomy_name.'-image-id', true );



    }

  echo wp_get_attachment_image ( $image_id, 'small' );
}

/*
 * Add script
 * @since 1.0.0
 */
 public function add_script() { ?>

   <script>
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#<?php echo $this->taxonomy_name;?>-image-id').val(attachment.id);
               $('#<?php echo $this->taxonomy_name;?>-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#<?php echo $this->taxonomy_name;?>-image-wrapper .custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button');
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#<?php echo $this->taxonomy_name;?>-image-id').val('');
       $('#<?php echo $this->taxonomy_name;?>-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#<?php echo $this->taxonomy_name;?>-image-wrapper').html('');
         }
       }
     });
   });
 </script>
 <?php }


}


class wp_editor_metabox{
    public $metaid;
    public $metatitle;
    public $post_type;
    public $wpeditor_id;
    public $metaboxnonce_id;
    public function __construct($metaid,$metatitle,$post_type,$wpeditor_id,$metaboxnonce_id){
        $this->metaid=$metaid;
        $this->metatitle=$metatitle;
        $this->post_type=$post_type;
        $this->wpeditor_id=$wpeditor_id;
        $this->metaboxnonce_id=$metaboxnonce_id;
        add_action('add_meta_boxes',array($this,'new_metabox'));
        add_action('save_post',array($this,'new_metabox_save'));
    }


    function new_metabox(){
    	add_meta_box($this->metaid,$this->metatitle,array($this,'new_metabox_detail'),$this->post_type,'normal','high');
    }
    function new_metabox_detail($post) {
        $field_value = get_post_meta( $post->ID, $this->wpeditor_id, false );
        if($field_value[0]==""){
             wp_editor( $field_value[0], $this->wpeditor_id, array('textarea_rows' => '5') );
        }else{
            wp_editor( $field_value[0], $this->wpeditor_id, array('textarea_rows' => '5') );
        }

        wp_nonce_field($this->metaboxnonce_id, 'meta_box_nonce');
    }

    function new_metabox_save($post_id){
    	        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], $this->metaboxnonce_id))
            return;

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post'))
            return;
            if (isset($_POST[$this->wpeditor_id])) {
            update_post_meta($post_id, $this->wpeditor_id, $_POST[$this->wpeditor_id]);
        }

    }
}

class addimagecustomizer{

    public $settingid;
    public $sectionid;
    public $sectiontitle;
    public $sectiondescription;
    public function __construct($settingid,$sectionid,$sectiontitle,$sectiondescription){
        $this->settingid=$settingid;
        $this->sectionid=$sectionid;
        $this->sectiontitle=$sectiontitle;
        $this->sectiondescription=$sectiondescription;
        add_action( 'customize_register', array($this,'addcustomizer') );
    }

    public function addcustomizer($wp_customize){
         //adding logo upload
        $wp_customize->add_setting($this->settingid);
        $wp_customize->add_section($this->sectionid,array(
        'title'=>__($this->sectiontitle,'gosimple'),
        'priority'=>30,
        'description'=>$this->sectiondescription
        ));
         $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,$this->settingid,array(
        'label' =>__($this->sectiontitle,'gosimple'),
        'section'=>$this->sectionid,
        'settings'=>$this->settingid
        )));
    }
}

class addcolorcustomizer{
    public $settingid;
    public $sectionid;
    public $sectiontitle;
    public $controltitle;
    public $sectiondescription;

    public function __construct($settingid,$sectionid,$sectiontitle,$controltitle,$sectiondescription){
        $this->settingid=$settingid;
        $this->sectionid=$sectionid;
        $this->sectiontitle=$sectiontitle;
        $this->controltitle=$controltitle;
        $this->sectiondescription=$sectiondescription;
        add_action( 'customize_register', array($this,'addcustomizer') );
    }

    public function addcustomizer($wp_customize){
         //adding logo upload
        $wp_customize->add_setting($this->settingid,array('type'=>'theme_mod','default'=>'#000000'));
        $wp_customize->add_section($this->sectionid,array(
        'title'=>__($this->sectiontitle,'gosimple'),
        'priority'=>30,
        'description'=>$this->sectiondescription
        ));
         $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,$this->settingid,array(
        'label' =>__($this->controltitle,'gosimple'),
        'section'=>$this->sectionid,
        'settings'=>$this->settingid
        )));
    }

}


?>