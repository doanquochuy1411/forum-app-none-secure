Pusher.logToConsole = true;

    var pusher = new Pusher('c3b55afe49178f9e72ea', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('post-reported');
    channel.bind('PostReported', function(data) {
        updateNotifications();
    });

    function updateNotifications() {
        $.ajax({
            url: BASE_URL + '/api/getNotifications', // Đường dẫn tới hàm xử lý lấy thông báo trên server
            type: 'GET',
            success: function(response) {
                // Chuyển đổi chuỗi JSON thành đối tượng JavaScript
                var data = JSON.parse(response);
                if (data.code === 200) {
                    // Update số lượng thông báo
                    $('.pushertag').text(data.count);
    
                    // Xóa các thông báo cũ trong dropdown
                    $('#notification-dropdown').find('li:not(.dropdown-header, .divider)').remove();
    
                    // Tạo một mảng các promises để xử lý các hàm bất đồng bộ
                    const notificationPromises = data.notifications.map(notification => {
                        return new Promise((resolve) => {
                            var image = BASE_URL + '/public/client/image/images.png';
                            if (notification.comment_id != null) {
                                getAuthOfComment(notification.comment_id, function(userDetail) {
                                    image = BASE_URL + '/public/src/uploads/' + userDetail.user_details[0].avatar; // Sử dụng avatar của người dùng
                                    notification.message = userDetail.user_details[0].comment_user_name.concat(" ", notification.message);
                                    resolve({ notification, image });
                                });
                            } else if (notification.report_id != null) {
                                getAuthOfReport(notification.report_id, function(reportDetail) {
                                    console.log(reportDetail)
                                    image = BASE_URL + '/public/src/uploads/' + reportDetail.report_details[0].avatar; // Sử dụng avatar của người dùng
                                    notification.message = reportDetail.report_details[0].user_name.concat(" ", notification.message);
                                    resolve({ notification, image });
                                });
                            } else {
                                getAuthOfPost(notification.post_id, function(postDetail) {
                                    image = BASE_URL + '/public/src/uploads/' + postDetail.post_details[0].avatar; // Sử dụng avatar của người dùng
                                    notification.message = postDetail.post_details[0].user_name.concat(" ", notification.message);
                                    resolve({ notification, image });
                                });
                            }
                        });
                    });
    
                    // Đợi tất cả các promises hoàn thành và hiển thị thông báo
                    Promise.all(notificationPromises).then(results => {
                        results.forEach(({ notification, image }) => {
                            addNotificationToDropdown(notification, image);
                        });
                    }).catch(error => {
                        console.error("Lỗi khi xử lý thông báo: ", error);
                    });
                } else {
                    addNotExistNotificationToDropdown();
                    console.log("Lỗi rồi"); // Log trạng thái khi không có thông báo mới
                    console.log(data);
                }
            },
            error: function() {
                addNotExistNotificationToDropdown();
                console.log("Error fetching notifications.");
            }
        });
    }
    

    function addNotificationToDropdown(notification, image) {
        $('#notification-dropdown').append(
            `<li>
                <a href="${BASE_URL}/home/notifications/${notification.id}">
                    <div style="display: flex; align-items: center;">
                        <img src="${image}" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                        <div class="notification-message" style="max-width: 200px;">
                            ${notification.message}
                        </div>
                        <span style="font-size: 0.8em; color: grey; margin-left: 10px;">${timeAgo(notification.created_at)}</span>
                    </div>
                </a>
            </li>`
        );
    }

    function addNotExistNotificationToDropdown() {
        $('#notification-dropdown').append(
            `<li>
                <a href="#">
                    Không có thông báo
                </a>
            </li>`
        );
    }

    function getAuthOfComment(cmt_id, callback) {
        $.ajax({
            url: BASE_URL+`/api/getUserDetailsViaCmtID/${cmt_id}`, // Đường dẫn tới hàm xử lý lấy thông báo trên server
            type: 'GET',
            success: function(response) {
                // Chuyển đổi chuỗi JSON thành đối tượng JavaScript
                var userDetail = JSON.parse(response);
                // console.log(userDetail)
                callback(userDetail);
            },
            error: function() {
                console.log("Error fetching notifications.");
                callback({ avatar: BASE_URL+'/public/client/image/images.png' });
            }
        });
    }

    function getAuthOfPost(post_id, callback) {
        $.ajax({
            url: BASE_URL+`/api/getAuthOfPost/${post_id}`, // Đường dẫn tới hàm xử lý lấy thông báo trên server
            type: 'GET',
            success: function(response) {
                // Chuyển đổi chuỗi JSON thành đối tượng JavaScript
                var postDetail = JSON.parse(response);
                console.log(postDetail)
                callback(postDetail);
            },
            error: function() {
                console.log("Error fetching notifications.");
                callback({ avatar: BASE_URL+'/public/client/image/images.png' });
            }
        });
    }

    function getAuthOfReport(report_id, callback) {
        $.ajax({
            url: BASE_URL+`/api/getAuthOfReport/${report_id}`, // Đường dẫn tới hàm xử lý lấy thông báo trên server
            type: 'GET',
            success: function(response) {
                console.log(response)
                // Chuyển đổi chuỗi JSON thành đối tượng JavaScript
                var reportDetail = JSON.parse(response);
                // console.log(reportDetail)
                callback(reportDetail);
            },
            error: function() {
                console.log("Error fetching notifications.");
                callback({ avatar: BASE_URL+'/public/client/image/images.png' });
            }
        });
    }

    $(document).ready(function() {
        updateNotifications(); // Lấy và hiển thị thông báo khi tải trang
    });

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
                break;  // Chỉ lấy khoảng thời gian lớn nhất
            }
        }
    
        return result || 'vừa mới';  // Nếu không có khoảng thời gian lớn hơn 0, hiển thị 'vừa mới'
    }
    
    