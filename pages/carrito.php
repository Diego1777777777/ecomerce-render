<?php
// pages/carrito.php — Controlador del carrito de compras
require_once '../config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$pageTitle = 'Carrito de Compras';

require_once '../includes/header.php';
include '../views/carrito.phtml';

// Script JavaScript específico del carrito
?>
<script>
const BASE_URL_CARRITO = "<?= BASE_URL ?>";

function formatCOP(p) { return '$' + p.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' COP'; }
function getCart()    { const d = localStorage.getItem('futbolshop_cart'); return d ? JSON.parse(d) : []; }
function saveCart(c)  { localStorage.setItem('futbolshop_cart', JSON.stringify(c)); }

function initCart() { updateCartCount(); const c = getCart(); renderCartItems(c); updateSummary(c); }

function renderCartItems(cart) {
    const el    = document.getElementById('cartItems');
    const empty = document.getElementById('emptyCart');
    const sum   = document.getElementById('orderSummary');
    if (!cart.length) { el.classList.add('hidden'); empty.classList.remove('hidden'); sum.classList.add('hidden'); return; }
    el.classList.remove('hidden'); empty.classList.add('hidden'); sum.classList.remove('hidden');
    el.innerHTML = cart.map(item => `
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex gap-6">
                <div class="w-32 h-32 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                    <img src="${IMG_URL}/${item.imagen}" alt="${item.nombre}"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null;this.src='${BASE_URL_CARRITO}/assets/img/placeholder.svg'">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-semibold text-black text-lg">${item.nombre}</h3>
                            <p class="text-sm text-gray-500 capitalize">${item.categoria}</p>
                        </div>
                        <button onclick="removeFromCart(${item.id})" class="text-gray-400 hover:text-red-600 transition-colors">✕</button>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-3">
                            <button onclick="updateQty(${item.id},-1)" class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 font-bold">−</button>
                            <span class="font-semibold w-8 text-center">${item.quantity}</span>
                            <button onclick="updateQty(${item.id},1)"  class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 font-bold">+</button>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">${formatCOP(item.precio)}</p>
                            <p class="text-xl font-bold text-black">${formatCOP(item.precio * item.quantity)}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>`).join('');
}

function updateSummary(cart) {
    const sub  = cart.reduce((s, i) => s + i.precio * i.quantity, 0);
    const ship = sub >= 200000 ? 0 : 15000;
    document.getElementById('subtotal').textContent = formatCOP(sub);
    document.getElementById('shipping').textContent = ship === 0 ? 'GRATIS' : formatCOP(ship);
    document.getElementById('total').textContent    = formatCOP(sub + ship);
}

function updateQty(id, d) {
    const cart = getCart();
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.quantity += d;
    if (item.quantity <= 0) { removeFromCart(id); return; }
    if (item.quantity > item.stock) { alert('Stock máximo: ' + item.stock); item.quantity = item.stock; }
    saveCart(cart); renderCartItems(cart); updateSummary(cart); updateCartCount();
}

function removeFromCart(id) {
    const cart = getCart().filter(i => i.id !== id);
    saveCart(cart); renderCartItems(cart); updateSummary(cart); updateCartCount();
}

function updateCartCount() {
    const total = getCart().reduce((s, i) => s + i.quantity, 0);
    const el = document.getElementById('cartCount');
    if (el) el.textContent = total;
}

document.getElementById('checkoutButton')?.addEventListener('click', () => {
    alert('Funcionalidad de pago en desarrollo. Total: ' + document.getElementById('total').textContent);
});

document.addEventListener('DOMContentLoaded', initCart);
</script>
<?php require_once '../includes/footer.php'; ?>
