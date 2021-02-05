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
                        <div class="col-4"> {{$d->Harga_total}}</div>
                    </div>
                    <hr>
                    @php
                        $total +=$d->Harga_total;
                    @endphp
                    @endforeach

                <strong>Total Pembayaran : Rp. {{$total}}</strong>
                <button class="btn btn-primary ml-3" id="cetak">Cetak</button>

            </div>
        </div>
    </div>
  </div>
@endsection
@section('modal')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-print">

      <div class="table-responsive">
          <table class="table table-bordered "  width="100%" cellspacing="0">
            <tbody id='table-body' class="text-center">
            <tr>
            <td colspan="2">Tanda Terima Legalisir Unimma</td>
            </tr>
            <tr>
            <td colspan="2">{{$pengajuan->Tgl_masuk}}</td>
            </tr>
            <tr>
            <td>Kode Tracking</td>
            <td>{{$pengajuan->Code}}</td></tr>
            <tr>
            <td colspan="2">{{$pengajuan->Alumni->Nama}}</td>
            </tr>
            <tr>
            <td>Biaya</td>
            <td>Rp. {{$total}}</td>
            </tr>
            <tr>
            <td colspan="2">Link tracking</td>
            </tr>
            <tr><td colspan="2">{{ route('base') }}</a></td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="myPrint()">Print</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>

  $('#cetak').on('click',function(e){

    e.preventDefault();
          $('#myModal').modal("show");

   });
  function myPrint(){
      var printContents = document.getElementById("modal-print").innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
      document.location.reload();
      //window.print();
    }
</script>
@endsection
