<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" style="width: 100%; font-family: Arial, sans-serif;">
        <!-- Header Laporan -->
        <tr>
            <td colspan="7" style="text-align: center; padding: 15px; background-color: #2c3e50; color: white; font-size: 18px; font-weight: bold; border: 1px solid #2c3e50;">
                LAPORAN PROYEK THECONNECT
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center; padding: 8px; background-color: #34495e; color: white; font-size: 12px; border: 1px solid #2c3e50;">
                Periode &nbsp;: &nbsp; {{$periodeTitle}}
            </td>
        </tr>
        
        <!-- Spacer -->
        <tr>
            <td colspan="7" style="height: 10px;"></td>
        </tr>
        
        <!-- Info Laporan -->
        <tr>
            <td colspan="3" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px;">
                <strong>Tanggal Cetak : &nbsp;</strong> {{\Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y')}}
            </td>
            <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px;">
                <strong>Periode : &nbsp;</strong> {{$periode}}
            </td>
            <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px;">
                <strong>Total Proyek : &nbsp;</strong> ({{count($project)}}) Proyek
            </td>
        </tr>
        
        <!-- Spacer -->
        <tr>
            <td colspan="7" style="height: 10px;"></td>
        </tr>
        
        <!-- Header Tabel -->
        <tr>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; text-align: center; border: 1px solid #2c3e50; font-size: 12px;">No</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Nama Proyek</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Deskripsi</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Tanggal Mulai</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Tanggal Selesai</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; text-align: center; border: 1px solid #2c3e50; font-size: 12px;">Presentase</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">PIC</td>
        </tr>
        
        <!-- Data Row 1 -->
        @foreach($project as $i => $row)
        <tr>
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{$i + 1}}</td>
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{$row->title}}</td>
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{$row->deskripsi}}</td>
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{\Carbon\Carbon::parse($row->start)->locale('id')->translatedFormat('d F Y')}}</td>
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{\Carbon\Carbon::parse($row->ended)->locale('id')->translatedFormat('d F Y')}}</td>

            @if(persentase_task($row->id_projects) == 100)
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #8feb34; font-size: 11px; color: #fff;">
                {{persentase_task($row->id_projects)}} % 
            </td>
            @else
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #f3f70c; font-size: 11px; color: black;">
                {{persentase_task($row->id_projects)}} % 
            </td>
            @endif
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{$row->users->name}}</td>
        </tr>
        @endforeach                                             
       
        
       
    </table>
</body>
</html>