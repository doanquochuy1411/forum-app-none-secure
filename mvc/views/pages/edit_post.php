<section class="header-descriptin329 pd-t-120">
    <div class="container">
        <h3>Chỉnh sửa <?php echo $title ?></h3>
        <ol class="breadcrumb breadcrumb840 z-index-2">
            <li><a href="<?php echo BASE_URL ?>">Trang chủ</a></li>
            <li><a
                    href="<?php echo BASE_URL . "/home/allPosts/" . $post_to_edit[0]["type"] ?>"><?php echo ucfirst($title) ?></a>
            </li>
            <li class="active"><?php echo $post_to_edit[0]["title"] ?></li>
        </ol>
    </div>
</section>
<section class="main-content920">
    <div class="container mg-top-70">
        <div class="row">
            <div class="col-md-9">
                <div class="ask-question-input-part032">
                    <h4>
                        <a href="<?php echo BASE_URL ?>/home/posts/<?php echo $post_to_edit[0]["id"] ?>"
                            style="text-decoration: none">
                            <b><?php echo ucfirst($title) ?>: <?php echo $post_to_edit[0]["title"] ?></b>
                        </a>
                    </h4>
                    <hr>
                    <form id="editForm"
                        action="<?php echo BASE_URL ?>/posts/HandleEdit/<?php echo $post_to_edit[0]["id"] ?>"
                        method="post">
                        <div class="username-part940">
                            <span class="form-description43">Loại bài đăng*</span>
                            <select id="contentType" name="contentType" class="username029">
                                <option value="post" <?php echo $post_to_edit[0]["type"] == 'post' ? 'selected' : ''; ?>>
                                    Bài
                                    viết</option>
                                <option value="question" <?php echo $post_to_edit[0]["type"] == 'question' ? 'selected' : ''; ?>>
                                    Đặt câu hỏi</option>
                                <option value="document" <?php echo $post_to_edit[0]["type"] == 'document' ? 'selected' : ''; ?>>
                                    Tài liệu</option>
                            </select>
                        </div>

                        <div class="email-part320">
                            <span class="form-description442">Danh mục* </span>
                            <select id="contentCategory" name="contentCategory" class="email30">
                                <?php
                                foreach ($categories as $category) {
                                    if ($post_to_edit[0]["category_id"] == decryptData($category["id"])) {
                                        $categoryIDSelected = $category["id"];
                                    }
                                    echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                                }
                                ?>
                            </select>
                            <small id="contentCategory_err"></small>
                        </div>
                        <div class="question-title39">
                            <span class="form-description43305">Tiêu đề* </span>
                            <input type="text" id="title" name="title" value="<?php echo $post_to_edit[0]["title"] ?>"
                                class="username029" placeholder="Nhập tiêu đề">
                            <br>
                            <small id="title_err"></small>
                        </div>

                        <div class="categori49">
                            <span class="form-description43305" style="margin-bottom: 5px">Tags </span>
                            <div id="tagsInputContainer" class="browsers" style="display: contents">
                                <?php if (count($tags_of_post) > 0) {
                                    foreach ($tags_of_post as $t) {
                                        // print_r($t["name"]);
                                        echo '<span class="badge badge-primary mx-1 tags">' . $t["name"] . ' <button type="button" class="close" aria-label="Close" onclick="removeTag(\'' . $t["name"] . '\')">
                                        <span aria-hidden="true">×</span>
                                      </button></span>';
                                    }
                                } ?>
                                <input type="text" id="tagsInput" placeholder="Nhập các tags, Enter để thêm"
                                    style="border: none; outline: none; width: 100%; margin-top: 5px; margin-left: 20%;">
                            </div>
                            <div id="hiddenTagsContainer"></div>
                        </div>
                        <div id="editorContainer">
                            <span class="form-description43305" style="margin-bottom: 5px">Nội dung </span>
                            <div id="editor"></div>
                            <input type="hidden" id="editorContent" name="content" />
                            <small id="editorContent_err"></small>
                        </div>
                        <input type="hidden" name="token"
                            value="<?php echo isset($_SESSION['_token']) ? $_SESSION['_token'] : "" ?>" />
                        <div class="publish-button2389">
                            <button type="submit" name="btnEditPost" class="publis1291">Cập nhật</button>
                        </div>
                    </form>

                </div>


            </div>
            <!--                end of col-md-9 -->
            <!--           strart col-md-3 (side bar)-->
            <?php require_once 'sidebar.php' ?>

        </div>
    </div>
</section>
<!-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<!-- <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.2.9/purify.min.js"></script>
<script>
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


        quill.root.innerHTML = `<?php echo isset($post_to_edit[0]["content"]) ? $post_to_edit[0]["content"] : "" ?>`;
        var postFormElement = document.getElementById('editForm');
        if (postFormElement) {
            postFormElement.addEventListener('submit', function (event) {
                document.getElementById('editorContent').value = quill.root.innerHTML;
                // console.log("second")
                var editorContent = quill.root.innerHTML.trim();
                const ctType = document.getElementById('contentType').value;
                const ctCategory = document.getElementById('contentCategory').value;

                if (ctType === 'post' && isCategoryPost(ctCategory)) {
                    if (editorContent === '' || editorContent === '<p><br></p>' || editorContent.length < 500) {
                        event.preventDefault();
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
                    event.preventDefault();
                    if (tags.length < 10) {
                        const tagText = tagsInput.value.trim();
                        if (tagText !== '' && !tags.includes(tagText)) {
                            addTag(tagText);
                            tags.push(tagText);
                            tagsInput.value = '';
                            updateHiddenTags();
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

            window.removeTag = function (tagText) {
                tags = tags.filter(tag => tag !== tagText);
                const tagElements = tagsInputContainer.getElementsByClassName('badge');
                for (let i = 0; i < tagElements.length; i++) {
                    if (tagElements[i].textContent.includes(tagText)) {
                        tagsInputContainer.removeChild(tagElements[i]);
                        break;
                    }
                }
                updateHiddenTags();
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
            initializeTags();
            updateHiddenTags();
        });
    } else {
        console.warn("Element #editor not found in the DOM.");
    }
</script>

<!-- Handel category -->
<script>
    const categories = <?php echo json_encode($categories); ?>;
    // console.log(categories)
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

                // Chọn danh mục làm mặc định
                let categoryIDOfPost = "<?php echo $categoryIDSelected ?? "" ?>";
                if (category.id === categoryIDOfPost) {
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