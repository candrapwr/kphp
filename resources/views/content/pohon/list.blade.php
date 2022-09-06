@extends('layouts/contentLayoutMaster')
@section('title', 'Manajemen Data Pohon')
@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('vendor-style')
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
<link rel="stylesheet" href="{{asset('js/leaflet/leaflet.css')}}">
<script src="{{ asset('js/leaflet/leaflet.js') }}"></script>
<link rel="stylesheet" href="{{asset('js/dragdrop/drag.css')}}">
@endsection

@section('content')
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic table">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama Pohon</th>
                                            <th>Jenis</th>
                                            <th>Diameter</th>
                                            <th>Tinggi</th>
                                            <th>Tahun Tanam</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal to add new record -->
                    <div class="modal fade" id="modals-insert">
                        <div class="modal-dialog modal-lg">
                            <form class="add-new-record modal-content pt-0" id="formSimpan">
                                <input name="update" type="hidden" class="form-control" value="0">
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body flex-grow-1">

                                    <form class="form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Nama
                                                                Pohon</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Nama Pohon" name="pohon_nama">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Jenis
                                                                Pohon</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Jenis Pohon" name="pohon_jenis">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Diameter
                                                                Pohon (&#13213;)</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Diameter" name="pohon_diameter">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Tinggi
                                                                Pohon (&#13213;)</label>
                                                            <input type="text" class="form-control" placeholder="Tinggi"
                                                                name="pohon_tinggi">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-select" name="pohon_status">
                                                                <option></option>
                                                                <option>Dilindungi</option>
                                                                <option>Tidak Dilindungi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Tahun
                                                                Tanam</label>
                                                            <input type="number" class="form-control"
                                                                placeholder="Tahun" name="pohon_tahun_tanam">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Rentang
                                                                Tumbuh</label>
                                                            <select class="form-select" id="basicSelect"
                                                                name="pohon_rentang_tumbuh">
                                                                <option></option>
                                                                <option>TK</option>
                                                                <option>BK</option>
                                                                <option>Normal</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div id="map" style="width: 100%; height: 400px;"></div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Latitude</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Latitude" name="pohon_lat" id="pohon_lat">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Longitude</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Longitude" name="pohon_long"
                                                                id="pohon_long">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label">Foto Pohon</label>
                                                            <div class="preview-zone hidden">
                                                                <div class="box box-solid">
                                                                    <div class="box-header with-border">
                                                                        <div><b>Preview</b></div>
                                                                    </div>
                                                                    <div class="box-body"></div>
                                                                </div>
                                                            </div>
                                                            <div class="dropzone-wrapper">
                                                                <div class="dropzone-desc">
                                                                    <i class="glyphicon glyphicon-download-alt"></i>
                                                                    <p>Choose an image file or drag it here.</p>
                                                                </div>
                                                                <input type="file" name="img_data" class="dropzone">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button id="loadingSimpan" type="button"
                                                    class="btn btn-outline-secondary">
                                                    <div class="spinner-border text-primary" role="status"></div>
                                                </button>
                                                <button id="btnSimpan" type="button"
                                                    class="btn btn-primary data-submit me-1"
                                                    onClick="simpan('insert');">Simpan</button>
                                                <button type="reset" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
        <!-- Modal to add new record -->
        <!-- Modal to edit record -->
        <div class="modal fade" id="modals-edit">
            <div class="modal-dialog modal-md">
                <form class="add-new-record modal-content pt-0" id="formSimpanE">
                    <input name="update" type="hidden" class="form-control" value="1">
                    <input name="dataId" type="hidden" class="form-control">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex-grow-1">

                    </div>
                </form>
            </div>
        </div>
        <!-- Modal to edit record -->
        <!-- Modal detail record -->
        <div class="modal fade" id="modals-detail">
            <div class="modal-dialog modal-lg">
                <form class="modal-content pt-0" id="formSimpanE">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Data Pohon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="row gx-4">
                            <div class="col-lg-6">
                                <form class="row gx-2 gy-1">
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Nama Pohon</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_nama" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Jenis</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_jenis" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Diameter</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_diameter" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Tinggi</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_tinggi" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Status</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_status" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Tahun Tanam</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_tahun_tanam" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Rentang Tumbuh</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_rentang_tumbuh" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Longitude</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_long" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-0">
                                        <label class="form-label">Latitude</label>
                                        <div class="input-group input-group-merge">
                                            <input id="_pohon_lat" class="form-control" type="text" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 mt-2 mt-lg-0">
                                <div class="added-cards">
                                    <div class="cardMaster rounded border p-2 mb-1">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column">
                                            <div class="card-information">
                                                <div class="d-flex align-items-center mb-50">
                                                    <h6 class="mb-0">Foto Pohon</h6>
                                                </div>
                                                <div id="_foto"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cardMaster border rounded p-2">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column">
                                            <div class="card-information">
                                                <h6>QrCode Pohon</h6>
                                                <div id="_qrcode"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal detail record -->
        </section>
        <!--/ Basic table -->
    </div>
</div>
</div>
</div>
<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!}
</script>
@endsection

@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset('js/pohon/pohon.js') }}"></script>
<script src="{{ asset('js/dragdrop/drag.js') }}"></script>
@endsection
