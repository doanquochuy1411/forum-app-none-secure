function valEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function validateNoSpecialChars(string) {
    var pattern = /^[\p{L}\p{N}\s!@$%&?,\-()*:\[\]]+$/u;
    return pattern.test(string);
}

function valPassword(string) {
    var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return pattern.test(string);
}

function valPhoneNumber(phoneNumber) {
    // Sử dụng biểu thức chính quy để kiểm tra định dạng số điện thoại
    const phoneNumberPattern = /^0\d{9,11}$/;

    // Kiểm tra xem số điện thoại có hợp lệ không
    return phoneNumberPattern.test(phoneNumber);
}

function validatePhoneNumber() {
    const phoneNumber = document.querySelector('input[name="phone_number"]').value.trim();
    const phoneNumberError = document.getElementById('phone_number_err');

    if (phoneNumber === "") {
        phoneNumberError.textContent = "Số diện thoại không được để trống";
        phoneNumberError.style.color = 'red'
        return false;
    } else if (!valPhoneNumber(phoneNumber)) {
        phoneNumberError.textContent = "Số điện thoại không hợp lệ";
        phoneNumberError.style.color = 'red'
        return false;
    } else {
        phoneNumberError.textContent = "";
        phoneNumberError.style.color = 'red'
        return true;
    }
}

function validateEmail() {
    const email = document.querySelector('input[name="email"]').value.trim();
    const emailError = document.getElementById('email_err');

    if (email === "") {
        emailError.textContent = "Email không được để trống";
        emailError.style.color = 'red'
        return false;
    } else if (!valEmail(email)) {
        emailError.textContent = "Email không hợp lệ";
        emailError.style.color = 'red'
        return false;
    } else {
        emailError.textContent = "";
        emailError.style.color = 'red'
        return true;
    }
}

function validateFullName() {
    const fullName = document.querySelector('input[name="full_name"]').value.trim();
    const fullNameError = document.getElementById('full_name_err');

    if (fullName === "") {
        fullNameError.textContent = "Tên người dùng không được để trống";
        fullNameError.style.color = 'red'
        return false;
    } else if (!validateNoSpecialChars(fullName)) {
        fullNameError.textContent = "Tên người dùng không được chứa ký tự đặc biệt";
        fullNameError.style.color = 'red'
        return false;
    } else {
        fullNameError.textContent = "";
        fullNameError.style.color = 'red'
        return true;
    }
}

function validateAccountName() {
    const accountName = document.querySelector('input[name="account_name"]').value.trim();
    const accountNameError = document.getElementById('account_name_err');

    if (accountName === "") {
        accountNameError.textContent = "Tên tài khoản không được để trống";
        accountNameError.style.color = 'red'
        return false;
    } else if (!validateNoSpecialChars(accountName)) {
        accountNameError.textContent = "Tên tài khoản không được chứa ký tự đặc biệt";
        accountNameError.style.color = 'red'
        return false;
    } else {
        accountNameError.textContent = "";
        accountNameError.style.color = 'red'
        return true;
    }
}
function validateUserName() {
    const userName = document.querySelector('input[name="user_name"]').value.trim();
    const userNameError = document.getElementById('user_name_err');

    if (userName === "") {
        userNameError.textContent = "Tên người dùng không được để trống";
        userNameError.style.color = 'red'
        return false;
    } else if (!validateNoSpecialChars(userName)) {
        userNameError.textContent = "Tên người dùng không được chứa ký tự đặc biệt";
        userNameError.style.color = 'red'
        return false;
    } else {
        userNameError.textContent = "";
        userNameError.style.color = 'red'
        return true;
    }
}

function validatePassword() {
    const password = document.querySelector('input[name="password"]').value.trim();
    const passwordError = document.getElementById('password_err');

    if (password === "") {
        passwordError.textContent = "Mật khẩu không được để trống";
        passwordError.style.color = 'red'
        return false;
    } else if (!valPassword(password)) {
        passwordError.textContent =
            "Mật khẩu phải có ít nhất một chữ hoa, thường, số và 1 trong các ký tự !,@,$,%,&,* (tối thiểu 8 ký tự)";
        passwordError.style.color = 'red'
        return false;
    } else {
        passwordError.textContent = "";
        passwordError.style.color = 'red'
        return true;
    }
}

