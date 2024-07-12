@extends('layouts.dashboard')

@section('title', 'Edit Alternatif')

@section('content')
<div class="content col bg-light">
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <h3 class="ms-4 me-2 text-dark fw-bold">Sistem Pendukung Keputusan Penilaian Pelayanan Hotel Terbaik</h3>
        <div class="dropdown me-4">
            <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-person-fill-gear">
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

    <div class="ms-4 me-4 bg-white rounded-3 shadow mb-4 p-4" style="height: 87vh;">
        <h2 class="text-primary mb-4">Edit Alternatif</h2>
        <form action="{{ url("dashboard/$alt->id") }}" method="POST">
            @method('PATCH')
            @csrf
            
            <div class="mb-3">
                <label for="alternatif" class="form-label fs-5">Alternatif</label>
                <input type="text" class="form-control" id="alternatif" name="alternatif" value="{{ $alt->a }}">
                @if($errors->has('alternatif'))
                    <div class="alert alert-danger mt-1">
                        {{ $errors->first('alternatif') }}
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label fs-5">Kriteria</label>
                <div class="d-flex justify-content-around flex-wrap">
                    @foreach(['Fasilitas', 'Interaksi', 'Teknologi', 'Keamanan', 'Tanggung Jawab'] as $index => $kriteria)
                        <div class="card text-center bg-light border-info mb-3" style="width: 18%;">
                            <div class="card-body">
                                <h5 class="card-title text-dark">{{ $kriteria }}</h5>
                                <select class="form-select" name="c{{ $index + 1 }}">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" @if($kr->{'c' . ($index + 1)} === $i) selected @endif>
                                            @if($i == 5) Sangat Tinggi
                                            @elseif($i == 4) Tinggi
                                            @elseif($i == 3) Cukup
                                            @elseif($i == 2) Rendah
                                            @else Sangat Rendah @endif
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('dashboard') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>