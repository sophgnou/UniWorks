document.addEventListener('DOMContentLoaded', function() {
    // Show/hide payment details based on selection
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paymentDetails = document.getElementById('credit-card-details');
    
    function togglePaymentDetails() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        paymentDetails.style.display = selectedMethod === 'credit_card' ? 'block' : 'none';
    }
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', togglePaymentDetails);
    });
    
    // Initialize
    togglePaymentDetails();
});