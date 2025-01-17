@extends('parent')

@section('title', 'Produk Galeri')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Produk Galeri</h3>
    </div>

    <div class="page-content">
        <section class="row">

            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12">
                            <a href="{{ route('admin.product.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <a href="{{ route('admin.product.gallery.create', $product->id) }}" class="btn btn-primary mb-3">Tambah
                                Produk Galeri</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $row)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <img src="{{ asset('storage/products/gallery/' . $row->image) }}" alt="{{ $row->name }}"
                                                    width="100">
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.product.gallery.destroy', [$product->id, $row->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm show_confirm"
                                                        data-name="{{ $row->name }}">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        var $ = jQuery;
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>

@endsection


@push('script')
    <script src="{{ asset('assets/admin/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/static/js/pages/datatables.js') }}"></script>
@endpush
