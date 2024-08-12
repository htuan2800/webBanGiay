<ul class="progress-bar-steps d-flex justify-content-between align-items-center py-5">
    <div class="progress-bar-line"></div>

    <li class="progress-bar-step <?php echo $statusBill >= 1 ? "active" : ""; ?>">
        <i class="fa-solid fa-box-open"></i>
        <div class="progress-bar-title">
            <span>Đã đặt đơn hàng</span>
            <span><?php echo $billCurrent['orderTime'] != null ? convertTime($billCurrent['orderTime']) . ", ngày" . convertDate($billCurrent['orderTime']) : ""; ?></span>
        </div>
    </li>

    <li class="progress-bar-step <?php echo $statusBill >= 2 ? "active" : ""; ?>">
        <i class="fa-solid fa-receipt"></i>
        <div class="progress-bar-title">
            <span>Đã duyệt đơn hàng</span>
            <span><?php echo $billCurrent['approvalTime'] != null ? convertTime($billCurrent['approvalTime']) . ", ngày" . convertDate($billCurrent['approvalTime']) : ""; ?></span>
        </div>
    </li>

    <li class="progress-bar-step <?php echo $statusBill >= 3 ? "active" : ""; ?>">
        <i class="fa-solid fa-truck"></i>
        <div class="progress-bar-title">
            <span>Đang giao</span>
            <span><?php echo $billCurrent['deliveryTime'] != null ? convertTime($billCurrent['deliveryTime']) . ", ngày" . convertDate($billCurrent['deliveryTime']) : ""; ?></span>
        </div>
    </li>

    <li class="progress-bar-step <?php echo $statusBill >= 4 ? "active" : ""; ?>">
        <i class="fa-solid fa-truck-fast"></i>
        <div class="progress-bar-title">
            <span>Đã nhận được hàng</span>
            <span><?php echo $billCurrent['completionTime'] != null ? convertTime($billCurrent['completionTime']) . ", ngày" . convertDate($billCurrent['completionTime']) : ""; ?></span>
        </div>
    </li>

    <li class="progress-bar-step <?php echo $statusBill == 5 ? "active" : ""; ?>">
        <i class="fa-solid fa-star"></i>
        <div class="progress-bar-title">
            <span>Đánh giá</span>
        </div>
    </li>
</ul>