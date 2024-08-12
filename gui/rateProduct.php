<?php
    if (isset($_POST['idProduct'])) {
        $idProduct = $_POST['idProduct'];
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá sản phẩm</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container-fluid row">
            <div class="star-wrap col-12 d-flex justify-content-center align-items-center">
                <div>
                    <input type="radio" name="rate" id="" data-star="5">
                    <input type="radio" name="rate" id="" data-star="4">
                    <input type="radio" name="rate" id="" data-star="3">
                    <input type="radio" name="rate" id="" data-star="2">
                    <input type="radio" name="rate" id="" data-star="1">
                </div>
            </div>

            <div class="content col-12 mt-3">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                    <label for="floatingTextarea">Đánh giá (tối đa 250 ký tự)</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-id-product="<?php echo $idProduct; ?>">Lưu
            đánh
            giá</button>
    </div>
</div>