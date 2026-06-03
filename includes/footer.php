<?php if (!defined('BASE_URL')) require_once dirname(__DIR__) . '/config.php'; ?>
<footer class="bg-black text-white py-12 mt-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">⚽ FUTBOLSHOP</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Tu tienda de confianza para equipamiento deportivo de fútbol.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Comprar</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="<?= BASE_URL ?>/pages/productos.php?categoria=calzado"    class="hover:text-white transition-colors">Calzado</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/productos.php?categoria=ropa"       class="hover:text-white transition-colors">Ropa</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/productos.php?categoria=accesorios" class="hover:text-white transition-colors">Accesorios</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/productos.php"                      class="hover:text-white transition-colors">Ver Todo</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Ayuda</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="<?= BASE_URL ?>/pages/contacto.php"              class="hover:text-white transition-colors">Contacto</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/contacto.php#envios"       class="hover:text-white transition-colors">Envíos</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/contacto.php#devoluciones" class="hover:text-white transition-colors">Devoluciones</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/contacto.php#faq"          class="hover:text-white transition-colors">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Legal</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Términos y Condiciones</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Política de Privacidad</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>&copy; <?= date('Y') ?> FutbolShop. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
