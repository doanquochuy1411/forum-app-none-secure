<style>
    /* CSS cho hiệu ứng fade in/out */
    .container-content {
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    .container-content.fade-out {
        opacity: 0;
    }
</style>
<!--    breadcumb of category -->
<section class="header-descriptin329 pd-t-120">
    <div class="container">
        <h3> Tất cả
        </h3>
        <ol class="breadcrumb breadcrumb840 z-index-2">
            <li><a href="<?php echo BASE_URL ?>">Trang chủ</a></li>
            <li><a href="<?php echo BASE_URL ?>/home/allPosts/post">Tìm kiếm <?php echo $label ?? "" ?></a></li>
            <li class="active"><?php echo $search ?? "" ?></li>
        </ol>
    </div>
</section>
<!--    body content-->
<section class="main-content920">
    <div class="container mg-top-70">
        <div class="row">
            <div class="col-md-9">
                <section id="main-content" class="category2781">
                    <?php
                    if (count($posts) > 0) {
                        echo '<div class="container-content">

                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous" id="prevBtn">
                                        <span aria-hidden="true">&laquo; Trước</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" aria-label="Next" id="nextBtn">
                                        <span aria-hidden="true">Sau &raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>';
                    } else {
                        echo '<div class="question-type2033">
                        <div class="row">
                            <p style="margin: 10px;"> <b>Chưa có ' . $title . '</b></p>
                        </div>
                    </div>';
                    }
                    ?>
                </section>
            </div>
            <!-- end of col-md-9 -->
            <!--strart col-md-3 (side bar)-->

            <?php require_once 'sidebar.php' ?>

        </div>
    </div>
</section>
<script>
    var postsData = <?php echo json_encode($posts); ?>;

    function paginate(data, page, limit, containerId) {
        var start = (page - 1) * limit;
        var end = start + limit;
        var paginatedData = data.slice(start, end);

        var container = document.querySelector(containerId + ' .container-content');
        container.classList.add('fade-out');

        setTimeout(function () {
            container.innerHTML = '';

            paginatedData.forEach(function (post) {
                // console.log(post)
                var content = stripImages(post.content);
                var html = '<div class="question-type2033">';
                html += '<div class="row">';
                html += '<div class="col-md-1">';
                html += '<div class="left-user12923 left-user12923-repeat">';
                html += '<a href="<?php echo BASE_URL ?>/home/info/' + post.account_name +
                    '"><img src="<?php echo BASE_URL ?>/public/src/uploads/' + post.avatar +
                    '" alt="image"> </a>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-11">';
                html += '<div class="right-description893">';
                html += '<div id="que-hedder2983">';
                html += '<h3><a href="<?php echo BASE_URL ?>/home/posts/' + post.id +
                    '" target="_blank">' +
                    post.title + '</a></h3>';
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
    paginate(postsData, currentPageContent1, 5, '#main-content');
    updatePagination(postsData, postsData.length, 5, '#main-content', currentPageContent1);
</script>