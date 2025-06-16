<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Coffee Studio - Costobrew</title>
    <!-- Load Readex Pro font first -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
      <style></style>
        /* Ensure Readex Pro font is used */
        body, .studio-title, .studio-subtitle, .coffee-title, .warning-text, .section-title {
            font-family: "Readex Pro", sans-serif !important;
            font-optical-sizing: auto;
            font-variation-settings: "HEXP" 0;
        }
        
        .studio-background {
            background: linear-gradient(135deg, #8B4513 0%, #A0522D 50%, #D2B48C 100%);
            min-height: 100vh;
            background-attachment: fixed;
        }
        
        .studio-main-card {
            background: #F5E6D3;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin: 40px auto;
            max-width: 900px;
            padding: 40px;
        }
        
        .studio-title {
            color: #5D4037;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .studio-subtitle {
            color: #8D6E63;
            margin-bottom: 40px;
        }
        
        .coffee-option-card {
            background: #FFFFFF;
            border: none;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 0 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        
        .coffee-option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .coffee-option-card.premade {
            background: #6D4C41;
            color: white;
        }
        
        .coffee-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #5D4037;
        }
        
        .coffee-option-card.premade .coffee-icon {
            color: white;
        }
        
        .coffee-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #5D4037;
            margin-bottom: 15px;
        }
        
        .coffee-option-card.premade .coffee-title {
            color: white;
        }
        
        .warning-message {
            background: rgba(255, 152, 0, 0.1);
            border: 1px solid #FF9800;
            border-radius: 10px;
            padding: 15px;
            margin-top: 30px;
            text-align: center;
        }
        
        .warning-text {
            color: #F57C00;
            font-weight: 500;
            margin: 0;
        }
        
        .section-title {
            text-align: center;
            color: #5D4037;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 40px;
        }
    </style>
</head>
<body class="studio-background">
<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container-fluid">
    <div class="studio-main-card">
        <!-- Studio Header -->
        <div class="text-center mb-5">
            <h1 class="studio-title">Coffee Studio</h1>
            <p class="studio-subtitle">Create your own Coffee from the ground up or Choose in our fine selection of Coffee's and pastries to go with.</p>
        </div>
        
        <!-- Selection Title -->
        <h2 class="section-title">Select how you want your coffee</h2>
        
        <!-- Coffee Options -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-4 col-md-6">
                <div class="coffee-option-card" onclick="selectDIY()">
                    <!-- Coffee Cup Icon -->
                    <div class="coffee-icon">
                        <svg width="80" height="80" viewBox="0 0 100 100" fill="currentColor">
                            <path d="M20 25 L80 25 L78 75 C78 80 74 85 68 85 L32 85 C26 85 22 80 22 75 Z"/>
                            <path d="M15 25 L85 25 C87 25 89 23 89 21 C89 19 87 17 85 17 L15 17 C13 17 11 19 11 21 C11 23 13 25 15 25"/>
                            <circle cx="50" cy="50" r="15" fill="none" stroke="currentColor" stroke-width="3"/>
                            <path d="M35 40 Q50 30 65 40"/>
                        </svg>
                    </div>
                    <h3 class="coffee-title">DIY Coffee</h3>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="coffee-option-card premade" onclick="selectPremade()">
                    <!-- Coffee Cup Icon -->
                    <div class="coffee-icon">
                        <svg width="80" height="80" viewBox="0 0 100 100" fill="currentColor">
                            <path d="M20 25 L80 25 L78 75 C78 80 74 85 68 85 L32 85 C26 85 22 80 22 75 Z"/>
                            <path d="M15 25 L85 25 C87 25 89 23 89 21 C89 19 87 17 85 17 L15 17 C13 17 11 19 11 21 C11 23 13 25 15 25"/>
                            <circle cx="50" cy="50" r="15" fill="none" stroke="currentColor" stroke-width="3"/>
                            <path d="M35 40 Q50 30 65 40"/>
                        </svg>
                    </div>
                    <h3 class="coffee-title">Premade</h3>
                </div>
            </div>
        </div>
        
        <!-- Warning Message -->
        <div class="warning-message">
            <p class="warning-text">
                <strong>Warning:</strong> DIY Coffee Gives you Full control, knowledge recommended, non-refundable.
            </p>
        </div>
    </div>
</main>

<script>
function selectDIY() {
    window.location.href = '/studio/diy';
}

function selectPremade() {
    window.location.href = '/studio/premade';
}
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
