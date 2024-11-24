<style>
    .container-content {
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
        margin: 0;
        padding: 0;
        box-shadow: none;
    }

    .container-content.fade-out {
        opacity: 0;
    }

    #main {
        padding: 20px;
        margin: 25px 0 0 0;
        background: #ffffff;
        box-shadow: 0px 0px 13px -3px;
    }

    #main>input:checked+label {
        background-color: white;
    }

    .question-type2033 {
        /* box-shadow: 0px 0px 10px -5px #777; */
        box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
    }

    .sidebar97239 {
        height: 95%;
        margin-bottom: 30px
    }

    /* Action css */
    .post-actions {
        position: relative;
        /* Cần cho menu hành động xuất hiện đúng vị trí */
    }

    .action-menu {
        position: absolute;
        top: 100%;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 100;
        margin-top: 5px;
        border-radius: 5px;
        animation: fadeIn 0.3s;
    }

    .action-menu button {
        display: block;
        width: 100%;
        padding: 10px;
        border: none;
        background: none;
        text-align: left;
        cursor: pointer;
    }

    .action-menu button:hover {
        background-color: #f0f0f0;
    }

    .action-icon {
        position: absolute;
        right: 15px;
        bottom: 0px;
    }

    .action-icon a {
        color: #000;
        font-size: 16px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            /* Bắt đầu với độ mờ 0 */
            transform: translateY(-10px);
            /* Bắt đầu từ vị trí trên menu */
        }

        to {
            opacity: 1;
            /* Kết thúc với độ mờ 1 */
            transform: translateY(0);
            /* Về vị trí ban đầu */
        }
    }
</style>
<!-- ======breadcrumb ======-->
<section class="header-descriptin329 pd-t-120">
    <div class="container">
        <h3>Thông tin chi tiết</h3>
        <ol class="breadcrumb breadcrumb840 z-index-2">
            <li><a href="<?php echo BASE_URL ?>">Trang chủ</a></li>
            <li class="active">Thông tin Chi tiết</li>
        </ol>
    </div>
