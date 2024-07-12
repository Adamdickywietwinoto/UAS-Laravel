@extends('layouts.dashboard')

@section('title')
  Dashboard
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
        </div>
      </div>
    </div>
    <div class="ms-4 me-4 pt-3 bg-secondary rounded-3 shadow me-2 mb-3 px-3 bg-secondary" style="height: 87vh;">
      <div class="ps-1 d-inline align-items-center">
        <div class="d-inline">
          <a href="{{ url('tambah-alter') }}" class="btn btn-success bg-info text-white">Tambah Alternatif</a>
        </div>
        <form action="{{ url('dashboard/cari')}}" class="d-inline ms-2" method="GET">
          <input type="text" name="cari" placeholder="Cari Alternatif .." class="form-control w-50 d-inline pb-2" value="{{ old('cari') }}">
          <button type="submit" class="btn btn-info text-white ms-2">Cari</button>
        </form>
        <div class="d-inline">
          <a href="{{ url('dashboard') }}" class="btn btn-info text-light">Refresh</a>
        </div>
      </div>
      <div class="mx-1 pt-2 gap-2">
        <table class="table text-center border rounded-3 align-items-center">
          <thead>
            <tr>
              <th class="col">No.</th>
              <th class="col">Alternatif</th>
              <th class="col">Fasilitas</th>
              <th class="col">Interaksi</th>
              <th class="col">Teknologi</th>
              <th class="col">Keamanan</th>
              <th class="col">Tanggung Jawab</th>
              <th class="col-2">Setting</th>
            </tr>
          </thead>
          @php
            $i = $alts->firstItem();
          @endphp
          <tbody>
          @foreach ($alts as $alt)
            @if (isset($krs[$alt->id]))
              <tr>
                <td>{{ $loop->iteration + ($alts->currentPage() - 1) * $alts->perPage() }}</td>
                <td>{{ $alt->a }}</td>
                <td>{{ $krs[$alt->id]->c1 }}</td>
                <td>{{ $krs[$alt->id]->c2 }}</td>
                <td>{{ $krs[$alt->id]->c3 }}</td>
                <td>{{ $krs[$alt->id]->c4 }}</td>
                <td>{{ $krs[$alt->id]->c5 }}</td>
                <td>
                <head>
  <!-- Link FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<div class="d-flex gap-2 justify-content-center">
  <a href='{{ "dashboard/$alt->id/edit" }}' class="btn btn-secondary p-1">
    <i class="fas fa-edit" style="font-size: 20px; color: white;"></i>
  </a>
  <button class="btn btn-danger p-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $alt->id }}">
    <i class="fas fa-trash-alt" style="font-size: 20px; color: white;"></i>
  </button>
</div>
                            
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal{{ $alt->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $alt->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteModal{{ $alt->id }}">Hapus {{ $alt->a }}?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            <form action="{{ url("dashboard/$alt->id") }}" method="POST">
                              @method('DELETE')
                              @csrf
                              <button class="btn btn-danger" type="submit">Ya</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @endif
          @endforeach
          </tbody>
        </table>
      </div>
      <div class="fs-5">
        {{ $alts->links('vendor.pagination.bootstrap-5') }}
      </div>
    </div>
@endsection
