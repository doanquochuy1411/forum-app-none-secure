<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="title" content="Diễn Đàn IT - IUH">

    <!-- Title web -->
    <title>Diễn Đàn IT - IUH - Admin</title>
    <!-- Favicons -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL ?>/public/admin/assets/img/favicon.ico">

    <!-- Font Family -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet"> -->

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet"
        href="<?php echo BASE_URL ?>/public/admin/assets/plugins/fontawesome/css/fontawesome.min.css">

    <!-- Calendar CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/css/calendar.css">

    <!-- Datatable-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/css/dataTables.bootstrap4.min.css">

    <!-- Select 2-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/css/select2.min.css">

    <!-- Datetime Picker-->
    <link rel="stylesheet"
        href="<?php echo BASE_URL ?>/public/admin/assets/plugins/datetimepicker/css/tempusdominus-bootstrap-4.min.css">

    <!--custom styles-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/admin/assets/css/statistics.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/src/css/pagination.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/public/src/css/admin.css">
    <!-- <link href="<?php echo BASE_URL; ?>/public/admin/assets/css/loading.css" rel="stylesheet" type="text/css"> -->
    <!-- logo -->
    <link rel="icon" href="<?php echo BASE_URL; ?>/public/admin/assets/img/logo-iuh.ico" type="image/x-icon">
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
    }
</style>

