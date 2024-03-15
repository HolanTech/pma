@extends('layouts.admin')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5> Input Site To Site</h5>
                    </div>
                    <div class="card-body">
                        <form id="dynamicForm" action="" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="inputSite1" class="form-label">Site 1</label>
                                <input type="text" class="form-control" id="inputSite1" name="site1"
                                    placeholder="Masukkan Site 1">
                            </div>
                            <div class="mb-3">
                                <label for="inputSite2" class="form-label">Site 2</label>
                                <input type="text" class="form-control" id="inputSite2" name="site2"
                                    placeholder="Masukkan Site 2">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" id="showDataOTB" class="btn btn-success">Show Data OTB</button>
                                <button type="button" id="showAssets" class="btn btn-warning">Show Assets</button>
                                <button type="button" id="showSpliceConfig" class="btn btn-danger">Show Splice
                                    Config</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-gradient-indigo">
                        <h5>Already Site </h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach ($datas as $data)
                                <li> {{ $data->site1 }} To {{ $data->site2 }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('showDataOTB').addEventListener('click', function() {
                changeFormActionAndSubmit('{{ route('data_otb.index') }}');
            });

            document.getElementById('showAssets').addEventListener('click', function() {
                changeFormActionAndSubmit('{{ route('asset.index') }}');
            });

            document.getElementById('showSpliceConfig').addEventListener('click', function() {
                changeFormActionAndSubmit();
            });

            function changeFormActionAndSubmit(newAction) {
                var form = document.getElementById('dynamicForm');
                form.action = newAction;
                form.method = 'GET'; // Sesuaikan jika Anda memerlukan method yang berbeda
                form.submit();
            }
        });
    </script>
@endpush
