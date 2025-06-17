// General Application JavaScript - CostoBrew
'use strict';

console.log('CostoBrew app.js loaded successfully');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - CostoBrew app initialized');

    // Counter Animation for Statistics
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const suffix = element.getAttribute('data-suffix') || '';
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + suffix;
        }, 16);
    }

    // Create intersection observer to trigger animations when elements come into view
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target); // Only animate once
                }
            });
        }, {
            threshold: 0.5 // Trigger when 50% of element is visible
        });

        // Observe all counter elements
        document.querySelectorAll('.counter').forEach(counter => {
            observer.observe(counter);
        });
    }

    // Web3Forms Validation Function
    function validateForm(formData) {
        const name = formData.get('name');
        const email = formData.get('email');
        const message = formData.get('message');
        const accessKey = formData.get('access_key');

        if (!name || name.trim().length < 2) {
            return 'Please enter a valid name (at least 2 characters)';
        }

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            return 'Please enter a valid email address';
        }

        if (!message || message.trim().length < 10) {
            return 'Please enter a message (at least 10 characters)';
        }

        if (!accessKey) {
            return 'Form configuration error: missing access key';
        }

        return null; // No errors
    }

    // Contact Form Handler with Web3Forms Integration
    const contactForm = document.getElementById('contactForm');
    const result = document.getElementById('result');

    if (contactForm && result) {
        console.log('Contact form found, setting up Web3Forms integration');

        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submission intercepted - processing with Web3Forms');

            // Get form data
            const formData = new FormData(contactForm);
            
            // Validate form
            const validationError = validateForm(formData);
            if (validationError) {
                result.innerHTML = '<div class="alert alert-warning mb-0"><i class="bi bi-exclamation-triangle me-2"></i>' + validationError + '</div>';
                result.style.display = "block";
                setTimeout(() => {
                    result.style.display = "none";
                }, 5000);
                return;
            }

            // Convert to JSON
            const object = Object.fromEntries(formData);
            const json = JSON.stringify(object);

            console.log('Submitting form data to Web3Forms:', object);

            // Show loading state
            result.innerHTML = '<div class="alert alert-info mb-0"><i class="bi bi-clock me-2"></i>Sending your message...</div>';
            result.style.display = "block";

            // Submit to Web3Forms API
            fetch('https://api.web3forms.com/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: json
            })
            .then(async (response) => {
                console.log('Web3Forms response status:', response.status);
                const responseData = await response.json();
                console.log('Web3Forms response data:', responseData);
                
                if (response.status === 200) {
                    result.innerHTML = '<div class="alert alert-success mb-0"><i class="bi bi-check-circle me-2"></i>Message sent successfully! We\'ll get back to you soon.</div>';
                    contactForm.reset(); // Reset form on success
                    
                    // Remove validation classes
                    contactForm.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                        el.classList.remove('is-valid', 'is-invalid');
                    });
                } else {
                    console.error('Web3Forms submission error:', responseData);
                    result.innerHTML = '<div class="alert alert-danger mb-0"><i class="bi bi-x-circle me-2"></i>' + (responseData.message || 'Error submitting form. Please try again.') + '</div>';
                }
            })
            .catch(error => {
                console.error('Network error during form submission:', error);
                result.innerHTML = '<div class="alert alert-danger mb-0"><i class="bi bi-wifi-off me-2"></i>Network error! Please check your connection and try again.</div>';
            })
            .finally(() => {
                // Hide message after delay
                setTimeout(() => {
                    if (result.style.display !== "none") {
                        result.style.display = "none";
                    }
                }, 8000);
            });
        });

        // Add real-time validation feedback
        const inputs = {
            name: contactForm.querySelector('#name'),
            email: contactForm.querySelector('#email'),
            message: contactForm.querySelector('#message')
        };

        // Name validation
        if (inputs.name) {
            inputs.name.addEventListener('blur', function() {
                if (this.value.trim().length < 2) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }

        // Email validation
        if (inputs.email) {
            inputs.email.addEventListener('blur', function() {
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }

        // Message validation
        if (inputs.message) {
            inputs.message.addEventListener('blur', function() {
                if (this.value.trim().length < 10) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }

    } else {
        console.log('Contact form or result element not found on this page');
        if (!contactForm) console.log('Element with ID "contactForm" not found');
        if (!result) console.log('Element with ID "result" not found');
    }

    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Global error handler for debugging
    window.addEventListener('error', function(e) {
        console.error('JavaScript error:', e.error);
        console.error('Error details:', {
            message: e.message,
            filename: e.filename,
            lineno: e.lineno,
            colno: e.colno
        });
    });

    console.log('CostoBrew app.js initialization complete');
});