$(document).ready(function() {

        $(document).on("click", "a.add", function(e) {
    		e.preventDefault();
    		var link = $(this);
    		var id = link.attr('id');
    		var url = link.attr('href');
            $.ajax({
                url: url,
                success: function(data)  {
    				link.replaceWith(data);
                }
            });
    	});

        $(document).on("submit", "form.ajax-submit", function(e) {
                e.preventDefault();

                var form = $(this);
        		var url = form.attr('action');
                var data = form.serialize();

                $.ajax({
                    url: url,
                    data: data,
                    method: "POST",
                    success: function(data)  {
                        console.log(data);
        				form.replaceWith(data);
                    }
                });
        });

        $(document).on("click", "a.cancel", function(e) {
            e.preventDefault();
            var confirmation = confirm("Are you sure?");
            if(confirmation) {
                $(this).parent().remove();
            }
        });

        $(document).on("click", "a.delete", function(e) {
            var confirmation = confirm("Are you sure?");
            if(!confirmation) {
                e.preventDefault();
            }
        });

        $(document).on("change", ".new-match select", function(e) {
            console.log(e.currentTarget.value);
            //store this value in the session or cookie
        });
    });