function validateCurrentPassword() {
    const password = document.querySelector('input[name="current_password"]').value.trim();
    const passwordError = document.getElementById('current_password_err');

    if (password === "") {
        passwordError.textContent = "Mật khẩu không được để trống";
        passwordError.style.color = 'red'
        return false;
    } else if (!valPassword(password)) {
        passwordError.textContent =
            "Mật khẩu phải có ít nhất một chữ hoa, thường, số và 1 trong các ký tự !,@,$,%,&,* (tối thiểu 8 ký tự)";
        passwordError.style.color = 'red'
        return false;
    } else {
        passwordError.textContent = "";
        passwordError.style.color = 'red'
        return true;
    }
}

function validateNewPassword() {
    const password = document.querySelector('input[name="new_password"]').value.trim();
    const passwordError = document.getElementById('new_password_err');

    if (password === "") {
        passwordError.textContent = "Mật khẩu không được để trống";
        passwordError.style.color = 'red'
        return false;
    } else if (!valPassword(password)) {
        passwordError.textContent =
            "Mật khẩu phải có ít nhất một chữ hoa, thường, số và 1 trong các ký tự !,@,$,%,&,* (tối thiểu 8 ký tự)";
        passwordError.style.color = 'red'
        return false;
    } else {
        passwordError.textContent = "";
        passwordError.style.color = 'red'
        return true;
    }
}

function validateRetypePassword() {
    const password = document.querySelector('input[name="password"]').value.trim();
    const retypePassword = document.querySelector('input[name="retype_password"]').value.trim();
    const retypePasswordError = document.getElementById('retype_password_err');

    if (retypePassword === "") {
        retypePasswordError.textContent = "Vui lòng Nhập lại mật khẩu";
        retypePasswordError.style.color = 'red'
        return false;
    } else if (password !== retypePassword) {
        retypePasswordError.textContent = "Mật khẩu và Nhập lại mật khẩu không khớp";
        retypePasswordError.style.color = 'red'
        return false;
    } else {
        retypePasswordError.textContent = "";
        retypePasswordError.style.color = 'red'
        return true;
    }
}


function validateRetypePasswordOfChangePass() {
    const password = document.querySelector('input[name="new_password"]').value.trim();
    const retypePassword = document.querySelector('input[name="retype_password_of_change"]').value.trim();
    const retypePasswordError = document.getElementById('retype_password_of_change_err');

    if (retypePassword === "") {
        retypePasswordError.textContent = "Vui lòng Nhập lại mật khẩu";
        retypePasswordError.style.color = 'red'
        return false;
    } else if (password !== retypePassword) {
        retypePasswordError.textContent = "Mật khẩu và Nhập lại mật khẩu không khớp";
        retypePasswordError.style.color = 'red'
        return false;
    } else {
        retypePasswordError.textContent = "";
        retypePasswordError.style.color = 'red'
        return true;
    }
}

function validateTitleOfPost() {
    const Title = document.querySelector('input[name="title"]').value.trim();
    const TitleError = document.getElementById('title_err');

    if (Title === "") {
        TitleError.textContent = "Tiêu đề không được để trống";
        TitleError.style.color = 'red'
        return false;
    } else if (!validateNoSpecialChars(Title)) {
        TitleError.textContent = "Tiêu đề không được chứa ký tự đặc biệt";
        TitleError.style.color = 'red'
        return false;
    } else {
        TitleError.textContent = "";
        TitleError.style.color = 'red'
        return true;
    }
}

// function validateContentCategory() {
//     const contentCategory = document.querySelector('input[name="contentCategory"]').value.trim();
//     const contentCategoryError = document.getElementById('contentCategory_err');

//     if (contentCategory === "") {
//         contentCategoryError.textContent = "Vui lòng chọn danh mục";
//         contentCategoryError.style.color = 'red'
//         return false;
//     } else {
//         contentCategoryError.textContent = "";
//         // contentCategoryError.style.color = 'red'
//         return true;
//     }
// }

