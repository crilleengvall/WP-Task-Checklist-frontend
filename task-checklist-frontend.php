<?php
/*
* Plugin Name: Task checklist - frontend
* Plugin URI: https://crilleengvall.github.io/WP-Task-Checklist-frontend/
* Description: Adds custom post type task. Displays tasks for visitors as checkboxes and checklists. Saves status of task in cookie.
* Version: 0.1
* Author: Christian Engvall
* Author URI: http://www.christianengvall.se
* License: GPL3
* License URI: https://www.gnu.org/licenses/gpl-3.0.html
* Text Domain: task-checklist-frontend
* Domain Path: /languages

Task checklist - frontend is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Task checklist - frontend is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Task checklist - frontend.  If not, see <https://www.gnu.org/licenses/gpl-3.0.html>.
*/
require_once('markup/print-markup.php');

class TaskChecklistFrontend {
  public function __construct() {
    $this->register_hooks();
  }

  public function register_hooks() {
    $this->add_custom_post_type();
    add_action( 'wp_enqueue_scripts', array($this, 'enqueue_css') );
    add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script') );
    register_activation_hook(__FILE__, array($this, 'perform_installation') );
    register_deactivation_hook( __FILE__, array($this, 'deactivate') );
    add_shortcode('tcf_task', array($this, 'display_task'));
    add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );
    add_action('admin_init', array($this, 'setup_tiny_mce_plugin'));
  }

  public function load_plugin_textdomain() {
    load_plugin_textdomain( 'task-checklist-frontend', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
  }

  public function perform_installation() {
    flush_rewrite_rules();
  }

  public function add_custom_post_type() {
    require_once( 'custom-post-types/task-custom-post-type.php' );
  }

  function deactivate() {
    flush_rewrite_rules();
  }

  public function enqueue_css() {
    wp_enqueue_style( 'tcf-css', plugins_url( '/css/tcfstyle.css', __FILE__ ) );
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
  }

  public function enqueue_script() {
    wp_enqueue_script( 'js-cookie', plugins_url( 'javascript/js.cookie.js', __FILE__ ) );
    wp_enqueue_script( 'tcf-js', plugins_url( 'javascript/tcfscripts.js', __FILE__ ) );
  }

  public function setup_tiny_mce_plugin() {
    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
        add_filter( 'mce_buttons', array( $this, 'register_tinymce_button' ) );
        add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_button' ) );
        add_filter( 'tiny_mce_before_init', array( $this, 'add_tinymce_task_categories' ) );
    }
  }

  public function add_tinymce_task_categories( $settings ) {
    $terms = get_terms( array(
        'taxonomy' => 'tcf_category',
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC'
    ));
    $settings_terms =  array();
    foreach ($terms as $key => $term) {
      array_push($settings_terms, $term->term_id . ':' . $term->name);
    }
    $settings['tcf_categories'] = implode(",", $settings_terms);
    return $settings;
  }

  public function register_tinymce_button( $buttons ) {
   array_push( $buttons, "button_task_checklist" );
   return $buttons;
  }

  function add_tinymce_button( $plugin_array ) {
     $plugin_array['task_checklist_script'] = plugins_url( '/editor/editor_plugin.js', __FILE__ ) ;
     return $plugin_array;
  }

  public function display_task($attributes) {
    $posts = $this->get_posts_from_shortcode_attributes($attributes);
    $printer = new TCFPrintMarkup();
    return $printer->create_tasklist_markup($posts);
  }

  private function get_posts_from_shortcode_attributes($attributes) {
    $posts_array = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'tcf_task',
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'tcf_category',
                'field' => 'term_id',
                'terms' => $attributes['categoryid'],
            ))));
            return $posts_array;
    }
}

$taskChecklistPlugin = new TaskChecklistFrontend();
