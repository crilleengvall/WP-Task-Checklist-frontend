<?php

function tcf_setup_post_type() {
  register_post_type('tcf_task',
    array(
          'labels' => array(
            'name' => __('Tasks', 'task-checklist-frontend'),
            'singular_name'      => __('Task', 'task-checklist-frontend'),
            'add_new'            => __('Add new', 'task-checklist-frontend'),
            'add_new_item'       => __('Add new task', 'task-checklist-frontend'),
            'edit_item'          => __( 'Edit task', 'task-checklist-frontend' ),
            'new_item'           => __( 'New task', 'task-checklist-frontend' ),
            'all_items'          => __( 'All tasks', 'task-checklist-frontend' ),
            'view_item'          => __( 'View task', 'task-checklist-frontend' ),
            'search_items'       => __( 'Search for task', 'task-checklist-frontend' ),
            'not_found'          => __( 'No tasks found', 'task-checklist-frontend' ),
            'not_found_in_trash' => __( 'No tasks in trash', 'task-checklist-frontend' )
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
    'name'              => __( 'Task category', 'task-checklist-frontend'),
    'singular_name'     => __( 'Task category', 'task-checklist-frontend'),
    'search_items'      => __( 'Search task category', 'task-checklist-frontend' ),
    'all_items'         => __( 'All task categories', 'task-checklist-frontend' ),
    'edit_item'         => __( 'Edit task category', 'task-checklist-frontend' ),
    'update_item'       => __( 'Update task category', 'task-checklist-frontend' ),
    'add_new_item'      => __( 'Add task category', 'task-checklist-frontend' ),
    'new_item_name'     => __( 'New task category', 'task-checklist-frontend' ),
    'menu_name'         => __( 'Task category', 'task-checklist-frontend' ),
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
