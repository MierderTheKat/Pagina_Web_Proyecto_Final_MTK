# Pagina Web Reservaciones
Página web de reservaciones para una graduación en la Universidad Politécnica de Durango

[Universidad Politécnica de Durango](http://www.unipolidgo.edu.mx/sitio/) - Ingeniería en software 4°A
- [Francisco Javier Rivera](https://github.com/MierderTheKat)

## Base de datos utilizada

Nombre de la base de datos: `registros`

Nombre de la tabla: `usuarios`

Estructura:
| #     | Nombre               | Tipo         | Nulo | Predeterminado | Extra          |
| :---: | :---                 | :---         | :---:| :---:          | :---           |
| 1     | `ID_usuario`         | int(5)       | No   | Ninguna        | AUTO_INCREMENT |
| 2     | `nombre`             | varchar(50)  | No   | Ninguna        |                |
| 3     | `apellido_paterno`   | varchar(50)  | No   | Ninguna        |                |
| 4     | `apellido_materno`   | varchar(50)  | Si   |                |                |
| 5     | `contrasena`         | varchar(100) | No   | Ninguna        |                |
| 6     | `correo`             | varchar(100) | No   | Ninguna        |                |
| 7     | `edad`               | int(3)       | No   | Ninguna        |                |
| 8     | `asientos_reservados`| int(255)     | Si   | 0              |                |
| 9     | `asientos_agregar`   | int(255)     | No   | Ninguna        |                |
| 10    | `creditos`           | int(255)     | No   | Ninguna        |                |

Nombre de la tabla: `asientos`

Estructura:
| #     | Nombre           | Tipo                             | Nulo  | Extra          |
| :---: | :---             | :---                             | :---: | :---           |
| 1     | `ID_asiento`     | int(9)                           | No    | AUTO_INCREMENT |
| 2     | `nombre_usuario` | varchar(100)                     | No    |                |
| 3     | `membresia`      | enum('Bronze', 'Silver', 'Gold') | No    |                |
| 4     | `No_ticket`      | varchar(20)                      | No    |                |
| 5     | `ID_usuario_FOR` | int(9)                           | No    | Foreign Key    |