</section>
<section class="main-content920">
    <div class="container mg-top-70">
        <div class="row">
            <!--    body content-->
            <div class="col-md-9">
                <div class="about-user2039 mt-70">
                    <div class="user-title3930">
                        <h3><a href="#"><?php echo $user_details["user_name"] ?></a>
                            <?php
                            if (isset($_SESSION["UserID"]) && decryptData($user_details["id"]) == decryptData($_SESSION["UserID"])) {
                                echo '<a href="#" class="edit-icon" data-toggle="modal" data-target="#edit-user-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                            }
                            ?>
                            <!-- Nút theo dõi -->
                            <button id="followButton" class="btn btn-sm btn-follow" <?php
                            if (!isset($_SESSION["UserID"]) || decryptData($user_details["id"]) == decryptData($_SESSION["UserID"])) {
                                echo "disabled";
                            }
                            ?>>
                                <i class="fa fa-plus i-plus"></i>Theo dõi
                            </button>

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
                                if (isset($_SESSION["UserID"]) && decryptData($user_details["id"]) == decryptData($_SESSION["UserID"])) {
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
                                if (isset($_SESSION["UserID"]) && decryptData($user_details["id"]) == decryptData($_SESSION["UserID"])) {
                                    echo '<li><i class="fa fa-phone" aria-hidden="true"></i> <strong>Số điện thoại:</strong>
                                    ' . $user_details["phone_number"] . ' 
                                </li>';
                                } else {
                                    echo '<li><i class="fa fa-phone" aria-hidden="true"></i> <strong>Số điện thoại:</strong>
                                    **********
                                </li>';
                                }
                                ?>
                                <?php
                                if ($user_details["gender"] == "Nam") {
                                    echo '<li><i class="fa fa-mars" aria-hidden="true"></i> <strong>Giới tính:</strong>
                                    Nam</li>';
                                } else if ($user_details["gender"] == "Nữ") {
                                    echo '<li><i class="fa fa-venus" aria-hidden="true"></i> <strong>Giới tính:</strong>
                                    Nữ</li>';
                                } else {
                                    echo '<li><i class="fa fa-transgender-alt" aria-hidden="true"></i> <strong>Giới tính:</strong>
                                    Không xác định</li>';
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
                                    <li><a href="#">Tài liệu ( <?php echo $user_details["total_document"] ?> )</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="main">
                    <input id="tab1" type="radio" name="tabs" checked>
                    <label for="tab1">Bài viết</label>

                    <input id="tab2" type="radio" name="tabs">
                    <label for="tab2">Câu hỏi</label>

                    <input id="tab3" type="radio" name="tabs">
                    <label for="tab3">Tài liệu</label>

                    <!-- Posts -->
                    <section id="content1">
                        <!-- Recently answered Content Section -->
                        <div class="container-content">
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">

                            </ul>
                        </nav>
                    </section>

                    <!-- Questions -->
                    <section id="content2">
                        <div class="container-content">

                        </div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination">

                            </ul>
                        </nav>
                    </section>

                    <!-- Documents -->
                    <section id="content3">
                        <div class="container-content">

                        </div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination">

                            </ul>
                        </nav>
                    </section>
                </div>
            </div>
            <!-- Popup form -->
            <!-- Bootstrap Modal -->
            <?php
            if (isset($_SESSION["UserID"]) && decryptData($user_details["id"]) == decryptData($_SESSION["UserID"])) {
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
                                        value="' . $user_details["user_name"] . '" placeholder="Nhập họ tên của bạn">
            <small id="user_name_err"></small>
        </div>
         <div class="form-group">
                    <label>Giới tính </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Nam" id="gender_male" checked>
                        <label class="form-check-label" for="gender_male">Nam</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Nữ" id="gender_female">
                        <label class="form-check-label" for="gender_female">Nữ</label>
                    </div>
                    <small id="gender_err" style="color: red;"></small>
                </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email"
                value="' . $user_details["email"] . '" placeholder="Nhập email của bạn">
            <small id="email_err"></small>
        </div>
        <div class="form-group">
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Nhập số điện thoại của bạn"
                value="' . $user_details["phone_number"] . '">
            <small id="phone_number_err"></small>
        </div>
        <div class="form-group">
            <label for="user_image">Ảnh đại diện:</label>
            <input type="file" accept=".jpg, .jpeg, .png, .gif" class="form-control-file" id="user_image" name="user_image">
        </div>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- popup -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editIcon = document.querySelector('.edit-icon');
        var popup = document.getElementById('edit-popup');
        var close = document.querySelector('.close');

        if (editIcon) { // Kiểm tra nếu phần tử tồn tại
            editIcon.addEventListener('click', function (event) {
                event.preventDefault();
                popup.style.display = 'flex';
            });
        }
        if (close) {
            close.addEventListener('click', function () {
                popup.style.display = 'none';
            });
        }

        window.addEventListener('click', function (event) {
            if (event.target == popup) {
                popup.style.display = 'none';
            }
        });
    });
</script>

<script>
    const currentUser = "<?php echo isset($_SESSION["UserID"]) ? decryptData($_SESSION["UserID"]) : "empty"; ?>";
    const ownUser = "<?php echo isset($user_details["id"]) ? decryptData($user_details["id"]) : "user_details"; ?>";
</script>

<!-- Handel user's post -->
<script>
    // console.log("hihi")
    var myQuestionsData = <?php echo json_encode($my_questions); ?>;
    var myPostsData = <?php echo json_encode($my_posts); ?>;
    var myDocumentsData = <?php echo json_encode($my_trades); ?>;

    function paginate(data, page, limit, containerId) {
        var start = (page - 1) * limit;
        var end = start + limit;
        var paginatedData = data.slice(start, end);

        var container = document.querySelector(containerId + ' .container-content');
        container.classList.add('fade-out');

        setTimeout(function () {
            container.innerHTML = '';

            paginatedData.forEach(function (post) {
                var content = stripImages(post.content);
                var html = '<div class="question-type2033">';
                html += '<div class="row">';
                html += '<div class="col-md-12">';
                html += '<div class="right-description893">';
                html += '<div id="que-hedder2983">';
                if (containerId === "#content5") {
                    html += '<h3><a href="<?php echo BASE_URL ?>/posts/edit/' + post.id +
                        '" target="_blank">' +
                        post.title +
                        '</a> <a href="#" style="color: red" title="Xóa bài viết"><i class="fa fa-close" onclick="confirmDelete(event,\'<?php echo BASE_URL ?>/posts/delete/' +
                        post.id +
                        '\')"></i></a></h3>';
                } else {
                    html += '<h3><a href="<?php echo BASE_URL ?>/home/posts/' + post.id +
                        '" target="_blank">' +
                        post.title + '</a></h3>';
                }
                html += '</div>';
                html += '<div class="ques-details10018">';
                html += '<div>' + content + '</div>';
                html += '</div>';
                html += '<hr>';
                html +=
                    '<div class="ques-icon-info3293"><a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"> ' +
                    post
                        .like_count +
                    ' Thích</i></a><a href="#"><i class="fa fa-clock-o" aria-hidden="true"> ' +
                    timeAgo(post.created_at) +
                    '</i></a> <a href="#"><i class="fa fa-comment" aria-hidden="true"> ' +
                    post.comment_count +
                    ' trả lời</i></a> <a href="#"><i class="fa fa-user-circle-o" aria-hidden="true"> ' +
                    post.views +
                    ' lượt xem</i>';
                html += '</div>';
                // Add action
                if (currentUser === ownUser) {
                    html += '<div class="post-actions action-icon">';
                    html +=
                        '<span class="action-dots" onclick="toggleActions(event)" id="action-dots"><i class="fa fa-ellipsis-h"></i></span>';
                    html +=
                        '<div class="action-menu" id="action-menu" style="display: none;">'; // Ẩn menu mặc định
                    html += '<button onclick="editPost(\'' + post.id +
                        '\')">Sửa</button>';
                    html += '<button onclick="deletePost(\'' + post.id +
                        '\')">Xóa</button>';
                    html += '</div>';
                    html += '</div>';
                }

                // End action
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-2">';
                html += '<div class="ques-type302">';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                container.innerHTML += html;
            });

            container.classList.remove('fade-out');
        }, 300); // Thời gian chờ để hiệu ứng fade out hoàn thành
    }

    function timeAgo(datetime) {
        const now = new Date();
        const ago = new Date(datetime);
        const diffInSeconds = Math.floor((now - ago) / 1000);

        const timeUnits = {
            year: 'năm',
            month: 'tháng',
            week: 'tuần',
            day: 'ngày',
            hour: 'giờ',
            minute: 'phút',
            second: 'giây'
        };

        const secondsInUnits = {
            year: 31536000,
            month: 2592000,
            week: 604800,
            day: 86400,
            hour: 3600,
            minute: 60,
            second: 1
        };

        let result = '';
        for (const [unit, label] of Object.entries(timeUnits)) {
            const interval = Math.floor(diffInSeconds / secondsInUnits[unit]);
            if (interval > 0) {
                result = interval + ' ' + label + ' trước';
                break; // Chỉ lấy khoảng thời gian lớn nhất
            }
        }

        return result || 'vừa mới'; // Nếu không có khoảng thời gian lớn hơn 0, hiển thị 'vừa mới'
    }

    function stripImages(content) {
        return content.replace(/<img[^>]*>/g, '');
    }

    function updatePagination(data, totalItems, limit, containerId, currentPage) {
        var totalPages = Math.ceil(totalItems / limit); // Tổng số trang
        var paginationContainer = document.querySelector(containerId + ' .pagination');
        paginationContainer.innerHTML = ''; // Xóa phân trang cũ

        var maxVisiblePages = 5; // Số lượng trang hiển thị tối đa
        var startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        var endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        if (endPage - startPage + 1 < maxVisiblePages && startPage > 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Nút "Trước"
        var prevBtn = document.createElement('li');
        prevBtn.className = currentPage === 1 ? 'page-item disabled' : 'page-item';
        var prevA = document.createElement('a');
        prevA.className = 'page-link';
        prevA.href = '#';
        prevA.innerHTML = '&laquo; Trước';
        prevA.addEventListener('click', function (event) {
            event.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                paginate(data, currentPage, limit, containerId);
                updatePagination(data, totalItems, limit, containerId, currentPage);
            }
        });
        prevBtn.appendChild(prevA);
        paginationContainer.appendChild(prevBtn);

        // Nút "1" và "..."
        if (startPage > 1) {
            var firstPage = document.createElement('li');
            firstPage.className = 'page-item';
            var firstA = document.createElement('a');
            firstA.className = 'page-link';
            firstA.href = '#';
            firstA.textContent = '1';
            firstA.addEventListener('click', function (event) {
                event.preventDefault();
                currentPage = 1;
                paginate(data, currentPage, limit, containerId);
                updatePagination(data, totalItems, limit, containerId, currentPage);
            });
            firstPage.appendChild(firstA);
            paginationContainer.appendChild(firstPage);

            if (startPage > 2) {
                var dots = document.createElement('li');
                dots.className = 'page-item disabled';
                dots.innerHTML = '<span class="page-link">...</span>';
                paginationContainer.appendChild(dots);
            }
        }

        // Các nút trang
        for (var i = startPage; i <= endPage; i++) {
            var li = document.createElement('li');
            li.className = i === currentPage ? 'page-item active' : 'page-item';
            var a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = i;
            a.addEventListener('click', function (event) {
                event.preventDefault();
                currentPage = parseInt(this.textContent);
                paginate(data, currentPage, limit, containerId);
                updatePagination(data, totalItems, limit, containerId, currentPage);
            });
            li.appendChild(a);
            paginationContainer.appendChild(li);
        }

        // Nút "..." và "Cuối"
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                var dots = document.createElement('li');
                dots.className = 'page-item disabled';
                dots.innerHTML = '<span class="page-link">...</span>';
                paginationContainer.appendChild(dots);
            }

            var lastPage = document.createElement('li');
            lastPage.className = 'page-item';
            var lastA = document.createElement('a');
            lastA.className = 'page-link';
            lastA.href = '#';
            lastA.textContent = totalPages;
            lastA.addEventListener('click', function (event) {
                event.preventDefault();
                currentPage = totalPages;
                paginate(data, currentPage, limit, containerId);
                updatePagination(data, totalItems, limit, containerId, currentPage);
            });
            lastPage.appendChild(lastA);
            paginationContainer.appendChild(lastPage);
        }

        // Nút "Sau"
        var nextBtn = document.createElement('li');
        nextBtn.className = currentPage === totalPages ? 'page-item disabled' : 'page-item';
        var nextA = document.createElement('a');
        nextA.className = 'page-link';
        nextA.href = '#';
        nextA.innerHTML = 'Sau &raquo;';
        nextA.addEventListener('click', function (event) {
            event.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                paginate(data, currentPage, limit, containerId);
                updatePagination(data, totalItems, limit, containerId, currentPage);
            }
        });
        nextBtn.appendChild(nextA);
        paginationContainer.appendChild(nextBtn);
    }

    // Khởi tạo phân trang cho content1
    var currentPageContent1 = 1;
    paginate(myPostsData, currentPageContent1, 5, '#content1');
    updatePagination(myPostsData, myPostsData.length, 5, '#content1', currentPageContent1);

    // Khởi tạo phân trang cho content2
    var currentPageContent2 = 1;
    paginate(myQuestionsData, currentPageContent2, 5, '#content2');
    updatePagination(myQuestionsData, myQuestionsData.length, 5, '#content2', currentPageContent2);

    // Khởi tạo phân trang cho content3
    var currentPageContent3 = 1;
    paginate(myDocumentsData, currentPageContent3, 5, '#content3');
    updatePagination(myDocumentsData, myDocumentsData.length, 5, '#content3', currentPageContent3);
