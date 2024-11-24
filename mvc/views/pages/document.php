<!--content-->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h3 class="text-primary font-weight-bold position-relative">Câu Hỏi</h3>
                <div class="title-underline"></div>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
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
                                        <th>Tiêu đề</th>
                                        <th>Tác giả</th>
                                        <th>Ngày tạo</th>
                                        <th>Lượt xem</th>
                                        <th>Lượt bình luận</th>
                                        <th>Lượt báo cáo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTableBody">
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
    const data = <?php echo json_encode($documents); ?>;
    let current_page = 1;
    const dataPerPage = 5;
    // Hàm hiển thị người dùng
    function displayData(data) {
        const dataTableBody = document.getElementById('dataTableBody');
        dataTableBody.innerHTML = ''; // Xóa dữ liệu cũ

        // Tính toán vị trí bắt đầu và kết thúc
        const start = (current_page - 1) * dataPerPage;
        const end = start + dataPerPage;
        const paginatedData = data.slice(start, end);

        paginatedData.forEach((d, index) => {
            // Tạo một phần tử tr từ chuỗi HTML
            const row = document.createElement('tr');

            // Thêm lớp user-row
            row.className = 'data-row';

            // Thiết lập nội dung HTML cho hàng
            row.innerHTML = `
        <td>${start + index + 1}</td>
        <td><b><a style="color: #000" href="<?php echo BASE_URL . '/home/posts/' ?>${d.id}">${d.title}</a><b></td>
                                    <td>${d.user_name}</td>
                                    <td>${new Date(d.created_at).toLocaleDateString('en-GB')}</td>
                                    <td>${d.views}</td>
                                    <td>${d.comment_count}</td>
                                    <td>${d.report_count}</td>
                                    <td>
                                        <a href="#" class="px-2 edit"></a>
                                        <a href="#" style="color: red" title="Xóa bài viết"><i class="fa fa-trash-alt" onclick="confirmDelete(event,'<?php echo BASE_URL ?>/posts/delete/${d.id}')"></i></a>
                                        </td>
    `;

            // Chèn hàng vào bảng
            dataTableBody.appendChild(row);

            // Sử dụng setTimeout để thêm lớp `show` sau khi hàng được thêm vào
            setTimeout(() => {
                row.classList.add('show'); // Thêm lớp `show` để kích hoạt hiệu ứng
            }, 0); // Đặt thời gian 0 để hiệu ứng diễn ra ngay lập tức
        });

    }

    function setupPagination(data) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = ''; // Xóa phân trang cũ

        const pageCount = Math.ceil(data.length / dataPerPage);
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
                displayData(data);
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
                displayData(data);
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
                    displayData(data);
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
                displayData(data);
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
                displayData(data);
                setupPagination(data);
            };
            pagination.appendChild(nextButton);
        }
    }

    // Gọi hàm khi trang được tải
    displayData(data);
    setupPagination(data);

    // Bắt sự kiện nhập liệu vào ô tìm kiếm
    document.getElementById('searchInput').addEventListener('input', function () {
        filterData(this.value);
    });
</script>