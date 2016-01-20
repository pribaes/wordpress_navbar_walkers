class wp_bootstrap_walker_accordion extends Walker_Nav_Menu {

    static private $header_nav_menu_mobile_id_cnt = 0;

    public function start_lvl(&$output) {
        $output .= "<div id=\"menucollapse-" . static::$header_nav_menu_mobile_id_cnt++ . "\" class=\"panel-collapse collapse\">";
        $output .= "<div class=\"panel\">";
    }

    public function end_lvl(&$output) {
        $output .= "</div></div>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array()) {
        $title = apply_filters('nav_menu_item_title', apply_filters('the_title', $item->title, $item->ID), $item, $args, $depth);
        if ($args->has_children) {
            $output .= '<a data-toggle="collapse" data-target="#menucollapse-' . static::$header_nav_menu_mobile_id_cnt . '" data-parent="#header_nav_mobile">' . $title . '</a>';
        } else {
            $output .= '<a href="' . (!empty($item->url) ? $item->url : '' ) . '">' . $title . '</a>';
        }
        $output .= $args->after;
    }

    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output) {

        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];

        if (isset($args[0])) {
            if (is_object($args[0])) {
                $args[0]->has_children = !empty($children_elements[$element->$id_field]);
            } else if (is_array($args[0])) {
                $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
            }
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
