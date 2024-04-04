<!DOCTYPE html>
<html>
<head>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #DDD;
}

tr:hover {background-color: #D6EEEE;}
.btn1{
  text-align: left !important;
  padding: 0;
  width: 50px;
}
.active {
    background-color: red; 
    color: white; 
}
.btn {
    background-color: blue;
    color: white; 
}
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"> 
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">


</head>
<body>

<h2>Hoverable Table</h2>
<a href="{{ URL::route('post.create'); }}" class="btn btn-primary btn1">Add</a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

 @foreach ($allColumns as $column)
    <button class="toggleColumnBtn" data-column="{{ $column }}" @if (in_array($column, $visibleColumns)) active @endif>{{ $column }}</button>
  @endforeach

  
  <table id="dataTable">
    <thead>
      <tr>
          <th>Sr.No</th>
          <th>Name</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>
  </table>
 
<script>
    
var myArray = [{ data: 'id', name: 'id' },
            { data: 'firstname', name: 'firstname' }];
let removeData=[];

$(document).ready(function() {
    localStorage.clear();
    var storedColumns = localStorage.getItem('datatableColumns');
    var visibleColumns = JSON.parse(storedColumns);
    if(storedColumns==null){
        var visibleColumns = [
            { data: 'id', name: 'id' },
            { data: 'firstname', name: 'firstname' }
        ];
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('posts.getData') }}",
            columns:visibleColumns,
            order: [[0, 'asc']], 
        });
    }
    $('.toggleColumnBtn').on('click', function() {
    var column = $(this).data('column');
    var newData = { data: column, name: column };
    var isExists = myArray.some(item => item.data === newData.data && item.name === newData.name);
    
    if (!isExists) {
        myArray.push(newData);
        localStorage.setItem('datatableColumns', JSON.stringify(myArray));
        updateDataTableColumns();
        $(this).toggleClass('active');
    } else {
        let lmyArray = JSON.parse(localStorage.getItem('datatableColumns'));
        let indexToRemove = lmyArray.findIndex(item => item.data === newData.data && item.name === newData.name);
        
        if (indexToRemove !== -1) {
            $(this).removeClass('active'); 
            lmyArray = lmyArray.filter(item => !(item.data === newData.data && item.name === newData.name));
           
           
            //localStorage.setItem('datatableColumns', JSON.stringify(lmyArray));
            updateDataTableColumnsRemove();
        }
    }
});

    
});
function updateDataTableColumnsRemove() {
    var storedColumns = localStorage.getItem('datatableColumns');
    var visibleColumns = JSON.parse(storedColumns);
    $('#dataTable').DataTable().destroy();
    
    var thead = $('#dataTable thead');
    if (thead.length > 0) {
        thead.empty();
        var headerRow = $('<tr></tr>');
        visibleColumns.forEach(function(column) {
            headerRow.append('<th>' + column.name + '</th>');
        });
        headerRow.append('<th>Action</th>'); 
        thead.append(headerRow);
    }
   
   
    var columnDefs = visibleColumns.map(column => ({ data: column.name, name: column.name }));
    columnDefs.push({ 
        data: null,
        name: 'action',
        orderable: false,
        render: function(data, type, row) {
            return '<a href="/posts/' + row.id + '/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;&nbsp;' +
                '<a href="/posts/' + row.id + '/edit" class="btn btn-danger btn-sm">Delete</a>';
        }
    });

    var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('posts.getData') }}",
        columns: columnDefs,
        order: [[0, 'asc']]
    });

    table.draw(); 
}


function updateDataTableColumns() {
    var storedColumns = localStorage.getItem('datatableColumns');
    var visibleColumns = JSON.parse(storedColumns);

    var thead = $('#dataTable thead');
    if (thead.length > 0) {
        thead.empty();
        var headerRow = $('<tr></tr>');
        visibleColumns.forEach(function(column) {
            headerRow.append('<th>' + column.name + '</th>');
        });
        headerRow.append('<th>Action</th>');
        thead.append(headerRow);
    }

    if (visibleColumns.length > 0) {
        var columnDefs = visibleColumns.map(function(column) {
            return { data: column.name, name: column.name };
        });
       // console.log(columnDefs);
        columnDefs.push({ 
            data: null,
            name: 'action',
            orderable: false,
            render: function(data, type, row) {
                
                return '<a href="/posts/' + row.id + '/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;&nbsp;' +
            '<a href="/posts/' + row.id + '/edit" class="btn btn-danger btn-sm">Delete</a>';
            }
        });

        var table = $('#dataTable').DataTable({
            destroy: true, // Destroy previous instance
            processing: true,
            serverSide: true,
            ajax: "{{ route('posts.getData') }}",
            columns: columnDefs,
            order: [[0, 'asc']]
        });

        table.draw();
        table.ajax.reload();
    }
}





</script>


</body>
</html>



