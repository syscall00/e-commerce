<script src="/public/js/cart/index.js"></script>
<script src="/public/js/common/product.js"></script>
<link rel="stylesheet" href="css/cart/index.css" />


<div class="container pt-5 pb-5">
    <div class="row">
        <?php $cart = $data['cart']; ?>
        <div class="col-lg-12 col-md-12 col-12">
            <h3 class="display-5 mb-2 text-center">Carrello</h3>
            <p class="mb-5 text-center">
                Hai <i class="font-weight-bold" id="num-cart"><?= $data['total_quantity']?></i> oggetti nel tuo carrello
            </p>
            <?php if($cart != NULL && count($cart) > 0) { ?>


                    <?php foreach ($cart as $item_cart) { ?>
                <div id="prod<?=$item_cart['id']?>" class="container bg-white pt-2">

  <div class="row rowchart border-bottom mt-3">
    <div class="col-md-6 mobchartprod">
        
    <div class="row">
                                <div class="col-md-3 text-left">
                                    <a href="/public/prod/<?=$item_cart['id']?>"><img src="/public/img/products/<?=$item_cart['id']?>/1.png" alt="" class="img-fluid d-md-block rounded mb-2 shadow" /></a>
                                </div>
                                <div class="col-md-9 text-left mt-sm-2">
                                    <h4>
                                        <a href="/public/prod/<?=$item_cart['id']?>"><?=$item_cart['name']?></a>
                                    </h4>
                                    <p class="font-weight-light"><?=$item_cart['seller_name'] . " " . $item_cart['seller_surname']?></p>
                                </div>
                            </div>
    </div>
    <div class="col-md-2 mobpriceprod" >
      <?=$item_cart['price']?>€
    </div>
    <div class="col-md-2 mobqtprod">
    <select class="custom-select" id="quantity">
                                <?php for ($i = 1; $i <= $item_cart['disponible_quantity'] && $i <= 10; $i++) { if($item_cart['cart_quantity'] == $i) { ?>
                                <option value="<?=$i?>" selected><?=$i?></option>
                                <?php } else { ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php } } ?>
                            </select>
    </div>
    <div class="col-md-2 mobactprod">
    <div class="text-right">
                                <button class="syncBtn btn btn-outline-primary btn-block mb-2" value="<?=$item_cart['id']?>"><i class="fas fa-sync"></i> Ricarica</button>

                                <button class="removeBtn btn btn-outline-primary btn-block mb-2" value="<?=$item_cart['id']?>"><i class="fas fa-trash"></i> Rimuovi</button>
                            </div>

    </div>
    </div>
</div>

            <?php } ?>




            <div class="float-right text-right">
                <h5>Prezzo totale</h5>
                <h3>
                    <span id="total-price"><?=$data['total_price']?>€</span>
                </h3>
            </div>
        </div>
    </div>
    <div class="row mt-4 d-flex align-items-center">
        <div class="col-sm-6 order-md-2 text-right">
            <button id="pay-order" class="btn btn-primary mb-4 btn-lg pl-5 pr-5"><i class="fad fa-cash-register"></i> Paga ora</button>
        </div>
        <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
            <a href="/public/"> <i class="fas fa-arrow-left mr-2"></i> Continua lo shopping</a>
        </div>
        <?php } else { ?>
        <h4>Ancora nessun prodotto nel carrello. Torna alla <a href="">Home</a></h4>
        </div>
        <?php } ?>
    </div>
</div>
