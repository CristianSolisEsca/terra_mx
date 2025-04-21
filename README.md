# Terra MX - Examen Técnico

Este proyecto fue desarrollado como parte del examen técnico para Terra MX. La aplicación permite el registro de usuarios, autenticación, y gestión de tareas mediante una interfaz sencilla y funcional.

## Características

- Registro y login de usuarios
- Gestión de sesiones
- CRUD de tareas
- Borrado lógico de tareas (estatus = 0)
- Frontend simple con TailwindCSS, jQuery y SweetAlert2
- Backend en PHP con conexión a base de datos MySQL

## Requisitos

- PHP >= 7.4
- MySQL
- Servidor local como Laragon, XAMPP o similar

## Instalación

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/CristianSolisEsca/terra_mx.git
2.- Importar la base de datos terra_exam.sql desde la carpeta raíz del proyecto.

3.- $this->conn = new mysqli('localhost', 'usuario', 'contraseña', 'nombre_de_bd');

4.- Iniciar el servidor local y acceder desde el navegador: http://localhost/terra_mx/register.php

Notas
El registro de usuario valida que no existan correos duplicados.

Las contraseñas se almacenan de forma segura usando password_hash().

Las tareas eliminadas se marcan como inactivas (status = 0) y no se muestran al usuario.

Autor
Cristian Solis
GitHub - CristianSolisEsca