function validateAgreeTerms() {
    const termsCheckbox = document.getElementById('agree_terms');
    const termsError = document.getElementById('terms_err');

    // Kiểm tra nếu checkbox chưa được chọn
    if (!termsCheckbox.checked) {
        termsError.textContent = "Bạn phải đồng ý với Chính sách và Điều khoản!";
        termsError.style.color = 'red';
        return false;
    } else {
        termsError.textContent = "";
        return true;
    }
}

function validateCheckBox() {
    // Lấy tất cả các checkbox lý do báo cáo
    var checkboxes = document.querySelectorAll('input[name="report_reasons[]"]');
    const checkboxErr = document.getElementById('report_reasons_err');
    var checked = false;

    // Kiểm tra xem ít nhất một checkbox đã được chọn
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            break;
        }
    }

    // Nếu không có checkbox nào được chọn, hiển thị thông báo lỗi
    if (!checked) {
        checkboxErr.textContent = "Bạn phải chọn ít nhất một lý do báo cáo";
        checkboxErr.style.color = 'red'
        return false;
    } else {
        checkboxErr.textContent = "";
        checkboxErr.style.color = ''
        return true;
    }
}

function validateCode() {
    const eValue = document.querySelector('input[name="code"]').value.trim();
    const eErr = document.getElementById('code_err');

    if (eValue === "") {
        eErr.textContent = "Vui lòng chọn nhập mã code";
        eErr.style.color = 'red'
        return false;
    } else if (!validateNoSpecialChars(eValue)) {
        eErr.textContent = "Mã code không hợp lệ!";
        eErr.style.color = 'red'
        return false;
    } else {
        eErr.textContent = "";
        return true;
    }
}

function validateAdditionalReportInfo() {
    // Lấy tất cả các checkbox lý do báo cáo
    var additionalInfo = document.getElementById('additional_info').value;
    const additionalInfoErr = document.getElementById('additional_info_err');
    if (additionalInfo == "") {
        return true;
    }
    if (!validateNoSpecialChars(additionalInfo)) {
        additionalInfoErr.textContent = "Nội dung báo cáo không hợp lệ!";
        additionalInfoErr.style.color = 'red'
        return false;
    } else {
        additionalInfoErr.textContent = "";
        additionalInfoErr.style.color = ''
        return true
    }
}


function validateTxtSearch() {
    // const txtSearch = document.querySelector('input[name="txtSearch"]').value.trim();
    const txtSearch = document.getElementById('srch-term').value.trim();

    if (txtSearch === "") {
        return false;
    } else if (!validateNoSpecialChars(txtSearch)) {
        return false;
    } else {
        return true;
    }
}


function validateContentCategory() {
    const contentCategory = document.getElementById("contentCategory");
    const selectedValue = contentCategory.value;
    const contentCategoryErr = document.getElementById('contentCategory_err');

    if (!selectedValue) {
        contentCategory.focus();
        contentCategoryErr.textContent = "Vui lòng chọn danh mục!";
        contentCategoryErr.style.color = 'red'
        return false;
    } else {
        contentCategoryErr.textContent = "";
        contentCategoryErr.style.color = ''
        return true
    }
}

function validateFormHandelRegister() {
    const isFullNameValid = validateFullName();
    const isAccountNameValid = validateAccountName();
    const isPasswordValid = validatePassword();
    const isRetypePasswordValid = validateRetypePassword();

    return isFullNameValid && isAccountNameValid && isPasswordValid && isRetypePasswordValid;
}

function validateFormSendCode() {
    const isEmailValid = validateEmail();
    const isTermValid = validateAgreeTerms();
    return isEmailValid && isTermValid;
}

function validateFormResetPassword() {
    const isPasswordValid = validatePassword();
    const isRetypePasswordValid = validateRetypePassword();
    return isPasswordValid && isRetypePasswordValid;
}

function validateFormLogin() {
    const isUserNameValid = validateUserName();
    const isPasswordValid = validatePassword();
    return isPasswordValid && isUserNameValid;
}

function validateFormCreatePost() {
    const isValidTitle = validateTitleOfPost();
    const isValidContentCategory = validateContentCategory();
    return isValidTitle && isValidContentCategory;
}

