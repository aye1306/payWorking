<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Test Reload Datatable</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>
<body>
	<label>input***</label>
	<input type="text" id="add" value placeholder="add">
	<button id="btnAdd" onclick="addData()">update</button>
	<br><br>
	<label>date</label>
	<input type="text" id="date" value placeholder="date pic">
	<button onclick="getDate()">update</button>
	<br><br>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
            	<th>#</th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <tr>
            	<td>1</td>
	            <td>Tiger Nixon</td>
	            <td>System Architect</td>
	            <td>Edinburgh</td>
	            <td>61</td>
	            <td>2011/04/25</td>
	            <td>$320,800</td>
        	</tr>
        	<tr>
            	<td>2</td>
	            <td>Tiger Nixon</td>
	            <td>System Architect</td>
	            <td>Edinburgh</td>
	            <td>61</td>
	            <td>2011/04/25</td>
	            <td>$320,800</td>
        	</tr>
        </tbody>
    </table>
</body>
<script type="text/javascript">
	$(document).ready( function() {

    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data'
        } ]
    } );
} );


	function addData(){
		const num = document.getElementById("add").value;
		$('#example').DataTable().destroy();
		$('#tbody').empty();
		for (var i = 0; i < num; i++) {
			$("#tbody").append(
				`
				<tr>
				 	<td>${(i+1)}</td>
		            <td>Tiger Nixon</td>
		            <td>System Architect</td>
		            <td>Edinburgh</td>
		            <td>61</td>
		            <td>2011/04/25</td>
		            <td>$320,800</td>
            	</tr>


				`
			);
		}

		$('#example').DataTable( {
	        dom: 'fBrtip',
	        buttons: [ {
	            extend: 'excelHtml5',
	            text: '<h4 style="font-size: 13px;"><i class="fa fa-                                              plus-circle fa-x5"></i> New</h4>',
                        titleAttr: 'Create New Record'
	        } ]
    	});

	}

	$("#date").flatpickr({
	    mode: "range",
        locale: 'th',
        dateFormat: 'Y-m-d',
        altInput: 'true',
        altFormat: 'j F พ.ศ. T'
	});

	function getDate(){
		const getDate =  $("#date").val();
		const date = getDate.split(" to ");
		console.log(date);
	}
</script>
</html>
