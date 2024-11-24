// function confirmDelete(event, targetHref) {
//   event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
//   Swal.fire({
//       title: "Bạn có chắc chắn xóa không",
//       width: '400px', // Tăng chiều rộng của popup
//       confirmButtonText: "Xóa",
//       // denyButtonText: `Don't save`,
//       // showDenyButton: true,
//       showCancelButton: true,
//       // customClass: {
//       //     title: 'swal2-title-large', // Kích thước chữ tiêu đề
//       //     popup: 'swal2-popup-large', // Kích thước văn bản trong popup
//       //     confirmButton: 'swal2-button-large', // Kích thước chữ nút xác nhận
//       //     denyButton: 'swal2-button-large', // Kích thước chữ nút từ chối
//       //     cancelButton: 'swal2-button-large' // Kích thước chữ nút hủy
//       // }
//   }).then((result) => {
//       if (result.isConfirmed) {
//         console.log("href: ", targetHref);
//         // window.location.href = targetHref;
//         // window.location.href = event.target.href;
//           // Swal.fire("Xóa thành công!", "", "success");
//       } 
//       // else if (result.isDenied) {
//       //     Swal.fire("Changes are not saved", "", "info");
//       // }
//   });
// }

// // // Gán sự kiện click cho tất cả các liên kết có class 'delete-link'
// // // document.querySelectorAll('.delete-link').forEach(link => {
// // //   link.addEventListener('click', function(event) {
// // //       event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
// // //       var targetHref = this.href; // Lấy giá trị href của liên kết

// // //       // Hiển thị SweetAlert2 popup
// // //       Swal.fire({
// // //           title: "Bạn có chắc chắn xóa không?",
// // //           width: '400px',
// // //           confirmButtonText: "Xóa",
// // //           showCancelButton: true,
// // //       }).then((result) => {
// // //           if (result.isConfirmed) {
// // //               window.location.href = targetHref; // Điều hướng đến href đã lưu
// // //           }
// // //       });
// // //   });
// // // });
