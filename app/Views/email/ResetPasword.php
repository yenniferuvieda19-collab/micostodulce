<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="margin: 0; padding: 0; background-color: #fce4ec; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="background-color: #e91e63; padding: 30px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Mi Costo Dulce</h1>
                            <p style="color: #f8bbd0; margin: 5px 0 0 0;">Repostería y Gestión</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px; text-align: center;">
                            <h2 style="color: #880e4f; margin-top: 0;">¿Olvidaste tu contraseña?</h2>
                            <p style="color: #555; font-size: 16px; line-height: 1.5;">
                                Hola <strong><?= $nombre_negocio ?></strong>,<br>
                                Recibimos una solicitud para restablecer la contraseña de tu cuenta. No te preocupes, ¡pasa hasta en las mejores cocinas!
                            </p>
                            
                            <div style="margin: 35px 0;">
                                <a href="<?= $link ?>" style="background-color: #e91e63; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; font-size: 16px; box-shadow: 0 4px 6px rgba(233, 30, 99, 0.3);">
                                    Restablecer mi contraseña
                                </a>
                            </div>

                            <p style="color: #999; font-size: 13px;">
                                Si no solicitaste este cambio, puedes ignorar este correo con seguridad. El enlace expirará en 1 hora.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="background-color: #f8f9fa; padding: 20px; color: #ad1457; font-size: 12px;">
                            &copy; <?= date('Y') ?> Mi Costo Dulce | Hecho con amor 🍰
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>