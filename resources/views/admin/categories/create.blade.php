@extends('parent')

@section('title', 'Tambah Kategori')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Tambah Kategori</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
            </ol>
        </nav>
    </div>

    <div class="page-content">
        <section class="row">

            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Kategori</label>
                                <input type="file" class="form-control" id="image" name="image" required value="{{ old('image') }}">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>

                        </form>
                        
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