<body>

    <!-- Main Wrapper -->
    <span class="loader"></span>
    <div class="hidden-content">
        <div class="main-wrapper">
            <!-- Header start -->
            <div class="header-menu">
                <div class="header-left">
                    <a href="<?php echo BASE_URL ?>" class="logo">
                        <img src="<?php echo BASE_URL ?>/public/src/uploads/logo-iuh-white.png" width="120" height="60"
                            alt="">
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="menubar">
                    <a id="toggle_btn" href="javascript:void(0);"><i class="fas fa-bars"></i></a>
                </div>
                <!-- /Mobile Menu Toggle -->

                <!-- Search-->
                <div class="searchbar">
                    <form class="form-inline my-1 w-25 float-left">
                        <input class="form-control mr-sm-2 search-input search_icon" type="text" id="searchInput"
                            placeholder="Tìm kiếm...">
                    </form>
                </div>
                <!--/ Search-->

                <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>

                <!-- Header Right Menu -->
                <ul class="nav user-menu float-right">
                    <!-- /Notifications -->
                    <li class="nav-item dropdown d-none d-sm-block">
                        <a href="#" id="alert-notification" class="dropdown-toggle nav-link" data-toggle="dropdown"><i
                                class="far fa-bell"></i>
                            <!-- <span class="badge badge-pill bg-danger float-right">3</span> -->
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span>Thông báo</span>
                            </div>
                            <div class="drop-scroll">
                                <ul class="notification-list" id="notification-dropdown">
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- /Notifications -->

                    <li class="nav-item dropdown has-arrow">
                        <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                            <span><?php echo $user[0]["user_name"] ?></span>&nbsp;
                            <span class="user-img">
                                <img class="rounded-circle"
                                    src="<?php echo BASE_URL ?>/public/src/uploads/<?php echo $user[0]["image"] ?>"
                                    width="24" alt="Admin">
                                <span class="status online"></span>
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo BASE_URL ?>">Trang chính</a>
                            <a class="dropdown-item" href="<?php echo BASE_URL ?>/home/logout">Đăng xuất</a>
                        </div>
                    </li>
                </ul>
                <!--/ Header Right Menu -->

                <!-- User Menu -->
                <div class="dropdown mobile-user-menu float-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                            class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Trang cá nhân</a>
                        <a class="dropdown-item" href="<?php echo BASE_URL ?>/home/logout">Đăng xuất</a>
                    </div>
                </div>
                <!--/ User Menu -->
            </div>
            <!-- /Header -->

            <!--sidebar-->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
                    <div id="sidebar-menu" class="sidebar-menu">
                        <ul>
                            <li class="menu-title">Chính</li>
                            <li class="<?php echo $Page == "dashboard" ? "active" : ""; ?>">
                                <a href="<?php echo BASE_URL ?>/admin"><i class="fas fa-tachometer-alt"></i> <span>Tổng

                                        quan</span></a>
                            </li>
                            <li class="<?php echo $Page == "user" ? "active" : ""; ?>">
                                <a href="<?php echo BASE_URL ?>/admin/users"><i class="fa fa-user-md"></i> <span>Người
                                        dùng</span></a>
                            </li>
                            <li class="<?php echo $Page == "post" ? "active" : ""; ?>">
                                <a href="<?php echo BASE_URL ?>/admin/posts"><i class="fa fa-edit"></i> <span>Bài
                                        viết</span></a>
                            </li>
                            <li class="<?php echo $Page == "question" ? "active" : ""; ?>">
                                <a href="<?php echo BASE_URL ?>/admin/questions"><i class="fa fa-question-circle"></i>
                                    <span>Câu
                                        hỏi</span></a>
                            </li>
                            <li class="<?php echo $Page == "document" ? "active" : ""; ?>">
                                <a href="<?php echo BASE_URL ?>/admin/documents"><i class="fa fa-book"></i>
                                    <span>Tài liệu</span></a>
                            </li>
                            <li class="<?php echo $Page == "category_admin" ? "active" : ""; ?>">
                                <a href="<?php echo BASE_URL ?>/admin/categories"><i class="fa fa-folder"></i>
                                    <span>Danh mục</span></a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL ?>"><i class="fas fa-home"></i> <span>Diễn
                                        đàn</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/sidebar-->

            <!--content-->
            <?php
            require_once "./mvc/views/pages/" . $Page . ".php";
            ?>
            <!--/ content-->

            <!--Delete patient modal-->
            <div id="delete_patient" class="modal fade delete-modal" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="<?php echo BASE_URL ?>/public/admin/assets/img/sent.png" alt="" width="50"
                                height="46">
                            <h3>Bạn có chắc chắn xóa?</h3>
                            <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Đóng</a>
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--Delete patient modal-->

            <!-- Add User modal -->
            <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-label"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h3 style="text-align: center" class="modal-title" id="edit-user-modal-label"><b>Thêm thành
                                    viên</b></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="add-user-form" action="<?php echo BASE_URL ?>/admin/addUser" method="post">
                                <div class="form-group">
                                    <label for="email">Email*</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <small id="email_err"></small>
                                </div>
                                <div class="form-group">
                                    <label for="account_name">Tên tài khoản*</label>
                                    <input type="text" class="form-control" id="account_name" name="account_name">
                                    <small id="account_name_err"></small>
                                </div>
                                <div class="form-group">
                                    <label for="user_name">Tên người dùng*</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name">
                                    <small id="full_name_err"></small>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="phone_number">Số điện thoại*</label>
                                    <input type="phone_number" class="form-control" id="phone_number"
                                        name="phone_number">
                                    <small id="phone_number_err"></small>
                                </div> -->
                                <div class="form-group">
                                    <label for="password">Mật khẩu*</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <small id="password_err"></small>
                                </div>
                                <input type="hidden" name="token" value="<?php echo $_SESSION['_token'] ?>" />
                                <button type="submit" name="btnAddUser" class="btn btn-primary">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End add user modal -->
        </div>
    </div>

    <!--scripts-->
    <!-- jQuery -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/jquery.slimscroll.js"></script>

    <!-- Select2 JS -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/select2.min.js"></script>
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/moment.min.js"></script>

    <!-- Datetime picker JS -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/plugins/datetimepicker/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <!-- Calender JS -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/calendar.min.js"></script>

    <!-- Apex chart JS -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/apex.js"></script>

    <!-- Custom JS -->
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/app.js"></script>
    <!-- <script src="<?php echo BASE_URL; ?>/public/admin/assets/js/loading.js"></script> -->

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo BASE_URL ?>/public/client/js/pusherAdmin.js"></script>
    <script src="<?php echo BASE_URL ?>/public/admin/assets/js/chart.js"></script>
    <script src="<?php echo BASE_URL ?>/public/src/js/main.js"></script>
    <script>
        $(document).ready(function () {
            // Add user modal
            $('#openAddUserModal').on('click', function () {
                $('#add-user').modal('show');
            });

            // Add category modal
            $('#openAddCategoryModal').on('click', function () {
                $('#add-category').modal('show');
            });

            // Edit category modal
            $('#openEditCategoryModal').on('click', function () {
                var categoryId = $(this).data('category-id');
                // console.log(categoryId);
                $('#edit-category').modal('show');
            });
        });
    </script>

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
                width: '500px', // Tăng chiều rộng của popup
                confirmButtonText: "Xóa",
                showCancelButton: true,
                cancelButtonText: "Thoát",
            }).then((result) => {
                if (result.isConfirmed) {
                    targetHref = targetHref + "/<?php echo $_SESSION['_token'] ?? '' ?>"
                    window.location.href = targetHref;
                }
            });
        }
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- <script src="<?php echo BASE_URL; ?>/public/client/js/pusher.js"></script> -->
</body>

</html>