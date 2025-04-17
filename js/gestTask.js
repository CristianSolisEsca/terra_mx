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
                                 '<button class="text-blue-500 hover:text-blue-700 edit-task" data-id="'+data[i]['id']+'"><i class="fas fa-edit"></i> Editar</button>'+
                                 '<button class="text-red-500 hover:text-red-700 delete-task" data-id="'+data[i]['id']+'"><i class="fas fa-trash"></i> Eliminar</button>'+
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


      $(document).on('click', '.edit-task', function() {
        var taskId = $(this).data('id');  

        $.ajax({
            url: '../engine/frontConsult.php',  
            data: { getTaskUserDataOnlyID: true, taskId: taskId },  
            type: 'POST',  
            dataType: 'json',  
            timeout: 2000, 
            success: function (data) {

                Swal.fire({
                    title: 'Editar Tarea',
                    html: `
                        <input id="task_name" class="swal2-input" value="${data[0]['task_name']}">
                        <textarea id="task_description" class="swal2-textarea">${data[0]['task_description']}</textarea>
                        <select id="task_status" class="swal2-select">
                            <option value="pending" ${data[0]['status'] === 'pending' ? 'selected' : ''}>Pendiente</option>
                            <option value="in_progress" ${data[0]['status'] === 'in_progress' ? 'selected' : ''}>En Progreso</option>
                            <option value="done" ${data[0]['status'] === 'done' ? 'selected' : ''}>Terminado</option>
                        </select>
                    `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar cambios',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        var updatedTaskName = document.getElementById('task_name').value;
                        var updatedTaskDescription = document.getElementById('task_description').value;
                        var updatedTaskStatus = document.getElementById('task_status').value;

                        $.ajax({
                            url: '../engine/frontConsult.php', 
                            type: 'POST',
                            data: {
                                getTaskUserUpdate: true,
                                task_id: taskId,
                                task_name: updatedTaskName,
                                task_description: updatedTaskDescription,
                                task_status: updatedTaskStatus  
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    Swal.fire('¡Éxito!', 'Tarea actualizada correctamente.', 'success');
                                    chargeTaskUser(); 
                                } else {
                                    console.log(response);
                                    Swal.fire('Error', 'Hubo un error al actualizar la tarea.', 'error');
                                }
                            }
                        });
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);  
            }
        });
    });

    $(document).on('click', '.delete-task', function() {
        var taskId = $(this).data('id');  

        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../engine/frontConsult.php',  
                    type: 'POST',
                    data: {  getTaskUserDelete: true,task_id: taskId },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('¡Eliminado!', 'La tarea ha sido eliminada.', 'success');
                            chargeTaskUser();  
                        } else {
                            Swal.fire('Error', 'Hubo un error al eliminar la tarea.', 'error');
                        }
                    }
                });
            }
        });
    });

    chargeTaskUser();

});


