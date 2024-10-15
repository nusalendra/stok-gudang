@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
    <!-- Bootstrap dan custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">

    <style>
        /* Background gradient */
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Card styling */
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Input focus effect */
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.6);
        }

        /* Button styling */
        .btn-primary {
            background-color: #667eea;
            border-color: #667eea;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            background-color: #764ba2;
            box-shadow: 0 0 10px rgba(118, 75, 162, 0.5);
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-2 text-center" style="color: #667eea;">Selamat Datang</h4>
                        <p class="mb-4 text-center">Silahkan masuk ke akun anda</p>
                        <!-- Form login tanpa logo dan teks welcome -->
                        <form id="formAuthentication" class="mb-3" action="/" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan Email Anda" autofocus>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>

                        {{-- <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ url('auth/register-basic') }}" class="text-primary">
                                <span>Create an account</span>
                            </a>
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Aksi Dihentikan',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
@endsection
