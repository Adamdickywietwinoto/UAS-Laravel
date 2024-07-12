@extends('layouts.edit')

@section('title')
  Edit Bobot
@endsection

@section('content')
  <div class="content col bg-light">
    <div class="mb-2 mt-2 d-flex bg-secondary align-items-center justify-content-between">
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
            <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="penjelasan" tabindex="-1"> 
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
          </div>
        </div>
      </div>
    </div>
    <div class="ms-4 me-4 bg-secondary rounded-3 shadow me-2 mb-3 px-3 bg-secondary" style="height: 87vh;">
      <h2 class="pt-2">Edit Bobot</h2>
      <form class="pt-4" action="{{ url('edit/bobot') }}" method="POST">
        @METHOD('PATCH')
        @CSRF
        <div class="row mb-3">
          <p class="col-10 offset-2"><span class="text-danger">*</span>Total Bobot Harus 100</p>
          <label for="kriteria" class="col-2 fs-5 d-flex align-items-center">Bobot</label>
          <div class="col gap-2 d-flex flex-row justify-content-around card bg-transparent border-0 w-25">
            <div class="mt-1 bg-body-secondary px-2 py-2 rounded-2">
              <p class="fw-medium mb-0">Fasilitas</p>
              <input type="text" class="form-control" id="b1" name="b1" value="{{ $bbt['b1'] }}">
            </div>
            <div class="mt-1 bg-dark-subtle px-2 py-2 rounded-2">
              <p class="fw-medium mb-0">Interaksi</p>
              <input type="text" class="form-control" id="b2" name="b2" value="{{ $bbt['b2'] }}">
            </div>
            <div class="mt-1 bg-body-secondary px-2 py-2 rounded-2">
              <p class="fw-medium mb-0">Teknologi</p>
              <input type="text" class="form-control" id="b3" name="b3" value="{{ $bbt['b3'] }}">
            </div>
            <div class="mt-1 bg-dark-subtle px-2 py-2 rounded-2">
              <p class="fw-medium mb-0">Keamanan</p>
              <input type="text" class="form-control" id="b4" name="b4" value="{{ $bbt['b4'] }}">
            </div>
            <div class="mt-1 bg-body-secondary px-2 py-2 rounded-2">
              <p class="fw-medium mb-0">Tanggung Jawab</p>
              <input type="text" class="form-control" id="b5" name="b5" value="{{ $bbt['b5'] }}">
            </div>
          </div>
          @if(session('error'))
            <div class="alert alert-danger mt-2 mx-2">
              {{ session('error') }}
            </div>
          @endif
          @if(session('success'))
            <div class="alert alert-success mt-2 mx-2">
              {{ session('success') }}
            </div>
          @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
@endsection
