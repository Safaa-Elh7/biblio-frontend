@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="notification-container" id="notification-container"></div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header with Search Bar -->
        <header class="page-header">
            <div class="search-bar">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Search books, authors, genres...">
                <button class="search-btn">
                    Search
                </button>
            </div>
        </header>
        
        <!-- Shopping Cart Title -->
        <h1 class="cart-title">Shopping Cart</h1>
        
        <!-- Shopping Cart Content -->
        <div class="cart-container">
            <!-- Left Side - Cart Items -->
            <div class="cart-items" id="cartItems">
                @if(session('success'))
                    <div class="p-4 mb-4 text-green-800 rounded bg-green-200">{{ session('success') }}</div>
                @endif
                @php
                    $cart = session('cart', []);
                @endphp
                @if(empty($cart))
                    <div class="empty-cart-message">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <p>Your cart is empty</p>
                        <p class="text-sm mt-2 text-gray-500">Browse our collection to find your next favorite book!</p>
                    </div>
                @else
                    @foreach($cart as $id => $item)
                        <div class="cart-item" data-id="{{ $id }}">
                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}" alt="{{ $item['name'] }}" class="item-image">
                            <div class="item-details">
                                <h3 class="item-title">{{ $item['name'] }}</h3>
                                @if(isset($item['author']))
                                <div class="item-author">{{ $item['author'] }}</div>
                                @endif
                                <div class="item-price-per-unit">{{ $item['price'] }} Dh / livre</div>
                            </div>
                            <div class="quantity-control flex items-center">
                                <button type="button" class="quantity-btn decrement-btn" data-id="{{ $id }}">-</button>
                                <span class="quantity-input">{{ $item['quantity'] }}</span>
                                <button type="button" class="quantity-btn increment-btn" data-id="{{ $id }}">+</button>
                            </div>
                            <div class="item-price">{{ $item['price'] * $item['quantity'] }} Dh</div>
                            <button type="button" class="remove-btn" title="Supprimer" data-id="{{ $id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <!-- Right Side - Order Summary -->
            <div class="right-column">
                <div class="order-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="subtotalValue">
                            @php
                                $subtotal = 0;
                                foreach($cart as $item) {
                                    $subtotal += $item['price'] * $item['quantity'];
                                }
                            @endphp
                            {{ $subtotal }} Dh
                        </span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Shipping</span>
                        <span class="summary-value">Free</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Tax</span>
                        <span class="summary-value">0 Dh</span>
                    </div>
                    
                    <div class="summary-row total-row">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="totalValue">{{ $subtotal }} Dh</span>
                    </div>
                    
                    <button class="checkout-btn">Checkout</button>
                    
                    <div class="payment-methods">
                        <p>We accept:</p>
                        <div class="payment-icons">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-amex"></i>
                            <i class="fab fa-cc-paypal"></i>
                        </div>
                    </div>
                </div>
                
                <div class="need-help">
                    <h3>Need Help?</h3>
                    <p><i class="fas fa-phone"></i> Call us at 1-800-BOOKS</p>
                    <p><i class="fas fa-envelope"></i> Email: support@mybookspace.com</p>
                    <p><a href="#" class="help-link">View our return policy</a></p>
                </div>
            </div>
        </div>
        
        <!-- Recently Viewed Section -->
        <section class="recently-viewed">
            <h2>Recently Viewed</h2>
            <div class="book-slider">
                <!-- Book Items -->
                <div class="book-card">
                    <img src="https://via.placeholder.com/150x200" alt="Book Cover" class="book-cover">
                    <h3 class="book-title">The Great Gatsby</h3>
                    <p class="book-author">F. Scott Fitzgerald</p>
                    <p class="book-price">200 Dh</p>
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
                
                <div class="book-card">
                    <img src="https://via.placeholder.com/150x200" alt="Book Cover" class="book-cover">
                    <h3 class="book-title">To Kill a Mockingbird</h3>
                    <p class="book-author">Harper Lee</p>
                    <p class="book-price">180 Dh</p>
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
                
                <div class="book-card">
                    <img src="https://via.placeholder.com/150x200" alt="Book Cover" class="book-cover">
                    <h3 class="book-title">1984</h3>
                    <p class="book-author">George Orwell</p>
                    <p class="book-price">150 Dh</p>
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
                
                <div class="book-card">
                    <img src="https://via.placeholder.com/150x200" alt="Book Cover" class="book-cover">
                    <h3 class="book-title">Pride and Prejudice</h3>
                    <p class="book-author">Jane Austen</p>
                    <p class="book-price">170 Dh</p>
                    <button class="add-to-cart-btn">Add to Cart</button>
                </div>
            </div>
        </section>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>MyBookSpace</h3>
                <p>Your online destination for quality books.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Track Your Order</a></li>
                    <li><a href="#">Return Policy</a></li>
                    <li><a href="#">Shipping Information</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>About Us</h3>
                <ul>
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Subscribe to our Newsletter</h3>
                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email">
                    <button type="submit">Subscribe</button>
                </form>
                <p>Get updates on new releases and exclusive offers.</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2023 MyBookSpace. All Rights Reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Accessibility</a>
            </div>
        </div>
    </footer>
