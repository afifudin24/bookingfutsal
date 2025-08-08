@extends('layout.master')

@section('judul')

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Laporan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <form action="{{ route('laporan.index') }}" method="GET">

                                <div class="row pb-3 d-flex align-items-end">
                                    <div class="col-md-3">
                                        <label>Start date</label>
                                        <input type="date" name="start_date" class="form-control"
                                            value="{{ request()->query('start_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>End date</label>
                                        <input type="date" name="end_date" class="form-control"
                                            value="{{ request()->query('end_date') }}">
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn mx-1 btn-primary me-2">Filter</button>
                            </form>
                            <!-- gunakan form post untuk export -->
                            <form action="{{ route('laporan.export') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ request()->query('start_date') }}" name="start_date">
                                <input type="hidden" value="{{ request()->query('end_date') }}" name="end_date">
                                <button type="submit" class="btn mx-1 btn-success">Export</button>
                            </form>
                        </div>
                    </div>

                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Konfirmasi</th>
                                <th>Cara Bayar</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $item)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal_konfirmasi }}</td>
                                    <td>{{ $item->cara_bayar }}</td>
                                    <td>{{ $item->total_harga }}</td>

                                </tr>

                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Konfirmasi</th>
                                <th>Cara Bayar</th>
                                <th>Total Harga</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection