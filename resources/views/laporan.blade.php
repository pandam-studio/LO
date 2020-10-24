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
                      <input class="single-daterange form-control" placeholder="" type="text" name="from">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">To </label>
                    <div class="date-input">
                      <input class="single-daterange form-control" placeholder="" type="text" name="to">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="element-content">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <button class="mr-2 mb-2 btn btn-outline-primary" type="submit">Download</button>                  </div>
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
