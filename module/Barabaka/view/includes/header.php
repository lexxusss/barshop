<?php
echo $this->doctype();
$products = $this->layout()->products;
$products_arr = $this->layout()->products_arr;
$_Global_Session = $this->layout()->global_session;
$products_in_cart = $this->layout()->products_in_cart;

$json_products_arr = json_encode($products_arr);
$json_products_in_cart = json_encode($products_in_cart);
//echo "<pre>"; var_dump($products_in_cart); die();
?>
<html lang="en" ng-app>
    <head>
        <meta charset="utf-8">
        <?php echo $this->headTitle($this->translate('Barabaka SHOP'))->setSeparator(' - ')->setAutoEscape(false) ?>

        <?php echo $this->headMeta()
            ->appendName('viewport', 'width=device-width, initial-scale=1.0')
            ->appendHttpEquiv('X-UA-Compatible', 'IE=edge')
        ?>

        <!-- Le styles -->
        <?php echo $this->headLink(array('rel' => 'shortcut icon', 'type' => 'image/vnd.microsoft.icon', 'href' => $this->basePath() . '/img/favicon.ico'))
                        ->prependStylesheet($this->basePath('css/style.css'))
                        ->prependStylesheet($this->basePath('css/bootstrap/bootstrap.min.css'))
                        //->prependStylesheet('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css')
                        //->prependStylesheet('http://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700')
                        ; ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Scripts -->
        <?php echo $this->headScript()
            ->prependFile($this->basePath('js/jquery.min.js'))
            ->prependFile($this->basePath('js/respond.min.js'), 'text/javascript', array('conditional' => 'lt IE 9',))
            ->prependFile($this->basePath('js/html5shiv.js'),   'text/javascript', array('conditional' => 'lt IE 9',))
            ->appendFile($this->basePath('js/customize/work_script.js'))
            //->appendFile($this->basePath('js/customize/angular/angular.js'))
//            ->appendFile($this->basePath('js/customize/angular/todo.js'))
//            ->appendFile($this->basePath('js/customize/angular/angular.min-resource.js'))
        ; ?>
    </head>
  <body>
    <div id="json_products" style="display: none!important;"><?=$json_products_arr?></div>
    
    <header>
      <div class="container">
       
        <div class="header_top" >
          <div class="row">
            <div class="col-md-5 col-sm-12">
              <a href="<?=$this->basePath()?>" class="logo">
                <img src="<?=$this->basePath('img/logo.png')?>"/>
              </a>
            </div>
            
            <div class="col-md-5 col-sm-6">
              <form class="navbar-form form_search" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search here..." />
                  <a href="#"><i></i></a>
                </div>
              </form>
            </div>
            
            <div class="show_cart_list col-md-2 col-sm-6">
              <div class="dropdown pull-right basket">
                <span>
                  <img src="<?=$this->basePath('img/basket.png')?>" />
                  <a href="#" class="your_cart">Your Cart</a>
                  <span class="caret arrow_down"></span>
                </span>
                <ul class="dropdown-menu cart_list" style="display: none;">
                <?php
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
                ?>
                </ul>
              </div>
            </div>
            
          </div><!-- row END-->
          
        </div><!-- header-top END-->
        
        <div class="header_bottom">
          <div class="row">
            
            <div class="col-xs-9">
              <div class="header_bottom_left">
                <ul class="top-nav">
                  <li><a href="<?=$this->url('home/category')?>?categ=for_Kitchen">For Kitchen</a></li>
                  <li><a href="<?=$this->url('home/category')?>?categ=for_Decoration">For Decoration</a></li>
                  <li><a href="<?=$this->url('home/category')?>?categ=for_You">For You</a></li>
                </ul>
              </div>
            </div>
            
            <div class="col-xs-3">
              <a href="#"  class="header_bottom_right">
                <span>GADGET SHOP</span>
              </a>
            </div>
            
          </div><!-- row END-->
        </div><!-- header-bottom END-->
        
      </div><!-- container END-->
    </header><!-- HEADER END-->