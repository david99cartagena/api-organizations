<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Invitación</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0;">
    <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td style="background-color: #007bff; color: #ffffff; text-align: center; padding: 20px;">
                <h2 style="margin: 0; font-size: 24px;">Invitación</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; color: #333333; font-size: 16px; line-height: 1.5;">
                <p>Has sido invitado a una organización.</p>
                <p>Haz clic en el botón de abajo para ver tu invitación:</p>
                <p style="text-align: center;">
                    <a href="{{ $url }}" style="display: inline-block; padding: 12px 25px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">Ver invitación</a>
                </p>
                <p style="font-size: 14px; color: #888888;">Si no esperabas este correo, puedes ignorarlo.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f4f4f4; color: #888888; text-align: center; padding: 10px; font-size: 12px;">
                &copy; {{ date('Y') }} David Cartagena. Todos los derechos reservados.
            </td>
        </tr>
    </table>
</body>
</html>
