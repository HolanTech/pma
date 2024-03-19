@extends('layouts.admin')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <!-- Card Input Site To Site -->
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
                                    placeholder="Input Site 1" aria-label="Site 1">
                            </div>
                            <div class="mb-3">
                                <label for="inputSite2" class="form-label">Site 2</label>
                                <input type="text" class="form-control" id="inputSite2" name="site2"
                                    placeholder="Input Site 2" aria-label="Site 2">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" id="showDataOTB" class="btn btn-success"><i
                                        class="fas fa-search"></i> Show Data OTB</button>
                                <button type="button" id="showAssets" class="btn btn-warning"><i
                                        class="fas fa-briefcase"></i> Show Assets</button>
                                <button type="button" id="showSpliceConfig" class="btn btn-danger"><i
                                        class="fas fa-tools"></i> Show Splice Config</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Card Already Site -->
                <div class="card">
                    <div class="card-header bg-gradient-indigo">
                        <h5>Already Site</h5>
                    </div>
                    <div class="card-body">
                        <!-- Dropdown untuk Site1 -->
                        <select class="form-control select2" id="alreadySite1" name="alreadySite1"
                            aria-label="Already Site 1">
                            <option value="">Select or Type</option>
                            @foreach ($allSites as $site)
                                <option value="{{ $site }}">{{ $site }}</option>
                            @endforeach
                        </select>

                        <div class="my-2">TO</div>

                        <!-- Dropdown untuk Site2 -->
                        <select class="form-control select2" id="alreadySite2" name="alreadySite2"
                            aria-label="Already Site 2">
                            <option value="">Select or Type</option>
                            @foreach ($allSites as $site)
                                <option value="{{ $site }}">{{ $site }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialization for Select2
            $('.select2').select2({
                tags: true,
                placeholder: "Select or type",
                allowClear: true,
                theme: 'bootstrap4'

            });

            // Function to change form action and submit with both inputs
            function changeFormActionAndSubmit(newAction, requireBoth = true) {
                var form = document.getElementById('dynamicForm');
                var inputSite1 = document.getElementById('inputSite1').value;
                var inputSite2 = document.getElementById('inputSite2').value;
                var alreadySite1 = $('#alreadySite1').val();
                var alreadySite2 = $('#alreadySite2').val();

                var site1Value = inputSite1 ? inputSite1 : alreadySite1;
                var site2Value = inputSite2 ? inputSite2 : alreadySite2;

                // For "Show Assets", proceed if at least one field is filled
                if (!requireBoth || (site1Value && site2Value)) {
                    document.getElementById('inputSite1').value = site1Value;
                    document.getElementById('inputSite2').value = site2Value;

                    form.action = newAction;
                    form.method = 'GET'; // Adjust if you need a different method
                    form.submit();
                } else {
                    alert(
                        "Please fill in both Site 1 and Site 2 fields for other actions, or at least one for Show Assets."
                        );
                }
            }

            // Button event listeners
            document.getElementById('showDataOTB').addEventListener('click', function() {
                changeFormActionAndSubmit('{{ route('data_otb.index') }}', true);
            });

            document.getElementById('showAssets').addEventListener('click', function() {
                changeFormActionAndSubmit('{{ route('asset.index') }}', false);
            });

            document.getElementById('showSpliceConfig').addEventListener('click', function() {
                changeFormActionAndSubmit('#', true);
            });
        });
    </script>
@endpush
