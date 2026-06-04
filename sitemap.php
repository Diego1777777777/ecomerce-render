<?php
// Le decimos al navegador y a Google que esto es un archivo XML, no HTML
header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
    <url>
        <loc>https://ecomerce-render.onrender.com/</loc>
        <priority>1.0</priority>
    </url>

    <?php
    // Si manejas productos desde una base de datos, descomenta este bloque
    // para que tus productos se indexen automáticamente en Google:
    /*
    while($row = $result->fetch_assoc()) {
        echo "<url>";
        echo "  <loc>https://ecomerce-render.onrender.com/producto.php?id=" . $row['id'] . "</loc>";
        echo "  <priority>0.8</priority>";
        echo "</url>";
    }
    */
    ?>

</urlset>