@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12">
      <div class="element-wrapper">
        <h6 class="element-header">
          Recent Orders
          @dump($pengajuan)
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
                  <th class="text-center">
                    No
                  </th>
                  <th>
                    No Alumni
                  </th>
                  <th>
                    Nama
                  </th>
                  <th>
                    Ijazah
                  </th>
                  <th>
                    Transkrip
                  </th>
                  <th>
                    Status
                  </th>
                  <th>
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody>
                 @php
                $start = ($pengajuan->perPage() * $pengajuan->currentPage()) - ($pengajuan->perPage()-1)
                @endphp
                @foreach ($pengajuan as $item)
                <tr class="text-center">
                  <td >
                    {{ $start++ }}
                  </td>
                  <td >
                    {{ $item->Alumni->No_alumni }}
                  </td>
                  <td >
                    {{ $item->Alumni->Nama }}
                  </td>
                  <td >
                    @foreach ($item->Berkas_Pengajuan as $i)
                        @if ($i->Id_berkas==1)
                            {{$i->Jumlah_berkas}}
                        @endif
                      @endforeach
                  </td>
                  <td >
                      @foreach ($item->Berkas_Pengajuan as $i)
                        @if ($i->Id_berkas==2)
                            {{$i->Jumlah_berkas}}
                        @endif
                      @endforeach
                  </td>
                  <td >
                    {{$item->Status->Keterangan}}
                  </td>
                  <td class="row-actions">
                    <a href="#"><i class="os-icon os-icon-ui-49"></i></a><a href="#"><i class="os-icon os-icon-grid-10"></i></a><a class="danger" href="#"><i class="os-icon os-icon-ui-15"></i></a>
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
@endsection
