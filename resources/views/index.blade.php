<!DOCTYPE html>
<html>
    <head>
        <title>Todo</title>
    </head>
    <style type="text/css">
        .box1 {
        border: solid 1px #006699;
        padding: 20px;
        background: #f3f3f3;
        border-radius: 5px;
        }
        .todos input.textfield {
        width: 480px;
        height: 36px;
        margin-right: 20px;
        font-size: 1.4em;
        vertical-align: top;
        }
        .todos input.checkbox {
        width: 20px;
        height: 20px;
        }
        .todos .checked {
        text-decoration: line-through;
        }
        .todos button {
        height: 36px;
        font-size: 1.1em;
        vertical-align: top;
        border: solid 1px #999;
        border-radius: 2px;
        }
        .todos .delete-icon {
        diplay: inline-block;
        cursor: pointer;
        }
    </style>
    <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
    <body>
        <div class="box1">
            <div class="todos">
                <div>
                    <form > <input class="textfield" name="newTodo"> <button class="add-todo" disabled="disabled" type="button">Add Todo</button> </form>
                </div>
                <div class="typing"> Type in a new todo...</div>
                <ul class="list-todo" style="list-style: none;">
                    @foreach($data as $key => $value)
                    	<li id="list-{{ $value->id }}"> <input  class="checkbox" type="checkbox" value="{{ $value->id }}" name="checkbox[]"> <span value>{{ $value->task }}</span> <span  data-id="{{ $value->id }}" class="delete-icon">[X]</span> </li>
                    @endForeach
                </ul>
                <div  class="mtop20"> <button class="deleted-selection">Delete Selected</button> </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
    $( document ).ready(function() {
    	init();
	    $("input[name=newTodo]").keyup(function(){
	    	let val = $(this).val();
	    	if(val != ""){
	    		$(".add-todo").removeAttr( "disabled" );
	    		$(".typing").html("Typing: "+val);
	    	}
	    	else{
	    		$(".typing").html("Type in a new todo...");
	    		$(".add-todo").attr("disabled","disabled");
	    	}
	    });

	    $(".add-todo").click(function(){
	    	var value = $("input[name=newTodo]").val();
	    	$.ajax({
		        url: "/todo/create",
		        type: "post",
		        data: { 
		        	"task" : value, 
		        	"_token": "{{ csrf_token() }}",
		        } ,
		        success: function (response) {

		        	if(response.success == true)
		        	{
		        		var template = '<li id="list-'+response.id+'"> <input  class="checkbox" type="checkbox" value="'+response.id+'" name="checkbox[]"> <span value>'+value+'</span> <span  data-id="'+response.id+'" class="delete-icon">[X]</span> </li>';
	    				$(".list-todo").append(template);	
		        	}
		           
	    			$(".typing").html("Type in a new todo...");
	    			$(".add-todo").attr("disabled","disabled");
	    			$("input[name=newTodo]").val("");
	    			init();
		        }
		    });
	    });

	    function init(){
	    	$(".delete-icon").click(function(){
		    	var id = $(this).attr('data-id');
		    	$.ajax({
			        url: "/todo/destroy",
			        type: "post",
			        data: { 
			        	"_token": "{{ csrf_token() }}",
			        	"id[0]": id,
			        } ,
			        success: function (response) {

			        	if(response.success == true)
			        	{
			        		for (var i = 0; i < response.id.length; i++) {
			        			$("#list-"+response.id[i]).remove();
			        		}
			        	}
			        }
			    });
		    });

		    $(".deleted-selection").click(function(){
		    	var id = [];
	            $.each($(".checkbox:checked"), function(){            
	                id.push($(this).val());
	            });

	            if(id.length > 0)
	            {
	            	$.ajax({
				        url: "/todo/destroy",
				        type: "post",
				        data: { 
				        	"_token": "{{ csrf_token() }}",
				        	"id": id,
				        } ,
				        success: function (response) {
					      	if(response.success == true)
				        	{
				        		for (var i = 0; i < response.id.length; i++) {
				        			$("#list-"+response.id[i]).remove();
				        		}
				        	}
				        }
				    });
	            }
		    });
	    }
	});
    </script>
</html>