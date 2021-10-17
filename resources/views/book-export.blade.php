<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<h1 id="customers">Daftar Buku</h1>

<table id="customers">
  <tr>
    <th>Judul Buku</th>
    <th>Nomor ISBN</th>
    <th>Nama Penulis</th>
  </tr>


  @foreach($books as $data)

  <tr>
    <td>{{ $data->title }}</td>
    <td>{{ $data->code }}</td>
    <td>{{ $data->author }}</td>
  </tr>
  
  @endforeach

</table>

</body>
</html>


