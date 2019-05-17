
                    $('#manufacturing_year').datepicker({
                    	dateFormat: 'yy-mm-dd',
                    	changeMonth: true,
            			changeYear: true
                    });

			     $("#add_more").click(function(){
			        $("#filediv").clone().appendTo("#rightdiv");
			      });

			     $(document).ready( function () {
				    $('#myTable').DataTable();
				} );
