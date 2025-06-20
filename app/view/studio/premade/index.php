<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premade Coffee Studio - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
        .btn-circle {
            width: 50px;
            height: 50px;
            border-radius: 50% !important;
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            min-height: calc(100vh - 120px);
            /* Adjust for header height */
            margin-bottom: 3rem;
            /* Add bottom margin for footer spacing */
        }

        .content-row {
            height: 100%;
        }        .content-columns {
            min-height: calc(100vh - 260px);
            /* Account for header, padding, and footer margin */
        }
        
        .stage-content {
            display: none;
        }
        
        .stage-content.active {
            display: block;
        }
        
        .ingredient-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .ingredient-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .ingredient-card.selected {
            border: 2px solid #8B4513 !important;
            background-color: rgba(139, 69, 19, 0.1) !important;
        }
    </style>
</head>

<body data-bs-theme="dark" class="d-flex flex-column min-vh-100 text-dark mainbg">
    <?php include __DIR__ . '/../../includes/header.php'; ?>
    <div class="container-fluid px-5 pt-5 main-content">
        <div class="pt-5 pb-3"></div>
        <div class="row row-cols-2 w-100 content-row">
            <div class="col-lg form-bg p-4 content-columns d-flex flex-column">
                <div class="text-dark w-50">
                    <h4 class="fw-semibold">Coffee Studio - Premade</h4>
                    <p>Choose from our expertly crafted coffee blends. Quick, easy, and perfectly balanced for your taste.</p>
                </div>                <div class="text-dark text-center mt-5">
                    <h5 id="stageTitle">Select your Cup</h5>
                </div>

                <!-- Stage 1: Cup Selector -->
                <div class="stage-content active" id="stage-0">
                    <div class="row row-cols-4 g-3 mt-3 justify-content-center">
                        <!-- Small Cup -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="cup" data-value="small" data-price="95.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-hot" style="font-size: 2.5rem; color: #8B4513;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Small</h6>
                                    <small class="text-muted d-block mb-3">8 oz</small>
                                </div>
                            </div>
                        </div>
                        <!-- Medium Cup -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="cup" data-value="medium" data-price="115.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-hot" style="font-size: 2.5rem; color: #8B4513;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Medium</h6>
                                    <small class="text-muted d-block mb-3">12 oz</small>
                                </div>
                            </div>
                        </div>
                        <!-- Large Cup -->
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="cup" data-value="large" data-price="135.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-hot" style="font-size: 2.5rem; color: #8B4513;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Large</h6>
                                    <small class="text-muted d-block mb-3">16 oz</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stage 2: Coffee Selector -->
                <div class="stage-content" id="stage-1">
                    <div class="row row-cols-4 g-3 mt-3 justify-content-center">
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="coffee" data-value="house-blend" data-price="0.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-straw" style="font-size: 2.5rem; color: #8B4513;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">House Blend</h6>
                                    <small class="text-muted d-block mb-3">Balanced</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="coffee" data-value="colombian-supreme" data-price="25.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-straw" style="font-size: 2.5rem; color: #D2691E;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Colombian Supreme</h6>
                                    <small class="text-muted d-block mb-3">Premium</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="coffee" data-value="dark-espresso" data-price="20.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-straw" style="font-size: 2.5rem; color: #654321;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Dark Espresso</h6>
                                    <small class="text-muted d-block mb-3">Bold</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="coffee" data-value="french-vanilla" data-price="30.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-straw" style="font-size: 2.5rem; color: #DEB887;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">French Vanilla</h6>
                                    <small class="text-muted d-block mb-3">Flavored</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="coffee" data-value="hazelnut-cream" data-price="30.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-straw" style="font-size: 2.5rem; color: #CD853F;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Hazelnut Cream</h6>
                                    <small class="text-muted d-block mb-3">Nutty</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="coffee" data-value="decaf-blend" data-price="0.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-cup-straw" style="font-size: 2.5rem; color: #A0522D;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Decaf Blend</h6>
                                    <small class="text-muted d-block mb-3">Decaf</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stage 3: Pastry Selector -->
                <div class="stage-content" id="stage-2">
                    <div class="row row-cols-4 g-3 mt-3 justify-content-center">
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="none" data-price="0.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-x-circle" style="font-size: 2.5rem; color: #6c757d;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">No Pastry</h6>
                                    <small class="text-muted d-block mb-3">Just Coffee</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="croissant" data-price="85.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-egg-fried" style="font-size: 2.5rem; color: #DAA520;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Croissant</h6>
                                    <small class="text-muted d-block mb-3">Buttery</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="blueberry-muffin" data-price="85.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-circle-fill" style="font-size: 2.5rem; color: #4169E1;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Blueberry Muffin</h6>
                                    <small class="text-muted d-block mb-3">Sweet</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="chocolate-cookie" data-price="45.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-circle-fill" style="font-size: 2.5rem; color: #8B4513;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Chocolate Cookie</h6>
                                    <small class="text-muted d-block mb-3">Chewy</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="danish" data-price="65.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-heart-fill" style="font-size: 2.5rem; color: #FF69B4;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Danish Pastry</h6>
                                    <small class="text-muted d-block mb-3">Fruit-filled</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="bagel" data-price="55.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-circle" style="font-size: 2.5rem; color: #D2B48C;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Bagel</h6>
                                    <small class="text-muted d-block mb-3">Cream Cheese</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="cinnamon-roll" data-price="70.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-arrow-clockwise" style="font-size: 2.5rem; color: #CD853F;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Cinnamon Roll</h6>
                                    <small class="text-muted d-block mb-3">Spiral</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white ingredient-card" data-stage="pastry" data-value="donut" data-price="39.00">
                                <div class="card-body p-2">
                                    <div class="mb-3">
                                        <i class="bi bi-circle" style="font-size: 2.5rem; color: #FF6347;"></i>
                                    </div>
                                    <h6 class="card-title text-dark mb-1">Glazed Donut</h6>
                                    <small class="text-muted d-block mb-3">Classic</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                <p class="text-center text-muted mt-3 mb-4">Choose your preferred cup size</p>
                <div class="d-flex justify-content-center align-items-center mt-4">
                    <button class="btn btn-custom-brown btn-circle me-3">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button class="btn btn-custom-brown rounded-pill px-4" id="resetBtn">Reset</button>
                    <button class="btn btn-custom-brown btn-circle ms-3">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
            <div class="col-lg-3 global-bg ms-3 p-4 content-columns d-flex flex-column">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <h5 class="fw-semibold text-dark mb-0">Order No:</h5>
                    <p class="text-dark mb-0">123456789</p>
                </div>                <div class="flex-grow-1">
                    <!--Container of selected items-->
                    <div class="mt-3">
                        <ul class="list-group mt-2">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center bg-white text-dark">
                                <span>Espresso</span>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center bg-white text-dark">
                                <span>Espresso</span>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center bg-white text-dark">
                                <span>Espresso</span>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center bg-white text-dark">
                                <span>Espresso</span>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center bg-white text-dark">
                                <span>Espresso</span>
                                <span class="badge bg-primary rounded-pill">1</span>
                            </li>
                        </ul>
                    </div>
                </div>                <div class="mt-auto">
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-dark">Delivery fee:</span>
                            <span class="text-dark" id="deliveryFeeDisplay">₱50.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-dark">VAT (12%):</span>
                            <span class="text-dark" id="vatDisplay">₱0.00</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-semibold text-dark mb-0">Total:</h5>
                            <h5 class="fw-semibold text-dark mb-0" id="totalDisplay">₱50.00</h5>
                        </div>
                    </div><div class="mt-3">
                        <button class="btn btn-custom-brown w-100 rounded rounded-pill" id="checkoutBtn">Checkout</button>
                        <p class="text-dark mt-2 text-center">By proceeding, you agree to our <a href="#"
                                class="text-primary">Terms of Service</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../../includes/footer.php'; ?>    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Stage management
        let currentStage = 0;
        const totalStages = 3;
        const stageTitles = [
            "Select your Cup",
            "Choose your Coffee", 
            "Add a Pastry"
        ];
        
        // Order state
        let coffeeOrder = {
            cup: null,
            coffee: null,
            pastry: null
        };
          // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
            updateStageTitle();
            updateNavigationButtons();
            updateOrderSummary();
            updateOrderNumber();
        });
        
        function updateOrderNumber() {
            // Generate a realistic order number
            const timestamp = Date.now();
            const orderNo = 'ORD' + timestamp.toString().slice(-8);
            document.querySelector('.d-flex.flex-wrap.align-items-center.justify-content-between p').textContent = orderNo;
        }function setupEventListeners() {
            // Previous/Next buttons
            document.querySelector('.btn-circle:first-child').addEventListener('click', previousStage);
            document.querySelector('.btn-circle:last-child').addEventListener('click', nextStage);
            
            // Reset button
            document.getElementById('resetBtn').addEventListener('click', resetOrder);
            
            // Checkout button
            document.getElementById('checkoutBtn').addEventListener('click', proceedToCheckout);
            
            // Ingredient cards
            document.querySelectorAll('.ingredient-card').forEach(card => {
                card.addEventListener('click', function() {
                    selectIngredient(this);
                });
            });
        }
        
        function selectIngredient(card) {
            const stage = card.dataset.stage;
            const value = card.dataset.value;
            const price = parseFloat(card.dataset.price);
            
            // Remove selection from other cards in this stage
            const currentStageElement = document.getElementById(`stage-${currentStage}`);
            currentStageElement.querySelectorAll('.ingredient-card').forEach(c => {
                c.classList.remove('selected');
            });
            
            // Select this card
            card.classList.add('selected');
            
            // Update order
            coffeeOrder[stage] = {
                value: value,
                price: price,
                name: card.querySelector('.card-title').textContent
            };
            
            updateOrderSummary();
            
            // Auto-advance to next stage after selection
            setTimeout(() => {
                if (currentStage < totalStages - 1) {
                    nextStage();
                }
            }, 500);
        }
        
        function previousStage() {
            if (currentStage > 0) {
                currentStage--;
                updateStage();
            }
        }
        
        function nextStage() {
            if (currentStage < totalStages - 1) {
                currentStage++;
                updateStage();
            }
        }
        
        function updateStage() {
            // Hide all stages
            document.querySelectorAll('.stage-content').forEach(stage => {
                stage.classList.remove('active');
            });
            
            // Show current stage
            document.getElementById(`stage-${currentStage}`).classList.add('active');
            
            updateStageTitle();
            updateNavigationButtons();
        }
        
        function updateStageTitle() {
            document.getElementById('stageTitle').textContent = stageTitles[currentStage];
        }
        
        function updateNavigationButtons() {
            const prevBtn = document.querySelector('.btn-circle:first-child');
            const nextBtn = document.querySelector('.btn-circle:last-child');
            
            // Update previous button
            if (currentStage === 0) {
                prevBtn.style.opacity = '0.5';
                prevBtn.style.pointerEvents = 'none';
            } else {
                prevBtn.style.opacity = '1';
                prevBtn.style.pointerEvents = 'auto';
            }
            
            // Update next button
            if (currentStage === totalStages - 1) {
                nextBtn.style.opacity = '0.5';
                nextBtn.style.pointerEvents = 'none';
            } else {
                nextBtn.style.opacity = '1';
                nextBtn.style.pointerEvents = 'auto';
            }
        }
        
        function updateOrderSummary() {
            const orderContainer = document.querySelector('.list-group');
            orderContainer.innerHTML = '';
            
            let total = 0;
            
            // Add selected items to order
            Object.entries(coffeeOrder).forEach(([key, item]) => {
                if (item && item.value !== 'none') {
                    total += item.price;
                    
                    orderContainer.innerHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-white text-dark">
                            <span>${item.name}</span>
                            <span class="badge bg-primary rounded-pill">₱${item.price.toFixed(2)}</span>
                        </li>
                    `;
                }
            });
            
            // If no items selected, show placeholder
            if (total === 0) {
                orderContainer.innerHTML = `
                    <li class="list-group-item bg-white text-dark text-center">
                        <em>No items selected yet</em>
                    </li>
                `;
            }
              // Update total
            const deliveryFee = 50; // ₱50 delivery fee
            const vatRate = 0.12; // 12% VAT for Philippines
            const subtotalWithDelivery = total + deliveryFee;
            const vat = subtotalWithDelivery * vatRate;
            const finalTotal = subtotalWithDelivery + vat;
            
            // Debug logging - more detailed
            console.log('=== Premade Coffee Studio Calculation Debug ===');
            console.log('Items selected:');
            Object.entries(coffeeOrder).forEach(([key, item]) => {
                if (item && item.value !== 'none') {
                    console.log(`  ${key}: ${item.name} = ₱${item.price.toFixed(2)}`);
                }
            });
            console.log('Subtotal (items only):', total.toFixed(2));
            console.log('Delivery Fee:', deliveryFee.toFixed(2));
            console.log('Subtotal + Delivery:', subtotalWithDelivery.toFixed(2));
            console.log('VAT Rate:', (vatRate * 100) + '%');
            console.log('VAT Amount (12% of ₱' + subtotalWithDelivery.toFixed(2) + '):', vat.toFixed(2));
            console.log('Final Total:', finalTotal.toFixed(2));
            console.log('===============================================');
            
            // Update delivery fee display
            const deliveryFeeElement = document.getElementById('deliveryFeeDisplay');
            if (deliveryFeeElement) {
                deliveryFeeElement.textContent = `₱${deliveryFee.toFixed(2)}`;
                console.log('✅ Updated delivery fee display to:', deliveryFeeElement.textContent);
            } else {
                console.log('❌ Could not find delivery fee element');
            }
            
            // Update VAT display  
            const vatElement = document.getElementById('vatDisplay');
            if (vatElement) {
                vatElement.textContent = `₱${vat.toFixed(2)}`;
                console.log('✅ Updated VAT display to:', vatElement.textContent);
            } else {
                console.log('❌ Could not find VAT element');
            }
              // Update final total display
            const totalElement = document.getElementById('totalDisplay');
            if (totalElement) {
                totalElement.textContent = `₱${finalTotal.toFixed(2)}`;
                console.log('✅ Updated final total display to:', totalElement.textContent);
            } else {
                console.log('❌ Could not find total element');
            }
        }
        
        function resetOrder() {
            // Reset order state
            coffeeOrder = {
                cup: null,
                coffee: null,
                pastry: null
            };
            
            // Remove all selections
            document.querySelectorAll('.ingredient-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Reset to first stage
            currentStage = 0;            updateStage();
            updateOrderSummary();
        }        function proceedToCheckout() {
            // Check if at least cup and coffee are selected (only required fields for premade)
            if (!coffeeOrder.cup) {
                alert('Please select a cup size before checkout.');
                return;
            }
            
            if (!coffeeOrder.coffee) {
                alert('Please select a coffee before checkout.');
                return;
            }
            
            // Calculate total (only count items that are selected)
            let total = 0;
            Object.values(coffeeOrder).forEach(item => {
                if (item && item.price) {
                    total += item.price;
                }
            });
            
            // Ensure minimum total
            if (total <= 0) {
                alert('Please select at least a cup size and coffee.');
                return;
            }
            
            // Calculate totals for checkout data
            let subtotal = 0;
            Object.values(coffeeOrder).forEach(item => {
                if (item && item.price) {
                    subtotal += item.price;
                }
            });
            
            const deliveryFee = 50;
            const subtotalWithDelivery = subtotal + deliveryFee;
            const vatAmount = subtotalWithDelivery * 0.12;
            const finalTotal = subtotalWithDelivery + vatAmount;
            
            // Generate order number (matches DIY format)
            const date = new Date();
            const dateStr = date.getFullYear().toString() + 
                           (date.getMonth() + 1).toString().padStart(2, '0') + 
                           date.getDate().toString().padStart(2, '0');
            const orderNumber = 'CB' + dateStr + Math.floor(Math.random() * 9000 + 1000);
            
            console.log('=== Premade Checkout Data Debug ===');
            console.log('Order Number:', orderNumber);
            console.log('Items subtotal:', subtotal.toFixed(2));
            console.log('Delivery fee:', deliveryFee.toFixed(2));
            console.log('VAT amount:', vatAmount.toFixed(2));
            console.log('Final total:', finalTotal.toFixed(2));
            console.log('==================================');
            
            // Prepare data for checkout
            const checkoutData = {
                type: 'premade_coffee',
                coffee_name: coffeeOrder.coffee ? coffeeOrder.coffee.name : 'Premade Coffee',
                build: coffeeOrder,
                subtotal: subtotal,
                deliveryFee: deliveryFee,
                vatAmount: vatAmount,
                total: finalTotal,
                price: finalTotal,  // Keep for compatibility
                orderNumber: orderNumber
            };
            
            // Show loading state
            const checkoutBtn = document.getElementById('checkoutBtn');
            const originalText = checkoutBtn.textContent;
            checkoutBtn.textContent = 'Processing...';
            checkoutBtn.disabled = true;
            
            // Send to server
            fetch('/studio/direct-checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(checkoutData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'Something went wrong. Please try again.');
                    checkoutBtn.textContent = originalText;
                    checkoutBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error. Please check your connection and try again.');
                checkoutBtn.textContent = originalText;
                checkoutBtn.disabled = false;
            });
        }
    </script>
</body>

</html>
