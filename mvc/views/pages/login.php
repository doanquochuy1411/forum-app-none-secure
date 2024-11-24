<div class="account-page pd-t-90">
    <div class="account-center">
        <div class="account-box">
            <form action="<?php echo BASE_URL; ?>/login/HandelLogin" class="form-signin" method="post">
                <div class="account-logo">
                    <a href="<?php echo BASE_URL; ?>"><img
                            src="<?php echo BASE_URL; ?>/public/admin/assets/img/logo.png" alt="image"
                            class="lg-auth"></a>
                </div>
                <div class="form-group mg-b-5">
                    <label for="user_name">Tên tài khoản</label>
                    <input type="text" id="user_name" autofocus name="user_name" class="form-control"
                        placeholder="Nhập tên tài khoản" value="<?php echo $_SESSION["account_name_info"] ?? "" ?>">
                    <small id="user_name_err" class="alert-valid"></small>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Nhập mật khẩu" value="<?php echo $_SESSION["password_info"] ?? "" ?>">
                    <small id="password_err" class="alert-valid"></small>
                </div>
                <div class="form-group text-right">
                    <a href="<?php echo BASE_URL; ?>/reset">Quên mật khẩu?</a>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" name="btnLogin" type="submit">Đăng nhập</button>
                </div>

                <div class="text-center register-link">
                    Bạn chưa có tài khoản? <a href="<?php echo BASE_URL; ?>/register">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </div>
</div>