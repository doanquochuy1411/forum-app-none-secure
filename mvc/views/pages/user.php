<!--content-->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <!-- <h4 class="page-title">Người dùng</h4> -->
                <h3 class="text-primary font-weight-bold position-relative">Người Dùng</h3>
                <div class="title-underline"></div>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="#" class="btn btn btn-primary btn-rounded float-right" id="openAddUserModal"><i
                        class="fa fa-plus"></i> Thêm người
                    dùng</a>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-border table-striped custom-table datatable m-b-0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ Tên</th>
                                        <th>Ngày tham gia</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="pagination" id="pagination"></div>
            </div>
        </div>
    </div>
</div>
<!--/ content-->

<script>
    // Dữ liệu người dùng từ PHP
    const allUsers = <?php echo json_encode($all_users); ?>;
    let current_page = 1;
    const usersPerPage = 5;
    let filteredUsers = allUsers;

    // Hàm hiển thị người dùng
    function displayUsers(users) {
        const userTableBody = document.getElementById('userTableBody');
        userTableBody.innerHTML = ''; // Xóa dữ liệu cũ

        // Tính toán vị trí bắt đầu và kết thúc
        const start = (current_page - 1) * usersPerPage;
        const end = start + usersPerPage;
        const paginatedUsers = users.slice(start, end);

        paginatedUsers.forEach((user, index) => {
            // Tạo một phần tử tr từ chuỗi HTML
            const row = document.createElement('tr');

            // Thêm lớp user-row
            row.className = 'data-row';

            // Thiết lập nội dung HTML cho hàng
            row.innerHTML = `
        <td>${start + index + 1}</td>
        <td><b><a style="color: #000" href="<?php echo BASE_URL . '/home/info/' ?>${user.account_name}">
        <img width="28" height="28" src="<?php echo BASE_URL . '/public/src/uploads/' ?>${user.image}" class="rounded-circle m-r-5" alt="Img"> ${user.user_name}</a></b></td>
        <td>${new Date(user.created_at).toLocaleDateString('en-GB')}</td>
        <td>${user.email || ''}</td>
        <td>${user.phone_number || ''}</td>
        <td>
            <a href="#" class="px-2 edit"></a>
            <a href="#" style="color: red" title="Xóa thành viên"><i class="fa fa-trash-alt" onclick="confirmDelete(event,'<?php echo BASE_URL ?>/admin/deleteUser/${user.id}')"></i></a>
        </td>
    `;

            // Chèn hàng vào bảng
            userTableBody.appendChild(row);

            // Sử dụng setTimeout để thêm lớp `show` sau khi hàng được thêm vào
            setTimeout(() => {
                row.classList.add('show'); // Thêm lớp `show` để kích hoạt hiệu ứng
            }, 0); // Đặt thời gian 0 để hiệu ứng diễn ra ngay lập tức
        });

    }

    // function setupPagination(users) {
    //     const pagination = document.getElementById('pagination');
    //     pagination.innerHTML = ''; // Xóa phân trang cũ
    //     const pageCount = Math.ceil(users.length / usersPerPage);

    //     // Nút "Trước"
    //     if (current_page > 1) {
    //         const prevButton = document.createElement('a');
    //         prevButton.textContent = '« Trước';
    //         prevButton.className = 'page-link';
    //         prevButton.href = '#'; // Thêm href để biến nó thành liên kết
    //         prevButton.onclick = function (event) {
    //             event.preventDefault(); // Ngăn chặn hành vi mặc định
    //             current_page--;
    //             displayUsers(users);
    //             setupPagination(users);
    //         };
    //         pagination.appendChild(prevButton);
    //     } else {
    //         const disabledPrevButton = document.createElement('span');
    //         disabledPrevButton.textContent = '« Trước';
    //         disabledPrevButton.className = 'disabled';
    //         pagination.appendChild(disabledPrevButton);
    //     }

    //     // Nút trang
    //     for (let i = 1; i <= pageCount; i++) {
    //         const pageButton = document.createElement('a');
    //         pageButton.textContent = i;
    //         pageButton.className = 'page-link';
    //         if (i === current_page) {
    //             pageButton.classList.add('active'); // Nút hiện tại
    //             pageButton.style.pointerEvents = 'none'; // Ngăn không cho nhấn vào nút đang chọn
    //         } else {
    //             pageButton.onclick = function (event) {
    //                 event.preventDefault(); // Ngăn chặn hành vi mặc định
    //                 current_page = i;
    //                 displayUsers(users);
    //                 setupPagination(users);
    //             };
    //         }
    //         pagination.appendChild(pageButton);
    //     }

    //     // Nút "Sau"
    //     if (current_page < pageCount) {
    //         const nextButton = document.createElement('a');
    //         nextButton.textContent = 'Sau »';
    //         nextButton.className = 'page-link';
    //         nextButton.href = '#'; // Thêm href để biến nó thành liên kết
    //         nextButton.onclick = function (event) {
    //             event.preventDefault(); // Ngăn chặn hành vi mặc định
    //             current_page++;
    //             displayUsers(users);
    //             setupPagination(users);
    //         };
    //         pagination.appendChild(nextButton);
    //     } else {
    //         const disabledNextButton = document.createElement('span');
    //         disabledNextButton.textContent = 'Sau »';
    //         disabledNextButton.className = 'disabled';
    //         pagination.appendChild(disabledNextButton);
    //     }
    // }

    function setupPagination(data) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = ''; // Xóa phân trang cũ

        const pageCount = Math.ceil(data.length / usersPerPage);
        const maxVisiblePages = 5; // Số lượng trang hiển thị tối đa

        // Nút "Trước"
        if (current_page > 1) {
            const prevButton = document.createElement('a');
            prevButton.textContent = '«';
            prevButton.className = 'page-link';
            prevButton.href = '#';
            prevButton.onclick = function (event) {
                event.preventDefault();
                current_page--;
                displayUsers(data);
                setupPagination(data);
            };
            pagination.appendChild(prevButton);
        }

        // Xử lý hiển thị các nút trang
        let startPage = Math.max(1, current_page - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(pageCount, startPage + maxVisiblePages - 1);

        if (startPage > 1) {
            const firstPage = document.createElement('a');
            firstPage.textContent = '1';
            firstPage.className = 'page-link';
            firstPage.href = '#';
            firstPage.onclick = function (event) {
                event.preventDefault();
                current_page = 1;
                displayUsers(data);
                setupPagination(data);
            };
            pagination.appendChild(firstPage);

            if (startPage > 2) {
                const dots = document.createElement('span');
                dots.textContent = '...';
                dots.className = 'dots';
                pagination.appendChild(dots);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            const pageButton = document.createElement('a');
            pageButton.textContent = i;
            pageButton.className = 'page-link';
            if (i === current_page) {
                pageButton.classList.add('active'); // Đánh dấu trang hiện tại
                pageButton.style.pointerEvents = 'none';
            } else {
                pageButton.onclick = function (event) {
                    event.preventDefault();
                    current_page = i;
                    displayUsers(data);
                    setupPagination(data);
                };
            }
            pagination.appendChild(pageButton);
        }

        if (endPage < pageCount) {
            if (endPage < pageCount - 1) {
                const dots = document.createElement('span');
                dots.textContent = '...';
                dots.className = 'dots';
                pagination.appendChild(dots);
            }

            const lastPage = document.createElement('a');
            lastPage.textContent = pageCount;
            lastPage.className = 'page-link';
            lastPage.href = '#';
            lastPage.onclick = function (event) {
                event.preventDefault();
                current_page = pageCount;
                displayUsers(data);
                setupPagination(data);
            };
            pagination.appendChild(lastPage);
        }

        // Nút "Sau"
        if (current_page < pageCount) {
            const nextButton = document.createElement('a');
            nextButton.textContent = '»';
            nextButton.className = 'page-link';
            nextButton.href = '#';
            nextButton.onclick = function (event) {
                event.preventDefault();
                current_page++;
                displayUsers(data);
                setupPagination(data);
            };
            pagination.appendChild(nextButton);
        }
    }

    // Hàm lọc dữ liệu dựa trên từ khóa tìm kiếm
    function filterUsers(keyword) {
        filteredUsers = allUsers.filter(user =>
            user.user_name.toLowerCase().includes(keyword.toLowerCase()) ||
            user.email.toLowerCase().includes(keyword.toLowerCase()) ||
            (user.phone_number && user.phone_number.toLowerCase().includes(keyword.toLowerCase()))
        );
        current_page = 1; // Quay về trang 1 sau khi lọc
        displayUsers(filteredUsers);
        setupPagination(filteredUsers);
    }

    // Gọi hàm khi trang được tải
    displayUsers(allUsers);
    setupPagination(allUsers);

    // Bắt sự kiện nhập liệu vào ô tìm kiếm
    document.getElementById('searchInput').addEventListener('input', function () {
        filterUsers(this.value);
    });
</script>