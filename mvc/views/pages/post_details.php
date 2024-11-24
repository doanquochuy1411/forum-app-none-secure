<style>
    .like-button {
        background-color: transparent;
        border: none;
        color: #007bff;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        transition: color 0.3s ease;
    }

    .like-button.liked {
        color: #ff4500;
    }

    .like-button i {
        margin-right: 5px;
    }

    #like-count {
        margin-left: 10px;
        font-size: 16px;
        color: #333;
    }

    #editorComment {
        height: 200px;
        width: 100%;
        border: solid 1px #ccc;
    }



    .quill-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0px 15px 15px 15px;
        box-sizing: border-box;
        border-radius: 5px;
        overflow-wrap: break-word;
    }

    .quill-container .ql-editor {
        font-family: Arial, sans-serif;
        font-size: 16px;
        color: #333;
        overflow: hidden;
    }

    .quill-container p:has(img),
    .quill-container p:has(video) {
        display: flex;
        justify-content: center;
    }

    .quill-container img,
    .quill-container video {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 10px 0;
    }

    .hidden-answer {
        display: none;
    }

    .show-answer {
        display: inline-block;
    }

    .footer-part {
        margin-top: 30px;
    }

    /* Reply */
    .comment-content-reply {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .comment-content-reply input[type="text"] {
        flex-grow: 1;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 12px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    .comment-content-reply input[type="text"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }

    .comment-content-reply button {
        padding: 6px 12px;
        border: none;
        background-color: #FF7361;
        color: #fff;
        font-size: 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .comment-content-reply button:hover {
        background-color: #03658c;
    }

    /* Scroll comment */
    /* .highlight {
        background-color: #CCC !important;
        transition: background-color 0.5s ease;
    } */
    @keyframes highlight {
        0% {
            background-color: transparent;
        }

        50% {
            background-color: #CCC;
        }

        100% {
            background-color: transparent;
        }
    }

    .highlight {
        animation: highlight 3s ease;
    }
</style>
<!-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<section class="header-descriptin329 pd-t-120">
    <div class="container">
        <h3>Chi tiết <?php echo $title ?></h3>
        <ol class="breadcrumb breadcrumb840">
            <li><a href="<?php echo BASE_URL ?>">Trang chủ</a></li>
            <li><a
                    href="<?php echo BASE_URL . "/home/allPosts/" . $posts[0]["type"] ?>"><?php echo ucfirst($title) ?></a>
            </li>
            <li class="active"><?php echo $posts[0]["title"] ?></li>
        </ol>
    </div>
</section>
<!-- <button onclick="scrollComment()">Click here</button> -->
<section class="main-content920">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="post-details">
                    <div class="details-header923" style="padding: 15px 15px 0px 15px">
                        <div class="row">
                            <div class="col-md-8 post">
                                <div class="post-title-left129">
                                    <i>
                                        Được tạo bởi
                                        <a href="<?php echo BASE_URL ?>/home/info/<?php echo encryptData($posts[0]["account_name"]) ?>"
                                            style="text-decoration: none;">
                                            <img style="width: 22px; border-radius:50%;"
                                                src="<?php echo BASE_URL ?>/public/src/uploads/<?php echo $posts[0]["avatar"] ?>"
                                                alt="">
                                            <span><?php echo $posts[0]["user_name"] ?></span>
                                        </a>
                                        <!-- Nút theo dõi -->
                                        <button id="followButton" class="btn btn-sm btn-follow" <?php
                                        if (!isset($_SESSION["UserID"]) || decryptData($posts[0]["user_id"]) == decryptData($_SESSION["UserID"])) {
                                            echo "disabled";
                                        }
                                        ?>>
                                            <i class="fa fa-plus i-plus"></i> ...
                                        </button>
                                    </i>
                                    <h3><?php echo $posts[0]["title"] ?></h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="post-que-rep-rihght320">
                                    <!-- <a href="#"><i class="fa fa-question-circle"
                                            aria-hidden="true"></i> Câu hỏi</a>  -->
                                    <a href="#" id="openReportModal" class="r-clor10"><i class="fa fa-bug"
                                            aria-hidden="true"></i> Báo cáo</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post-details-info1982">
                        <div class="quill-container">
                            <!-- {{ post_content }} -->
                            <?php echo $posts[0]["content"] ?>
                        </div>
                        <hr>
                        <div class="post-footer29032">
                            <div class="l-side2023">
                                <i class="fa fa-clock-o clock2" aria-hidden="true">
                                    <?php echo timeAgo($posts[0]["created_at"]) ?></i> <a href="#"><i
                                        class="fa fa-commenting commenting2" aria-hidden="true">
                                        <?php echo count($comments) ?> trả lời</i></a> <i class="fa fa-user user2"
                                    aria-hidden="true"> <?php echo $posts[0]["views"] ?> lượt xem</i>
                            </div>
                            <div class="r-side-like" style="margin-top: 12px">
                                <button id="like-btn" class="like-button">
                                    <i class="fa fa-thumbs-up"></i> Thích
                                </button>
                                <span id="like-count"><?php echo $posts[0]["like_count"] ?></span> lượt thích
                            </div>
                        </div>
                    </div>
                </div>
                <div class="share-tags-page-content12092">
                    <div class="l-share2093">
                        <i class="fa fa-share" aria-hidden="true"> Chia sẻ: </i>
                        <a style="margin: 0 2px"
                            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo BASE_URL ?>/home/posts/<?php echo $posts[0]["id"] ?>"
                            target="_blank">
                            <i class="fa fa-facebook" aria-hidden="true"> </i>
                        </a>
                        <a style="margin: 0 2px"
                            href="https://t.me/share/url?url=<?php echo BASE_URL ?>/home/posts/<?php echo $posts[0]["id"] ?>"
                            target="_blank">
                            <i class="fa fa-instagram" aria-hidden="true"> </i>
                        </a>
                        <a style="margin: 0 2px"
                            href="https://t.me/share/url?url=<?php echo BASE_URL ?>/home/posts/<?php echo $posts[0]["id"] ?>"
                            target="_blank">
                            <i class="fa fa-telegram" aria-hidden="true"> </i>
                        </a>
                    </div>

                    <div class="R-tags309"> <i class="fa fa-tags" aria-hidden="true">
                            <?php if (count($tags_of_post) > 0) {
                                $tagNames = [];

                                foreach ($tags_of_post as $tag) {
                                    $tagNames[] = $tag['name'];
                                }

                                // Nối các phần tử của mảng $tagNames thành một chuỗi và in ra
                                echo implode(', ', $tagNames);
                            }
                            ?>
                        </i>
                    </div>
                </div>
                <div class="comment-list12993">
                    <div class="container">
                        <div class="row">
                            <div class="comments-container">
                                <h3><?php echo count($comments) ?> Bình luận</h3>
                                <ul id="comments-list" class="comments-list">
                                    <?php
                                    if (count($comments) > 0) {
                                        // Tạo mảng để lưu trữ các comment theo cấu trúc cây
                                        $comments_tree = array();

                                        // Tạo mảng để lưu trữ các comment theo id để dễ dàng tra cứu
                                        $comments_by_id = array();

                                        // Phân loại các comment vào cấu trúc cây
                                        foreach ($comments as $comment) {
                                            // Đặt comment vào mảng theo id để dễ dàng tra cứu
                                            $comments_by_id[$comment['id']] = $comment;

                                            // Nếu comment không có parent_comment_id, đây là comment cha
                                            if ($comment['parent_comment_id'] === null) {
                                                $comments_tree[$comment['id']] = array(
                                                    'comment' => $comment,
                                                    'replies' => array() // Mảng để lưu các comment con
                                                );
                                            } else {
                                                // Nếu comment có parent_comment_id, thêm vào mảng replies của comment cha
                                                if (isset($comments_by_id[$comment['parent_comment_id']])) {
                                                    $parent_id = $comment['parent_comment_id'];
                                                    if (!isset($comments_tree[$parent_id])) {
                                                        $comments_tree[$parent_id] = array(
                                                            'comment' => $comments_by_id[$parent_id],
                                                            'replies' => array()
                                                        );
                                                    }
                                                    $comments_tree[$parent_id]['replies'][] = $comment;
                                                }
                                            }
                                        }

                                        // Hàm đệ quy để in comment và các comment con
                                        function print_comments($comments_tree)
                                        {
                                            $userID = isset($_SESSION["UserID"]) ? decryptData($_SESSION["UserID"]) : "";
                                            $avatar = isset($_SESSION["Avatar"]) ? $_SESSION["Avatar"] : "";
                                            $userName = isset($_SESSION["UserName"]) ? $_SESSION["UserName"] : "";
                                            // $userID = decryptData($userID);
                                            foreach ($comments_tree as $parent_id => $data) {
                                                echo '<li>';
                                                $comment = $data['comment'];
                                                // Nếu là chủ comment thì có thể sửa hoặc xóa
                                                if (decryptData($comment['user_id']) != $userID) {
                                                    echo '<div class="comment-main-level" id="comment_' . $comment["id"] . '">
                                                        <div class="comment-avatar"><img src="' . BASE_URL . '/public/src/uploads/' . $comment['avatar'] . '" alt=""></div>
                                                        <div class="comment-box" style="width: 88%">   
                                                            <div class="comment-head">
                                                                <h6 class="comment-name"><a href="' . BASE_URL . '/users/' . $comment['user_id'] . '">' . $comment['comment_user_name'] . '</a></h6>
                                                                <span><i class="fa fa-clock-o" style="display: block;"> ' . timeAgo($comment['created_at']) . '</i></span>
                                                                <i class="fa fa-reply" style="display: block" onclick="toggleReply(\'replyList_' . $comment['id'] . '\')"></i>
                                                            </div>
                                                            <div class="comment-content" id="comment_index_' . $comment['id'] . '"> ' . $comment['content'] . '
                                                        </div>
                                                         </div>
                                                    </div>';

                                                    echo '<ul class="comments-list reply-list" id="replyList_' . $comment['id'] . '"
                                    style="display: none;">
                                    <li>
                                        <div class="comment-avatar"><img
                                                src="' . BASE_URL . '/public/src/uploads/' . $avatar . '"
                                                alt=""></div>
                                        <div class="comment-box" style="width: 88%">
                                            <div class="comment-head">
                                                <h6 class="comment-name"><a href="">' . $userName . '</a></h6>
                                            </div>
                                            <div class="comment-content comment-content-reply">
                                                <input type="text" id="replyInput_' . $comment['id'] . '"
                                    placeholder="Nhập câu trả lời của bạn"></input>
                                    <button onclick="submitReply(\'' . $comment['id'] . '\')"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                        </li>
                        </ul>';
                                                } else {
                                                    // chủ comment
                                                    echo '<div class="comment-main-level">
                            <div class="comment-avatar"><img
                                    src="' . BASE_URL . '/public/src/uploads/' . $comment['avatar'] . '" alt="">
                            </div>
                            <div class="comment-box" style="width: 88%">
                                <div class="comment-head">
                                    <h6 class="comment-name"><a
                                            href="' . BASE_URL . '/users/' . $comment['user_id'] . '">' .
                                                        $comment['comment_user_name'] . '</a></h6>
                                    <span><i class="fa fa-clock-o" style="display: block;"> ' .
                                                        timeAgo($comment['created_at']) . '</i></span>
                                    <a href="javascript:void(0);' . $comment['id'] . '"><i class="fa fa-reply"
                                            style="display: block"
                                            onclick="toggleReply(\'replyList_' . $comment['id'] . '\')"></i></a>
                                    <a href="#"><i class="fa fa-trash" style="cursor: pointer; display: block;"
                                            onclick="confirmDelete(event, \'' . BASE_URL . '/posts/deleteComment/' . encryptData($comment['id']) . '\')"></i></a>
                                </div>
                                <div class="comment-content" id="comment_index_' . $comment['id'] . '"> ' . $comment['content'] . '
                                </div>
                            </div>
                        </div>';

                                                    echo '<ul class="comments-list reply-list" id="replyList_' . $comment['id'] . '"
                        style="display: none;">
                        <li>
                            <div class="comment-avatar"><img
                                    src="' . BASE_URL . '/public/src/uploads/' . $avatar . '"
                                    alt=""></div>
                            <div class="comment-box" style="width: 88%">
                                <div class="comment-head">
                                    <h6 class="comment-name"><a href="">' . $userName . '</a></h6>
                                </div>
                                <div class="comment-content comment-content-reply">
                                    <input type="text" id="replyInput_' . $comment['id'] . '"
                        placeholder="Nhập câu trả lời của bạn"></input>
                        <button onclick="submitReply(\'' . $comment['id'] . '\')">Gửi</button>
                </div>
            </div>
            </li>
            </ul>';
                                                }

                                                // In các comment con nếu có
                                                if (isset($data['replies']) && count($data['replies']) > 0) {
                                                    echo '<ul class="comments-list reply-list">';
                                                    foreach ($data['replies'] as $reply) {
                                                        if (decryptData($reply['user_id']) != $userID) {
                                                            echo '<li>
                                <div class="comment-avatar"><img
                                        src="' . BASE_URL . '/public/src/uploads/' . $reply['avatar'] . '" alt=""></div>
                                <div class="comment-box" style="width: 88%" id="replyList_' . $comment['id'] . '">
                                    <div class="comment-head">
                                        <h6 class="comment-name"><a
                                                href="' . BASE_URL . '/users/' . $reply['user_id'] . '">' .
                                                                $reply['comment_user_name'] . '</a></h6>
                                        <span><i class="fa fa-clock-o" style="display: block;"> ' .
                                                                timeAgo($reply['created_at']) . '</i></span>
                                        <i class="fa fa-reply" style="display: block" onclick="toggleReply(\'replyList_' . $comment['id'] . '\')"></i>
                                    </div>
                                    <div class="comment-content" id="comment_index_' . $reply['id'] . '"> ' . $reply['content'] . '
                                    </div>
                                </div>
                            </li>';
                                                        } else {
                                                            // Chủ comment con
                                                            echo '<li>
                                <div class="comment-avatar"><img
                                        src="' . BASE_URL . '/public/src/uploads/' . $reply['avatar'] . '" alt=""></div>
                                <div class="comment-box" style="width: 88%" id="replyList_' . $comment['id'] . '">
                                    <div class="comment-head">
                                        <h6 class="comment-name"><a
                                                href="' . BASE_URL . '/users/' . $reply['user_id'] . '">' .
                                                                $reply['comment_user_name'] . '</a></h6>
                                        <span><i class="fa fa-clock-o" style="display: block;"> ' .
                                                                timeAgo($reply['created_at']) . '</i></span>
                                        <a href="#"><i class="fa fa-trash" style="cursor: pointer; display: block;"
                                                onclick="confirmDelete(event,\'' . BASE_URL . '/posts/deleteComment/' . encryptData($reply['id']) . '\')"></i></a>
                                        <i class="fa fa-reply" style="display: block" onclick="toggleReply(\'replyList_' . $comment['id'] . '\')"></i>
                                    </div>
                                    <div class="comment-content" id="comment_index_' . $reply['id'] . '"> ' . $reply['content'] . '
                                    </div>
                                </div>
                            </li>';
                                                        }
                                                    }
                                                    echo '</ul>';
                                                }
                                                echo '</li>';
                                            }
                                        }

                                        print_comments($comments_tree);
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment289-box">
                    <hr>
                    <h3 style="margin-bottom: 15px;">Câu trả lời của bạn</h3>
                    <!-- <hr> -->
                    <div class="row">
                        <form id="postCommentForm" action="<?php echo BASE_URL ?>/posts/createComment" method="post">
                            <div class=" col-md-12">
                                <div id="editorContainer" class="post9320-box">
                                    <div id="editorComment"></div>
                                    <input type="hidden" id="editorCommentContent" name="content" />
                                    <input type="hidden" value="<?php echo $posts[0]["id"] ?>" name="post_id" />
                                    <input type="hidden" value="" name="parent_comment_id" />
                                </div>
                            </div>
                            <input type="hidden" name="token"
                                value="<?php echo isset($_SESSION['_token']) ? $_SESSION['_token'] : "" ?>" />
                            <div class="col-md-12">
                                <button type="submit" name="btnComment" class="pos393-submit">Bình luận</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="related3948-question-part">
                    <h3>Nội dung liên quan</h3>
                    <hr>
                    <?php
                    if (count($relate_posts) > 0) {
                        foreach ($relate_posts as $post) {
                            if (decryptData($post["id"]) != decryptData($posts[0]["id"])) {
                                echo '<p><a href="' . BASE_URL . '/home/posts/' . $post["id"] . '"><i class="fa fa-angle-double-right" aria-hidden="true"></i> ' . $post['title'] . '</a></p>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- Pop up -->
            <div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-label"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h3 style="text-align: center" class="modal-title" id="edit-user-modal-label"><b>Lý do báo
                                    cáo</b></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="report-post-form"
                                action="<?php echo BASE_URL ?>/reports/send/<?php echo $posts[0]["id"] ?>"
                                method="post">
                                <div class="form-group">
                                    <label for="report_reasons">Chọn lý do báo cáo:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="report_reasons[]"
                                            value="Spam" id="reason1">
                                        <label class="form-check-label" for="reason1">
                                            Spam
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="report_reasons[]"
                                            value="Ngôn từ thô tục" id="reason2">
                                        <label class="form-check-label" for="reason2">
                                            Ngôn từ thô tục
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="report_reasons[]"
                                            value="Nội dung không phù hợp" id="reason3">
                                        <label class="form-check-label" for="reason3">
                                            Nội dung không phù hợp
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="report_reasons[]"
                                            value="Quảng cáo không liên quan" id="reason4">
                                        <label class="form-check-label" for="reason4">
                                            Quảng cáo không liên quan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="report_reasons[]"
                                            value="Khác" id="reason5">
                                        <label class="form-check-label" for="reason5">
                                            Khác
                                        </label>
                                    </div>
                                    <small id="report_reasons_err"></small>
                                </div>

                                <div class="form-group">
                                    <label for="additional_info">Thông tin bổ sung (tùy chọn):</label>
                                    <textarea class="form-control" id="additional_info" name="additional_info"
                                        rows="3"></textarea>
                                    <small id="additional_info_err"></small>
                                </div>

                                <!-- Hidden field to store post or question ID -->
                                <input type="hidden" name="token" value="<?php echo $_SESSION['_token'] ?? "" ?>" />
                                <button type="submit" name="btnReport" class="btn btn-danger">báo cáo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--                end of col-md-9 -->
            <!--           strart col-md-3 (side bar)-->
            <aside class="col-md-12 sidebar97240">
                <div class="scrollable-sidebar">
                    <div class="categori-part329">
                        <h4>Danh mục</h4>
                        <ul>
                            <?php
                            if (count($categories) > 0) {
                                foreach ($categories as $category) {
                                    echo '<li><a href="' . BASE_URL . '/home/categories/' . $category['id'] . '/post">' . $category['name'] . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="recent-post3290">
                        <h4>Bài viết gần đây</h4>
                        <?php
                        $count = 0;
                        foreach ($recent_posts as $post) {
                            if ($count >= 8) {
                                break;
                            }
                            echo '<div class="post-details021"> <a href="' . BASE_URL . '/home/posts/' . $post['id'] . '">
                                <h5>' . $post['title'] . '</h5>
                            </a>
                            <small
                                style="color: red">', $post['created_at'], '</small>    
                        </div>
                        <hr>';
                            $count++;
                        }
                        ?>
                    </div>
                    <!--          start tags part-->
                    <div class="tags-part2398">
                        <h4>Tags</h4>
                        <ul>
                            <?php
                            if (count($tags)) {
                                $count = 0;
                                foreach ($tags as $tag) {
                                    if ($count >= 5) {
                                        break;
                                    }
                                    echo '<li><a href="' . BASE_URL . '/home/tags/' . $tag['name'] . '">' . $tag['name'] . '</a></li>';
                                    $count++;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <!--          End tags part-->

                </div>
            </aside>

        </div>
    </div>
</section>

<!-- Thêm vào phần <head> -->
<!-- <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.2.9/purify.min.js"></script>
<script>
    if (document.querySelector('#editorComment')) {
        var quill = new Quill('#editorComment', {
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
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }], // Danh sách có thứ tự và không thứ tự
                    [{
                        'align': []
                    }], // Căn chỉnh văn bản
                    ['bold', 'italic', 'underline',
                        'strike'
                    ], // Định dạng: đậm, nghiêng, gạch chân, gạch ngang
                    ['blockquote', 'code-block'], // Trích dẫn và khối mã
                    ['link', 'image', 'video'], // Chèn liên kết, hình ảnh, video
                    ['clean'] // Xóa định dạng
                ]
            }
        });

        var postCommentFormElement = document.getElementById('postCommentForm');
        if (postCommentFormElement) {
            postCommentFormElement.addEventListener('submit', function (event) {
                document.getElementById('editorCommentContent').value = quill.root.innerHTML;
                var editorContent = quill.root.innerHTML.trim();
                if (editorContent === '' || editorContent === '<p><br></p>') {
                    event.preventDefault(); // Ngăn chặn việc gửi form
                }
            });
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Lấy thông tin bài post và user (truyền từ server vào)
        var postId = "<?php echo $posts[0]['id']; ?>";
        var userId =
            "<?php echo isset($_SESSION['UserID']) ? $_SESSION['UserID'] : ""; ?>"; // Giả sử bạn lưu user ID trong session
        // Biến lưu số lượt like ban đầu (lấy từ server)
        var likeCount = parseInt($('#like-count').text());

        // Gọi API chỉ một lần khi trang tải
        $.ajax({
            url: '<?php echo BASE_URL ?>/api/CheckLikedPost/' + postId + '/' + userId,
            type: 'GET',
            success: function (data) {
                var response = JSON.parse(data);
                // console.log(response);
                // Cập nhật trạng thái và số lượt like
                if (response.like_status === 'liked') {
                    $('#like-btn').html('<i class="fa fa-thumbs-up"></i> Đã thích').addClass('liked');
                } else {
                    $('#like-btn').html('<i class="fa fa-thumbs-up"></i> Thích').removeClass('liked');
                }
                // Cập nhật số lượt like
                $('#like-count').text(response.like_count);
            },
            error: function (xhr, status, error) {
                console.log("Error: " + error);
            }
        });

        // Sự kiện khi người dùng bấm nút "Like"
        $('#like-btn').on('click', function () {
            if (userId === "") {
                window.location.href = "<?php echo BASE_URL ?>/login";
            }
            // Toggle trạng thái liked
            const isLiked = $(this).hasClass('liked');
            const action = isLiked ? 'unlike' : 'like';

            // Cập nhật UI ngay lập tức để cải thiện trải nghiệm người dùng
            $(this).html('<i class="fa fa-thumbs-up"></i> ' + (isLiked ? 'Thích' : 'Đã thích')).toggleClass(
                'liked');

            // Gửi yêu cầu Ajax đến API để xử lý like/unlike
            $.ajax({
                url: '<?php echo BASE_URL ?>/api/handelLikePost',
                type: 'POST',
                data: {
                    post_id: postId,
                    user_id: userId,
                    action: action
                },
                success: function (data) {
                    var response = JSON.parse(data);
                    // console.log(response);
                    // Cập nhật số lượt like
                    likeCount = response.like_count;
                    $('#like-count').text(likeCount);
                },
                error: function (xhr, status, error) {
                    console.log("Error: " + error);
                    // Nếu có lỗi, khôi phục trạng thái UI
                    $(this).html('<i class="fa fa-thumbs-up"></i> ' + (isLiked ? 'Đã thích' :
                        'Thích')).toggleClass('liked');
                }
            });
        });
    });
</script>
<script>
    function toggleReply(replyListId) {
        const $existUser = <?php echo isset($_SESSION["UserID"]) ? 1 : 0; ?>;
        if (!$existUser) {
            window.location.href = "<?php echo BASE_URL ?>";
            exit();
        }

        const replyList = document.getElementById(replyListId);
        const inputField = replyList.querySelector('input[type="text"]');

        if (replyList.style.display === 'none' || replyList.style.display === '') {
            replyList.style.display = 'block'; // Hiển thị phần tử
            inputField.focus();
        } else {
            replyList.style.display = 'none'; // Ẩn phần tử
        }
    }

    function submitReply(commentId) {
        const replyInput = $('#replyInput_' + commentId);
        const replyContent = replyInput.val();

        if ($.trim(replyContent) === '') {
            return;
        }

        const data = {
            token: '<?php echo isset($_SESSION["_token"]) ? $_SESSION["_token"] : ""; ?>',
            btnComment: true,
            content: replyContent,
            parent_comment_id: commentId,
            post_id: '<?php echo $posts[0]["id"] ?>'
        };

        $.ajax({
            url: '<?php echo BASE_URL; ?>/posts/CreateComment',
            type: 'POST',
            data: data,
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log("Error:", error);
            },
        });
    }
</script>
<script>
    $(document).ready(function () {
        const commentId =
            "comment_index_<?php echo isset($_SESSION["IndexComment"]) ? $_SESSION["IndexComment"] : ""; ?>";
        scrollComment(commentId);
    });

    <?php $_SESSION["IndexComment"] = 0 ?>

    function scrollComment(commentId) {
        console.log("vào được scroll rồi");
        var commentSelector = "#" + commentId;
        var $comment = $(commentSelector);

        if ($comment.length) {
            var offset = $comment.offset().top;
            var headerHeight = 300;
            $('html, body').animate({
                scrollTop: offset - headerHeight
            }, 1000);

            $comment.addClass('highlight');

            setTimeout(function () {
                $comment.removeClass('highlight');
            }, 3000);
        } else {
            console.log("Không tìm thấy bình luận với ID:", commentId);
        }
    }
</script>

<!-- Handel Follower -->
<script>
    $(document).ready(function () {
        // await checkFollowStatus(authId, userId);

        var userId =
            "<?php echo isset($_SESSION['UserID']) ? $_SESSION['UserID'] : "none"; ?>";
        var authId =
            "<?php echo isset($posts[0]["user_id"]) ? $posts[0]["user_id"] : "none"; ?>";

        checkFollowStatus(authId, userId);

        $('#followButton').on('click', function () {
            if (userId === "") {
                window.location.href = "<?php echo BASE_URL ?>/login";
            }

            const isFollowed = $(this).hasClass('followed');
            const action = isFollowed ? 'unFollow' : 'follow';

            $(this).html('<i class="fa fa-plus i-plus"></i> ' + (isFollowed ? 'Theo dõi' :
                'Đang theo dõi'))
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
            // console.log("Call api: ", data);

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