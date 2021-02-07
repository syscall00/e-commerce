<div class="col-sm-4">
    
    <div class="list-group sticky-top" id="stick-navbar" role="tablist">
        <h6><?=$data['user']['name'] . " " . $data['user']['surname']?></h6>
    
        <a href="my" class="list-group-item list-group-item-action <?=stripos($_SERVER['REQUEST_URI'],'wishlist') == false?"active" : "" ?>">
          <i class="fa fa-shopping-bag mr-1 text-muted"></i> I miei ordini
        </a>
        
        <a href="my/wishlist" class="list-group-item list-group-item-action <?=stripos($_SERVER['REQUEST_URI'],'wishlist') ?"active" : "" ?>">
          <i class="fa fa-heart mr-1 text-muted"></i> I miei preferiti
        </a>
     </div>
</div>