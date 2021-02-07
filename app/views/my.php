<link href="css/my/index.css" type="text/css" rel="stylesheet" />

<div class="container mb-4 mt-4">
    <div class="row">
        <?php include_once('account_navbar.php'); $orders = $data['orderList'];?>

        <div class="col-lg-8 pb-5">
            <!-- Foreach order, generate a container -->
            <?php foreach($orders as $order) { ?>

            <div class="bg-white p-3 rounded mb-3">
                <?= $newDateString = date_format(date_create_from_format('Y-m-d H:i:s', $order['date']), 'd/m/Y H:i') . " " . $order['price'] . "€";?>
                <!-- Foreach product in order, generate the item -->
                <?php foreach($order['0'] as $order_products) { ?>
                <hr />
                <div class="row mb-1">
                    <div class="col-md-2">
                        <a href="/public/prod/<?=$order_products['prod_id']?>"><img class="img-fluid" src="/public/img/products/<?=$order_products['prod_id']?>/1.png" /> </a>
                    </div>
                    <a href="/public/prod/<?=$order_products['prod_id']?>"></a>
                    <div class="col-md-9">
                        <a href="/public/prod/<?=$order_products['prod_id']?>"> </a>
                        <div class="listing-title">
                            <a href="/public/prod/<?=$order_products['prod_id']?>"> </a>
                            <h6>
                                <a href="/public/prod/<?=$order_products['prod_id']?>"><?=$order_products['prod_name']?></a>
                            </h6>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="d-flex flex-row align-items-center ratings"><?=$order_products['price']?>€</div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="d-flex flex-row align-items-center ratings">
                                <span>
                                    <?=$order_products['quantity']?> acquistati
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <?php } ?>
        </div>
    </div>
</div>
