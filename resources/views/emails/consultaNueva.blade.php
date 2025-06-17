<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        body {
            margin: 0;
            padding: 20px;
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            background-color: #ffffff;
            border-collapse: collapse;
        }
        h1 {
            color: #ffffff;
            margin: 0;
            padding: 10px 0;
            font-size: 24px;
        }
        .header {
            background-color: #1d4ed8;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .content {
            padding: 15px;
            color: #374151;
            font-size: 16px;
        }
        .label {
            color: #ef4444;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            table {
                width: 100% !important;
            }
            h1 {
                font-size: 20px !important;
            }
        }
    </style>
</head>
<body>
    <table cellpadding="10" cellspacing="0" border="0">
        <tr class="header">
            <td>
                <h1>Nueva Consulta Recibida</h1>
            </td>
        </tr>
        <tr>
            <td class="content">
                <p><span class="label">Nombre:</span> {{ $nombre }}</p>
                <p><span class="label">Teléfono:</span> {{ $telefono }}</p>
                <p><span class="label">Email:</span> {{ $email }}</p>
                <p><span class="label">Mensaje:</span><br>
                <span>{{ $mensaje }}</span></p>
            </td>
        </tr>
    </table>
</body>
</html>