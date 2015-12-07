<?php

// descriptive submenu

//location of the nav menu to display (registered via register_nav_menu in functions.php)
$location = 'your_location';

//Choose the depth that will have the menu items displayed. top depth is 1
//If the depth is below the actual level,
//the deepest level available will be displayed instead
$display_depth = 1;
//get the the parent item containing the childrens to display. extract the ID
$menu_parent = get_menu_parent($location, $display_depth);
$menu_parent_id=$menu_parent["id"];
//create a new custom walker (that display all the childs of the given menu item)
$walker = new submenuwalker($menu_parent_id);
//display the menu
wp_nav_menu(array('theme_location' => $location, 'container' => 'div', 'walker' => $walker));

//end descriptive submenu


//compact submenu

$location = 'your_location';
$display_depth = 1;
$walker = new submenuwalker(get_menu_parent($location, $display_depth)["id"]);
wp_nav_menu(array('theme_location' => $location, 'container' => 'div', 'walker' => $walker));

//end compact submenu

//submenu 2.0 without submenuwalker
// to init
echo "normal:<br>";
wp_nav_menu(array(
  'theme_location' => 'primary',
  'sub_menu' => true
));
echo "from second level to bottom<br>";
wp_nav_menu(array(
  'theme_location' => 'primary',
  'sub_menu' => true,
  'sub_menu_from_second_level' => true,
));
echo "only first level:<br>";
wp_nav_menu(array(
  'theme_location' => 'primary',
  'depth' => '1',
));
echo "only first and second level:<br>";
wp_nav_menu(array(
  'theme_location' => 'primary',
  'depth' => '2',
));
echo "only second level:<br>";
wp_nav_menu(array(
  'theme_location' => 'primary',
  'sub_menu' => true,
  'sub_menu_only_second_level' => true,
));
echo "only siblings:<br>";
wp_nav_menu(array(
  'theme_location' => 'primary',
  'sub_menu' => true,
  'sub_menu_only_siblings' => true,
));

//end submenu 2.0 without submenuwalker