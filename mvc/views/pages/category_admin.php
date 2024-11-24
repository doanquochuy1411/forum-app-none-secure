<!--content-->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <!-- <h4 class="page-title">Danh mục</h4> -->
                <h3 class="text-primary font-weight-bold position-relative">Danh mục</h3>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="#" id="openAddCategoryModal" class="btn btn btn-primary btn-rounded float-right"><i
                        class="fa fa-plus"></i> Thêm danh
                    mục</a>
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
                                        <th>Tên danh mục</th>
                                        <th>Mô tả</th>
                                        <th>Loại</th>
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

    <!-- Add Category modal -->
    <div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h3 style="text-align: center" class="modal-title" id="add-category-modal-label"><b>Thêm danh
                            mục</b>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-category-form" action="<?php echo BASE_URL ?>/admin/addCategory" method="post">
                        <div class="form-group">
                            <label for="category_name">Tên danh mục*</label>
                            <input type="text" class="form-control" id="category_name" name="category_name">
                            <small id="category_name_err"></small>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Mô tả</label>
                            <input type="text" class="form-control" id="category_description"
                                name="category_description">
                            <small id="category_description_err"></small>
                        </div>
                        <div class="form-group">
                            <label for="category_type">Loại danh mục</label>
                            <select class="form-control" id="category_type" name="category_type" required>
                                <option value="post" selected>Bài Viết</option>
                                <option value="document">Tài liệu</option>
                            </select>
                            <small id="category_type_err"></small>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['_token'] ?>" />
                        <button type="submit" name="btnAddCategory" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End add category modal -->
</div>
<!--/ content-->


<script>
    // Dữ liệu người dùng từ PHP
    const data = <?php echo json_encode($categories); ?>;
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
        <td>${d.name}</td>
                                    <td>${d.description}</td>
                                    <td>${convertTypeToVietnamese(d.category_type)}</td>
                                    <td>
                                        <a href="<?php echo BASE_URL ?>/admin/UpdateCategory/${d.id}" class="px-2 edit"><i
                                        class="fas fa-pencil-alt"></i></a>
                                        <a href="#" style="color: red" title="Xóa danh mục"><i class="fa fa-trash-alt" onclick="confirmDelete(event,'<?php echo BASE_URL ?>/admin/deleteCategory/${d.id}')"></i></a>
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

    function convertTypeToVietnamese(type) {
        return type === "post" ? "Bài viết" : type === "document" ? "Tài liệu" : "Không xác định";
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

    // Hàm lọc dữ liệu dựa trên từ khóa tìm kiếm
    function filterData(keyword) {
        filteredData = data.filter(d =>
            d.name.toLowerCase().includes(keyword.toLowerCase()) ||
            d.description.toLowerCase().includes(keyword.toLowerCase())
        );
        current_page = 1; // Quay về trang 1 sau khi lọc
        displayData(filteredData);
        setupPagination(filteredData);
    }

    // Gọi hàm khi trang được tải
    displayData(data);
    setupPagination(data);

    // Bắt sự kiện nhập liệu vào ô tìm kiếm
    document.getElementById('searchInput').addEventListener('input', function () {
        filterData(this.value);
    });
</script>