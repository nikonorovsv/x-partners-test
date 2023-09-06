<?php

namespace theme\helpers;

use theme\core\Component;
use WP_Post;

/**
 * Class Menu
 * @package theme\helpers
 */
class Menu extends Component
{
    use Cache;

    private array $_items;
    private $_uid;

    private ?WP_Post $_current = null;
    private ?WP_Post $_ancestor = null;
    private ?WP_Post $_parent = null;

    private string $_post_type = '';
    private ?WP_Post $_post_type_ancestor = null;
    private ?WP_Post $_post_type_parent = null;

    /**
     * @param string $uid String location name or Int menu id
     * @param array $conf
     */
    public function __construct($uid, array $conf = [])
    {
        parent::__construct($conf);

        $this->_uid = $uid;
        $this->_items = $this->wpData();
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        $fallback = function () {
            return $this->_items
                ? $this->walk($this->_items[0])
                : [];
        };

        return static::cache($fallback, "menu_{$this->_uid}");
    }

    /**
     * @param string $post_type
     * @return void
     */
    public function usePostType(string $post_type): void
    {
        $this->_post_type = $post_type;
    }

    /**
     * Should be called after self::items()
     * @return ?WP_Post
     */
    public function getCurrent(): ?WP_Post
    {
        return $this->_current;
    }

    /**
     * Should be called after self::items()
     * @return ?WP_Post
     */
    public function getAncestor(): ?WP_Post
    {
        return $this->_ancestor;
    }

    /**
     * Should be called after self::items()
     * @return ?WP_Post
     */
    public function getPostTypeAncestor(): ?WP_Post
    {
        return $this->_post_type_ancestor;
    }

    /**
     * Should be called after self::items()
     * @return ?WP_Post
     */
    public function getParent(): ?WP_Post
    {
        return $this->_parent;
    }

    /**
     * Should be called after self::items()
     * @return ?WP_Post
     */
    public function getPostTypeParent(): ?WP_Post
    {
        return $this->_post_type_parent;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        $items = $this->getItems();

        $_relevant = [
            $this->_ancestor,
            $this->_current,
            $this->_parent,
            $this->_post_type_ancestor,
            $this->_post_type_parent
        ];

        $relevant = [];
        foreach ($_relevant as $p) {
            if (!empty($p)) {
                $relevant[] = $p->ID;
            }
        }

        foreach ($items as $item) {
            if (in_array($item['menu_id'], $relevant)) {
                return $item['items'] ?? [];
            }
        }

        return [];
    }

    /**
     * @param WP_Post $item
     * @return void
     */
    private function setActive(WP_Post $item): void
    {
        if ($this->_post_type && in_array("current-{$this->_post_type}-ancestor", $item->classes)) {
            $this->_post_type_ancestor = $item;
        }
        if ($this->_post_type && in_array("current-{$this->_post_type}-parent", $item->classes)) {
            $this->_post_type_parent = $item;
        }

        if ($item->current) {
            $this->_current = $item;
        }
        if ($item->current_item_ancestor) {
            $this->_ancestor = $item;
        }
        if ($item->current_item_parent) {
            $this->_parent = $item;
        }
    }

    /**
     * @return array
     */
    private function wpData(): array
    {
        global $_wp_registered_nav_menus;
        if (!$_wp_registered_nav_menus) {
            return [];
        }
        $menu_id = $this->getId();
        if (empty($menu_id)) {
            return [];
        }
        $menu = wp_get_nav_menu_object($menu_id);
        $items = (array)wp_get_nav_menu_items($menu, ['update_post_term_cache' => false]);
        unset($locations, $menu);
        if (!$items) {
            return [];
        }
        _wp_menu_item_classes_by_context($items);
        $prepared_items = [];
        foreach ($items as $item) {
            $prepared_items[$item->menu_item_parent][] = $item;
        }
        unset($items);

        return $prepared_items;
    }

    /**
     * @return int
     */
    private function getId(): int
    {
        if (is_int($this->_uid)) {
            return $this->_uid;
        } else if (is_string($this->_uid)) {
            // Try by location slug
            if ($id = self::getMenuIdByLocation($this->_uid)) {
                return $id;
            }
            // Try by name
            if ($id = self::getMenuIdByName($this->_uid)) {
                return $id;
            }
        }

        return $this->_uid;
    }

    /**
     * @param array $items
     *
     * @return array
     */
    private function walk(array $items): array
    {
        $_items = [];
        foreach ($items as $item) {
            $item->classes = array_filter($item->classes);
            $this->setActive($item);

            $_item = [];
            $_item['menu_id'] = $item->ID;
            $_item['title'] = $item->title;
            $_item['url'] = $item->url;
            if (array_key_exists($item->ID, $this->_items)) {
                $_item['items'] = $this->walk($this->_items[$item->ID]);
            }

            $_item['options'] = [
                'id' => sprintf($this->item_id ?? null, $item->ID),
                'class' => array_values($item->classes),
                'title' => $item->attr_title,
                'target' => $item->target,
                'rel' => $item->xfn
            ];

            $_items[] = $_item;
        }

        return $_items;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function getMenuIdByName(string $name)
    {
        $fallback = function () use ($name) {
            $menus = wp_get_nav_menus();
            foreach ($menus as $menu) {
                if ($menu->name === $name) {
                    return $menu->term_id;
                }
            }
            return null;
        };

        return static::cache($fallback, 'menu_id_by_name_' . sanitize_key($name));
    }

    /**
     * @param string $location_name
     * @return mixed
     */
    public static function getMenuIdByLocation(string $location_name)
    {
        $fallback = function () use ($location_name) {
            $locations = get_nav_menu_locations();
            if ($locations && isset($locations[$location_name])) {
                return $locations[$location_name];
            }
            return null;
        };

        return static::cache($fallback, 'menu_id_by_location_' . sanitize_key($location_name));
    }
}
