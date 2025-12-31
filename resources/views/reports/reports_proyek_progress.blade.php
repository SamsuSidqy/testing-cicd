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
                LAPORAN PROGRESS PROYEK
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center; padding: 8px; background-color: #34495e; color: white; font-size: 12px; border: 1px solid #2c3e50;">
                PIC ({{$project->users->name}})
            </td>
        </tr>
        
        <!-- Spacer -->
        <tr>
            <td colspan="7" style="height: 10px;"></td>
        </tr>
        
        <!-- Info Laporan -->
        <tr>
            <td colspan="3" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px;">
                <strong>Tanggal Cetak : </strong> {{\Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y')}}
            </td>
            <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px;">
                <strong>Nama Proyek : </strong> &nbsp;{{$project->title}}
            </td>
            <td colspan="2" style="padding: 8px; background-color: #ecf0f1; border: 1px solid #bdc3c7; font-size: 11px;">
                <strong>Total Tasks : </strong> &nbsp;({{count($task)}}) Tasks
            </td>
        </tr>
        
        <!-- Spacer -->
        <tr>
            <td colspan="7" style="height: 10px;"></td>
        </tr>
        
        <!-- Header Tabel -->
        <tr>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; text-align: center; border: 1px solid #2c3e50; font-size: 12px;">No</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px; width:150px;">Nama Tasks</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Pelaksana</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Deadline</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Pengerjaan</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Status</td>
            <td style="padding: 10px; background-color: #34495e; color: white; font-weight: bold; border: 1px solid #2c3e50; font-size: 12px;">Terakhir Updated</td>
        </tr>
        
        <!-- Data Row 1 -->
        @foreach($task as $i => $row)
        <tr>
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{$i + 1}}</td>
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{$row->name}}</td>
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{$row->anggota->name}}</td>
            <td style="padding: 8px; text-align: right; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{\Carbon\Carbon::parse($row->deadline)->locale('id')->translatedFormat('d F Y')}}</td>

            @if($row->status === 'Completed')
                @if($row->extend_deadline)
                <td style="padding: 8px; text-align: center; border: 1px solid #ddd; 
                background-color: #e0e330; font-size: 11px; color:black;">
                    Penambahan Waktu                
                </td>
                @else
                <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #2debe7; font-size: 11px; color:black;">
                    Tepat Waktu                
                </td>
                @endif            
            @else
             <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #e1eb31; font-size: 11px; color:black;">
                ON Progress               
            </td>
            @endif

            @if($row->status === 'Completed')
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #13d90f; font-size: 11px; color:black;">
                Completed                
            </td>
            @else
            <td style="padding: 8px; text-align: center; border: 1px solid #ddd; background-color: #e1eb31; font-size: 11px; color:black;">
                Progress                
            </td>
            @endif

            @if($row->activity)
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">{{\Carbon\Carbon::parse($row->activity->created_at)->locale('id')->translatedFormat('d F Y, H:i:s')}} WIB</td>
            @else
            <td style="padding: 8px; border: 1px solid #ddd; background-color: #ffffff; font-size: 11px;">Belum Ada Aktifitas</td>
            @endif
        </tr>                                  
        @endforeach 
       
    </table>
</body>
</html>