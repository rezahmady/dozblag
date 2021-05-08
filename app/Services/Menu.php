<?php

namespace App\Services;

use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class Menu { 
    protected $items;
    protected $current;
    protected $currentKey;
    
    public function __construct() {
        $this->current = Request::url();
    }

    /** Shortcut method for create a menu with a callback.
     * This will allow you to do things like fire an even on creation.
     * @param callable $callback Callback to use after the menu creation 
     * @return object
     */ 
    public static function create($callback) {
        $menu = new Menu(); $callback($menu);
        $menu->sortItems(); return $menu;
    }
    
    /** Add a menu item to the item stack
     * @param string $key Dot separated hierarchy 
     * @param string $name Text for the anchor 
     * @param string $url URL for the anchor 
     * @param integer $sort Sorting index for the items 
     * @param string $icon URL to use for the icon 
     */
    public function add($key, $name, $url, $sort = 0, $icon = null) { 
        $item = array(
            'key' => $key,
            'name' => $name,
            'url' => $url,
            'sort' => $sort,
            'icon' => $icon,
            'children' => array()
            );
        $children = str_replace('.', '.children.', $key);
		if(is_array($this->items)) {
			if(!array_key_exists($key, $this->items)) {
				array_set($this->items, $children, $item);
				if ($url == $this->current) {
					$this->currentKey = $key; }
			}
		} else {
			array_set($this->items, $children, $item);
				if ($url == $this->current) {
					$this->currentKey = $key; }
		}
		
    }
    
    /** Recursive function to loop through items and create a menu 
     * @param array $items List of items that need to be rendered 
     * @param boolean $level Which level you are currently rendering 
     * @return string
     */
    public function render($items = null, $level = 1) { 

		// dd($this->items);
        $items = $items ?: $this->items;
		$menu = '';
        if(is_array($this->items)) foreach($items as $item) {
			$classes = array('nav-item');
            $classes[] = $this->getActive($item);
            $has_children = sizeof($item['children']);
            
            if ($has_children) {
				$classes[] = 'nav-dropdown';
            }
            $menu .= '<li class="' . implode(' ', $classes). '" >';
            $menu .= $this->createAnchor($item);
			$menu .= ($has_children) ? '<ul class="nav-dropdown-items">' : '' ;
            $menu .= ($has_children) ? $this->render($item['children'], ++$level) : '';
			$menu .= ($has_children) ? '</ul>' : '' ;
            $menu .= '</li>';
		}
        return $menu;
    }

	public function render_old($items = null, $level = 1) { 

		dd($this->items);
        $items = $items ?: $this->items;
		$attr = (1 === $level) ? 'menu level-1' : 'level-' . $level;
        $menu = '<ul class="' . $attr . '" >'; foreach($items as $item) {
            $classes = array('menu__item');
            $classes[] = $this->getActive($item);
            $has_children = sizeof($item['children']);
            
            if ($has_children) {
                $classes[] = 'parent';
            }
            $menu .= '<li class="' . implode(' ', $classes). '" >';
            $menu .= $this->createAnchor($item);
            $menu .= ($has_children) ? $this->render($item['children'], ++$level) : '';
            $menu .= '</li>'; }
            $menu .= '</ul>';
        return $menu;
    }
    
    /** Method to render an anchor 
     * @param array $item Item that needs to be turned into a link 
     * @return string 
     */
    private function createAnchor($item) {
		$has_children = sizeof($item['children']);
		$class = ($has_children) ? ' nav-dropdown-toggle' : '' ;
        $output = '<a class="nav-link'.$class.'" href="' . $item['url'] . '">';
        $output .= $this->createIcon($item);
        $output .= $item['name'];
        $output .= '</a>';
        return $output;
    }
    
    /** Method to render an icon 
     * @param array $item Item that needs to be turned into a icon
     * @return string
     */
    private function createIcon($item) {
        $output = ''; if($item['icon']) {
            $output .= sprintf('<i class="nav-icon la la-%s"></i>', $item['icon']);
        } return $output;
    }
    
    /** Method to sort through the menu items and put them in order 
     * @return void 
     */
    private function sortItems() { 
        if(is_array($this->items)) usort($this->items, function($a, $b) {
            if($a['sort'] == $b['sort']) {
                return 0;
            }
            return ($a['sort'] < $b['sort'] ? -1 : 1);
        });
    }
    
    /** Method to find the active links 
     * @param array $item Item that needs to be checked if active 
     * @return string 
     */
    private function getActive($item) {
        $url = trim($item['url'], '/');
        if ($this->current === $url) {
            return 'active current';
        }
        
        if(strpos($this->currentKey, $item['key']) === 0) {
            return 'active';
        }
        
        return '';
    }
}