<!DOCTYPE html>
<html>
<head>
  <title>Tugas Pertama Campuspedia</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container mt-4">
  
  <div class="card">
      
    <div class="card-header text-center font-weight-bold">
      <h2> Katalog Buku Perpustakaan </h2>
    </div>

    <br>

    <div class="col-md-12 mt-1 mb-2">
        <button type="button" id="addNewBook" class="btn btn-primary">Tambah</button>
        <a href="/exportpdf" class="btn btn-success">Unduh PDF</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="datatable-ajax-crud">
           <thead class="thead-dark">
              <tr>
                 <th>Id</th>
                 <th>Judul Buku</th>
                 <th>Nomor ISBN</th>
                 <th>Penulis Buku</th>
                 <th>Timestamp</th>
                 <th>Aksi</th>
                 
              </tr>
           </thead>
        </table>
    </div>
  </div>
  
  <!-- boostrap add and edit book model -->
    <div class="modal fade" id="ajax-book-model" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxBookModel"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Judul Buku</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="title" name="title" placeholder="Masukan Judul Buku" maxlength="50" required="">
                </div>
              </div>  
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nomor ISBN</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="code" name="code" placeholder="Masukan Nomor ISBN" maxlength="50" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Penulis Buku</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="author" name="author" placeholder="Masukan Penulis Buku" required="">
                </div>
              </div>
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Simpan
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>



<!-- end bootstrap model -->
<script type="text/javascript">

 $(document).ready( function () {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#datatable-ajax-crud').DataTable({
        
           processing: true,
           serverSide: true,
           ajax: "{{ url('ajax-datatable-crud') }}",
           columns: [
                    {data: 'id', name: 'id', 'visible': false},
                    { data: 'title', name: 'title' },
                    { data: 'code', name: 'code' },
                    { data: 'author', name: 'author' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false},
                 ],
          order: [[0, 'desc']]
          
    });
    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Add Book");
       $('#ajax-book-model').modal('show');
    });
 
    $('body').on('click', '.edit', function () {
        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-book') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Book");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#title').val(res.title);
              $('#code').val(res.code);
              $('#author').val(res.author);
           }
        });
    });
    $('body').on('click', '.delete', function () {
       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-book') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              var oTable = $('#datatable-ajax-crud').dataTable();
              oTable.fnDraw(false);
           }
        });
       }
    });
    $('body').on('click', '#btn-save', function (event) {
          var id = $("#id").val();
          var title = $("#title").val();
          var code = $("#code").val();
          var author = $("#author").val();
          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);
         
          // ajax
          $.ajax({
            type:"POST",
            url: "{{ url('add-update-book') }}",
            data: {
              id:id,
              title:title,
              code:code,
              author:author,
            },
            dataType: 'json',
            success: function(res){
            $("#ajax-book-model").modal('hide');
            var oTable = $('#datatable-ajax-crud').dataTable();
            oTable.fnDraw(false);
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
           }
        });
    });
});
</script>
</div>  
</body>
</html>