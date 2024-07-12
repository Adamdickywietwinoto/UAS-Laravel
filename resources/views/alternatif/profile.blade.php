@extends('layouts.dashboard')

@section('title')
  Profile
@endsection

@section('content')
  <div class="content col bg-light">
    <div class="mb-2 mt-2 bg-secondary d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <h3 class="ms-4 me-2 text-light fw-bold d-inline">Sistem Pendukung Keputusan Penilaian Pelayanan Hotel Terbaik</h3>
      </div>
      <div class="dropdown-center me-5">
        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
          </svg>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/profile">Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="penjelasan" tabindex="-1"> 
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        </div>
      </div>
    </div>
    <div class="ms-4 me-4 pt-3 bg-secondary rounded-3 shadow me-2 mb-3 px-3 bg-secondary" style="height: 87vh;">
    <form class="pt-4" action="{{ url('profile') }}" method="POST">
      @CSRF
      <div class="row mb-3">
        <div class="col-6 d-flex d-inline">
          <label for="nama" class="col-sm-2 form-label d-inline d-flex">Nama</label>
          <div class="col mb-3">
            <input type="text" class="form-control m-0" id="nama" name="nama" value="{{ $user->nama }}">
            @if($errors->has('nama'))
              <div class="alert alert-danger mt-1">
                {{ $errors->first('nama') }}
              </div>
            @endif
          </div>
        </div>
        <div class="col-6 d-flex">
          <label for="email" class="col-sm-2 form-label">Email</label>
          <div class="col mb-3">
            <input type="text" class="form-control m-0" id="email" name="email" value="{{ $user->email }}">
            @if($errors->has('email'))
              <div class="alert alert-danger mt-1">
                {{ $errors->first('email') }}
              </div>
            @endif
          </div>
        </div>
        <div class="col d-flex d-inline">
          <label for="password" class="col-sm-2 form-label d-inline d-flex">Password</label>
          <div class="col-10 mb-3">
            <input type="text" class="form-control m-0" id="password" name="password">
            @if($errors->has('password'))
              <div class="alert alert-danger mt-1">
                {{ $errors->first('password') }}
              </div>
            @endif
          </div>
        </div>
        <div class="col d-flex">
          <label for="password_confirmation" class="col-sm-2 form-label">Password Konfirmasi</label>
          <div class="col-10 mb-3">
            <input type="text" class="form-control m-0" id="password_confirmation" name="password_confirmation">
            @if($errors->has('password_confirmation'))
              <div class="alert alert-danger mt-1">
                {{ $errors->first('password_confirmation') }}
              </div>
            @endif
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div class="">  
            <a href="{{ url('dashboard') }}" class="btn btn-primary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus Akun</div> 
        </div>
      </form>
      <div class="modal fade" id="deleteModal" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="deleteModal">Apakah Akan di Hapus?</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
              <form action="{{ url("profile/$user->id") }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" type="submit">Iya</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
