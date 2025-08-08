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
                            <h3 class="card-title">Halaman Feedback</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- jika ada session feedback maka tampilkan -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            @endif
                            <!-- buat form feedback -->
                            <form action="/feedback" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="feedback">Feedback</label>
                                    <!-- pake textarea -->
                                    <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                                    <!-- <input type="text" class="form-control" id="feedback" name="feedback"> -->
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>

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