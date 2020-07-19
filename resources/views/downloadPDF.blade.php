<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th,
        table{
			font-size: 9pt;
            text-align: left;
            border: 1px solid black;
		}
	</style>
	<center>
		<h3>Laporan legalisir</h3>
	</center>
    <br>
    <div>
        Tanggal {{$tanggalSelesai}} sampai {{$tanggalSelesai}}
    </div>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				@foreach ($berkas as $b)
                    <th>{{$b->Nama_berkas}}</th>
                @endforeach
				
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($pegawai as $p)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->Nama}}</td>
				<td>{{$p->Email}}</td>
                
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>