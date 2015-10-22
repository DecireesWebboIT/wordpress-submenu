# wordpress-submenu

This page will explain you how to display a sub-group of a custom menu element in wordpress, separated from any other menu (the initial menu has to be created inside "appearance -> menu" of wordpress admin area.
For example, we have the following menu:
* home
* about
    * organisation
        * team
        * users
        * reviews
* contact
    * mail
    * phone
    * bird

and we want to display only :
* team
* users
* reviews
or:
* mail
* phone
* bird
depending on our actual location inside the menu

The menu widget doesn't allow us to do that, so we have to find a way to do it manually. A great plugin is available with such features, if you want to display it via a widget: [Custom menu wizard](https://wordpress.org/plugins/custom-menu-wizard/) .
In our case, we don't want to display it in a widget, but we want to display it via the template, for example in the header.php file.

# Installation
* copy the content of **functions.php** inside your wordpress theme function.php
* declare your menu name and location in the code you just copy-pasted
* copy the **include directory** into your wordpress theme directory
* copy the compact menu code from header.php wherever you want in one of your templates
* configure the menu depth and the location you chose for your menu
* make sure you have a multi-level menu configured in your wordpress backend
* display a child page with your template assigned
* enjoy
