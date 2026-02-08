<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Mi Costo Dulce</title>
</head>
<body style="margin: 0; padding: 0; background-color: #fce4ec; font-family: 'Segoe UI', Helvetica, Arial, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #fce4ec;">
        <tr>
            <td align="center" style="padding: 20px 10px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                    
                    <tr>
                        <td align="center" style="background-color: #ee1d6d; padding: 40px 20px;">
                            <div style="background-color: rgba(255,255,255,0.2); width: 80px; height: 80px; border-radius: 50%; line-height: 80px; margin-bottom: 15px;">
                                <span style="font-size: 40px;">🍰</span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; letter-spacing: 1px; font-weight: bold;">Mi Costo Dulce</h1>
                            <p style="color: #ffffff; margin: 5px 0 0 0; opacity: 0.9; font-size: 14px; text-transform: uppercase; letter-spacing: 2px;">Gestión de Repostería</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 30px; text-align: center;">
                            <h2 style="color: #4a4a4a; margin-top: 0; font-size: 24px;">¡Hola, <?= esc($nombre_negocio) ?>!</h2>
                            
                            <p style="color: #666666; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
                                Recibimos una solicitud para restablecer la contraseña de tu cuenta.<br>
                                <span style="color: #ee1d6d; font-weight: bold;">¡No te preocupes!</span> A veces hasta a los mejores chefs se les pasa un ingrediente.
                            </p>
                            
                            <div style="margin: 40px 0;">
                                <a href="<?= $link ?>" style="background-color: #007bff; color: #ffffff; padding: 18px 35px; text-decoration: none; border-radius: 50px; font-weight: bold; display: inline-block; font-size: 16px; box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4); transition: all 0.3s ease;">
                                    Restablecer mi contraseña
                                </a>
                            </div>

                            <p style="color: #999999; font-size: 13px; line-height: 1.5; padding: 0 20px;">
                                Si tú no pediste este cambio, puedes ignorar este mensaje con tranquilidad. <br>
                                <strong>El enlace vencerá en 1 hora.</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="background-color: #fafafa; padding: 30px; border-top: 1px solid #eeeeee;">
                            <p style="color: #ee1d6d; font-size: 12px; margin: 0; font-weight: bold;">
                                &copy; <?= date('Y') ?> Mi Costo Dulce
                            </p>
                            <p style="color: #aaaaaa; font-size: 11px; margin: 5px 0 0 0;">
                                Hecho con amor para endulzar tu negocio 🧁
                            </p>
                        </td>
                    </tr>
                </table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" style="padding: 20px; color: #999999; font-size: 11px;">
                            Este es un correo automático, por favor no lo respondas directamente.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>