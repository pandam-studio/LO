@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12">
      <div class="element-wrapper">
        <div class="element-box">
        <form id="formValidate" action="{{url('save/alumn i')}}">
              @csrf
            <h5 class="form-header">
              Input data
            </h5>
            <div class="form-desc" id="time">
            </div>
            <fieldset class="form-group">
              <legend><span>Data Alumni</span></legend>
              <div class="row justify-content-center">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label for="noalumni" class="col-sm-4 col-form-label">Nomor Alumni</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="noalumni" name="noalumni" placeholder="Nomor Alumni">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                  </div>
                </div>
              </div>
              <legend><span>Berkas</span></legend>
              @foreach ($berkas as $b)
                <div class="row justify-content-center">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label for="{{str_replace(' ','',$b->Nama_berkas)}}" class="col-sm-4 col-form-label">{{$b->Nama_berkas}}</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control" id="{{str_replace(' ','',$b->Nama_berkas)}}" nama="{{str_replace(' ','',$b->Nama_berkas)}}" placeholder="{{$b->Nama_berkas}}">
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </fieldset>
            <div class="form-buttons-w">
              <button class="btn btn-primary" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
            <Script>
                function set(){
                    let d = new Date();
                     document.getElementById("time").innerHTML= d.toLocaleString();
                     }
                 setInterval(set,1000);


            </Script>
@endsection
