<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Diễn Đàn IT - IUH">
    <!-- <meta name="description"
        content="The Ask is a bootstrap design help desk, support forum website template coded and designed with bootstrap Design, Bootstrap, HTML5 and CSS. Ask ideal for wiki sites, knowledge base sites, support forum sites">
     -->
    <meta name="keywords"
        content="HTML, CSS, JavaScript,Bootstrap,js,Forum,webstagram ,webdesign ,website ,web ,webdesigner ,webdevelopment">
    <meta name="robots" content="index, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <!-- logo -->
    <link rel="icon" href="<?php echo BASE_URL; ?>/public/admin/assets/img/logo-iuh.ico" type="image/x-icon">
    <!-- Title web -->
    <title>Diễn Đàn IT - IUH</title>
    <link href="<?php echo BASE_URL; ?>/public/client/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/client/css/style.css" rel="stylesheet" type="text/css">
    <!-- <link href="<?php echo BASE_URL; ?>/public/client/css/animate.css" rel="stylesheet" type="text/css"> -->
    <link href="<?php echo BASE_URL; ?>/public/client/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/client/css/footer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/client/css/sidebar.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/client/css/avt-header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/client/css/pusher.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/admin/assets/css/loading.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/src/css/navigation_header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/src/css/header.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/src/css/footer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>/public/src/css/body_auth.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/src/css/body_client.css">

    <!-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"> -->
    <!-- SweetAlert2 CSS -->
    <!-- Popup thông báo -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        #editor {
            height: 300px;
            margin-top: 20px;
        }

        .dropdown-menu>li:first-child>a:hover,
        .dropdown-menu>li:first-child>a:focus {
            color: #000;
            background-color: #fff !important;

        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .data-row {
            opacity: 0;
            /* Bắt đầu với độ trong suốt bằng 0 */
            transform: translateY(20px);
            /* Di chuyển xuống một chút */
            transition: opacity 0.5s ease, transform 0.5s ease;
            /* Hiệu ứng chuyển tiếp */
        }

        .data-row.show {
            opacity: 1;
            /* Đặt độ trong suốt thành 1 khi hiển thị */
            transform: translateY(0);
            /* Đưa nó trở lại vị trí ban đầu */
        }

        .modal-backdrop {
            z-index: 998;
        }
    </style>
</head>


<body>
    <span class="loader"></span>
    <div class="hidden-content">
        <!-- ==========header mega navbar=======-->
        <div class=" top-menu-bottom932 fixed-header">
            <nav class="navbar navbar-default mg-0">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle
                            navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="<?php echo BASE_URL ?>"><img
                            src="<?php echo BASE_URL ?>/public/src/uploads/logo-iuh-white.png" alt="Logo"></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav"> </ul>
                    <ul class="nav navbar-nav navbar-right header-right">
                        <li><a href="<?php echo BASE_URL ?>">Trang chủ</a></li>
                        <!-- <li><a href="ask_question.html">Giới thiệu</a></li> -->
                        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Bài viết
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu animated zoomIn">
                                <?php
                                if (count($categories) > 0) {
                                    echo '<li><a href="' . BASE_URL . '/home/allPosts/post">Tất cả</a></li>';
                                    foreach ($categories as $category) {
                                        if ($category['category_type'] == "post") {
                                            echo '<li><a href="' . BASE_URL . '/home/categories/' . $category['id'] . '/post">' . $category['name'] . '</a></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Câu hỏi <span class="caret"></span></a>
                            <ul class="dropdown-menu animated zoomIn">
                                <?php
                                if (count($categories) > 0) {
                                    echo '<li><a href="' . BASE_URL . '/home/allPosts/question">Tất cả</a></li>';
                                    foreach ($categories as $category) {
                                        if ($category['category_type'] == "post") {
                                            echo '<li><a href="' . BASE_URL . '/home/categories/' . $category['id'] . '/question">' . $category['name'] . '</a></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </li>

                        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Tài liệu <span class="caret"></span></a>
                            <ul class="dropdown-menu animated zoomIn">
                                <?php
                                if (count($categories) > 0) {
                                    echo '<li><a href="' . BASE_URL . '/home/allPosts/document">Tất cả</a></li>';
                                    foreach ($categories as $category) {
                                        if ($category['category_type'] == "document") {
                                            echo '<li><a href="' . BASE_URL . '/home/categories/' . $category['id'] . '/document">' . $category['name'] . '</a></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </li>

                        <!-- <li><a href="<?php echo BASE_URL ?>/home/policy">Chính sách</a></li> -->
                        <li>
                            <div class="col-md-12">
                                <div class="navbar-serch-right-side">
                                    <form class="navbar-form" role="search" id="searchForm" method="post"
                                        action="<?php echo BASE_URL ?>/home/search" id="formSearch">
                                        <div class="input-group add-on">
                                            <input class="form-control form-control222" placeholder="Tìm kiếm"
                                                id="srch-term" type="text" name="txtSearch"
                                                value="<?php echo isset($search) ? $search : ""; ?>">
                                            <input type="hidden" id="search-type" name='search-type'>

                                            <div class="input-group-btn">
                                                <button class="btn btn-default btn-default2913" type="submit"
                                                    name="btnSearch"><i class="glyphicon glyphicon-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>

                        <!-- Thêm icon chuông và dropdown thông báo -->
                        <li class="dropdown">
                            <?php
                            if (isset($_SESSION["UserID"])) {
                                echo '<a href="#" class="dropdown-toggle un-hover" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                <span class="badge pushertag"
                                    style="position: relative; top: -9px; background-color:red">0</span>
                                <!-- Số lượng thông báo -->
                            </a>
                            <ul class="dropdown-menu animated zoomIn" id="notification-dropdown">
                                <li class="dropdown-header">
                                    <h5 style="font-size: large; margin-bottom: 0">Thông báo</h5>
                                </li>
                                <li role="separator" class="divider"></li>
                            </ul>';
                            }
                            ?>
                        </li>

                        <!-- User menu -->
                        <li class="nav-item dropdown">
                            <?php
                            if (isset($_SESSION["UserID"])) {
                                $image = $_SESSION["Avatar"];
                                if ($_SESSION["RoleID"] == 1) {
                                    echo '<li class="dropdown"> <a href="' . BASE_URL . '/home/info/' . $_SESSION["AccountName"] . '" class="dropdown-toggle avt-user" data-toggle="dropdown"><img src="' . BASE_URL . '/public/src/uploads/' . $image . '" alt="Avatar"></span></a>
                            <ul class="dropdown-menu animated zoomIn">
                                <li><a href="' . BASE_URL . '/home/info/' . $_SESSION["AccountName"] . '"><img src="' . BASE_URL . '/public/src/uploads/' . $image . '" alt="Avatar"> <b>' . $_SESSION["UserName"] . '</b></a></li>
                                <hr>
                                <li><a href="' . BASE_URL . '/home/info/' . $_SESSION["AccountName"] . '">Trang cá nhân</a></li>
                                <li><a href="' . BASE_URL . '/admin">Trang quản trị</a></li>
                                <li><a href="#" id="openChangePasswordModal">Đổi mật khẩu</a></li>
                                <li><a href="' . BASE_URL . '/home/logout">Đăng xuất</a></li>
                            </ul>
                        </li>';
                                } else {
                                    echo '<li class="dropdown"> <a href="' . BASE_URL . '/home/info/' . $_SESSION["AccountName"] . '" class="dropdown-toggle avt-user" data-toggle="dropdown"><img src="' . BASE_URL . '/public/src/uploads/' . $image . '" alt="Avatar"></span></a>
                                <ul class="dropdown-menu animated zoomIn">
                                    <li><a href="' . BASE_URL . '/home/info/' . $_SESSION["AccountName"] . '"><img src="' . BASE_URL . '/public/src/uploads/' . $image . '" alt="Avatar"> <b>' . $_SESSION["UserName"] . '</b></a></li>
                                    <hr>
                                    <li><a href="' . BASE_URL . '/home/info/' . $_SESSION["AccountName"] . '">Trang cá nhân</a></li>
                                    <li><a href="#" id="openChangePasswordModal">Đổi mật khẩu</a></li>
                                    <li><a href="' . BASE_URL . '/home/logout">Đăng xuất</a></li>
                                </ul>
                            </li>';
                                }

                                echo '<div class="modal fade" id="change-password" tabindex="-1" role="dialog"
                        aria-labelledby="edit-user-modal-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header justify-content-center">
                                    <h3 style="text-align: center" class="modal-title" id="edit-user-modal-label"><b>Đổi Mật Khẩu</b></h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-user-form" action="' . BASE_URL . '/users/changePassword" method="post"
                                        ">
                                        <div class="form-group">
                                            <label for="current_password">Mật khẩu hiện tại:</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Nhập mật khẩu hiện tại của bạn">
                                            <small id="current_password_err"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">Mật khẩu mới:</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nhập mật khẩu hiện mới của bạn">
                                            <small id="new_password_err"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="retype_password_of_change">Nhập lại mật khẩu:</label>
                                            <input type="password" class="form-control" id="retype_password_of_change" name="retype_password_of_change" placeholder="Nhập lại mật khẩu mới của bạn">
                                            <small id="retype_password_of_change_err"></small>
                                        </div>
                                        <input type="hidden" name="token" value="' . $_SESSION['_token'] . '" />
                                        <button type="submit" name="btnChangePassword" class="btn btn-primary">Lưu thay đổi</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
                            } else {
                                echo '<a href="' . BASE_URL . '/Login"><i class="fa fa-user" aria-hidden="true"></i> Đăng
                                nhập</a>';
                            }
                            ?>
                        </li>

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
                <!-- /.container-fluid -->
            </nav>
        </div>


        <?php
        require_once "./mvc/views/pages/" . $Page . ".php";
        ?>

        <!--    footer -->
        <section class="footer-part">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-part-one320">
                            <img src="<?php echo BASE_URL ?>/public/src/uploads/logo-iuh-white.png" alt=""
                                class="img-footer">
                            <p class="pd-10">
                                Chào mừng các bạn đến với Diễn đàn Công nghệ thông tin, kênh thông tin cung cấp các
                                thông tin, kiến thức cho các bạn sinh viên.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-part-two320">
                            <h4>Liên kết nhanh</h4>
                            <a href="<?php echo BASE_URL ?>">
                                <p>- Trang chủ</p>
                            </a>
                            <a href="<?php echo BASE_URL ?>/home/allposts/post">
                                <p>- Bài viết</p>
                            </a>
                            <a href="<?php echo BASE_URL ?>/home/allposts/document">
                                <p>- Tài liệu</p>
                            </a>
                            <a href="<?php echo BASE_URL ?>/home/allposts/question">
                                <p>- Câu hỏi</p>
                            </a>
                            <a href="<?php echo BASE_URL ?>/home/policy" class="last-child12892">
                                <p>- Chính sách</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-part-four320">
                            <h4>Liên hệ</h4>
                            <!-- <h4>Địa chỉ:</h4> -->
                            <p>12 Nguyễn Văn Bảo, P4, Quận Gò Vấp <br>Thành phố Hồ Chí Minh.
                            </p>
                            <h4>Hỗ trợ:</h4>
                            <p>Số điện thoại: 0366 555 444</p>
                            <p>Email: hotro@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="footer-social">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>Bản quyền © 2024 | <strong>Diễn đàn công nghệ thông tin</strong></p>
                    </div>
                    <div class="col-md-6">
                        <div class="social-right2389"> <a href="#" class="bg-w"><i class="fa fa-twitter-square"
                                    aria-hidden="true"></i></a> <a href="#" class="bg-w"><i class="fa fa-facebook"
                                    aria-hidden="true"></i></a> <a href="#" class="bg-w"><i class="fa fa-google-plus"
                                    aria-hidden="true"></i></a> <a href="#" class="bg-w"><i class="fa fa-youtube"
                                    aria-hidden="true"></i></a> <a href="#" class="bg-w"><i class="fa fa-skype"
                                    aria-hidden="true"></i></a> <a href="#" class="bg-w"><i class="fa fa-linkedin"
                                    aria-hidden="true"></i></a> <a href="#" class="bg-w"><i class="fa fa-rss"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/client/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/client/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/client/js/npm.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/client/js/footer.js"></script>
    <script src="<?php echo BASE_URL; ?>/public/admin/assets/js/loading.js"></script>

    <!-- Trình soạn thảo -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script> -->

    <!-- SweetAlert2 JS -->
    <!-- popup thông báo -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        var title_mess = "<?php echo isset($_SESSION['title_message']) ? $_SESSION['title_message'] : "" ?>";
        var text_mes = "<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : "" ?>";

        function showSuccessNotification() {
            Swal.fire({
                icon: 'success',
                title: title_mess,
                text: text_mes,
                timer: 2000,
                timerProgressBar: true
            });
        }

        function showFailNotification() {
            Swal.fire({
                icon: 'error',
                title: title_mess,
                text: text_mes,
                timer: 3000,
                timerProgressBar: true
            });
        }

        function showWarningNotification() {
            Swal.fire({
                icon: 'warning',
                title: title_mess,
                text: text_mes,
                timer: 3000,
                timerProgressBar: true
            });
        }

        function showInfoNotification() {
            Swal.fire({
                icon: 'info',
                title: title_mess,
                text: text_mes,
                // timer: 3000,
                // timerProgressBar: true,
                showConfirmButton: true
            });
        }

        <?php
        $status = isset($_SESSION['action_status']) ? $_SESSION['action_status'] : "";
        switch ($status) {
            case 'success':
                echo 'showSuccessNotification();';
                $_SESSION['action_status'] = 'none';
                $_SESSION['title_message'] = '';
                $_SESSION['message'] = '';
                break;
            case 'error':
                echo 'showFailNotification();';
                $_SESSION['action_status'] = 'none';
                $_SESSION['title_message'] = '';
                $_SESSION['message'] = '';
                break;
            case 'warning':
                echo 'showWarningNotification();';
                $_SESSION['action_status'] = 'none';
                $_SESSION['title_message'] = '';
                $_SESSION['message'] = '';
                break;
            case 'info':
                echo 'showInfoNotification();';
                $_SESSION['action_status'] = 'none';
                $_SESSION['title_message'] = '';
                $_SESSION['message'] = '';
                break;
            default:
                echo '';
                break;
        }
        ?>
    </script>

    <script>
        function confirmDelete(event, targetHref) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
            Swal.fire({
                title: "Bạn có chắc chắn xóa không",
                width: '400px', // Tăng chiều rộng của popup
                confirmButtonText: "Xóa",
                cancelButtonText: "Thoát",
                // denyButtonText: `Don't save`,
                // showDenyButton: true,
                showCancelButton: true,
                // customClass: {
                //     title: 'swal2-title-large', // Kích thước chữ tiêu đề
                //     popup: 'swal2-popup-large', // Kích thước văn bản trong popup
                //     confirmButton: 'swal2-button-large', // Kích thước chữ nút xác nhận
                //     denyButton: 'swal2-button-large', // Kích thước chữ nút từ chối
                //     cancelButton: 'swal2-button-large' // Kích thước chữ nút hủy
                // }
            }).then((result) => {
                if (result.isConfirmed) {
                    targetHref = targetHref + "/<?php echo $_SESSION['_token'] ?? '' ?>"
                    // console.log("href: ", targetHref);
                    window.location.href = targetHref;
                    // window.location.href = event.target.href;
                    // Swal.fire("Xóa thành công!", "", "success");
                }
                // else if (result.isDenied) {
                //     Swal.fire("Changes are not saved", "", "info");
                // }
            });
        }
    </script>

    <!-- popup change password -->
    <script>
        $(document).ready(function () {
            // Khi người dùng nhấn vào nút "Đổi Mật Khẩu"
            $('#openChangePasswordModal').on('click', function () {
                // Hiển thị modal popup
                $('#change-password').modal('show');
            });
        });

        $(document).ready(function () {
            // Khi người dùng nhấn vào nút "Báo cáo"
            $('#openReportModal').on('click', function () {
                // Hiển thị modal popup
                $('#report').modal('show');
            });
        });
    </script>

    <!-- Pusher Thông báo realtime -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const BASE_URL = 'http://localhost/forum-app-none-secure';
    </script>
    <script src="<?php echo BASE_URL; ?>/public/client/js/pusher.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- handel type search -->
    <script>
        $(document).ready(function () {
            function updateSearchType() {
                const checkedRadio = $('input[name="tabs"]:checked').val();
                const sType =
                    "<?php echo isset($_SESSION["SearchType"]) ? $_SESSION["SearchType"] : "post"; ?>";

                console.log("search type: " + sType);
                if (checkedRadio) {
                    $('#search-type').val(checkedRadio);
                } else {
                    $('#search-type').val(sType);
                }
                console.log("Giá trị của #search-type:", document.getElementById('search-type').value);
            }

            updateSearchType();

            if ($('input[name="tabs"]').length > 0) {
                $('input[name="tabs"]').change(updateSearchType);
            }
        });
    </script>
</body>

</html>