@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12">
      <div class="element-wrapper">
        <h6 class="element-header">
          Kelola Status
        </h6>

        <div class="element-box-tp">
          <!--------------------
          START - Controls Above Table
          -------------------->
          <div class="controls-above-table">
            <div class="row">
              <div class="col-sm-6">
                <form class="form-inline justify-content-sm-start" id="form">
                  <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text" name="search" value="{{ old('search') }}">
                  <button class="btn btn-primary" type="submit">Cari</button>
                </form>
              </div>
              <div class="col-sm-6">
                <form class="form-inline justify-content-sm-end">
                  <select class="form-control form-control-sm rounded bright" 
                   name="status" onChange="this.form.submit()">
                    @foreach($status as $s)
                        <option value="{{$s->Id_status}}" 
                          {{($s->Id_status==$selected)?"selected":""}}
                          > {{$s->Keterangan}} </option>
                    @endforeach
                  </select>
                </form>
              </div>
            </div>
          </div>
          <!--------------------
          END - Controls Above Table
          ------------------          --><!--------------------
          START - Table with actions
          ------------------  -->
          <div class="table-responsive">
            <table class="table table-bordered table-lg table-v2 table-striped">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                    <th>Code Pengajuan</th>
                    <th>No Alumni</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Tgl Pengajuan</th>
                    <th>Tgl Pengambilan</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                 @php
                $start = ($pengajuan->perPage() * $pengajuan->currentPage()) - ($pengajuan->perPage()-1)
                @endphp
                @foreach ($pengajuan as $item)
                <tr class="text-center">
                  <td >{{ $start++ }}</td>
                  <td >{{ $item->Code }}</td>
                  <td >{{ $item->Alumni->No_alumni }}</td>
                  <td >{{ $item->Alumni->Nama }}</td>
                  <td>{{$item->Status->Keterangan}}</td>
                  <td>{{$item->Tgl_masuk}}</td>
                  <td>{{$item->Tgl_keluar}}</td>

                  <td class="row-actions">
                    <a class="detail" data-id="{{$item->Id_pengajuan}}"
                        data-nama="{{$item->alumni->Nama}}"
                        data-email="{{$item->alumni->Email}}"
                        data-status="{{$item->Id_status}}" href="#"><i class="os-icon os-icon-ui-49"></i></a>
                    <a class="danger" data-id="{{$item->Id_pengajuan}}" href="#"><i class="os-icon os-icon-ui-15"></i></a>
                    @if(empty($item->Tgl_keluar))
                      <a class="btn btn-success text-white ambil" data-id="{{$item->Id_pengajuan}}" href="#">Ambil berkas</a>                        
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!--------------------
          END - Table with actions
          ------------------            --><!--------------------
          START - Controls below table
          ------------------  -->
          <div class="controls-below-table">
            <div class="table-records-info">
              Showing records {{($pengajuan->perPage() * $pengajuan->currentPage()) - ($pengajuan->perPage()-1)}} - {{$start-1}}
            </div>
            <div class="table-records-pages">
                {{ $pengajuan->links()}}
            </div>
          </div>
          <!--------------------
          END - Controls below table
          -------------------->
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pengajuan </h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="hidden">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <label class="col-sm-2 col-form-label" id="Nama"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <label class="col-sm-2 col-form-label" id="Email"></label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="Status" name="Status">
                                @foreach($status as $s)
                                    <option value="{{$s->Id_status}}">{{$s->Keterangan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="Detail">

                    </div>
                  </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save">Save changes</button>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $('.danger').click(function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        var url ="{{url('pengajuan/delete')}}"+"/"+id;
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                fetch(url),
                swal("Poof! Your data has been deleted!", {
                icon: "success",
                }).then(()=>{
                    location.reload()
                });
            } else {
                swal("Your data is safe!");
            }
            });
    });


    $('.ambil').click(function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        $.get("{{route('ambil')}}", {idPeng:id},
            function (data) {
                if(data!=""){
                    swal("Data saved!", "Berkas di ambil", "success").then(()=>{
                        location.reload();
                    });
                }else{
                    swal("Failed to save", "please try again!", "error");
                }
            },
            "json"
        );
    });

    $('#save').click(function (e) {
        e.preventDefault();
        let Status = $('#Status').val();
        let id=$('#hidden').val();
        $.get("{{route('updateStatus')}}", {idPeng:id, status:Status},
            function (data) {
                if(data!=""){
                    swal("Data saved!", "Status Updated!", "success").then(()=>{
                        location.reload();
                    });
                }else{
                    swal("Failed to save", "please try again!", "error");
                }
            },
            "json"
        );
    });

    $('.detail').click(function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let email = $(this).data('email');
        let nama = $(this).data('nama');
        let status= $(this).data('status');
        $('#Nama').html(nama);
        $('#Email').html(email);
        $('#Status').val(status);
        $('#hidden').val(id);

        $.getJSON("{{route('getDetail')}}",{Id_pengajuan:id},
            function (data) {
                let html = "";
                let total =0;
                data.forEach(e => {
                    html +=
                    `<div class="form-group row">
                        <label class="col-sm-4 col-form-label">`+ e.Nama_berkas +`</label>
                        <label class="col-sm-4 col-form-label">`+ e.Jumlah_berkas+` lembar</label>
                        <label class="col-sm-4 col-form-label"> Rp. `+(e.Jumlah_berkas * e.Harga).toLocaleString('id-ID')+`</label>
                    </div>`;
                   total+=e.Jumlah_berkas * e.Harga;
                });
                html +=
                `<hr>
                <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Total Pembayaran : </label>
                        <label class="col-sm-4 col-form-label"> Rp. `+total.toLocaleString('id-ID'); +`</label>
                    </div>`
                $('#Detail').html(html);
            }
        );
        $('#modal').modal('show');

    });
</script>
@endsection