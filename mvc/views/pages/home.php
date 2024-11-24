<style>
    /* CSS cho hiệu ứng fade in/out */
    .container-content {
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    .container-content.fade-out {
        opacity: 0;
    }

    label[for="tab5"],
    #tab5 {
        color: #000;
        font: 14px Arial, sans-serif;
        margin: 0px 0px -1px;
        padding: 13px 15px;
        font-weight: bold;
        background-color: #F3F3F3;
        /* Đặt màu nền */
        border: none;
        outline: none;
        /* text-decoration: none; */
    }
</style>
<!-- ======content section/body=====-->
<section class="main-content920 pd-t-90">
    <div>
        <img class="img-side" src="<?php echo BASE_URL ?>/public/src/uploads/slide.jpg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div id="main">
                    <input id="tab1" type="radio" name="tabs" checked value="post">
                    <label for="tab1">Bài viết</label>

                    <input id="tab2" type="radio" name="tabs" value="question">
                    <label for="tab2">Câu hỏi</label>

                    <input id="tab3" type="radio" name="tabs" value="document">
                    <label for="tab3">Tài liệu</label>

                    <input id="tab4" type="radio" name="tabs" value="none">
                    <label for="tab4">Tạo mới</label>

                    <?php
                    if (isset($_SESSION["UserID"])) {
                        echo '
                         <a class="my-post-btn" href="' . BASE_URL . '/posts/user/' . $_SESSION["UserID"] . '" name="tabs" id="tab5">
                    Bài đăng của tôi
                    </a>
                    ';
                    }
                    ?>

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

                    <!-- Create post -->
                    <section id="content4">
                        <!--Recent Question Content Section -->
                        <form id="postForm" action="<?php echo BASE_URL ?>/home/createPost" method="post">
                            <div class=" form-group row">
                                <div class="col-md-6">
                                    <label for="contentType">Loại bài đăng</label>
                                    <select id="contentType" name="contentType" class="form-control">
                                        <option value="post" selected>Bài viết</option>
                                        <option value="question">Đặt câu hỏi</option>
                                        <option value="document">Tài liệu</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="contentCategory">Danh mục</label>
                                    <select id="contentCategory" name="contentCategory" class="form-control">
                                        <?php
                                        for ($i = 0; $i < count($categories); $i++) {
                                            if ($i == 0) {
                                                echo '<option value="' . $categories[$i]['id'] . '" selected>' . $categories[$i]['name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $categories[$i]['id'] . '">' . $categories[$i]['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <small id="contentCategory_err"></small>
                                </div>
                            </div>

                            <!-- Input for title -->
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="Nhập tiêu đề">
                                <small id="title_err"></small>
                            </div>

                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <div id="tagsInputContainer" class="form-control" style="display: inline-table">
                                    <input type="text" id="tagsInput" placeholder="Nhập các tags, Enter để thêm"
                                        style="border: none; outline: none; width: 100%;">
                                </div>
                            </div>
                            <div id="hiddenTagsContainer"></div>

                            <div id="editorContainer">
                                <label for="editor">Nội dung</label>
                                <div id="editor"></div>
                                <input type="hidden" id="editorContent" name="content" />
                                <small id="editorContent_err"></small>
                            </div>

                            <input type="hidden" name="token"
                                value="<?php echo isset($_SESSION['_token']) ? $_SESSION['_token'] : "" ?>" />
                            <div class="text-right">
                                <button type="submit" name="btnCreatePost" class="btn btn-primary"
                                    style="margin-top: 5px;">Đăng</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
            <!--end of col-md-9 -->
            <!--strart col-md-3 (side bar)-->
            <?php require_once 'sidebar.php' ?>
        </div>
    </div>
</section>
<script>
    var postsData = <?php echo json_encode($posts); ?>;
    var questionsData = <?php echo json_encode($questions); ?>;
    var myPostsData = <?php echo json_encode($my_posts); ?>;
    var documentsData = <?php echo json_encode($documents); ?>;

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
    paginate(postsData, currentPageContent1, 5, '#content1');
    updatePagination(postsData, postsData.length, 5, '#content1', currentPageContent1);

    // Khởi tạo phân trang cho content2
    var currentPageContent2 = 1;
    paginate(questionsData, currentPageContent2, 5, '#content2');
    updatePagination(questionsData, questionsData.length, 5, '#content2', currentPageContent2);

    // Khởi tạo phân trang cho content3
    var currentPageContent3 = 1;
    paginate(documentsData, currentPageContent3, 5, '#content3');
    updatePagination(documentsData, documentsData.length, 5, '#content3', currentPageContent3);

    // Khởi tạo phân trang cho content5
    if (Array.isArray(myPostsData) && myPostsData.length > 0) {
        var currentPageContent5 = 1;
        paginate(myPostsData, currentPageContent5, 5, '#content5');
        updatePagination(myPostsData, myPostsData.length, 5, '#content5', currentPageContent5);
    }
</script>

<!-- Handel category -->
<script>
    const categories = <?php echo json_encode($categories); ?>;
    document.addEventListener('DOMContentLoaded', function () {
        const contentType = document.getElementById('contentType');
        const contentCategory = document.getElementById('contentCategory');

        function updateCategoryOptions(selectedType) {
            contentCategory.innerHTML = '';

            let filteredCategories;
            if (selectedType === 'question') {
                filteredCategories = categories.filter(category => category.category_type === 'post');
            } else {
                filteredCategories = categories.filter(category => category.category_type === selectedType);
            }

            filteredCategories.forEach((category, index) => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;

                // Chọn danh mục đầu tiên làm mặc định
                if (index === 0) {
                    option.selected = true;
                }

                contentCategory.appendChild(option);
            });
        }

        contentType.addEventListener('change', function () {
            const selectedType = contentType.value;
            updateCategoryOptions(selectedType);
        });

        updateCategoryOptions(contentType.value);
    });
</script>

<!-- Thêm vào phần <head> -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.2.9/purify.min.js"></script>
<script>
    // console.log("hihihi")
    if (document.querySelector('#editor')) {
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, false]
                    }], // Tùy chọn header (h1, h2, h3)
                    [{
                        'color': []
                    }, {
                        'background': []
                    }], // Màu chữ và màu nền
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }], // Chỉ số trên và dưới (subscript và superscript)
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }], // Danh sách có thứ tự và không thứ tự
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }], // Thụt lề
                    [{
                        'align': []
                    }], // Căn chỉnh văn bản
                    ['bold', 'italic', 'underline', 'strike'], // Định dạng: đậm, nghiêng, gạch chân, gạch ngang
                    ['blockquote', 'code-block'], // Trích dẫn và khối mã
                    ['link', 'image', 'video'], // Chèn liên kết, hình ảnh, video
                    ['clean'] // Xóa định dạng
                ]
            }
        });


        var postFormElement = document.getElementById('postForm');
        if (postFormElement) {
            postFormElement.addEventListener('submit', function (event) {
                // document.getElementById('editorContent').value = DOMPurify.sanitize(quill.root.innerHTML);
                // var editorContent = DOMPurify.sanitize(quill.root.innerHTML).trim();
                document.getElementById('editorContent').value = quill.root.innerHTML;
                var editorContent = quill.root.innerHTML.trim();
                const ctType = document.getElementById('contentType').value;
                const ctCategory = document.getElementById('contentCategory').value;

                if (ctType === 'post' && isCategoryPost(ctCategory)) {
                    if (editorContent === '' || editorContent === '<p><br></p>' || editorContent.length < 500) {
                        event.preventDefault(); // Ngăn chặn việc gửi form
                        document.getElementById('editorContent_err').textContent =
                            'Nội dung phải có ít nhất 500 ký tự.';
                        document.getElementById('editorContent_err').style.color = 'red'
                    } else {
                        document.getElementById('editorContent_err').textContent = '';
                    }
                } else {
                    if (editorContent === '' || editorContent === '<p><br></p>' || editorContent.length < 10) {
                        event.preventDefault(); // Ngăn chặn việc gửi form
                        document.getElementById('editorContent_err').textContent =
                            'Nội dung phải có ít nhất 10 ký tự.';
                        document.getElementById('editorContent_err').style.color = 'red'
                    } else {
                        document.getElementById('editorContent_err').textContent = '';
                    }
                }
            });
        }

        function isCategoryPost(categoryId) {
            return categories.some(category => category.id === categoryId && category.category_type === 'post');
        }

        // <!-- tags -->
        document.addEventListener('DOMContentLoaded', function () {
            const tagsInput = document.getElementById('tagsInput');
            const tagsInputContainer = document.getElementById('tagsInputContainer');
            const hiddenTagsContainer = document.getElementById('hiddenTagsContainer');
            let tags = [];

            function initializeTags() {
                const existingTags = document.querySelectorAll('.tags');
                for (let i = 0; i < existingTags.length; i++) {
                    let tagText = existingTags[i].textContent.trim();
                    tagText = tagText.replace('×', '').trim();
                    if (tagText !== "") {
                        tags.push(tagText);
                    }
                }
            }

            tagsInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Ngăn chặn hành vi Enter mặc định
                    if (tags.length < 10) {
                        const tagText = tagsInput.value.trim();
                        if (tagText !== '' && !tags.includes(tagText)) {
                            addTag(tagText);
                            tags.push(tagText);
                            tagsInput.value = '';
                            updateHiddenTags(); // Cập nhật các input ẩn
                        }
                    }
                }
            });

            function addTag(tagText) {
                const tagElement = document.createElement('span');
                tagElement.className = 'badge badge-primary mx-1 tags';
                tagElement.innerHTML = `${tagText} <button type="button" class="close" aria-label="Close" onclick="removeTag('${tagText}')">
                                    <span aria-hidden="true">&times;</span>
                                  </button>`;
                tagsInputContainer.insertBefore(tagElement, tagsInput);
            }

            function updateHiddenTags() {
                hiddenTagsContainer.innerHTML = '';

                tags.forEach(tag => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'tags[]';
                    hiddenInput.value = tag;
                    hiddenTagsContainer.appendChild(hiddenInput);
                });
            }

            window.removeTag = function (tagText) {
                tags = tags.filter(tag => tag !== tagText);
                const tagElements = tagsInputContainer.getElementsByClassName('badge');
                for (let i = 0; i < tagElements.length; i++) {
                    if (tagElements[i].textContent.includes(tagText)) {
                        tagsInputContainer.removeChild(tagElements[i]);
                        break;
                    }
                }
                updateHiddenTags(); // Cập nhật các input ẩn sau khi xóa tag
            }


            initializeTags();
            updateHiddenTags();
        });
    }
</script>