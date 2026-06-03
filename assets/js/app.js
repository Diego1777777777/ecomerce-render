// =====================================================
// FutbolShop — app.js  (JavaScript Global)
// BASE_URL e IMG_URL son inyectados por header.php
// =====================================================

function formatCOP(price) {
    return '$' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' COP';
}

function getCart() {
    const d = localStorage.getItem('futbolshop_cart');
    return d ? JSON.parse(d) : [];
}

function saveCart(cart) {
    localStorage.setItem('futbolshop_cart', JSON.stringify(cart));
}

// Agregar al carrito — imagen es solo el nombre del archivo
function addToCart(id, nombre, precio, imagen, categoria, stock) {
    const cart = getCart();
    const existing = cart.find(i => i.id === id);

    if (existing) {
        if (existing.quantity < stock) {
            existing.quantity++;
        } else {
            showToast(`Solo hay ${stock} unidades disponibles`, 'error');
            return;
        }
    } else {
        cart.push({ id, nombre, precio, imagen, categoria, stock, quantity: 1 });
    }

    saveCart(cart);
    updateCartCount();
    showToast(`${nombre} añadido al carrito ✓`, 'success');
}

function updateCartCount() {
    const total = getCart().reduce((s, i) => s + i.quantity, 0);
    const el = document.getElementById('cartCount');
    if (el) el.textContent = total;
}

function showToast(msg, type = 'success') {
    const old = document.getElementById('fs-toast');
    if (old) old.remove();
    const t = document.createElement('div');
    t.id = 'fs-toast';
    t.style.cssText = 'position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;padding:.75rem 1.25rem;border-radius:.5rem;color:#fff;font-weight:600;font-size:.875rem;box-shadow:0 4px 12px rgba(0,0,0,.2);transition:opacity .3s,transform .3s';
    t.style.background = type === 'success' ? '#111' : '#dc2626';
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(1rem)'; setTimeout(() => t.remove(), 300); }, 2800);
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();

    // Búsqueda — Enter en barra de header
    ['searchInput', 'searchInputMobile'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('keydown', e => {
            if (e.key !== 'Enter') return;
            const q = encodeURIComponent(el.value.trim());
            if (!q) return;
            const enPages = window.location.pathname.includes('/pages/');
            window.location.href = (enPages ? '' : 'pages/') + 'productos.php?buscar=' + q;
        });
    });
});
