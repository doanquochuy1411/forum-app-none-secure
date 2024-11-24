<div class="account-page pd-t-90">
    <div class="account-center">
        <div class="account-box">
            <form class="form-signup-info" action="<?php echo BASE_URL; ?>/Register/HandelRegister" method="post">
                <div class="account-logo">
                    <a href="<?php echo BASE_URL; ?>"><img
                            src="<?php echo BASE_URL; ?>/public/admin/assets/img/logo.png" class="lg-auth"
                            alt="Preadmin"></a>
                </div>
                <input hidden type="text" name="email" placeholder="Email" value="<?php echo $data ?> ">
                <div class="form-group">
                    <label for="full_name">Tên của bạn</label>
                    <input type="text" class="form-control" value="<?php echo $full_name ?? "" ?>" name="full_name"
                        id="full_name" placeholder="Nhập họ tên của bạn" autofocus>
                    <small id="full_name_err"></small>
                </div>
                <div class="form-group">
                    <label>Giới tính </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Nam" id="gender_male" checked>
                        <label class="form-check-label" for="gender_male">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Nữ" id="gender_female">
                        <label class="form-check-label" for="gender_female">Nữ</label>
                    </div>
                    <small id="gender_err" style="color: red;"></small>
                </div>
                <div class="form-group">
                    <label for="account_name">Tên tài khoản</label>
                    <input type="text" class="form-control" value="<?php echo $account_name ?? "" ?>"
                        name="account_name" id="account_name" placeholder="Nhập tên tài khoản của bạn">
                    <small id="account_name_err"></small>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" value="<?php echo $password ?? "" ?>" name="password"
                        id="password" placeholder="Nhập mật khẩu của bạn">
                    <small id="password_err"></small>
                </div>
                <div class="form-group">
                    <label for="retype_password">Nhập lại mật khẩu của bạn</label>
                    <input type="password" class="form-control" value="<?php echo $re_type_password ?? "" ?>"
                        name="retype_password" id="retype_password" placeholder="Nhập lại mật khẩu của bạn">
                    <small id="retype_password_err"></small>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit" name="btnRegister">Đăng ký</button>
                </div>
                <div class="text-center register-link">
                    <a href="<?php echo BASE_URL; ?>/login">Trở về đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>