@extends('layouts.main')

@section('head')
  <meta name="_token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div class="element-wrapper">
  <h6 class="element-header">
    Data Admin
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
            <th>Nik</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($admin as $a)
          <tr>
            <th>{{$i++}}</th>
            <th>{{$a->nik}}</th>
            <th>{{$a->nama}}</th>
            <th>{{$a->email}}</th>
            <th><a href="#" class="btn btn-success js-edit" data-id="{{$a->id_user}}" data-nik="{{$a->nik}}" data-nama="{{$a->nama}}" data-email="{{$a->email}}"><i class="os-icon os-icon-edit-32"></i></a>
              <a href="#" class="btn btn-danger js-delete" data-id="{{$a->id_user}}" ><i class="os-icon os-icon-ui-15"></i></a></th>
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
        <h5 class="modal-title" id="exampleModalLabel">Admin</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" id="id">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nik</label>
                  <div class="col-sm-7">
                      <input type="number" class="form-control" maxlength="10" id="nik">
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-7">
                        <input class="form-control" id="nama">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" id="email">
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Password</label>
                  <div class="col-sm-7">
                      <input type="password" class="form-control" id="password" min="6">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Password Confirm</label>
                  <div class="col-sm-7">
                      <input type="password" class="form-control" id="password1" min="6">
                  </div>
                </div>
             
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save</button>
        </div>
      </form>
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
      let nik=$(this).data('nik');
      let nama = $(this).data('nama');
      let email=$(this).data('email');
      $('#id').val(id);
      $('#nik').val(nik);
      $('#nama').val(nama);
      $('#email').val(email);
      $('#modal').modal("show");
    });

    $('.js-delete').click(function (e) { 
      e.preventDefault();

      let id = $(this).data('id');
      let url ="{{url('adminx/delete')}}"+"/"+id;
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

    $('#email').blur(function (e) { 
      e.preventDefault();
      let email =$(this).val();
      let id = $('#id').val();
      $.getJSON("{{url('/validateEmail')}}", {id:id,email:email},
        function (data, textStatus, jqXHR) {
          if(data.result=="error"){
            swal('error!',data.message,data.result).then(()=>{$('#email').focus()});
            $('#save').attr('disabled',true);
          }else{
            // swal('ok!',data.message,'info');
            $('#save').attr('disabled',false);
          }
        }
      );
    });

    function cekField(){
      let idEl = $('#id');
      let nikEl = $('#nik');
      let namaEl = $('#nama');
      let emailEl = $('#email');
      let passwordEl =$('#password');
      let password1El =$('#password1');

      let id = idEl.val();
      let nik = nikEl.val();
      let nama = namaEl.val();
      let email = emailEl.val();
      let password = passwordEl.val();
      let password1 =password1El.val();

      if(nik==""|| isNaN(nik)){
        swal('error!','please input field nik!','error').then(()=>{
        nikEl.focus();
        });
        return false;
      }

      if(nama==""){
        swal('error!','please input field nama!','error').then(()=>{
        namaEl.focus();
        
        });
        return false;
      }

      if(email==""){
        swal('error!','please input field email!','error').then(()=>{
        emailEl.focus();
        });
        return false;
      }

      if(id==""){
        if(password==""){
          swal('error!','please input field password!','error').then(()=>{
          passwordEl.focus();
          });
          return false;
        }
        if(password1==""){
          swal('error!','please input field password confirmation!','error').then(()=>{
          password1El.focus();
          });
          return false;
        }
      }
      
      if(email.indexOf('@')<1 || email.lastIndexOf('.')<1){
        swal('error!','invalid email!','error').then(()=>{
        emailEl.focus();
        });
        return false;
      }

      if(password!=password1){
        swal('error!','password doesn`t match!','error').then(()=>{
          password1El.focus();
        });
          return false;
      }

      if(password!=""){
        if(password.length <6){
          swal('error!','minimum password is 6 character!','error').then(()=>{
          password1El.focus();
          });
          return false;
        }
      }

      return true;
    }

    $('#save').click(function (e) { 
      e.preventDefault();
      
      if(cekField()){
        let id = $('#id').val();
        let nik = $('#nik').val();
        let nama = $('#nama').val();
        let email = $('#email').val();
        let password =$('#password').val();
        let password1 =$('#password1').val();

        $.post("{{route('tambahUser')}}", {id:id,nik:nik,nama:nama,email:email,password:password,password1:password1},          
          function (data,textStatus, xhr) {

            // console.log( xhr +'sad'+textStatus);
            if(data!==""){
              swal(data.messageTitle,data.message,data.result).then(()=>location.reload());
            }else{
              swal('Error!','please try again!','error');
            }
          },
          "json"
        );
      }
    });

    $('#add').click(function (e) { 
      e.preventDefault();
      $('#id').val("");
      $('#nik').val("");
      $('#nama').val("");
      $('#email').val("");
      $('#password').val("");
      $('#password').val("");

      $('#modal').modal("show");
    });
  });//DocReady  
     
</script>

<script src="admin/js/dataTables.bootstrap4.min.js"></script>
@endsection