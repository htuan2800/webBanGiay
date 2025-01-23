<?php

use function PHPSTORM_META\type;

require_once __DIR__ . '/..\\database\\database.php';
require_once __DIR__ . '/..\\database\\product.php';
require_once __DIR__ . '/..\\handle.php';
?>
<div class="filter-lg">
    <div class="filter">
        <details class="price col-lg-12 col-md-12 col-sm-4" open>
            <summary>Giá</summary>
            <!-- <div>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="checkbox" value="CURRENTPRICE < 1000000">
                    <label class="form-check-label">
                        Dưới 1.000.000đ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="checkbox" value="CURRENTPRICE BETWEEN 1000000 AND 2000000">
                    <label class="form-check-label">
                        1000.000đ - 2.000.000đ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="checkbox" value="CURRENTPRICE BETWEEN 2000000 AND 4000000">
                    <label class="form-check-label">
                        2000.000đ - 4.000.000đ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="checkbox" value="CURRENTPRICE BETWEEN 4000000 AND 5000000">
                    <label class="form-check-label">
                        4000.000đ - 5.000.000đ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="checkbox" value="CURRENTPRICE BETWEEN 5000000 AND 10000000">
                    <label class="form-check-label">
                        5000.000đ - 10.000.000đ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-filter" type="checkbox" value="CURRENTPRICE > 10000000">
                    <label class="form-check-label">
                        Trên 10.000.000đ
                    </label>
                </div>
            </div> -->
            <?php
            $products = new product($db);
            $products = $products->selectProductsByPrice(1);
            $maxPrice = (int) ($products[0]["currentPrice"]);
            ?>
            <div class="range">
                <div class="range-price-label d-flex justify-content-center py-2">

                    <span class="min-price-label"><?php echo convertPrice(0) ?></span>
                    <span class="px-1">-</span>
                    <span class="max-price-label"><?php echo convertPrice($maxPrice) ?></span>
                </div>
                <div class="range-slider">
                    <span class="range-selected"></span>
                </div>

                <div class="range-input">

                    <input type="range" class="min" min="0" max="<?php echo $maxPrice ?>" value="0" step="10">
                    <input type="range" class="max" min="0" max="<?php echo $maxPrice ?>" value="<?php echo $maxPrice ?>" step="10">
                </div>

            </div>
        </details>

        <details class="size col-lg-12 col-md-12 col-sm-4" open>
            <summary>Size</summary>
            <div>
                <div class="form-check">
                    <input class="form-check-input size-filter" type="checkbox" value="">
                    <label class="form-check-label">
                        36
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input size-filter" type="checkbox" value="">
                    <label class="form-check-label">
                        37
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input size-filter" type="checkbox" value="">
                    <label class="form-check-label">
                        38
                    </label>
                </div>
            </div>
        </details>

        <details class="sub-brand col-lg-12 col-md-12 col-sm-4" open>
            <summary>Thiết kế</summary>
            <div>
                <?php
                require_once __DIR__ . "\\..\\database\\brand.php";
                $brands = new brand($db);
                $subBrands = $brands->selectSubBrandById($_GET['idBrand']);
                foreach ($subBrands as $subBrand) {
                ?>
                    <div class="form-check">
                        <input class="form-check-input sub-brand-filter" type="checkbox"
                            value="<?php echo $subBrand['subBrandName'] ?>">
                        <label class="form-check-label">
                            <?php echo $subBrand['subBrandName'] ?>
                        </label>
                    </div>
                <?php
                }
                ?>
            </div>
        </details>
    </div>
</div>


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Bộ lọc</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

    </div>
</div>