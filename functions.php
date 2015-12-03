<?php

//load custom menu walker class
require_once('includes/submenu_one_level_walker.php');

//register all menus
register_nav_menus( array(
  'your_location' => 'your_menu_description'
) );

// $location is the location name of the nav menu
function get_menu_parent( $location, $display_depth=1) {

  //get the actual menu item
  $menu_item=get_actual_menu_item($location);

  //get all the menu object specified
  $menu = wp_get_nav_menu_object(get_nav_menu_locations()[ $location ]);

  //get the name of the menu
  $menu_name = $menu->name;

  //get all the nav menu items of the specified menu
  $menu_items  = wp_get_nav_menu_items( $menu_name );

  //create a temporary array
  $temp_array=array();

  //avoir erasing the $menu_item
  $actualmenuitem=$menu_item;

  //if the actual menu item has been correctly set
  if(gettype($actualmenuitem)=='object') {

    //go up all the way to the root parent element of this submenu
    // saving all his ancestors in the temp array until the top
    $added_top_item=false;
    while ($actualmenuitem->menu_item_parent > 0) {
      foreach ($menu_items as $the_menu_item) {

        if ($the_menu_item->ID == $actualmenuitem->menu_item_parent) {
          array_push($temp_array, ["title"=>$actualmenuitem->title, "url"=>$actualmenuitem->url, "parent_id"=>$actualmenuitem->menu_item_parent, "id"=>$actualmenuitem->ID]);
          $actualmenuitem = $the_menu_item;
          break 1;
        }
      }
      if($actualmenuitem->menu_item_parent==0 && !$added_top_item){
        array_push($temp_array, ["title"=>$actualmenuitem->title, "url"=>$actualmenuitem->url, "parent_id"=>$actualmenuitem->menu_item_parent, "id"=>$actualmenuitem->ID]);
        break 1;
      }
    }
  }
  else{
    return false;
  }


  //add root level to the array
  array_push($temp_array, ["title"=>"home", "url"=>"/",]);

  //reverse the array to have the highest parent first
  $temp_array=array_reverse($temp_array);

  //check if the depth is too big, if it is the case, then set it to the minimum available
  if(sizeof($temp_array)<=$display_depth){
    $display_depth=sizeof($temp_array)-1;
  }
  //get the ID of the menu item parent that contains the elements we want to display
  $parent_item_id=$temp_array[$display_depth];

  //check if this page is a menu parent itself, and if it's the case, display its children anyway
  if(is_null($parent_item_id)){
    $parent_item_id = '';
  }
  return $parent_item_id;
}


/**
 * Get the Menu Name of the current page
 *
 * $loc is the location name of the nav menu
 *
 * Source:
 * http://wordpress.stackexchange.com/a/155833/1044
 *
 */
function get_actual_menu_item( $loc ) {
  global $post;
  $menuitem='';
  $locs = get_nav_menu_locations();
  $menu = wp_get_nav_menu_object( $locs[$loc] );
  if($menu) {
    $items = wp_get_nav_menu_items($menu->term_id);
    foreach ($items as $k => $v) {
      // Check if this menu item links to the current page
      if (isset($post) && $items[$k]->object_id == $post->ID) {
        $menuitem = $items[$k];
        break;
      }
    }
  }
  return $menuitem;
}


# filter_hook function to react on start_in argument
function my_wp_nav_menu_objects_start_in( $sorted_menu_items, $args ) {
  if(isset($args->start_in)) {
    $menu_item_parents = array();
    foreach( $sorted_menu_items as $key => $item ) {
      // init menu_item_parents
      if( $item->object_id == (int)$args->start_in ) $menu_item_parents[] = $item->ID;

      if( in_array($item->menu_item_parent, $menu_item_parents) ) {
        // part of sub-tree: keep!
        $menu_item_parents[] = $item->ID;
      } else {
        // not part of sub-tree: away with it!
        unset($sorted_menu_items[$key]);
      }
    }
    return $sorted_menu_items;
  } else {
    return $sorted_menu_items;
  }
}
# in functions.php add hook & hook function
add_filter("wp_nav_menu_objects",'my_wp_nav_menu_objects_start_in',10,2);