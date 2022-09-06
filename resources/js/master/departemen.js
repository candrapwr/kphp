$(function () {
    'use strict';
    $('.datatables-basic').DataTable({
        ajax: $('body').attr('data-asset-path') + 'master/departemen_json',
        columns: [{
                data: 'depId'
            },
            {
                data: 'depNama'
            },
            {
                data: ''
            }
        ],
        columnDefs: [{
                targets: 0,
                responsivePriority: 4,
                visible: false
            },
            {
                targets: 1,
                visible: true
            },
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<div class="d-inline-flex">' +
                        '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                        feather.icons['more-vertical'].toSvg({
                            class: 'font-small-4'
                        }) +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a href="javascript:;" class="dropdown-item">' +
                        feather.icons['file-text'].toSvg({
                            class: 'font-small-4 me-50'
                        }) +
                        'Details</a>' +
                        '<a href="javascript:void(0);" class="dropdown-item" onClick="hapus(\'' + full['depId'] + '\')">' +
                        feather.icons['archive'].toSvg({
                            class: 'font-small-4 me-50'
                        }) +
                        'Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<a href="javascript:void(0);" class="item-edit" onClick="console.log(dataField)">' +
                        feather.icons['edit'].toSvg({
                            class: 'font-small-4'
                        }) +
                        '</a>'
                    );
                }
            }
        ],
        order: [
            [0, 'desc']
        ],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 10,
        //lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [{
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                text: feather.icons['share'].toSvg({
                    class: 'font-small-4 me-50'
                }) + 'Export',
                buttons: [{
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({
                            class: 'font-small-4 me-50'
                        }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({
                            class: 'font-small-4 me-50'
                        }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [1, 2]
                        }
                    }
                ],
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                    }, 50);
                }
            },
            {
                text: feather.icons['plus'].toSvg({
                    class: 'me-50 font-small-4'
                }) + 'Tambah Data',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#modals-slide-in'
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details of ' + data['depNama'];
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ?
                            '<tr data-dt-row="' +
                            col.rowIdx +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            '<td>' +
                            col.title +
                            ':' +
                            '</td> ' +
                            '<td>' +
                            col.data +
                            '</td>' +
                            '</tr>' :
                            '';
                    }).join('');

                    return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                }
            }
        },
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });
    $('div.head-label').html('<h6 class="mb-0">List Data</h6>');
    $('#loadingSimpan').hide();
});

function simpan() {
    $.ajax({
        url: $('body').attr('data-asset-path') + 'master/departemen_json',
        type: 'post',
        dataType: 'json',
        data: $('#formSimpan').serialize(),
        beforeSend: function () {
            $('#loadingSimpan').show();
            $('#btnSimpan').hide();
        },
        complete: function () {
            $('#loadingSimpan').hide();
            $('#btnSimpan').show();
        },
        success: function (response, textStatus, xhr) {
            console.log(response)
            if (response.sukses == true) {
                Swal.fire(
                    'SUKSES',
                    response.pesan,
                    'success'
                );
                $('.datatables-basic').DataTable().ajax.reload();
            } else {
                Swal.fire(
                    'GAGAL',
                    response.pesan,
                    'error'
                )
            }
        },
        error: function (request, status, error) {
            //location.reload();
        }
    })
}

function hapus(dataId) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data ini akan di hapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $('body').attr('data-asset-path') + 'master/departemen_json',
                type: 'post',
                dataType: 'json',
                data: {
                    dataId: dataId,
                    delData: 1,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend: function () {},
                complete: function () {},
                success: function (response, textStatus, xhr) {
                    console.log(response)
                    if (response.sukses == true) {
                        Swal.fire(
                            'SUKSES',
                            response.pesan,
                            'success'
                        );
                        $('.datatables-basic').DataTable().ajax.reload();
                    } else {
                        Swal.fire(
                            'GAGAL',
                            response.pesan,
                            'error'
                        )
                    }
                },
                error: function (request, status, error) {
                    //location.reload();
                }
            })
        }
    })
}
