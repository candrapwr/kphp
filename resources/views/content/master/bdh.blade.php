@extends('layouts/contentLayoutMaster')
@section('title', 'Master Bagian Daerah Hutan (BDH)')
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
                                            <th>Induk KPH</th>
                                            <th>Nama BDH</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal to add new record -->
                    <div class="modal fade" id="modals-insert">
                        <div class="modal-dialog modal-md">
                            <form class="add-new-record modal-content pt-0" id="formSimpan">
                            <input name="update" type="hidden" class="form-control" value="0">
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label">Nama BDH</label>
                                        <input name="bdh_name" type="text" class="form-control" placeholder="Nama BDH"
                                            required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Induk KPH</label>
                                        <select class="form-select" name="kph_id">
                                            <option selected="">Pilih KPH</option>
                                            @foreach($data_kph as $v_kph)
                                            <option value="{{$v_kph->kph_id}}">{{$v_kph->kph_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button id="loadingSimpan" type="button" class="btn btn-outline-secondary">
                                        <div class="spinner-border text-primary" role="status"></div>
                                    </button>
                                    <button id="btnSimpan" type="button" class="btn btn-primary data-submit me-1"
                                        onClick="simpan('insert');">Simpan</button>
                                    <button type="reset" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Batal</button>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label">Nama BDH</label>
                                        <input name="bdh_name_e" type="text" class="form-control" placeholder="Nama BDH"
                                            required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Induk KPH</label>
                                        <select class="form-select" name="kph_id_e" id="kph_id_e">
                                            <option selected="">Pilih KPH</option>
                                            @foreach($data_kph as $v_kph)
                                            <option value="{{$v_kph->kph_id}}">{{$v_kph->kph_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button id="loadingSimpanE" type="button" class="btn btn-outline-secondary">
                                        <div class="spinner-border text-primary" role="status"></div>
                                    </button>
                                    <button id="btnSimpanE" type="button" class="btn btn-primary data-submit me-1"
                                        onClick="simpan('update');">Simpan</button>
                                    <button type="reset" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal to edit record -->
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
</div>
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
<script src="{{ asset('js/master/bdh.js') }}"></script>
@endsection
