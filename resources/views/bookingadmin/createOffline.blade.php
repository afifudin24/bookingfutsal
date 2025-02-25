@extends('layout.master')

@section('judul')
    Booking Offline
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @if ($data->status == 'Tidak Aktif')
                <div class="modal-body">
                    <h3>Lapangan Tutup</h3>
                </div>

            </div>
            </div>
            </div>
        @else
            <div class="modal-body">
                @if (auth()->user()->type == 'user')
                    <form action="{{ url('booking/create')}}" method="POST">
                @endif
                    @if (auth()->user()->type == 'admin')
                        <form action="{{ url('bookingadmin/create')}}" method="POST">
                    @endif

                        @csrf
                        <div class="col-xxl">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <h4 class="fw-bold py-2 mb-2"><span class="text-muted fw-light">Booking Offline</h4>

                                    <p class='badge badge-warning'>Futsal</p>
                                    <ul class="list-bullets">
                                        <li class="mb-2"> Siang : @currency($data->harga)</li>
                                        <li class="mb-2"> Malam : @currency($data->harga + 40000)</li>

                                    </ul>
                                    <p class='badge badge-warning'>Bulu Tangkis</p>
                                    <ul class="list-bullets">
                                        <li class="mb-2"> Siang dan malam : @currency(30000)</li>


                                    </ul>


                                    <label for="lapangan_id">Lapangan</label>
                                    <select name="lapangan_id" id="lapangan_id" class="form-control">
                                        @foreach ($lapangan as $item)
                                            <option data-value="{{$item}}" value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('lapangan_id')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-group mb-2">
                                        <label for="time_from">Jam Mulai</label>
                                        <input type="text" class="form-control datetimepicker" id="time_from" name="time_from"
                                            value="{{ old('time_from') }}" />
                                        @error('time_from')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="time_to">Jam Berakir</label>
                                        <input type="text" class="form-control datetimepicker" id="time_to" name="time_to"
                                            value="{{ old('time_to') }}" />
                                        @error('time_to')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <label for="total" id="total" class="">Total Bayar : <span
                                            id="totalbayar">@currency($data->harga)</span></label>

                                    <div class="row p-2">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        @endif
    </div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    {{--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/id.js"></script>
    <script>
        let textharga = {{$data->harga}};
        let lapanganNama = "{{$lapangan[0]->nama}}";
        console.log(lapanganNama);

        document.addEventListener('DOMContentLoaded', function () {

            $("#lapangan_id").on('change', function () {
                let selectedOption = $(this).find(":selected").data("value");
                console.log(selectedOption);
                let harga = selectedOption.harga;
                textharga = harga;
                lapanganNama = selectedOption.nama;
                $('#totalbayar').html(`Rp. ${harga.toLocaleString()}`);

            });



            if (@js($errors->any())) {
                $('#exampleModal').modal('show');
            }

        });
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:00',
            locale: 'id',
            sideBySide: true,
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
            },
            minDate: new Date,
            stepping: 10,
            disabledHours: [0, 1, 2, 3, 4, 5, 6]
        });
        $('.datetimepicker').on('dp.change', e => {
            const timefrom = moment($('#time_from').val());
            const timeto = moment($('#time_to').val());


            const start = +timefrom.format('H');
            const end = +timeto.format('H');

            const harga = textharga;

            let total = 0;
            for (let i = start; i < end; i++) {
                if (lapanganNama == 'Lapangan Futsal') {

                    if (i < 17) {
                        total += +harga;
                    } else {
                        total += (+harga + 40000);
                    }
                } else {
                    total += +harga;
                }
            }

            $('#totalbayar').text('Rp. ' + Intl.NumberFormat().format(total));
            $('#dp').text('Rp. ' + Intl.NumberFormat().format(total / 2));
        })
    </script>
@endsection