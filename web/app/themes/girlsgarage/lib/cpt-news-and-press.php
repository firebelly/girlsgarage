<?php
/**
 * News and Press post type
 */

namespace Firebelly\PostTypes\NewsAndPress;
use PostTypes\PostType; // see https://github.com/jjgrainger/PostTypes
use PostTypes\Taxonomy;

$news_and_press = new PostType(['name' => 'news_and_press', 'plural' => 'News and Press Posts', 'slug' => 'news-and-press'], [
  'taxonomies' => ['topic'],
  'supports'   => ['title', 'thumbnail', 'editor', 'revisions'],
  'rewrite'    => ['with_front' => false],
]);
$news_and_press->filters(['topic']);
$news_and_press->icon('dashicons-media-document');

// Custom taxonomies
$topic = new Taxonomy([
  'name'     => 'topic',
  'slug'     => 'topic',
  'plural'   => 'Topics',
]);
$topic->register();

$news_and_press->register();