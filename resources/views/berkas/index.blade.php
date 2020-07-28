  @extends('layouts.main')

  @section('head')
    <meta name="_token" content="{{ csrf_token() }}"/>
  @endsection

  @section('content')
  <div class="element-wrapper">
    <h6 class="element-header">
      Data Berkas
    </h6>
    <div class="element-box">
      <h6 class="element-header">
        <button class="btn btn-primary" id="add"><i class="fa fa-plus"></i> Tambah Data</button>
      </h6>
      <div class="table-responsive">
        <table id="x" width="100%" class="table table-striped table-lightfont">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Berkas</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($berkas as $b)
            <tr>
              <th>{{$i++}}</th>
              <th>{{$b->Nama_berkas}}</th>
              <th>{{$b->Harga}}</th>
              <th><a href="#" class="btn btn-success js-edit" data-id="{{$b->Id_berkas}}" data-nama="{{$b->Nama_berkas}}" data-harga="{{$b->Harga}}"><i class="os-icon os-icon-edit-32"></i></a>
                <a href="#" class="btn btn-danger js-delete" data-id="{{$b->Id_berkas}}" ><i class="os-icon os-icon-ui-15"></i></a></th>
            </tr>    
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
    <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Berkas</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
              <form>
                  <input type="hidden" id="id">
                  <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Nama Berkas</label>
                      <div class="col-sm-7">
                          <input class="form-control" id="nama">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Harga</label>
                      <div class="col-sm-7">
                          <input type="number" class="form-control" id="harga">
                      </div>
                  </div>
                </form>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save">Save</button>
          </div>
      </div>
      </div>
  </div>
  @endsection
  @section('script')
    <script>
    $(document).ready(function () {
      $('#x').DataTable();
    
      $('.js-edit').click(function (e) { 
        e.preventDefault();
        let id= $(this).data('id');
        let nama = $(this).data('nama');
        let harga=$(this).data('harga')
        $('#id').val(id);
        $('#nama').val(nama);
        $('#harga').val(harga);
        $('#modal').modal("show");
      });

      $('.js-delete').click(function (e) { 
        e.preventDefault();

        let id = $(this).data('id');
        let url ="{{url('berkas/delete')}}"+"/"+id;
        swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this record!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                fetch(url),
                swal("Poof! Your record has been deleted!", {
                  icon: "success",
                }).then(()=>location.reload());
              } else {
                swal("Your record is safe!");
              }
            });
      });

      $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      $('#save').click(function (e) { 
        e.preventDefault();
        
        let id = $('#id').val();
        let nama = $('#nama').val();
        let harga = $('#harga').val();

        $.post("{{route('tambahBerkas')}}", {id:id,nama:nama,harga:harga},
          
          function (data) {
            if(data!==""){
              swal(data.messageTitle,data.message,data.result).then(()=>location.reload());
            }else{
              swal('Error!','please try again!','error');
            }
          },
          "json"
        );
      });

      $('#add').click(function (e) { 
        e.preventDefault();
        $('#id').val("");
        $('#nama').val("");
        $('#harga').val("");
        $('#modal').modal("show");
      });
    });//DocReady  
      
  </script>

  <script src="admin/js/dataTables.bootstrap4.min.js"></script>
  @endsection