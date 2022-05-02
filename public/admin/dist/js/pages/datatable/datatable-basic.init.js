// $('.data-table tfoot th').each(function() {
//     var title = $(this).text();
//     $(this).html('<input type="text" placeholder="Tìm kiếm ' + title + '" />');
// });
// $('.data-table').DataTable({
//     "language": {
//         url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json'
//         // "decimal": "",
//         // "emptyTable": "Không có dữ liệu",
//         // "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
//         // "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
//         // "infoFiltered": "(được lọc từ _MAX_ tổng số mục)",
//         // "infoPostFix": "",
//         // "thousands": ",",
//         // "lengthMenu": "Hiển thị _MENU_ mục",
//         // "loadingRecords": "Đang tải...",
//         // "processing": "Đang tải...",
//         // "search": "Tìm kiếm:",
//         // "zeroRecords": "Không tìm thấy kết quả",
//         // "paginate": {
//         //     "first": "Đầu tiền",
//         //     "last": "Cuối cùng",
//         //     "next": "Sau",
//         //     "previous": "Trước"
//         // },
//         // "aria": {
//         //     "sortAscending": ": kích hoạt để sắp xếp cột tăng dần",
//         //     "sortDescending": ": kích hoạt để sắp xếp cột giảm dần"
//         // }
//     },
//     initComplete: function() {
//         // Apply the search
//         this.api().columns().every(function() {
//             var that = this;
            
//             $('input').on('keyup change clear', function() {
//                 console.log(this.value);
//                 console.log(that);
//                 if (that.column().search() !== this.value) {
//                     that
//                         .column()
//                         .search(this.value)
//                         .draw();
//                 }
//             });
//         });
//     }
// });