</div>

<style>
/* Base Styles */
body, html {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

.page-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.main-content {
    flex: 1;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

/* Header */
.page-header {
    background-color: white;
    padding: 15px 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.search-bar {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    background-color: #f5f5f5;
    border-radius: 4px;
    padding: 8px 15px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.search-icon {
    color: #777;
    margin-right: 10px;
}

.search-bar input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 8px 0;
    font-size: 16px;
    outline: none;
}

.search-btn {
    background-color: #7c2d2d;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.2s;
}

.search-btn:hover {
    background-color: #6a2424;
}

/* Cart Title */
.cart-title {
    font-size: 32px;
    margin: 30px 0;
    color: #333;
    text-align: center;
    font-weight: 700;
}

/* Cart Container */
.cart-container {
    display: flex;
    gap: 30px;
    margin-bottom: 40px;
}

@media (max-width: 768px) {
    .cart-container {
        flex-direction: column;
    }
}

/* Cart Items */
.cart-items {
    flex: 1.5;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    padding: 20px;
}

.empty-cart-message {
    text-align: center;
    padding: 40px 20px;
}

.empty-cart-icon {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 20px;
}

/* Cart Item */
.cart-item {
    display: flex;
    padding: 20px 0;
    border-bottom: 1px solid #eee;
    align-items: center;
    position: relative;
}

.cart-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 80px;
    height: 100px;
    object-fit: cover;
    margin-right: 20px;
    border-radius: 4px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.item-details {
    flex: 1;
}

.item-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 8px 0;
}

.item-author {
    color: #777;
    margin-bottom: 8px;
    font-size: 14px;
}

.item-price-per-unit {
    color: #555;
    font-size: 14px;
    margin-bottom: 5px;
}

/* Quantity Control */
.quantity-control {
    display: flex;
    align-items: center;
    margin: 0 20px;
}

.quantity-btn {
    background-color: #7c2d2d;
    color: white;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
}

.quantity-btn:hover {
    background-color: #6a2424;
}

.quantity-input {
    width: 30px;
    text-align: center;
    margin: 0 10px;
    font-weight: 500;
    user-select: none;
}

.item-price {
    font-weight: 700;
    font-size: 18px;
    color: #333;
    margin: 0 20px;
}

.remove-btn {
    background: none;
    border: none;
    color: #7c2d2d;
    cursor: pointer;
    font-size: 16px;
    transition: color 0.2s;
}

.remove-btn:hover {
    color: #ff0000;
}

/* Right Column / Order Summary */
.right-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-summary {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    padding: 25px;
}

.summary-title {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 22px;
    font-weight: 700;
    color: #333;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    color: #555;
}

.summary-label {
    font-weight: 500;
}

.total-row {
    border-top: 2px solid #eee;
    margin-top: 10px;
    padding-top: 20px;
    font-size: 18px;
    font-weight: 700;
    color: #333;
}

.checkout-btn {
    background-color: #7c2d2d;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 14px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 20px;
    width: 100%;
    transition: background-color 0.2s;
}

.checkout-btn:hover {
    background-color: #6a2424;
}

.payment-methods {
    margin-top: 25px;
    text-align: center;
    color: #777;
}

.payment-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 10px;
    font-size: 24px;
}

/* Need Help Section */
.need-help {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    padding: 25px;
}

.need-help h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: #333;
}

.need-help p {
    margin: 10px 0;
    color: #555;
}

.need-help i {
    margin-right: 8px;
    color: #7c2d2d;
}

.help-link {
    color: #7c2d2d;
    text-decoration: none;
}

.help-link:hover {
    text-decoration: underline;
}

/* Recently Viewed Section */
.recently-viewed {
    margin-top: 40px;
}

.recently-viewed h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.book-slider {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding: 10px 0;
    scrollbar-width: thin;
    scrollbar-color: #7c2d2d #f0f0f0;
}

.book-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    padding: 15px;
    width: 180px;
    flex-shrink: 0;
    transition: transform 0.2s;
}

.book-card:hover {
    transform: translateY(-5px);
}

.book-cover {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 12px;
}

