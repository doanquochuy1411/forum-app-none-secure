<div class="account-page pd-t-90">
    <div class="account-center">
        <div class="account-box">
            <form class="form-signin" action="<?php echo BASE_URL; ?>/Reset/HandelReset" method="post">
                <div class="account-logo">
                    <a href="<?php echo BASE_URL; ?>"><img
                            src="<?php echo BASE_URL; ?>/public/admin/assets/img/logo.png" class="lg-auth"
                            alt="Preadmin"></a>
                </div>
                <input hidden type="text" name="email" placeholder="Email" value="<?php echo $data ?> ">
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" id="new_password" class="form-control" name="password"
                        placeholder="Mật khẩu mới của bạn" onchange="validatePassword()">
                    <small id="password_err"></small>
                </div>
                <div class="form-group">
                    <label for="retype_new_password">Nhập lại mật khẩu của bạn</label>
                    <input type="password" class="form-control" id="retype_new_password" name="retype_password"
                        placeholder="Nhập lại mật khẩu của bạn" onchange="validateRetypePassword()">
                    <small id="retype_password_err"></small>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit" name="btnReset">Khôi phục</button>
                </div>
                <div class="text-center register-link">
                    <a href="<?php echo BASE_URL; ?>/login">Quay lại trang đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>