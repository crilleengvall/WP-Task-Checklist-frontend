<?php

function tcf_setup_post_type() {
  register_post_type('tcf_task',
    array(
          'labels' => array(
            'name' => __('Tasks'),
            'singular_name'      => __('Task'),
            'add_new'            => __('Add new'),
            'add_new_item'       => __('Add new task'),
            'edit_item'          => __( 'Redigera spartips' ),
            'new_item'           => __( 'New task' ),
            'all_items'          => __( 'All tasks' ),
            'view_item'          => __( 'View task' ),
            'search_items'       => __( 'Search for task' ),
            'not_found'          => __( 'No tasks found' ),
            'not_found_in_trash' => __( 'No tasks in trash' )
          ),
          'public' => true,
          'has_archive' => false,
          'menu_icon' => 'dashicons-yes',
          'exclude_from_search' => true,
          'rewrite' => false
    )
  );
}

add_action( 'init', 'tcf_setup_post_type' );


function tcf_setup_post_type_categories() {
  $labels = array(
    'name'              => _x( 'Task category', 'taxonomy general name' ),
    'singular_name'     => _x( 'Task category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search task category' ),
    'all_items'         => __( 'All task categories' ),
    'edit_item'         => __( 'Edit task category' ),
    'update_item'       => __( 'Update task category' ),
    'add_new_item'      => __( 'Add task category' ),
    'new_item_name'     => __( 'New task category' ),
    'menu_name'         => __( 'Task category' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' 	=> true,
    'public'		=> false,
    '_builtin'		=> false,
    'show_admin_column' => true,
    'show_ui' => true,
    'rewrite' => false
  );
  register_taxonomy( 'tcf_category', 'tcf_task', $args );
}

add_action( 'init', 'tcf_setup_post_type_categories', 0 );
