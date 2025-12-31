
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Log Error Report</title>
</head>
<body>

<h3>Log Request</h3>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="background-color:#CBCBCB;">ID</th>
      <th style="background-color:#CBCBCB;">Method</th>
      <th style="background-color:#CBCBCB;">Type</th>
      <th style="background-color:#CBCBCB;">URL</th>
      <th style="background-color:#CBCBCB;">Created</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{$payload->id_logging}}</td>
      <td>{{$payload->method}}</td>
      <td>{{$payload->type}}</td>
      <td>{{$payload->url}}</td>
      <td>{{\Carbon\Carbon::parse($payload->created_at)->locale('id')->translatedFormat('d F Y, H:i:s')}} WIB</td>
    </tr>
  </tbody>
</table>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td>Id User</td>
      <td># {{$payload->pengguna->id_users}}</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>{{$payload->pengguna->name}}</td>
    </tr>
    <tr>
      <td>Email</td>
      <td>{{$payload->pengguna->email}}</td>
    </tr>
    <tr>
      <td>LinkedIn</td>
      <td>{{$payload->pengguna->linkedln}}</td>
    </tr>
    <tr>
      <td>Facebook</td>
      <td>{{$payload->pengguna->facebook}}</td>
    </tr>
    <tr>
      <td>Twitter</td>
      <td>{{$payload->pengguna->twitter}}</td>
    </tr>
    <tr>
      <td>Whatsapp</td>
      <td>{{$payload->pengguna->whatsaap}}</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>{{$payload->pengguna->address}}</td>
    </tr>
    <tr>
      <td>IP</td>
      <td>{{$payload->ip4}}</td>
    </tr>
    <tr>
      <td>Device</td>
      <td>{{$payload->device}}</td>
    </tr>
    <tr>
      <td>Platform</td>
      <td>{{$payload->platform}}</td>
    </tr>
    <tr>
      <td>Browser</td>
      <td>{{$payload->browser}}</td>
    </tr>
    <tr>
      <td>Agent</td>
      <td>{{$payload->agent}}</td>
    </tr>
    <tr>
      <td>Browser Version</td>
      <td>{{$payload->browser_version}}</td>
    </tr>
  </tbody>
</table>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td style="
      word-wrap: break-word;
      word-break: break-word;
      white-space: normal;
      ">
      {{$payload->deskripsi}}
      </td>
    </tr>
  </tbody>
</table>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
  <tbody>
    <tr>
        <td>
        <pre id="json-data" style="
        word-wrap: break-word;
      	word-break: break-word;
      	white-space: pre-wrap;
        ">{!! json_encode(json_decode($payload->data), JSON_PRETTY_PRINT) !!}</pre>
        </td>
    </tr>
  </tbody>
</table>

</body>
</html>
