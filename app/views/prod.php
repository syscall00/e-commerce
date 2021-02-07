<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
<link href="css/product/index.css" type="text/css" rel="stylesheet" />

<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="js/prod/index.js"></script>
<script src="js/common/product.js"></script>

<div class="container">
    <div class="product m-4">
        <?php  $product = $data['prod'];  
        $reviews = $data['revs'];
        $available = $product['quantity'] > 0; ?>
        
        <div class="row">
            <input type="hidden" id="prodId" name="prodId" value="<?=$product['id']?>" />

            <div class="col-md-4 pro-img">
                <div class="pro-img-details">
                    <img class="img-fluid pro-img" src="img/products/<?=$product['id']?>/1.png" alt="" />
                </div>
            </div>
            <div class="col-md-8">
                <h3 class="mb-0"><?=$product['name']?></h3>
                <div class="stars mb-1"><?=$data['modelProd']->generateStars($product['rating']);?></div>
                <p><?=$product['description']?></p>
                <div class="product_meta">
                    <span>
                        Venduto da <strong><?=$product['seller_name'] . ' ' . $product['seller_surname']?></strong>
                    </span>
                </div>
                <div class="mb-1">
                    <strong>Prezzo : </strong> <span class="pro-price"> <?=$product['price']?>€</span>
                </div>
                <div class="mb-3">
                    <strong><?=$available ? "Disponibile" : "Non disponibile"?> </strong>
                </div>
                <div class="mb-3 quantity-form">
                    <?php if($available) { ?>

                    <label><strong>Quantità</strong></label>
                    <select class="custom-select custom-select-lg col-2" id="quantity">
                        <?php } ?>
                        <?php for ($i = 1; $i <= $product['quantity'] && $i <= 10; $i++) {?>
                        <option value="<?=$i?>"><?=$i?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="actions">
                    <?php if($available) {?>
                    <button id="cartbtn" class="btn btn-outline-primary mr-2" type="button"><i class="fa fa-shopping-cart"></i> Aggiungi al carrello</button>
                    <?php } ?>
                    <button id="wishaddbtn" class="btn btn-outline-primary <?=$data['isInWish']? 'd-none' : ''?>" type="button"><i class="fa fa-heart"></i> Aggiungi ai preferiti</button>
                    <button id="wishrmvbtn" class="btn btn-outline-primary <?=$data['isInWish']? '': 'd-none'?>" type="button"><i class="fas fa-heart-broken"></i> Rimuovi dai preferiti</button>
                </div>
            </div>
        </div>
    </div>
    <hr />

    <div class="row">
        <div class="col">
            <div class="mt-5">
                <h5 class="ml-4">Prodotti simili</h5>
                <div class="slider col-md-6 mb-4">
                    <?php foreach($data['related'] as $related_item) { ?>
                    <div class="col-md-2">
                        <a href="prod/<?=$related_item['id']?>">
                            <div class="card card-body slick-img">
                                <img class="img-fluid" src="/public/img/products/<?=$related_item['id']?>/1.png" alt="related" />
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="reviews mt-3 mb-5">
                <div class="border rounded px-4 pt-1 bg-white">
                    <h5>
                        <span id="rating-count"><?=count($reviews)?></span> recensioni
                    </h5>
                    <h5>
                        Punteggio totale: <span id="rating-value"><?=$product['rating']?></span>
                    </h5>
                    <div id="reviews-container">
                        <?php foreach ($reviews as $review) {?>
                        <hr />
                        <div class="media mt-4 mb-4">
                            <div class="media-body">
                                <p class="mb-0">
                                    <strong><?=$review['name'] . " " . $review['surname']?></strong>
                                    <span> – </span><span><?=$review['time']?> </span>
                                </p>
                                <div class="rating">
                                    <?=$data['modelProd']->generateStars($review['vote']);?>
                                    <div>
                                        <p class="mb-0"><?=$review['review']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php if($data['canReview']) {?>
                    <div id="add-review-box">
                        <h5 class="mt-4">Aggiungi una recensione</h5>

                        <div id="rating-system">
                            <ul>
                                <li class="star highlight" data-index="0"><i class="fas fa-star fa-sm text-primary"></i></li>
                                <li class="star highlight" data-index="1"><i class="far fa-star fa-sm text-primary"></i></li>
                                <li class="star highlight" data-index="2"><i class="far fa-star fa-sm text-primary"></i></li>
                                <li class="star" data-index="3"><i class="far fa-star fa-sm text-primary"></i></li>
                                <li class="star" data-index="4"><i class="far fa-star fa-sm text-primary"></i></li>
                            </ul>
                        </div>

                        <div>
                            <div class="md-form md-outline">
                                <textarea id="form-review" class="md-textarea form-control pr-6" rows="4"></textarea>
                            </div>
                            <div class="text-right pb-2">
                                <button type="button" class="btn btn-primary mt-3" id="add-review"><i class="fa fa-share-square-o"></i> Aggiungi una recensione</button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
