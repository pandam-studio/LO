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
			padding-right: 10px;
		}
		table{
			border-collapse: collapse;
		}
	</style>
	<center>
		<h3>Laporan legalisir</h3>
	</center>
    <br>
    <div>
        Laporan tanggal : {{$tanggalMulai}} sampai {{$tanggalSelesai}}
	</div>
	<hr>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Code pengajuan</th>
				<th>Nama</th>
				@foreach ($berkas as $b)
                    <th>{{$b->Nama_berkas}}</th>
				@endforeach
				<th>Subtotal</th>
			</tr>
		</thead>
		<tbody>
			@php 
			$i=0;
			$total=0;
			$subtotal=0;
			@endphp
			@foreach($pengajuan as $p)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $p->Code }}</td>
				<td>{{$p->Alumni->Nama}}</td>
				@foreach ($berkas as $b)
					@foreach ($p->Berkas_Pengajuan as $bp)
						@php
							if($b->Id_berkas==$bp->Id_berkas){
								echo("<th>$bp->Jumlah_berkas</th>");
								$subtotal += $bp->Jumlah_berkas * $bp->Harga;
							}else{
								echo("<th>0</th>");
							}
						@endphp
					@endforeach
				@endforeach
				<td>Rp. {{ number_format($subtotal ,0,',','.')}}</td>
				@php
					$total += $subtotal;
					$subtotal=0;
				@endphp
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>
	<div>
        Jumlah pengajuan = {{$i}}
	</div>
	<br>
	<div>
		Total Pemasukan =Rp. {{ number_format($total ,0,',','.')}}
	</div>
</body>
</html>