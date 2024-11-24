// window.addEventListener('load', () => {
//     // Tìm phần tử loader và thêm lớp hidden để ẩn nó
//     const loader = document.querySelector('.loader');
//     if (loader) {
//         loader.classList.add('hidden');
//     }

//     // Hiển thị nội dung trang sau khi loader bị ẩn
//     const content = document.querySelector('.hidden-content');
//     if (content) {
//         content.style.opacity = '1';
//     }
//     // Phục hồi cuộn của trang
//     document.body.style.overflow = 'auto';
// });

// setTimeout(() => {
//     // Tìm phần tử loader và thêm lớp hidden để ẩn nó
//     const loader = document.querySelector('.loader');
//     if (loader) {
//         loader.classList.add('hidden');
//     }

//     // Hiển thị nội dung trang sau khi loader bị ẩn
//     const content = document.querySelector('.hidden-content');
//     if (content) {
//         content.style.opacity = '1';
//     }
//     // Phục hồi cuộn của trang
//     document.body.style.overflow = 'auto';
// }, 1000); // Thời gian chờ 1 giây
document.addEventListener('DOMContentLoaded', () => {
    // Tìm phần tử loader và thêm lớp hidden để ẩn nó
    const loader = document.querySelector('.loader');
    if (loader) {
        loader.classList.add('hidden');
    }

    // Hiển thị nội dung trang sau khi loader bị ẩn
    const content = document.querySelector('.hidden-content');
    if (content) {
        content.style.opacity = '1';
    }

    // Phục hồi cuộn của trang
    document.body.style.overflow = 'auto';
});
