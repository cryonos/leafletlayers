<?php

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 *
 * @since      1.0.0
 * @package    LeafletLayers
 * @subpackage LeafletLayers/includes
 *
 */

if ( ! class_exists( 'LeafletLayers_Actions_Filters' ) ) {

	class LeafletLayers_Actions_Filters {

		/**
		 * The array of actions registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
		 */
		protected static $actions = array();

		/**
		 * The array of filters registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
		 */
		protected static $filters = array();
		
		/**
		 * The array of actions registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
		 */
		protected static $shortcodes = array();

		/**
		 * Add a new action to the collection to be registered with WordPress.
		 *
		 * @since    1.0.0
		 * @param      string               $hook             The name of the WordPress action that is being registered.
		 * @param      object               $component        A reference to the instance of the object on which the action is defined.
		 * @param      string               $callback         The name of the function definition on the $component.
		 * @param      int      Optional    $priority         The priority at which the function should be fired.
		 * @param      int      Optional    $accepted_args    The number of arguments that should be passed to the $callback.
		 */
		public static function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {

			self::$actions = self::add( self::$actions, $hook, $component, $callback, $priority, $accepted_args );
		
		}

		/**
		 * Add a new filter to the collection to be registered with WordPress.
		 *
		 * @since    1.0.0
		 * @param      string               $hook             The name of the WordPress filter that is being registered.
		 * @param      object               $component        A reference to the instance of the object on which the filter is defined.
		 * @param      string               $callback         The name of the function definition on the $component.
		 * @param      int      Optional    $priority         The priority at which the function should be fired.
		 * @param      int      Optional    $accepted_args    The number of arguments that should be passed to the $callback.
		 */
		public static function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {

			self::$filters = self::add( self::$filters, $hook, $component, $callback, $priority, $accepted_args );
		
		}
		
		public static function add_shortcode( $tag, $function_name ) {

			self::$shortcodes = self::add_short( self::$shortcodes, $tag, $function_name );
		
		}

		/**
		 * A utility function that is used to register the actions and hooks into a single
		 * collection.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @param      array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
		 * @param      string               $hook             The name of the WordPress filter that is being registered.
		 * @param      object               $component        A reference to the instance of the object on which the filter is defined.
		 * @param      string               $callback         The name of the function definition on the $component.
		 * @param      int      Optional    $priority         The priority at which the function should be fired.
		 * @param      int      Optional    $accepted_args    The number of arguments that should be passed to the $callback.
		 * @return   type                                   The collection of actions and filters registered with WordPress.
		 */
		private static function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

			$hooks[] = array(
				'hook'          => $hook,
				'component'     => $component,
				'callback'      => $callback,
				'priority'      => $priority,
				'accepted_args' => $accepted_args
			);

			return $hooks;

		}
		
		private static function add_short($shorts, $tag, $function_name)	{
			
			$shorts[] = array(
			'tag' => $tag,
			'function_name' => $function_name
			);
			
			return $shorts;
		}

		/**
		 * Register the filters and actions with WordPress.
		 *
		 * @since    1.0.0
		 */
		public static function init_actions_filters() {

			foreach ( self::$filters as $hook ) {
				add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
			}

			foreach ( self::$actions as $hook ) {
				add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
			}
			foreach( self::$shortcodes as $short) {
				add_shortcode( $short['tag'], array('LeafletLayers_Controller_Public', $short['function_name']) );
			}

		}

	}

}