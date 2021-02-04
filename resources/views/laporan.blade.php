@extends('layouts.main')

@section('content')
<div class="row"  style="height: 100%">
    <div class="col-sm-12">
      <div class="element-wrapper">
        <h6 class="element-header">
          Laporan
        </h6>
        <div class="element-box-tp">
          <div class="element-content">
            <div class="row">
              <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="#">
                  <div class="label">
                    On process
                  </div>
                  <div class="value">
                    {{$op}}
                  </div>
                </a>
              </div>
              <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="#">
                  <div class="label">
                    Ready to pickup
                  </div>
                  <div class="value">
                    {{$rtp}}
                  </div>
                </a>
              </div>
              <div class="col-sm-4 col-xxxl-3">
                <a class="element-box el-tablo" href="#">
                  <div class="label">
                    Done
                  </div>
                  <div class="value">
                    {{$done}}
                  </div>
                </a>
              </div>
            </div>

          <form action="{{route('downloadPDF')}}">
            <div class="element-content">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">From </label>
                    <div class="date-input">
                      <input class="single-daterange form-control" id="from" placeholder="" type="text" name="from">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">To </label>
                    <div class="date-input">
                      <input class="single-daterange form-control" id="to" placeholder="" type="text" name="to">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="element-content">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <button class="mr-2 mb-2 btn btn-outline-primary" type="button" id='cetak'>cetak</button>                  </div>
                </div>
              </div>
            </div>
          </form>
          </div>
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
      <img style="width:80px;height:80px;float:left;margin:20px 0 -130px 50px;" src="https://akupintar.id/documents/20143/0/UNIVERSITAS+MUHAMMADIYAH+MAGELANG.png/045ba160-2c81-bef2-a70a-bbc53b7eb988?version=1.0&t=1518537517784&imagePreview=1">
      <center><h5 class="text-center col-md-10" id="topheader" style="word-wrap">TATA USAHA FAKULTAS TEKNIK UNIVERSITAS MUHAMMADIYAH MAGELANG</h5></center>
				<p class="text-center" style="font-size:18px" id="subheader">Jl. Mayjend. Bambang Soegeng, Mertoyudan, Magelang 56172</p>
        <br>
          <hr style="border:3px double #dedede;margin-top:30px">
				<p class="font-weight-bold text-center"><em>LAPORAN LAGALISIR PERIODE,</em><br><span class="nomor" id="nomor"></span></p>

      <div class="table-responsive">
          <table class="table table-bordered"  width="100%" cellspacing="0">
            <thead>
              <tr>
                  <th>No</th>
                  <th>Kode Pengajuan</th>
                  <th>No alumni</th>
                  <th>Nama</th>
                  <th>tgl legalisir</th>
                  <th>tgl ambil</th>
                  <th>sub Total</th>
              </tr>
            </thead>
            <tbody id='table-body'>
            </tbody>
          </table>
          <table class="table table bordered" style="width:100%;table-layout:fixed;">
            <tbody><tr>
                <td class="border-0"></td>
                <td class="border-0 text-left">Total :</td>
                <td class="border-0 text-right"><span id="daerah"></span>, <span class="font-weight-bold tanggal" id="tanggal"></span><br>Magelang, {{ date('d-F-Y',time())}} <br>Petugas TU<br><br><br>{{Auth::user()->nama}}<br>NIK. {{Auth::user()->nik}}<span class="nik" id="nik"></span></td>
              </tr>
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
      let id = $(this).data('id');
      let from = $('#from').val();
      let to = $('#to').val();
      let no =0;
      let tableBody='';
      let alamat ='';
      $.ajax({
        type: "GET",
        url: "{{route('downloadPDF')}}",
        data: {from:from,to:to},
        dataType: "JSON",
        success: function (response) {
          console.log(response);
          const months = ["Januari", "Februari", "Maret","April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
          let formatFrom = new Date(from);
          let formatTo = new Date(to);
          $('#nomor').html(''+ formatFrom.getDate()+'-'+months[formatFrom.getMonth()] +'-'+ formatFrom.getFullYear() +' sampai ' + formatTo.getDate()+'-'+months[formatTo.getMonth()] +'-'+ formatTo.getFullYear() );
          // $('#subheader').html((response.type_unit_kerja.nama+" UMUM Daerah " +response.unit_kerja.daerah).toUpperCase());
          for(i in response.data.pengajuan ){
            let subtotal = 0;
            for(j in response.data.pengajuan[i].berkas__pengajuan ){
              subtotal += response.data.pengajuan[i].berkas__pengajuan[j].Harga_total
            }
            tableBody+='<tr>';
              tableBody+='<td>'+(no+=1)+'</td>';
              tableBody+='<td>'+response.data.pengajuan[i].Code+'</td>';
              tableBody+='<td>'+response.data.pengajuan[i].alumni.No_alumni+'</td>';
              tableBody+='<td>'+response.data.pengajuan[i].alumni.Nama+'</td>';
              tableBody+='<td>'+response.data.pengajuan[i].Tgl_masuk+'</td>';
              tableBody+='<td>'+response.data.pengajuan[i].Tgl_keluar+'</td>';
              tableBody+='<td>'+subtotal+'</td>';
            tableBody+='</tr>';
          }

          $('#table-body').html(tableBody);
          $('#myModal').modal("show");
        }
      });

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
