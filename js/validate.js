$(document).ready(function () {

    // validate empty
    function validateEmpty(value) {
        return value === "";
    }

    // validate fullname
    function validateFullname(fullname) {
        // Biểu thức chính quy để kiểm tra các ký tự tên tiếng Việt có dấu
        var re = /^[a-zA-ZÀ-ỹ\s]+$/;
        return re.test(fullname) ? "" : "Tên không chứa kí tự đặc biệt hoặc số!";
    }


    // validate phone number
    function validatePhone(phone) {
        var re = /^0[0-9]{9,10}$/;
        return re.test(phone) ? "" : "Số điện thoại không hợp lệ!";
    }

    // validate email
    function validateEmail(email) {
        var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return re.test(email) ? "" : "Email không hợp lệ!";
    }

    // validate username
    function validateUsername(username) {
        var re = /^[a-zA-Z0-9]{6,20}$/;
        return re.test(username) ? "" : "Tài khoản phải từ 6-20, không chứa kí tự đặc biệt!";
    }

    // validate password
    function validatePassword(password) {
        if (password.length < 6 || password.length > 20) {
            return "Mật khẩu phải từ 6-20 ký tự!";
        }
        return "";
    }

    // validate confirm password
    function validateConfirmPassword(password, confirmPassword) {
        return password === confirmPassword ? "" : "Xác nhận mật khẩu sai!";
    }

    function validateAddress(address) {
        var re = /^[a-zA-ZÀ-ỹ\s0-9,.-/]{0,250}$/;
        return re.test(address) ? "" : "Địa chỉ phải ít hơn 250 kí tự và không chứa kí tự đặc biệt!";
    }

    function validatePrice(price) {
        var re = /^[0-9]+$/;
        return re.test(price) ? "" : "Giá phải là số!";
    }

    window.validateEmpty = validateEmpty;
    window.validateFullname = validateFullname;
    window.validatePhone = validatePhone;
    window.validateUsername = validateUsername;
    window.validatePassword = validatePassword;
    window.validateConfirmPassword = validateConfirmPassword;
    window.validateAddress = validateAddress;
    window.validatePrice = validatePrice;
    window.validateEmail = validateEmail;
});