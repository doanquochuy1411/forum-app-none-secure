<style>
    .auth-logo img {
        max-width: 150px;
        margin: 0 auto 20px;
        display: block;
    }

    .auth-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        text-align: center;
    }

    .auth-instructions {
        font-size: 1.4rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .input-group {
        display: flex;
        align-items: center;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        overflow: hidden;
    }

    .input-group-text {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-right: 1px solid #ddd;
        padding: 10px;
        font-size: 1.2rem;
        color: #007bff;
        width: 60px;
    }

    .input-group-text i {
        margin: 0;
        font-size: 2rem;
    }

    .form-control {
        border: none;
        padding: 10px;
        font-size: 1rem;
        box-shadow: none;
    }

    .form-control:focus {
        outline: none;
        box-shadow: 0 0 3px rgba(0, 123, 255, 0.3);
    }

    .alert-valid {
        font-size: 0.8rem;
        color: red;
        margin-top: 5px;
        display: block;
    }
</style>
<div class="account-page pd-t-90">
    <div class="account-center">
        <div class="account-box">
            <form action="<?php echo BASE_URL; ?>/login/Handel2FA" class="form-signin" method="post">
                <div class="form-group mg-b-5">
                    <center>
                        <h4 class="auth-title">Xác thực hai yếu tố (2FA)</h4>
                    </center>
                </div>
                <div class="auth-logo">
                    <a href="<?php echo BASE_URL; ?>"><img src="<?php echo $link ?? ""; ?>" alt="image"
                            class="lg-auth"></a>
                </div>
                <p class="auth-instructions">
                    Để bảo vệ tài khoản, vui lòng cài đặt ứng dụng <strong>Google Authenticator</strong> trên điện thoại
                    của bạn.
                    Sau đó, mở ứng dụng và quét mã QR ở trên để thêm tài khoản này vào ứng dụng.
                </p>
                <p class="auth-instructions">
                    Sau khi thêm thành công, nhập mã xác thực hiển thị trong ứng dụng vào ô bên dưới để hoàn tất đăng
                    nhập.
                </p>

                <input type="hidden" name="account_name" value="<?php echo $account_name ?? ""; ?>" />

                <div class="form-group mg-b-5">
                    <!-- <label>Nhập mã xác thực: </label> -->
                    <!-- <input type="text" autofocus name="pass_code" required class="form-control"
                        placeholder="Nhập mã xác thực" value=""> -->
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i> <!-- Biểu tượng ổ khóa -->
                        </span>
                        <input type="text" id="pass_code" name="pass_code" required class="form-control"
                            placeholder="Nhập mã xác thực" value="">
                    </div>
                    <small id="pass_code_err" class="alert-valid"></small>
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" name="btn2FA" type="submit">Đăng nhập</button>
                </div>

                <div class="text-center register-link">
                    <a href="<?php echo BASE_URL; ?>/login">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>