.book-title {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 8px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.book-author {
    font-size: 14px;
    color: #777;
    margin: 0 0 8px 0;
}

.book-price {
    font-weight: 700;
    color: #333;
    margin: 0 0 12px 0;
}

.add-to-cart-btn {
    background-color: #7c2d2d;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px;
    width: 100%;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.add-to-cart-btn:hover {
    background-color: #6a2424;
}

/* Footer */
.footer {
    background-color: #333;
    color: white;
    padding: 40px 20px 20px;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: space-between;
}

.footer-section {
    flex: 1;
    min-width: 200px;
}

.footer-section h3 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 18px;
}

.social-icons {
    display: flex;
    gap: 15px;
    margin-top: 15px;
}

.social-icons a {
    color: white;
    font-size: 18px;
}

.footer-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul a {
    color: #ccc;
    text-decoration: none;
    transition: color 0.2s;
}

.footer-section ul a:hover {
    color: white;
}

.newsletter-form {
    display: flex;
    margin-bottom: 15px;
}

.newsletter-form input {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 4px 0 0 4px;
    outline: none;
}

.newsletter-form button {
    background-color: #7c2d2d;
    color: white;
    border: none;
    border-radius: 0 4px 4px 0;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.newsletter-form button:hover {
    background-color: #6a2424;
}

.footer-bottom {
    max-width: 1200px;
    margin: 0 auto;
    padding-top: 20px;
    margin-top: 20px;
    border-top: 1px solid #444;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.footer-bottom p {
    margin: 0;
    color: #999;
}

.footer-bottom-links {
    display: flex;
    gap: 20px;
}

.footer-bottom-links a {
    color: #999;
    text-decoration: none;
    transition: color 0.2s;
}

.footer-bottom-links a:hover {
    color: white;
}

/* Notification Styles */
.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.notification {
    background-color: white;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 16px 20px;
    transform: translateX(120%);
    transition: transform 0.3s ease-out;
    min-width: 280px;
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    border-left: 4px solid #4caf50;
}

.notification-error {
    border-left: 4px solid #f44336;
}

.notification-content {
    display: flex;
    align-items: flex-start;
}

.notification-message {
    flex: 1;
    color: #333;
    font-weight: 500;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .footer-content {
        justify-content: flex-start;
    }
    
    .footer-section {
        flex-basis: 45%;
    }
}

@media (max-width: 768px) {
    .cart-item {
        flex-wrap: wrap;
        padding: 15px 0;
    }
    
    .item-image {
        width: 60px;
        height: 80px;
    }
    
    .item-details {
        width: calc(100% - 80px);
    }
    
    .quantity-control, .item-price, .remove-btn {
        margin-top: 15px;
    }
    
    .quantity-control {
        order: 2;
    }
    
    .item-price {
        order: 3;
    }
    
    .remove-btn {
        order: 4;
        position: absolute;
        top: 15px;
        right: 0;
    }
    
    .footer-section {
        flex-basis: 100%;
    }
    
    .footer-bottom {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
}
</style>

<script>
$(document).ready(function() {
    // Event handlers for quantity controls
    $('.increment-btn').on('click', function() {
        const id = $(this).data('id');
        updateQuantity(id, 'increment');
    });
    
    $('.decrement-btn').on('click', function() {
        const id = $(this).data('id');
        updateQuantity(id, 'decrement');
    });
    
    // Event handler for remove button
    $('.remove-btn').on('click', function() {
        const id = $(this).data('id');
        removeItem(id);
    });
    
    // Function to update quantity
    function updateQuantity(id, action) {
        $.ajax({
            url: '{{ route("client.panier.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                action: action
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Panier mis à jour', 'success');
                    // Reload the page to reflect changes
                    location.reload();
                }
            },
            error: function(error) {
                console.error('Erreur lors de la mise à jour:', error);
                showNotification('Erreur lors de la mise à jour', 'error');
            }
        });
    }
    
    // Function to remove item
    function removeItem(id) {
        $.ajax({
            url: '{{ route("client.panier.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Livre retiré du panier', 'success');
                    // Reload the page to reflect changes
                    location.reload();
                }
            },
            error: function(error) {
                console.error('Erreur lors de la suppression:', error);
                showNotification('Erreur lors de la suppression', 'error');
            }
        });
    }
    
    // Function to display notification
    function showNotification(message, type) {
        const notification = $(`
            <div class="notification notification-${type}">
                <div class="notification-content">
                    <div class="notification-message">${message}</div>
                </div>
            </div>
        `);
        
        $('#notification-container').append(notification);
        
        setTimeout(function() {
            notification.addClass('show');
            
            setTimeout(function() {
                notification.removeClass('show');
                setTimeout(function() {
                    notification.remove();
                }, 300);
            }, 3000);
        }, 100);
    }
});
</script>
@endsection