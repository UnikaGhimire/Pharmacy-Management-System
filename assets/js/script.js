// DOMContentLoaded wrapper
document.addEventListener('DOMContentLoaded', function() {

    // --- Confirm delete actions ---
    document.querySelectorAll('a[onclick*="confirm"]').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) e.preventDefault();
        });
    });

    // --- Auto-hide alerts ---
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // --- Form validation ---
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            form.querySelectorAll('[required]').forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '';
                }
            });
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });

    // --- Password strength indicator ---
    document.querySelectorAll('input[type="password"]').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length < 6) this.style.borderColor = 'red';
            else if (this.value.length < 10) this.style.borderColor = 'orange';
            else this.style.borderColor = 'green';
        });
    });

    // --- Table search ---
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const text = this.value.toLowerCase();
            document.querySelectorAll('.data-table tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(text) ? '' : 'none';
            });
        });
    }

    // --- Prevent double submission ---
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Processing...';
            }
        });
    });

    // --- OTP input formatting ---
    const otpInput = document.getElementById('otp');
    if (otpInput) {
        otpInput.addEventListener('input', () => {
            otpInput.value = otpInput.value.replace(/[^0-9]/g, '');
        });
    }

    // --- OTP countdown timer ---
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        let seconds = parseInt(countdownEl.dataset.seconds, 10);
        const timer = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(timer);
                location.reload(); // show expired message
            } else {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                countdownEl.textContent =
                    String(m).padStart(2, '0') + ':' +
                    String(s).padStart(2, '0');
            }
        }, 1000);
    }
});

// --- Helpers ---
function formatCurrency(amount) {
    return 'Rs. ' + parseFloat(amount).toFixed(2);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric', month: 'short', day: 'numeric'
    });
}
document.addEventListener('DOMContentLoaded', function() {
    // OTP input - only numbers
    const otpInput = document.getElementById('otp');
    if (otpInput) {
        otpInput.addEventListener('input', () => {
            otpInput.value = otpInput.value.replace(/[^0-9]/g, '');
        });
    }

    // Countdown timer
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        let seconds = parseInt(countdownEl.dataset.seconds, 10);

        const timer = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(timer);
                countdownEl.textContent = "Expired";
                const btn = document.querySelector('button[type="submit"]');
                if (btn) btn.disabled = true;
                // Optional: reload page to show expired alert
                // location.reload();
            } else {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                countdownEl.textContent =
                    String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            }
        }, 1000);
    }
});
