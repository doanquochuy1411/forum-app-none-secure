<!-- ======breadcrumb ======-->
<section class="header-descriptin329">
    <div class="container">
        <h3>Thông tin chi tiết</h3>
        <ol class="breadcrumb breadcrumb839">
            <li><a href="<?php echo BASE_URL ?>">Trang chủ</a></li>
            <li class="active">Thông tin Chi tiết</li>
        </ol>
    </div>
</section>
<section class="main-content920">
    <div class="container">
        <div class="row">
            <!--    body content-->
            <div class="col-md-9">
                <div class="about-user2039 mt-70">
                    <div class="user-title3930">
                        <h3><a href="#"><?php echo $user_details["user_name"] ?></a>
                            <?php
                            if (isset($_SESSION["UserID"]) && $user_details["id"] == $_SESSION["UserID"]) {
                                // echo '<a href="#" class="edit-icon"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                                echo '<a href="#" class="edit-icon" data-toggle="modal" data-target="#edit-user-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                            }
                            ?>
                            <span class="badge229">
                                <a href="#">Thành viên</a>
                            </span>
                        </h3>
                        <hr>
                    </div>
                    <div class="user-image293"> <img
                            src="<?php echo BASE_URL . '/public/src/uploads/' . $user_details['image'] ?>" alt="Image">
                    </div>
                    <div class="user-list10039">
                        <div class="ul-list-user-left29">
                            <ul>
                                <li><i class="fa fa-plus" aria-hidden="true"></i> <strong>Ngày tham gia:</strong>
                                    <?php echo formatVietnameseDate($user_details["created_at"]) ?></li>
                                <?php
                                if (isset($_SESSION["UserID"]) && $user_details["id"] == $_SESSION["UserID"]) {
                                    echo '<li><i class="fa fa-envelope" aria-hidden="true"></i> <strong>Email:</strong> ' . $user_details["email"] . '
                                </li>';
                                } else {
                                    echo '<li><i class="fa fa-envelope" aria-hidden="true"></i> <strong>Email:</strong> ********
                                </li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="ul-list-user-right29">
                            <ul>
                                <?php
                                if (isset($_SESSION["UserID"]) && $user_details["id"] == $_SESSION["UserID"]) {
                                    echo '<li><i class="fa fa-phone" aria-hidden="true"></i> <strong>Số điện thoại:</strong>
                                    ' . $user_details["phone_number"] . ' 
                                </li>';
                                } else {
                                    echo '<li><i class="fa fa-phone" aria-hidden="true"></i> <strong>Số điện thoại:</strong>
                                    **********
                                </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="user-statas921">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ul_list_ul_list-icon-ok281">
                                <ul>
                                    <li><a href="#">Câu hỏi ( <?php echo $user_details["total_questions"] ?> )</a></li>
                                    <li><a href="#">Bài viết ( <?php echo $user_details["total_posts"] ?> )</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ul_list_ul_list-icon-ok281">
                                <ul>
                                    <li><a href="#">Điểm tích lũy ( <?php echo $user_details["point"] ?> )</a></li>
                                    <li><a href="#">Bình luận ( <?php echo $user_details["total_comments"] ?> )</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Popup form -->
            <!-- Bootstrap Modal -->
            <?php
            if (isset($_SESSION["UserID"]) && $user_details["id"] == $_SESSION["UserID"]) {
                echo '<div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog"
                aria-labelledby="edit-user-modal-label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h3 style="text-align: center" class="modal-title" id="edit-user-modal-label"><b>Cập Nhật
                                    Thông
                                    Tin<b></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-user-form" action="' . BASE_URL . '/users/UpdateInfo" method="post" enctype="multipart/form-data"
                                >
                                <div class="form-group">
                                    <label for="user_name">Tên người dùng:</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name"
                                        value="' . $user_details["user_name"] . '">
            <small id="user_name_err"></small>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email"
                value="' . $user_details["email"] . '">
            <small id="email_err"></small>
        </div>
        <div class="form-group">
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number"
                value="' . $user_details["phone_number"] . '">
            <small id="phone_number_err"></small>
        </div>
        <div class="form-group">
            <label for="user_image">Ảnh đại diện:</label>
            <input type="file" class="form-control-file" id="user_image" name="user_image">
        </div>
        <input type="hidden" name="token" value="' . $_SESSION['_token'] . '" />
        <button type="submit" name="btnUpdateInfo" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>
    </div>
    </div>
    </div>';
            }
            ?>

            <!--                end of col-md-9 -->
            <!--           strart col-md-3 (side bar)-->
            <?php require_once 'sidebar.php' ?>

        </div>
    </div>
</section>