// Test file to verify JavaScript loading
console.log('Test JavaScript file loaded successfully');

// Simple function to test JavaScript execution
function testJS() {
    alert('JavaScript is working correctly!');
}

// Check if DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Test: DOM is ready');
    
    // Test if we can find the contact form
    const form = document.getElementById('contactForm');
    if (form) {
        console.log('Test: Contact form found');
    } else {
        console.log('Test: Contact form NOT found');
    }
    
    // Test if we can find the result div
    const result = document.getElementById('result');
    if (result) {
        console.log('Test: Result div found');
    } else {
        console.log('Test: Result div NOT found');
    }
});
