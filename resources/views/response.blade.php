@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="element-wrapper">
            <div class="element-box">

                <div class="row">
                    <div class="alert alert-primary text-white" role="alert">
                        Data Berhasil Disimpan!
                    </div>
                </div>
                    @php
                        $total = 0;
                    @endphp
                      <div class="row">
                        <div class="col-4">Nama</div>
                        <div class="col-2">Harga satuan</div>
                        <div class="col-2">Jumlah</div>
                        <div class="col-4">Harga subTotal</div>
                    </div>
                    <hr>

                    @foreach ($data as $d)
                    <div class="row">
                        <div class="col-4">{{$d->Nama_berkas}} </div>
                        <div class="col-2">{{$d->Harga}}</div>
                        <div class="col-2">{{$d->Jumlah_berkas}}</div>
                        <div class="col-4"> {{$total += $d->Jumlah_berkas*$d->Harga}}</div>
                    </div>
                    <hr>
                    @endforeach

                <strong>Total Pembayaran : Rp. {{$total}}</strong>

            </div>
        </div>
    </div>
  </div>
@endsection
