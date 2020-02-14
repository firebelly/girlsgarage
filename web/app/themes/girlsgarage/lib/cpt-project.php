<?php
/**
 * Project post type
 */

namespace Firebelly\PostTypes\Project;
use PostTypes\PostType; // see https://github.com/jjgrainger/PostTypes
use PostTypes\Taxonomy;

$projects = new PostType(['name' => 'project', 'plural' => 'Projects', 'slug' => 'projects'], [
  'taxonomies' => ['topic'],
  'supports'   => ['title', 'thumbnail', 'editor', 'revisions'],
  'rewrite'    => ['with_front' => false],
]);
$projects->filters(['topic']);
$projects->icon('dashicons-hammer');

// Custom taxonomies
$topic = new Taxonomy([
  'name'     => 'topic',
  'slug'     => 'topic',
  'plural'   => 'Topics',
]);
$topic->register();

$projects->register();

/**
 * CMB2 custom fields
 */
function metaboxes() {
  $prefix = '_cmb2_';

  $project_info = new_cmb2_box([
    'id'            => $prefix . 'project_info',
    'title'         => __( 'Project Info', 'cmb2' ),
    'object_types'  => ['project'],
    'context'       => 'normal',
    'priority'      => 'high',
  ]);
  $tools_group = $project_info->add_field([
    'id'              => $prefix .'tools',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Tool {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Tool', 'cmb2' ),
      'remove_button' => __( 'Remove Tool', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $project_info->add_group_field( $tools_group, [
    'name' => 'Quantitiy',
    'id'   => 'quantitiy',
    'type' => 'text_small',
  ]);
  $project_info->add_group_field( $tools_group, [
    'name' => 'Name/description',
    'id'   => 'name',
    'type'  => 'text',
  ]);

  $parts_group = $project_info->add_field([
    'id'              => $prefix .'parts',
    'type'            => 'group',
    'options'         => [
      'group_title'   => __( 'Part {#}', 'cmb2' ),
      'add_button'    => __( 'Add Another Part', 'cmb2' ),
      'remove_button' => __( 'Remove Part', 'cmb2' ),
      'sortable'      => true,
    ],
  ]);
  $project_info->add_group_field( $parts_group, [
    'name' => 'Quantitiy',
    'id'   => 'quantitiy',
    'type' => 'text_small',
  ]);
  $project_info->add_group_field( $parts_group, [
    'name' => 'Name/description',
    'id'   => 'name',
    'type'  => 'text',
  ]);
}
add_filter( 'cmb2_admin_init', __NAMESPACE__ . '\metaboxes' );
