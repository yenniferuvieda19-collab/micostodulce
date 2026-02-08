<html>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #ddd;">
        <div style="background-color: #e91e63; color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0;">Mi Costo Dulce</h1>
        </div>
        
        <div style="padding: 30px; line-height: 1.6; color: #333;">
            <h2 style="color: #e91e63;">¡Hola, <?= $nombre_negocio  ?>!</h2>
            <p>Estamos muy felices de tenerte con nosotros. En <strong>Mi Costo Dulce</strong> nos apasiona hacer tu vida más dulce y organizada.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="<?= base_url() ?>" style="background-color: #e91e63; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">Visitar mi cuenta</a>
            </div>
            
            <p>Si tienes alguna duda, responde a este correo. ¡Estamos para ayudarte!</p>
        </div>
        
        <div style="background-color: #f9f9f9; color: #777; padding: 15px; text-align: center; font-size: 12px;">
            <p>&copy; <?= date('Y') ?> Mi Costo Dulce. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
