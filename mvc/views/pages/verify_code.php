<?php
$expiryTime = $_SESSION['otp_map'][$data]['otp_expiry'];
$remainingTime = $expiryTime - time();
?>
<style>
    .recode-btn {
        text-decoration: underline;
        color: #18568c !important;
    }

    .recode-btn:hover {
        opacity: 0.8;
    }
</style>
<div class="account-page pd-t-90">
    <div class="account-center">
        <div class="account-box">
            <form class="form-signin" action="<?php echo BASE_URL; ?>/<?php echo $controller ?>/VerifyCode"
                method="post">
                <div class="account-logo">
                    <a href="<?php echo BASE_URL; ?>"><img
                            src="<?php echo BASE_URL; ?>/public/admin/assets/img/logo.png" class="lg-auth"
                            alt="Preadmin"></a>
                </div>
                <input hidden type="text" name="email" placeholder="Email" value="<?php echo $data ?> ">
                <div class="form-group">
                    <label for="code">Nhập mã xác minh</label>
                    <input type="text" class="form-control" id="code" name="code" autofocus
                        placeholder="Nhập mã xác minh của bạn">
                    <small id="code_err"></small>
                </div>
                <div class="form-group text-center">
                    <p><span id="countdown"></span></p>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" name="btnVerifyCode" type="submit">Tiếp theo</button>
                </div>
                <div class="text-center register-link">
                    <a href="<?php echo BASE_URL; ?>/login">Quay lại trang đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var timeLeft = <?php echo $remainingTime; ?>;
    var countdownInterval;

    function updateCountdown() {
        if (timeLeft > 0) {
            document.getElementById("countdown").textContent = "Mã xác nhận có hiệu lực trong " + timeLeft + " giây.";
            timeLeft--;
        } else {
            clearInterval(countdownInterval); // Dừng đếm ngược khi hết thời gian
            document.getElementById("countdown").innerHTML =
                "Mã xác nhận đã hết hạn. " +
                '<a class="recode-btn" href="javascript:void(0)" onclick="resendCode()">Gửi lại.</a>';
        }
    }

    countdownInterval = setInterval(updateCountdown, 1000);

    function resendCode() {
        var email = "<?php echo isset($data) ? $data : 'none'; ?>";
        $.ajax({
            url: `<?php echo BASE_URL ?>/publicApi/reSendCode/${email}`,
            type: 'GET',
            success: function (response) {
                timeLeft = 90;
                clearInterval(countdownInterval);
                countdownInterval = setInterval(updateCountdown, 1000);

                Swal.fire({
                    icon: 'success',
                    title: 'Mã xác minh đã được gửi lại thành công.',
                    timer: 2000,
                    timerProgressBar: true
                });
            },
            error: function () {
                console.log("Error sending code.");
                Swal.fire({
                    icon: 'error',
                    title: 'Gửi mã xác minh thất bại. Vui lòng thử lại sau!',
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        });
    }
</script>