</script>

<!-- action script -->
<script>
    function toggleActions(event) {
        event.preventDefault(); // Ngăn chặn sự kiện click lan ra ngoài
        event.stopPropagation(); // Ngăn chặn sự kiện click lan ra ngoài
        const actionMenu = event.currentTarget.nextElementSibling;

        // Ẩn tất cả các menu khác
        document.querySelectorAll('.action-menu').forEach(menu => {
            if (menu !== actionMenu) {
                menu.style.display = 'none'; // Ẩn các menu khác
            }
        });

        // Chuyển đổi hiển thị menu hiện tại
        if (actionMenu.style.display === 'block') {
            actionMenu.style.display = 'none';
        } else {
            actionMenu.style.display = 'block';
        }
    }

    // Ẩn menu khi nhấp ra ngoài
    document.addEventListener('click', () => {
        document.querySelectorAll('.action-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    });

    function editPost(postId) {
        window.location.href = "<?php echo BASE_URL ?>/posts/edit/" + postId;
    }

    function deletePost(postId) {
        confirmDelete(event, "<?php echo BASE_URL ?>/posts/delete/" + postId);
    }
</script>

<!-- Handel Follower -->
<script>
    $(document).ready(function () {
        var userId =
            "<?php echo isset($_SESSION['UserID']) ? $_SESSION['UserID'] : "none"; ?>";
        var authId =
            "<?php echo isset($user_details["id"]) ? $user_details["id"] : "none"; ?>";

        checkFollowStatus(authId, userId);

        $('#followButton').on('click', function () {
            const isFollowed = $(this).hasClass('followed');
            const action = isFollowed ? 'unFollow' : 'follow';

            $(this).html('<i class="fa fa-plus i-plus"></i> ' + (isFollowed ? 'Theo dõi' : 'Đang theo dõi'))
                .toggleClass(
                    'followed');

            // Gửi yêu cầu Ajax đến API để xử lý follow/unfollow
            $.ajax({
                url: '<?php echo BASE_URL ?>/api/handelFollow',
                type: 'POST',
                data: {
                    auth_id: authId,
                    user_id: userId,
                    action: action
                },
                success: function (data) {
                    console.log("Theo dõi thành công");
                },
                error: function (xhr, status, error) {
                    console.log("Error: " + error);
                    // Nếu có lỗi, khôi phục trạng thái UI
                    $(this).html('<i class="fa fa-plus i-plus"></i> ' + (isFollowed ?
                        'Bỏ theo dõi' :
                        'Theo dõi')).toggleClass('followed');
                }
            });
        });
    });

    async function checkFollowStatus(authId, userId) {
        try {
            let response = await fetch('<?php echo BASE_URL ?>/api/CheckFollowUser/' + authId + '/' + userId);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            let data = await response.json();
            console.log("Call api: ", data);

            if (data.follow_status === 'followed') {
                $('#followButton').html('<i class="fa fa-plus i-plus"></i> Đang theo dõi').addClass('followed');
            } else {
                $('#followButton').html('<i class="fa fa-plus i-plus"></i> Theo dõi').removeClass('followed');
            }
        } catch (error) {
            console.log("Error: ", error);
        }
    }
</script>