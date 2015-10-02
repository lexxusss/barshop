/*--------------- Basket AJAX ------------------*/
    var $ = jQuery;
    
    var products = $.parseJSON($('#json_products').text());
    
    $('.show_cart_list').on('mouseover', function() {$('.cart_list').show()});
    $('.show_cart_list').on('mouseleave', function() {$('.cart_list').hide()});
    
    /*----------- customize functions ------------*/
    function myTrim(x) {
        return x.replace(/^\s+|\s+$/gm,'');
    }
    
    function dump(obj) {
        var out = "";
        
        if(obj && typeof(obj) == "object") 
            for (var i in obj) out += i + ": " + obj[i] + "\n";
        else out = obj;
        
        alert(out);
    }
    
    function countProperties(object) {
        var count = 0;
        
        for (var k in object) {
            if (object.hasOwnProperty(k)) {
               ++count;
            }
        }
        
        return count;
    }
    /*----------- customize functions ------------*/
    
    function products_in_cart() {
        $.ajax({
            type:"POST",
            url:"/cart-manager/products-in-cart",
            success: function(data) {
                $('.cart_list').html(data);
            },
            error: function() {
			    alert("Ajax error cart dropdown listing. Sorry about that.");
			}
        });
    }
    
    function addToCart(product_id) {
        var product = products[product_id],
        add_cart_button = $('#add_cart_'+product_id);
        
        add_cart_button.text('Remove');
        add_cart_button.attr('onclick', 'removeFromCart('+product_id+')');
        
        addToListCart(product_id);
        
        $.ajax({
            type:"POST",
            url:"/cart-manager/add-into-cart",
            data:{
                product_into_cart: product
            },
            success: function(data) {
                if ( data != '' ) { // exception - your product is already in cart
                    alert(data);
                } else { // success
                    products_in_cart();
                }
            },
            error: function(){
			    alert("Ajax error adding. Sorry about that.");
			}
        });
        
        return false;
    }
    
    function removeFromCart(product_id) {
        //alert(); return;
        var product = products[product_id],
        add_cart_button = $('#add_cart_'+product_id);
        
        add_cart_button.text('Add to Cart');
        add_cart_button.attr('onclick', 'addToCart('+product_id+')');
        
        removeFromListCart(product_id);
        
        $.ajax({
            type:"POST",
            url:"/cart-manager/remove-from-cart",
            data:{
                product_from_cart: [product_id]
            },
            success: function(data) {
                if ( data != '' ) { // exception - your product is already in cart
                    alert(data);
                } else { // success
                    products_in_cart();
                }
            },
            error: function(){
			    alert("Ajax error removing. Sorry about that.");
			}
        });
        
        return false;
    }
    
    function removeFromListCart(product_id) {
        $('#cart_item_'+product_id).remove();
        
        //alert('!'+$('.show_cart_list ul').html()+'!');
        
        if ( $('.show_cart_list ul').has("li").length === 0 ) {
            $(".show_cart_list ul").append('<div class="empty_cart">YOUR CART <br> IS EMPTY ELSE...</div>');
        }
    }
    
    function addToListCart(product_id) {
        var product = products[product_id];
        //alert(product.name);
        
        if ( $('.empty_cart') ) $('.empty_cart').remove();
        $(".show_cart_list ul").append('<li id="cart_item_'+product_id+'">'+product.name+' <span onclick="removeFromCart('+product_id+');">X</span></li>');
    }
/*--------------- Basket AJAX ------------------*/


/*--------------- pages AJAX  ---------------*/
/*---- index page ----*/

/*---- index page ----*/

/*---- category page ----*/
    var category = $('#current_category').text();
    
    function pagination() {
        var sub_category = 1,
        sorting_by = $('.current_sorting_by').text(),
        items = $('.current_items').text(),
        page = $('.pagination li.active').text();
        
        //alert(sorting_by); return;
        $('.product-items').css('opacity','0.5');
        
        $.ajax({
            type:"POST",
            url:"/category-manager/pagination",
            data:{
                category: category,
                sorting_by: sorting_by,
                items_per_page: items,
                page: page
            },
            success: function(data) {
                //alert(data); //return;
                var products_category_info = jQuery.parseJSON(data);
                
                $('.product-items').html(products_category_info['products']);
                $('.pagination').html(products_category_info['pagination_pages']);
                
                $('.product-items').css('opacity','1');
                $('#session_sorting_by').text(sorting_by);
                //alert(products_category_info['debug']);
            },
            error: function() {
                $('.product-items').css('opacity','1');
			    alert("Ajax error items per page. Sorry about that.<br/>");
			    //dump(data);
			}
        });
    }
    
    /*------------------ pagination filters ------------------*/
    function setSubCategory(sub_category) {
        var name_for_class = sub_category.substring(0, 6),
        current_sub_categ = myTrim($('.sub_categories_list>li>a.active').text());
        
        if ( sub_category == current_sub_categ ) {
            return false;
        } else {
            $('.sub_categories_list>li>a.active').removeClass('active');
            $('.sub_categ_'+name_for_class).addClass('active');
            $('#current_sub_category_name').text(sub_category);
            
            //pagination();
        }
    }
    
    function set_items_per_page(items) {
        var current_items = myTrim($('.current_items').text());
        
        if ( items == current_items ) {
            return false;
        } else {
            $('.current_items').text(items);
            pagination();
        }
    }
    
    function set_sorting_by(param) {
        var current_param = myTrim($('.current_sorting_by').text());
        
        if ( param == current_param ) {
            return false;
        } else {
            $('.current_sorting_by').text(param);
            pagination();
        }
    }
    
    function makeActiveCurrentPage(page) {
        var current_page = myTrim($('#current_page').text());
        
        if ( page == $('#current_page').text() ) {
            return false;
        } else {
            $('.pagination li.active').removeClass('active');
            $('.page_'+page).addClass('active');
            $('#current_page').text(page);
            
            pagination();
        }
    }
    /*------------------ pagination filters ------------------*/
/*---- category page ----*/
/*--------------- pages AJAX  ---------------*/


