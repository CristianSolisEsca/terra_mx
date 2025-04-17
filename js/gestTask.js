$(document).ready(function () {

    function chargeTaskUser() {
        var user = $("#axios").val();  
        $.ajax({
            url: '../engine/frontConsult.php',  
            data: { getTaskUser: true, user: user },  
            type: 'POST',  
            dataType: 'json',  
            timeout: 2000, 
            success: function (data) {
                var task_user = '';  
                var status = '';  

                for (var i = 0; i < data.length; i++) {

                    if (data[i]['status'] == 'pending') {
                        status = '<span class="mt-3 inline-block text-xs font-medium bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">Pendiente</span>';
                    }

                    if (data[i]['status'] == 'in_progress') {
                        status = '<span class="mt-3 inline-block text-xs font-medium bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">En Progreso</span>';
                    }

                    if (data[i]['status'] == 'done') {
                        status = '<span class="mt-3 inline-block text-xs font-medium bg-green-100 text-green-700 px-3 py-1 rounded-full">Terminado</span>';
                    }

                    task_user += '<div class="bg-white rounded-xl shadow p-5 task-item" data-id="'+data[i]['id']+'">'+
                                 '<h3 class="text-lg font-bold text-gray-800  task-name">'+data[i]['task_name']+'</h3>'+
                                 '<p class="text-gray-600 text-sm mt-1">'+data[i]['task_description']+'</p>'+
                                 status+
                                 '<div class="flex justify-end space-x-2 mt-4">'+
                                 '</div>'+
                                 '</div>';
                }

                $("#list").empty();
                $("#list").append(task_user);
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);  
            }
        });
    }

    chargeTaskUser();

});


