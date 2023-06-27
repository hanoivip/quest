$(document).ready(function(){
	
	$('#quest-tasks-refresh').on('click', function () {
		event.preventDefault()
		console.log('xxx')
		var url = $(this).attr('data-action')
		var updateId = $(this).attr('data-update-id')
		var template = $(this).attr('data-template')
		var param = new FormData();  
		param.append("template", template)
		$.ajax({
            url: url,
            method: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            data: new URLSearchParams(param).toString(),
            dataType : 'html',
            cache: false,
            processData: false,
            success:function(response)
            {
            	console.log(response)
            	$('#' + updateId).html(response)
            },
            error: function(response) {
            }
        })
	})
})