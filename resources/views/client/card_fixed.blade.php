<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Checkout Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS styling similar to original card.blade.php */
        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background-color: #e6c998;
        }
        
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .checkout-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #7c2d2d;
        }
        
        .form-section {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #7c2d2d;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.75rem;
        }
        
        .input-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .input-group {
            flex: 1;
            margin-bottom: 1rem;
        }
        
        .input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #4a4a4a;
        }
        
        .input-field {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #d4d4d4;
            font-size: 1rem;
        }
        
        .input-field:focus {
            outline: none;
            border-color: #7c2d2d;
            box-shadow: 0 0 0 2px rgba(124, 45, 45, 0.2);
        }
        
        .submit-btn {
            background-color: #7c2d2d;
            color: white;
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 1.125rem;
            transition: all 0.2s ease;
            width: 100%;
        }
        
        .submit-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s;
        }
        
        .loading-overlay.active {
            visibility: visible;
            opacity: 1;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #7c2d2d;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h1 class="checkout-title">Complete Your Order</h1>
        
        <!-- Flash Messages -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
        
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        
        <form id="checkoutForm" action="{{ route('client.card.processPayment') }}" method="POST" onsubmit="return handleSubmit()">
            @csrf
            
            <!-- Shipping Information -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-shipping-fast"></i>
                    Shipping Information
                </h2>
                
                <div class="input-row">
                    <div class="input-group">
                        <label class="input-label" for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" class="input-field" required>
                        <div class="error-message" id="fullName-error"></div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label class="input-label" for="address">Address</label>
                    <input type="text" id="address" name="address" class="input-field" required>
                    <div class="error-message" id="address-error"></div>
                </div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label class="input-label" for="city">City</label>
                        <input type="text" id="city" name="city" class="input-field" required>
                        <div class="error-message" id="city-error"></div>
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label" for="zipCode">Zip Code</label>
                        <input type="text" id="zipCode" name="zipCode" class="input-field" required>
                        <div class="error-message" id="zipCode-error"></div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Information -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-credit-card"></i>
                    Payment Information
                </h2>
                
                <div class="input-group">
                    <label class="input-label" for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" class="input-field" placeholder="1234 5678 9012 3456" required>
                    <div class="error-message" id="cardNumber-error"></div>
                </div>
                
                <div class="input-group">
                    <label class="input-label" for="cardHolder">Card Holder</label>
                    <input type="text" id="cardHolder" name="cardHolder" class="input-field" required>
                    <div class="error-message" id="cardHolder-error"></div>
                </div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label class="input-label" for="expiryDate">Expiry Date</label>
                        <input type="text" id="expiryDate" name="expiryDate" class="input-field" placeholder="MM/YY" required maxlength="5">
                        <div class="error-message" id="expiryDate-error"></div>
                    </div>
                    
                    <div class="input-group">
                        <label class="input-label" for="cvv">Security Code (CVV)</label>
                        <input type="text" id="cvv" name="cvv" class="input-field" required maxlength="4">
                        <div class="error-message" id="cvv-error"></div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-shopping-cart"></i>
                    Order Summary
                </h2>
                
                <div class="mb-6">
                    @if(empty($cart))
                        <p>Your cart is empty</p>
                    @else
                        @foreach($cart as $item)
                        <div class="flex items-center justify-between border-b pb-4 mb-4">
                            <div class="flex items-center">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-16 object-cover rounded mr-4">
                                <div>
                                    <p class="font-medium">{{ $item['name'] }}</p>
                                    <p class="text-gray-600 text-sm">{{ $item['author'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">{{ $item['price'] * $item['quantity'] }} Dh</p>
                                <p class="text-sm">Qty: {{ $item['quantity'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>{{ $subtotal }} Dh</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>{{ $shipping }} Dh</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Tax (4%)</span>
                        <span>{{ $tax }} Dh</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg mt-4">
                        <span>Total</span>
                        <span>{{ $total + $shipping }} Dh</span>
                    </div>
                </div>
            </div>
            
            <button type="submit" id="submitBtn" class="submit-btn">Place Order</button>
        </form>
    </div>
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
    
    <script>
        // Format card number with spaces
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.slice(0, 16);
            
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue;
        });
        
        // Format expiry date with slash
        document.getElementById('expiryDate').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.slice(0, 4);
            
            if (value.length > 2) {
                e.target.value = value.slice(0, 2) + '/' + value.slice(2);
            } else {
                e.target.value = value;
            }
        });
        
        // Clear all error messages
        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => {
                el.textContent = '';
            });
            document.querySelectorAll('.input-field').forEach(el => {
                el.classList.remove('border-red-500');
            });
        }
        
        // Validate form before submission
        function handleSubmit() {
            clearErrors();
            let isValid = true;
            
            // Required fields validation
            const requiredFields = document.querySelectorAll('.input-field[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    document.getElementById(field.id + '-error').textContent = 'This field is required';
                }
            });
            
            // Card number validation
            const cardNumber = document.getElementById('cardNumber');
            const cardDigits = cardNumber.value.replace(/\D/g, '');
            if (cardDigits.length < 13) {
                isValid = false;
                cardNumber.classList.add('border-red-500');
                document.getElementById('cardNumber-error').textContent = 'Card number must have at least 13 digits';
            }
            
            // Expiry date validation
            const expiryDate = document.getElementById('expiryDate');
            if (!/^\d{2}\/\d{2}$/.test(expiryDate.value)) {
                isValid = false;
                expiryDate.classList.add('border-red-500');
                document.getElementById('expiryDate-error').textContent = 'Use MM/YY format';
            }
            
            // CVV validation
            const cvv = document.getElementById('cvv');
            if (!/^\d{3,4}$/.test(cvv.value)) {
                isValid = false;
                cvv.classList.add('border-red-500');
                document.getElementById('cvv-error').textContent = 'CVV must be 3 or 4 digits';
            }
            
            if (!isValid) {
                // Scroll to first error
                const firstErrorField = document.querySelector('.input-field.border-red-500');
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({behavior: 'smooth', block: 'center'});
                    firstErrorField.focus();
                }
                return false;
            }
            
            // Show loading overlay
            document.getElementById('loadingOverlay').classList.add('active');
            return true;
        }
    </script>
</body>
</html>
