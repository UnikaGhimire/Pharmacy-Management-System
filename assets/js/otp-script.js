document.addEventListener('DOMContentLoaded', () => {
    const otpInput = document.getElementById('otp');
    if (otpInput) {
        otpInput.addEventListener('input', () => {
            otpInput.value = otpInput.value.replace(/[^0-9]/g, '');
        });
    }

    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        let seconds = parseInt(countdownEl.dataset.seconds, 10);

        const timer = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(timer);
                countdownEl.textContent = "Expired";
                document.querySelector('button.btn').disabled = true;
            } else {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                countdownEl.textContent =
                    String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            }
        }, 1000);
    }
});
