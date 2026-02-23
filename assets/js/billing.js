function toggleCustomerType() {
    const customerType = document.querySelector('input[name="customer_type"]:checked').value;
    document.getElementById('patientSelect').style.display = customerType === 'patient' ? 'block' : 'none';
    document.getElementById('guestInfo').style.display = customerType === 'guest' ? 'block' : 'none';
    document.getElementById('patient_id').required = customerType === 'patient';
    document.getElementById('guest_name').required = customerType === 'guest';
}

// Add / Remove items
function addItem() {
    const billItems = document.getElementById('billItems');
    const firstItem = billItems.querySelector('.bill-item');
    const newItem = firstItem.cloneNode(true);
    newItem.querySelectorAll('input, select').forEach(input => {
        if(input.type==='number') input.value = input.classList.contains('quantity-input') ? '1' : '';
        else if(input.tagName==='SELECT') input.selectedIndex=0;
    });
    billItems.appendChild(newItem);
}

function removeItem(button) {
    const billItems = document.getElementById('billItems');
    if(billItems.children.length>1) button.closest('.bill-item').remove();
    calculateTotal();
}

function updatePrice(select){
    const option = select.options[select.selectedIndex];
    const price = option?.getAttribute('data-price')||0;
    const row = select.closest('.bill-item');
    row.querySelector('.price-input').value = price;
    calculateSubtotal(row.querySelector('.quantity-input'));
}

function calculateSubtotal(input){
    const row = input.closest('.bill-item');
    const price = parseFloat(row.querySelector('.price-input').value)||0;
    const quantity = parseInt(input.value)||0;
    row.querySelector('.subtotal-input').value = (price*quantity).toFixed(2);
    calculateTotal();
}

function calculateTotal(){
    let total = 0;
    document.querySelectorAll('.subtotal-input').forEach(input=>{
        total+=parseFloat(input.value)||0;
    });
    document.getElementById('totalAmount').textContent = 'Rs. '+total.toFixed(2);
    document.getElementById('totalAmountInput').value = total.toFixed(2);
}
