<!--content-->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <!-- <h4 class="page-title">Danh mục</h4> -->
                <h3 class="text-primary font-weight-bold position-relative">Danh mục</h3>
                <!-- <div class="title-underline"></div> -->
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="#" id="openAddCategoryModal" class="btn btn btn-primary btn-rounded float-right"><i
                        class="fa fa-plus"></i> Thêm danh
                    mục</a>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <table class="table table-border table-striped custom-table datatable m-b-0">
                    <form id="edit-category-form"
                        action="<?php echo BASE_URL ?>/admin/handelUpdateCategory/<?php echo $category[0]['id'] ?>"
                        method="post" class="p-4 shadow rounded bg-white">
                        <h1 class="text-center mb-4 text-primary">Cập Nhật Danh Mục</h1>

                        <div class="form-group mb-3">
                            <label for="category_name_update" class="form-label">Tên danh mục <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category_name_update"
                                placeholder="Nhập tên danh mục" name="category_name_update"
                                value="<?php echo $category[0]['name'] ?>" required>
                            <small id="category_name_update_err" class="text-danger"></small>
                        </div>
                        <input type="hidden" value="<?php echo $category[0]['name'] ?>" name="current_name">
                        <div class="form-group mb-3">
                            <label for="category_description_update" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" id="category_description_update"
                                placeholder="Nhập mô tả cho danh mục" name="category_description_update"
                                value="<?php echo $category[0]['description'] ?>">
                            <small id="category_description_update_err" class="text-danger"></small>
                        </div>

                        <input type="hidden" name="token" value="<?php echo $_SESSION['_token'] ?>" />

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Quay
                                lại</button>
                            <button type="submit" name="btnUpdateCategory" class="btn btn-primary">Cập
                                nhật</button>
                        </div>
                    </form>
                </table>
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