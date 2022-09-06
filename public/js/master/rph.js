$(function () {
    'use strict';
    $('.datatables-basic').DataTable({
        ajax: $('body').attr('data-asset-path') + 'master/rph_all',
        columns: [{
                data: 'rph_id'
            },
            {
                data: 'kph_name'
            },
            {
                data: 'bdh_name'
            },
            {
                data: 'rph_name'
            },
            {
                data: 'rph_size'
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
                targets: 2,
                visible: true
            },
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function (data, type, full, meta) {
                    var idData = full['rph_id'];
                    return (
                        '<div class="d-inline-flex">' +
                        '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                        feather.icons['menu'].toSvg({
                            class: 'font-small-4'
                        }) +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-end">' +
                        '<a href="javascript:void(0);" class="dropdown-item" onClick="hapus(\'' + idData + '\')">' +
                        feather.icons['archive'].toSvg({
                            class: 'font-small-4 me-50'
                        }) +
                        'Delete</a>' +
                        '<a href="javascript:void(0);" class="dropdown-item" onClick="edit(\'' + idData + '\')">' +
                        feather.icons['edit'].toSvg({
                            class: 'font-small-4 me-50'
                        }) +
                        'Edit</a>' +
                        '</div>' +
                        '</div>'
                    );
                }
            }
        ],
        order: [
            [0, 'desc']
        ],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 10,
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
                    'data-bs-target': '#modals-insert'
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
                        return 'Details of ' + data['kph_name'];
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== ''
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

function simpan(mode) {
    var idForm;
    if(mode == 'update'){
        idForm = $('#formSimpanE').serialize();
    }else{
        idForm = $('#formSimpan').serialize();
    }

    var data = new FormData($("#formSimpan")[0]);

    $.ajax({
        url: $('body').attr('data-asset-path') + 'master/rph_add',
        type: 'post',
        //dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#loadingSimpan').show();
            $('#btnSimpan').hide();
        },
        complete: function () {
            $('#loadingSimpan').hide();
            $('#btnSimpan').show();
        },
        success: function (responseStr, textStatus, xhr) {
            var response = JSON.parse(responseStr);
            if (response.sukses == true) {
                $('#modals-insert').modal('hide');
                $('#modals-edit').modal('hide');
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
            Swal.fire(
                'GAGAL',
                error,
                'error'
            )
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
                url: $('body').attr('data-asset-path') + 'master/rph_del',
                type: 'post',
                dataType: 'json',
                data: {
                    dataId: dataId,
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
                    Swal.fire(
                        'GAGAL',
                        error,
                        'error'
                    )
                }
            })
        }
    })
}

function edit(dataId) {
    $.ajax({
        url: $('body').attr('data-asset-path') + 'master/rph_edit',
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            dataId: dataId,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        beforeSend: function () {
            $('#loadingSimpanE').show();
            $('#btnSimpanE').hide();
        },
        complete: function () {
            $('#loadingSimpanE').hide();
            $('#btnSimpanE').show();
        },
        success: function (response, textStatus, xhr) {
            //console.log(response.data);
            $('input[name="rph_name_e"]').val(response.data.rph_name);
            $('input[name="dataId"]').val(response.data.rph_id);
            $('input[name="rph_size_e"]').val(response.data.rph_size);
            $('#bdh_id_e').val(response.data.bdh_id);
            $('#modals-edit').modal('show');
        },
        error: function (request, status, error) {
            Swal.fire(
                'GAGAL',
                error,
                'error'
            )
        }
    })
}

$('#modals-insert').on('hidden.bs.modal', function (e) {
    $(this)
        .find("input,textarea,select")
        .val('')
        .end()
        .find("input[type=checkbox], input[type=radio]")
        .prop("checked", "")
        .end();
})