function validateFormSearch() {
    const isValidTxtSearch = validateTxtSearch();
    return isValidTxtSearch;
}

function validateFormEditInfo() {
    const isValidUserName = validateUserName();
    const isValidEmail = validateEmail();
    const isValidPhoneNumber = validatePhoneNumber();
    return isValidUserName && isValidEmail && isValidPhoneNumber;
}

function validateFormChangePassword() {
    const isPasswordValid = validateCurrentPassword();
    const isNewPasswordValid = validateNewPassword();
    const isRetypePasswordValid = validateRetypePasswordOfChangePass();
    return isPasswordValid && isNewPasswordValid && isRetypePasswordValid;
}

function validateFormReport() {
    const isReasonValid = validateCheckBox();
    const isAdditionalValid = validateAdditionalReportInfo();

    return isReasonValid && isAdditionalValid
}

function validateFormAddUser() {
    const isValidAccountName = validateAccountName();
    const isValidUserName = validateUserName();
    const isValidEmail = validateEmail();
    const isValidPhoneNumber = validatePhoneNumber();
    const isValidPassword = validatePassword();

    return isValidAccountName && isValidUserName && isValidEmail && isValidPhoneNumber && isValidPassword
}

function validateFormAddCategory() {
    const isCategoryName = validateCategoryName();
    const isCategoryDescription = validateCategoryDescription();

    return isCategoryName && isCategoryDescription
}

function validateFormEditCategory() {
    const isCategoryName = validateCategoryNameUpdate();
    const isCategoryDescription = validateCategoryDescriptionUpdate();

    return isCategoryName && isCategoryDescription
}

function validateCategoryName() {
    const categoryName = document.querySelector('input[name="category_name"]').value.trim();
    const categoryNameError = document.getElementById('category_name_err');

    if (categoryName === "") {
        categoryNameError.textContent = "Tên danh mục không được để trống";
        categoryNameError.style.color = 'red'
        return false;
    } else if (!validateNoSpecialChars(categoryName)) {
        categoryNameError.textContent = "Tên danh mục không được chứa ký tự đặc biệt";
        categoryNameError.style.color = 'red'
        return false;
    } else {
        categoryNameError.textContent = "";
        categoryNameError.style.color = 'red'
        return true;
    }
}

function validateCategoryNameUpdate() {
    const categoryName = document.querySelector('input[name="category_name_update"]').value.trim();
    const categoryNameError = document.getElementById('category_name_update_err');

    if (categoryName === "") {
        categoryNameError.textContent = "Tên danh mục không được để trống";
        categoryNameError.style.color = 'red'
        return false;
    } else if (!validateNoSpecialChars(categoryName)) {
        categoryNameError.textContent = "Tên danh mục không được chứa ký tự đặc biệt";
        categoryNameError.style.color = 'red'
        return false;
    } else {
        categoryNameError.textContent = "";
        categoryNameError.style.color = 'red'
        return true;
    }
}

function validateCategoryDescription() {
    const categoryDescription = document.querySelector('input[name="category_description"]').value.trim();
    const categoryDescriptionError = document.getElementById('category_description_err');

    if (categoryDescription == ""){
        return true;
    }

    if (!validateNoSpecialChars(categoryDescription)) {
        categoryDescriptionError.textContent = "Mô tả không được chứa ký tự đặc biệt";
        categoryDescriptionError.style.color = 'red'
        return false;
    } else {
        categoryDescriptionError.textContent = "";
        categoryDescriptionError.style.color = 'red'
        return true;
    }
}

function validateCategoryDescriptionUpdate() {
    const categoryDescription = document.querySelector('input[name="category_description_update"]').value.trim();
    const categoryDescriptionError = document.getElementById('category_description_update_err');

    if (categoryDescription == ""){
        return true;
    }

    if (!validateNoSpecialChars(categoryDescription)) {
        categoryDescriptionError.textContent = "Mô tả không được chứa ký tự đặc biệt";
        categoryDescriptionError.style.color = 'red'
        return false;
    } else {
        categoryDescriptionError.textContent = "";
        categoryDescriptionError.style.color = 'red'
        return true;
    }
}


function validateFormVerifyCode() {
    const isCode = validateCode();
    return isCode
}
