@extends('layouts.admin')

@section('content')
    <div class="text-center">
        <div class="card mt-1"><strong>
                <h4>Add New User</h4>
            </strong>
        </div>
    </div>
    <div class="card">
        <form method="POST" action="{{ route('customer.store') }}">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="card-6">

                        <div class="row m-3">
                            <div class="col-12">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" placeholder="Nama Pelanggan" required autocomplete="name"
                                    autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-12">
                                <input id="no_hp" type="text"
                                    class="form-control @error('no_hp') is-invalid @enderror" name="no_hp"
                                    value="{{ old('no_hp') }}" placeholder="Nomor Handphone" required autocomplete="no_hp">
                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-12">
                                <input id="email" type="text"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" placeholder="email" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-12 input-group">
                                <textarea name="address" id="address" cols="30" rows="4" placeholder="alamat"
                                    class="form-control @error('address') is-invalid @enderror" name="address" required autocomplete="address"></textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-6">

                        <div class="row m-3">
                            <div class="col-12">
                                <input name="paket" id="paket" type="text"
                                    class="form-control @error('paket') is-invalid @enderror" value="{{ old('paket') }}"
                                    placeholder="paket" required autocomplete="paket" autofocus>
                                @error('paket')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-12">
                                <input id="latitude" type="text"
                                    class="form-control @error('latitude') is-invalid @enderror" name="latitude"
                                    value="{{ old('latitude') }}" placeholder="latitude" required autocomplete="latitude">
                                @error('latitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-12">
                                <input id="longitude" type="text"
                                    class="form-control @error('longitude') is-invalid @enderror" name="longitude"
                                    value="{{ old('longitude') }}" placeholder="longitude" required
                                    autocomplete="longitude">
                                @error('longitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-12">
                                <input id="date" type="date"
                                    class="form-control @error('date') is-invalid @enderror" name="date"
                                    value="{{ old('date') }}" required autocomplete="date">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row m-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Save Change') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    {{-- <script>
        function togglePasswordVisibility(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var passwordToggleIcon = document.getElementById('password-toggle-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordToggleIcon.className = 'far fa-eye-slash';
            } else {
                passwordField.type = 'password';
                passwordToggleIcon.className = 'far fa-eye';
            }
        }
    </script> --}}
@endsection
