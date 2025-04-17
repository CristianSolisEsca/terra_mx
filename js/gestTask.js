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

    
    $('#addTaskBtn').click(function() {
        Swal.fire({
          title: 'Agregar Nueva Tarea',
          html: `
            <input id="task_name" class="swal2-input" placeholder="Nombre de la tarea">
            <textarea id="task_description" class="swal2-textarea" placeholder="Descripción de la tarea"></textarea>
            <select id="task_status" class="swal2-select">
              <option value="pending">Pendiente</option>
              <option value="in_progress">En Progreso</option>
              <option value="done">Terminado</option>
            </select>
          `,
          focusConfirm: false,
          showCancelButton: true,
          confirmButtonText: 'Agregar',
          cancelButtonText: 'Cancelar',
          preConfirm: () => {
            var taskName = document.getElementById('task_name').value;
            var taskDescription = document.getElementById('task_description').value;
            var taskStatus = document.getElementById('task_status').value;
    
            if (!taskName || !taskDescription) {
              Swal.showValidationMessage('Por favor ingresa todos los campos');
              return false;
            }
    
            $.ajax({
              url: '../engine/frontConsult.php',
              type: 'POST',
              data: {
                getTaskUserAdd: true,
                task_name: taskName,
                task_description: taskDescription,
                task_status: taskStatus,
                user_id: $('#axios').val()
              },
              success: function(response) {
                console.log(response);
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    Swal.fire('¡Éxito!', 'Tarea agregada correctamente.', 'success');
                    chargeTaskUser();
                } else {
                    Swal.fire('Error', jsonResponse.message || 'Hubo un error al agregar la tarea.', 'error');
                }
              }
            });
          }
        });
      });

    chargeTaskUser();

});


