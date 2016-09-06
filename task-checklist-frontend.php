<?php
/*
* Plugin Name: Task checklist - frontend
* Plugin URI: http://www.christianengvall.se
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

class TaskChecklistFrontend {
  public function __construct() {
    $this->register_hooks();
  }

  public function register_hooks() {
    $this->add_custom_post_type();
    register_activation_hook(__FILE__, array($this, 'perform_installation') );
    register_deactivation_hook( __FILE__, array($this, 'deactivate') );
    add_shortcode('tcf_task', array($this, 'display_task'));
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

  public function display_task($attributes) {
    $posts_array = get_posts(
    array(
        'posts_per_page' => -1,
        'post_type' => 'tcf_task',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'tcf_category',
                'field' => 'term_id',
                'terms' => 27,
            )
        )
      )
    );
    $html = "";
    foreach ($posts_array as $key => $post) {
      $html .= '<div class="tcf-task">' . $post->post_title . '</div>';
    }
    return $html;
    //return "<pre>" . print_r($posts_array, true) . "</pre>";
  }
}

$taskChecklistPlugin = new TaskChecklistFrontend();
