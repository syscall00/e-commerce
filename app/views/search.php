<script src="js/search/index.js"></script>
<script src="js/common/product.js"></script>
<link rel="stylesheet" href="css/search/index.css" />

<div class="container">
    <div class="row m-3 mobmarg">
        <div class="col-lg-3 mb-4">

        <!-- Generate filter div -->
            <div class="card sticky-top" id="filter_div">
                <article class="card-group-item">
                    <header class="card-header">
                        <h6 class="title">Range di prezzo</h6>
                    </header>
                    <div class="filter-content">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Min</label>
                                    <input type="number" class="form-control" id="min-filter" placeholder="0€" min="0" />
                                    <button class="btn btn-block btn-outline-primary mt-2" id="confirm-filter">Ok</button>
                                </div>
                                <div class="form-group col-md-6 text-right">
                                    <label>Max</label>
                                    <input type="number" class="form-control" id="max-filter" placeholder="100€" min="0" />
                                    <button class="btn btn-block btn-outline-primary mt-2" id="reset-filter">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="card-group-item">
                    <header class="card-header">
                        <h6 class="title">Recensioni</h6>
                    </header>
                    <div class="filter-content">
                        <div class="card-body">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="Check0" />
                                <label class="custom-control-label" for="Check0">Solo disponibili</label>
                            </div>

                            <?php for($i = 4; $i >= 0; $i--) { ?>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" value="<?=$i?>" id="filter<?=$i?>"
                                <?= $i == 0? 'checked="checked"' : ''?> name="filter">
                                <label class="custom-control-label" for="filter<?=$i?>">
                                    <?=$i . ($i == 1? " stella" : " stelle") ?> o più
                                </label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <!-- end filter div here -->


        <!-- result container -->
        <div class="col-sm-7">
            <h4>
                Risultati per <span id="search-value"><?=$data['search']?></span>
			</h4>
            <div class="productsList">
                <!-- foreach result, generate an item and fill it -->
                <?php foreach($data['prodList'] as $item) { ?>

                <div class="bg-white p-3 rounded mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="/public/prod/<?=$item['id']?>"><img class="img-fluid" src="/public/img/products/<?=$item['id']?>/1.png" alt="prod<?=$item['id']?>" /></a>
                        </div>
                        <div class="col-md-9">
                            <div class="listing-title">
                                <a href="/public/prod/<?=$item['id']?>">
                                    <h5><?=$item['name']?></h5>
                                </a>
                            </div>

                            <div class="d-flex flex-row align-items-center">
                                <div class="d-flex flex-row align-items-center ratings"><?=$data['modelProd']->generateStars($item['rating']);?></div>
                            </div>
                            <div class="description">
                                <div>
                                    <span>
                                        Venduto da <strong><?=$item['seller_name']. " " . $item['seller_surname']?></strong>
                                    </span>
                                </div>
                                <div class="price mb-2">
                                    <span><?=$item['price']?>€</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="<?=$item['quantity'] > 0? 'available':'not-available'?>">
                                    <?=$item['quantity'] > 0? 'Disponibile':'Non disponibile'?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
