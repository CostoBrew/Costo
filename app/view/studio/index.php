<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Studio - Costobrew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
    <style>
        .studio-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .studio-panel {
            background: rgba(237, 225, 210, 0.98);
            border-radius: 20px 20px 20px 0px;
            max-width: 800px;
            width: 100%;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        
        .studio-title {
            color: #2d1810;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 16px;
        }
        
        .studio-description {
            color: #6b5b73;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 40px;
        }
        
        .selection-title {
            color: #2d1810;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 40px;
        }
        
        .coffee-options {
            display: flex;
            gap: 30px;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .coffee-option {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            width: 260px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        
        .coffee-option:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }
        
        .coffee-option.diy {
            background: white;
            color: #2d1810;
        }
        
        .coffee-option.premade {
            background: #3d2b1f;
            color: white;
        }
        
        .coffee-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            display: block;
        }
        
        .coffee-option-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }
        
        .warning-text {
            color: #dc3545;
            font-size: 0.95rem;
            font-weight: 500;
            margin-top: 20px;
            background: rgba(220, 53, 69, 0.1);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #dc3545;
        }
        
        @media (max-width: 768px) {
            .coffee-options {
                flex-direction: column;
                align-items: center;
            }
            
            .coffee-option {
                width: 100%;
                max-width: 280px;
            }
            
            .studio-panel {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body data-bs-theme="dark" class="d-flex flex-column min-vh-100 mainbg">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <div class="studio-container pt-5 mt-3">
        <div class="studio-panel p-5">

            <div class="text-start mb-4 w-50 text-dark mb-5">
            <h4 class="fw-semibold">Coffee Studio</h1>
            <p>
                Create your own Coffee from the ground up or Choose in our fine selection of Coffee's and pastries to go with.
            </p>
            </div>

            <h4 class="fw-semibold text-dark mb-5">Select how you want your coffee</h4>

            <div class="coffee-options">
                <a href="/studio/diy" class="coffee-option diy">
                    <div class="coffee-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"/>
                            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/>
                            <line x1="6" y1="2" x2="6" y2="4"/>
                            <line x1="10" y1="2" x2="10" y2="4"/>
                            <line x1="14" y1="2" x2="14" y2="4"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </div>
                    <h3 class="coffee-option-title">DIY Coffee</h3>
                </a>
                
                <a href="/studio/premade" class="coffee-option premade">
                    <div class="coffee-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"/>
                            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/>
                            <line x1="6" y1="2" x2="6" y2="4"/>
                            <line x1="10" y1="2" x2="10" y2="4"/>
                            <line x1="14" y1="2" x2="14" y2="4"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </div>
                    <h3 class="coffee-option-title">Premade</h3>
                </a>
            </div>
            
            <div class="warning-text">
                <strong>Warning:</strong> DIY Coffee Gives you Full control, knowledge recommended, non-refundable.
            </div>
        </div>
    </div>
    
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
