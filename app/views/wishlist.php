<script src="/public/js/common/product.js"></script>

<script src="/public/js/my/wishlist.js"></script>
<link href="css/my/index.css" type="text/css" rel="stylesheet" />
<link href="css/wishlist/index.css" type="text/css" rel="stylesheet" />

<div class="container mb-4 mt-4">
    <div class="row">
        <?php include_once('account_navbar.php');?>

        <div class="col-lg-8 pb-5">
            <h3>
                Hai <?=count($data['prodList'])?> elementi nella tua wishlist
            </h3>

            <!-- foreach product in wishlist, generate an item and fill it -->
            <?php foreach($data['prodList'] as $item) { ?>

            <div class="bg-white p-3 rounded mb-3">
                <div class="row">
                    <div class="col-md-2">
                        <a href="/public/prod/<?=$item['id']?>"><img class="img-fluid" src="/public/img/products/<?=$item['id']?>/1.png" alt="prod<?=$item['id']?>" /> </a>
                    </div>
                    <a href="/public/prod/<?=$item['id']?>"></a>
                    <div class="col-md-9">
                        <a href="/public/prod/<?=$item['id']?>"> </a>
                        <div class="listing-title">
                            <a href="/public/prod/<?=$item['id']?>"> </a>
                            <h6>
                                <a href="/public/prod/<?=$item['id']?>"><?=$item['name']?></a>
                            </h6>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="d-flex flex-row align-items-center ratings"><?=$item['price']?>€</div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="d-flex flex-row align-items-center ratings"><?=$item['quantity']>0? "Disponibile" : "Non disponibile" ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
</div>
