<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
<link rel="stylesheet" href="css/home/index.css" />
<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="js/home/index.js"></script>

<div class="container">
    <div class="row">
        <div class="col-12 mt-3">
            <h3>
                Benvenuto su Ecommerce, <?=$data['name']?>
            </h3>
            <p>Tutto quello che desideri, a portata di mano</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <!-- Generate slider tiles -->
            <?php if(count($data['popularProd']) > 3) { ?>
            <div class="mt-5">
                <h5 class="ml-4">Prodotti popolari</h5>

                <div class="slider col-md-12">
                    <?php foreach ($data['popularProd'] as $prod) { ?>
                    <div class="col-md-4">
                        <a href="prod/<?=$prod['prod_id']?>">
                            <div class="card card-body slick-img">
                                <img class="img-fluid" src="/public/img/products/<?=$prod['prod_id']?>/1.png" alt="popular" />
                            </div>
                        </a>
                    </div>
                    <?php } } ?>
                </div>
            </div>
        </div>
    </div>
</div>
