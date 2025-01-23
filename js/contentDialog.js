$(document).ready(function () {
  function contentSearch() {
    var content = `
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" style="margin: -170px auto" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Tìm kiếm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-search container-fluid row d-flex justify-content-center">
                        <input type="text" class="col-lg-8 col-md-8 col-sm-8" placeholder="Tìm kiếm sản phẩm">
                        <span class="col-lg-1 col-md-1 col-sm-1"></span>
                        <button type="submit" class="btn btn-dark col-lg-3 col-md-3 col-sm-3">Tìm kiếm</button>
                    </form>
                </div>
            </div>
        </div>
        `;
    return content;
  }

  function contentAddAddress() {
    var content = `
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm địa chỉ giao hàng</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./addressInfo.php" class="form-address row">
                        <div class="mb-4 col-lg-6 col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="recipient-name" placeholder="Tên người nhận">
                            <span class="error"></span>
                        </div>
                        <div class="mb-4 col-lg-6 col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="phone" placeholder="Số điện thoại">
                            <span class="error"></span>
                        </div>
                        <div class="city col-12">
                            <select class="form-select form-select-sm mb-3" id="city" aria-label=".form-select-sm">
                                <option value="" selected>Chọn thành phố</option>
                            </select>
                        </div>
                        <div class="district col-12">
                            <select class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm">
                                <option value="" selected>Chọn quận huyện</option>
                            </select>
                        </div>
                        <div class="ward col-12">
                            <select class="form-select form-select-sm mb-3" id="ward" aria-label=".form-select-sm">
                                <option value="" selected>Chọn phương xã</option>
                            </select>
                        </div>
                        <div class="address-info mb-3 col-lg-12 col-md-12 col-sm-12">
                            <textarea name="address" class="form-control" cols="30" rows="10" id=""
                                placeholder="Địa chỉ"></textarea>
                            <span class="error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-type="add-address">Lưu địa chỉ</button>
                </div>
            </div>
        </div>`;
    return content;
  }

  function contentUpdateAddress(name, address, phone, city, district, ward) {
    var content = `
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sửa địa chỉ giao hàng</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./addressInfo.php" class="form-address row">
                        <div class="mb-4 col-lg-6 col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="recipient-name" placeholder="Tên người nhận" value="${name}" data-old-name="${name}">
                            <span class="error"></span>
                        </div>
                        <div class="mb-4 col-lg-6 col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="phone" placeholder="Số điện thoại" value="${phone}" data-old-phone="${phone}">
                            <span class="error"></span>
                        </div>
                        <div class="city col-12">
                            <select class="form-select form-select-sm mb-3" id="city" aria-label=".form-select-sm">
                                <option value="0" selected>${city}</option>
                            </select>
                        </div>
                        <div class="district col-12">
                            <select class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm">
                                <option value="0" selected>${district}</option>
                            </select>
                        </div>
                        <div class="ward col-12">
                            <select class="form-select form-select-sm mb-3" id="ward" aria-label=".form-select-sm">
                                <option value="0" selected>${ward}</option>
                            </select>
                        </div>
                        <div class="address-info mb-3 col-lg-12 col-md-12 col-sm-12">
                            <textarea name="address" class="form-control" cols="30" rows="10" id=""
                                placeholder="Địa chỉ" data-old-address="${city}, ${district}, ${ward}, ${address}">${address}</textarea>
                            <span class="error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-type="update-address">Thay đổi địa chỉ</button>
                </div>
            </div>
        </div>`;
    return content;
  }

  window.contentSearch = contentSearch;
  window.contentAddAddress = contentAddAddress;
  window.contentUpdateAddress = contentUpdateAddress;
});
