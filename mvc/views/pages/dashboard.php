<!-- content -->
<div class="page-wrapper">
    <div class="content">
        <!-- Dashboard-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="admin_title">Tổng quan</h3>
                <div class="row bg-white m-0 mb-4 overview">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-2 pr-0 pd-l-0">
                        <div class="dash-widget">
                            <span class="dash-widget-bg1">
                                <img src="<?php echo BASE_URL ?>/public/admin/assets/img/my-icons/icon-1.5.png"
                                    alt="Icon" width="25">
                            </span>
                            <div class="dash-widget-info float-left pl-2">
                                <p>Tổng Thành Viên</p>
                                <h4><?php echo count($all_users) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-2 pr-0">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2"><img
                                    src="<?php echo BASE_URL ?>/public/admin/assets/img/my-icons/icon-2.4.png"
                                    alt="Icon" width="25"></span>
                            <div class="dash-widget-info float-left pl-2">
                                <p>Tổng Bài Viết</p>
                                <h4><?php echo count($posts) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-2 pr-0">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3"><img
                                    src="<?php echo BASE_URL ?>/public/admin/assets/img/my-icons/icon-3.9.png"
                                    alt="Icon" width="25"></span>
                            <div class="dash-widget-info float-left pl-2">
                                <p>Tổng Câu Hỏi</p>
                                <h4><?php echo count($questions) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-2 pr-0">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3"><img
                                    src="<?php echo BASE_URL ?>/public/admin/assets/img/my-icons/icon-5.png" alt="Icon"
                                    width="25"></span>
                            <div class="dash-widget-info float-left pl-2">
                                <p>Tổng Tài Liệu</p>
                                <h4><?php echo count($documents) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-2 pr-0">
                        <div class="dash-widget">
                            <span class="dash-widget-bg4"><img
                                    src="<?php echo BASE_URL ?>/public/admin/assets/img/my-icons/icon-4.4.png"
                                    alt="Icon" width="25"></span>
                            <div class="dash-widget-info float-left pl-2">
                                <p>Tổng lượt xem</p>
                                <h4><?php
                                $total_view = 0;
                                foreach ($questions as $question) {
                                    $total_view += $question["views"];
                                }
                                foreach ($posts as $post) {
                                    $total_view += $post["views"];
                                }
                                echo $total_view;
                                ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mt-4">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="yearSelect" class="form-label">Chọn năm:</label>
                            <select id="yearSelect" class="form-select">
                                <?php
                                $currentYear = date("Y");
                                foreach ($years as $year) {
                                    if ($year == $currentYear) {
                                        echo '<option value="' . $year . '" selected>' . $year . '</option>';
                                    } else {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 text-center">
                            <h4 class="text-dark mb-4">Thống kê Số lượng Bài Đăng theo Tháng</h4>
                            <div class="card p-3">
                                <canvas id="postsChart"></canvas>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <h4 class="text-dark mb-4">Thống kê Số lượng Người dùng theo Tháng</h4>
                            <div class="card p-3">
                                <canvas id="usersChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 text-center">
                            <h4 class="text-dark mb-4">Top 10 bài viết có lượt xem cao nhất</h4>
                            <div class="card p-3">
                                <canvas id="viewsChart"></canvas>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-center">
                            <h4 class="text-dark mb-4">Top 10 bài viết được thích nhiều nhất</h4>
                            <div class="card p-3">
                                <canvas id="likesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Dashboard-->

        <!-- Latest PAtients-->
        <div class="row">
            <div class="col-12">
                <h4 class="admin_title">NGƯỜI DÙNG MỚI NHẤT</h4>
                <div class="table-responsive">
                    <table class="table bg-white mb-0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ tên</th>
                                <th>Ngày tham gia</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($all_users as $user) {
                                if ($count == 5) {
                                    break;
                                }
                                if ($user["id"] != $_SESSION["UserID"]) {
                                    echo '  <tr>
                                    <td>00' . $count . '</td>
                                    <td>' . $user['user_name'] . '</td>
                                    <td>' . date('d/m/Y', strtotime($user["created_at"])) . '</td>
                                    <td>' . $user['email'] . '</td>
                                    <td>' . $user['phone_number'] . '</td>
                                    <td>
                                    <a href="#" style="color: red" title="Xóa thành viên" class="px-2 del"><i class="fa fa-trash-alt" onclick="confirmDelete(event,\'' . BASE_URL . '/admin/deleteUser/' . $user['id'] . '\')"></i></a>
                                        </td>
                                </tr>';
                                    $count++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Latest Patients-->
    </div>
</div>
<!--/ content -->