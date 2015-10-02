<?php

namespace Barabaka\Service;

class Paginator
{
    
    function pagine_array($array, $items_per_page) {
        $count_of_arr = count($array);
        $pagination_arr = array();
        $count_of_page = ceil($count_of_arr / $items_per_page);
        
        for ( $i = 1, $k = 0; $k < $count_of_arr; $i++ ) {
            for ( $j = 1; $j <= $items_per_page && $array[$k]; $j++, $k++ ) {
                $pagination_arr[$i][$j] = $array[$k];
            }
        }
        
        return $pagination_arr;
    }
}