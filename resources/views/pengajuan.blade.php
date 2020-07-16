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
                <a class="btn btn-sm btn-secondary" href="#">Download CSV</a><a class="btn btn-sm btn-secondary" href="#">Archive</a><a class="btn btn-sm btn-danger" href="#">Delete</a>
              </div>
              <div class="col-sm-6">
                <form class="form-inline justify-content-sm-end">
                  <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text"><select class="form-control form-control-sm rounded bright">
                    <option selected="selected" value="">
                      Select Status
                    </option>
                    <option value="Pending">
                      Pending
                    </option>
                    <option value="Active">
                      Active
                    </option>
                    <option value="Cancelled">
                      Cancelled
                    </option>
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
                  <td class="row-actions">
                    <a class="detail" data-id="{{$item->Id_pengajuan}}" href="#"><i class="os-icon os-icon-ui-49"></i></a>
                    <a class="update" data-id="{{$item->Id_pengajuan}}" href="#" ><i class="os-icon os-icon-grid-10"></i></a>
                    <a class="danger" data-id="{{$item->Id_pengajuan}}" href="#"><i class="os-icon os-icon-ui-15"></i></a>
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
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
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
                swal("Poof! Your data has been deleted!", {
                icon: "success",
                }).then((value)=>{
                    return fetch(url);
                });
            } else {
                swal("Your data is safe!");
            }
            });
    });

    $('.detail').click(function (e) {
        e.preventDefault();
        $('#modal').modal('show');

    });
</script>
@endsection
