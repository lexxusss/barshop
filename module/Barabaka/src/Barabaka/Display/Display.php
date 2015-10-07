<?php
namespace Barabaka\Display;

class Display
{
    public function cartListDropDown($products_in_cart) {
        if ( $products_in_cart ) {
            foreach ( $products_in_cart as $product_in_cart ) {
                echo "<li id='cart_item_{$product_in_cart['id']}'>
                        {$product_in_cart['name']}
                        <span onclick='removeFromCart({$product_in_cart['id']});'>X</span>
                    </li>";
            }
        } else {
            echo "<div class='empty_cart'>YOUR CART <br/> IS EMPTY ELSE...</div>";
        }
        
        die();
    }
    
    public function categoryProducts($pagination_arr, $items_per_page, $page) {
        $items_in_row = $items_per_page > 4 ? 4 : 2;
        $class_for_row = $items_per_page > 4 ? "items_more" : "items_less";
        $class_for_cols = $items_per_page > 4 ? "col-md-3" : "col-md-4";
        
        $rows = $items_per_page / $items_in_row;
        ?>
        <!--Products start-->
            <?php for ( $i = 0, $item = 1; $i < $rows; $i++ ): ?>
                <div class="row <?=$class_for_row?>">
                  <?php for ( $j = 0; $j < $items_in_row && $pagination_arr[$page][$item]; $j++, ++$item ): ?>
                      <div class="<?=$class_for_cols?> product-block-wrap">
                        <div class="product-block default">
                          <div class="product-block-info overlay">
                            <a href="" class="product-name">
                                <?=$pagination_arr[$page][$item]['name']?>
                            </a>
                            <div class="price-box">
                              <span class="price-old"><?=$pagination_arr[$page][$item]['price_old']?></span>
                              <span class="price-now"><?=$pagination_arr[$page][$item]['price_new']?></span>
                              <span class="popularity">(<?=$pagination_arr[$page][$item]['popularity']?>)</span>
                            </div>
                            <?php if ( !$_SESSION['products_in_cart'][$pagination_arr[$page][$item]['id']] ): ?>
                                <a id="add_cart_<?=$pagination_arr[$page][$item]['id']?>" href="#middle" class="btn btn-primary btn-cart" onclick="addToCart(<?=$pagination_arr[$page][$item]['id']?>)">
                                Add to Cart
                                </a>
                            <?php else: ?>
                                <a id="add_cart_<?=$pagination_arr[$page][$item]['id']?>" href="#middle" class="btn btn-primary btn-cart" onclick="removeFromCart(<?=$pagination_arr[$page][$item]['id']?>)">
                                Remove
                                </a>
                            <?php endif; ?>
                          </div>
                          
                          <div class="product-block-img">
                            <img src="/img/<?=$pagination_arr[$page][$item]['img']?>" class="img-responsive"/>
                          </div>
                                               
                          <a href="" class="product-badge sale">Sale</a>
                        </div>
                      </div><!--product-block-wrap END-->
                  <?php endfor; ?>
                </div><!--row END-->
            <?php endfor; ?>
        <!--Product-items END-->
        <?php
    }
    
    public function paginationPages($pagination_arr, $curr_page) {
        ?>
        <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php foreach ( $pagination_arr as $page => $page_products ): ?>
            <li class="page_<?=$page?> <?=$curr_page==$page?' active':''?>">
                <a href="#bottom" onclick="makeActiveCurrentPage('<?=$page?>');">
                    <?=$page?>
                </a>
            </li>
        <?php endforeach; ?>
        <li>
            <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <?php
    }
}














