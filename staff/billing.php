<?php 
$page_title = 'Create Bill';
include '../includes/header.php';
check_role('staff');

// Get all active medicines
$sql = "SELECT * FROM medicines WHERE stock_quantity > 0 AND expiry_date > CURDATE() ORDER BY name ASC";
$medicines_result = mysqli_query($conn, $sql);

// Get all patients
$sql = "SELECT id, name, email FROM users WHERE role = 'patient' ORDER BY name ASC";
$patients_result = mysqli_query($conn, $sql);
?>

<div class="billing-wrap">
    <div class="page-header">
        <h1>Create New Bill</h1>
        <a href="view_bills.php">View Bills</a>
    </div>

    <div class="form-container">
        <form action="process_billing.php" method="POST" class="billing-form" id="billingForm">
            <!-- CUSTOMER INFO -->
            <div class="customer-section">
                <h2>Customer Information</h2>
                
                <div class="form-group">
                    <label>Customer Type</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="customer_type" value="patient" checked onchange="toggleCustomerType()">
                            Registered Patient
                        </label>
                        <label>
                            <input type="radio" name="customer_type" value="guest" onchange="toggleCustomerType()">
                            Guest Customer
                        </label>
                    </div>
                </div>

                <div id="patientSelect" class="form-group">
                    <label for="patient_id">Select Patient</label>
                    <select id="patient_id" name="patient_id">
                        <option value="">-- Select Patient --</option>
                        <?php while ($patient = mysqli_fetch_assoc($patients_result)): ?>
                            <option value="<?php echo $patient['id']; ?>">
                                <?php echo htmlspecialchars($patient['name']); ?> 
                                (<?php echo htmlspecialchars($patient['email']); ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div id="guestInfo" style="display: none;">
                    <div class="form-group">
                        <label for="guest_name">Customer Name *</label>
                        <input type="text" id="guest_name" name="guest_name">
                    </div>
                    <div class="form-group">
                        <label for="guest_phone">Phone Number</label>
                        <input type="tel" id="guest_phone" name="guest_phone">
                    </div>
                </div>
            </div>

            <!-- BILL ITEMS -->
            <div class="items-section">
                <h2>Bill Items</h2>
                
                <div id="billItems">
                    <div class="bill-item">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Medicine</label>
                                <select name="medicine_id[]" class="medicine-select" required onchange="updatePrice(this)">
                                    <option value="">-- Select Medicine --</option>
                                    <?php 
                                    mysqli_data_seek($medicines_result, 0);
                                    while ($medicine = mysqli_fetch_assoc($medicines_result)): 
                                    ?>
                                        <option value="<?php echo $medicine['id']; ?>" 
                                                data-price="<?php echo $medicine['price']; ?>"
                                                data-stock="<?php echo $medicine['stock_quantity']; ?>">
                                            <?php echo htmlspecialchars($medicine['name']); ?> 
                                            (Stock: <?php echo $medicine['stock_quantity']; ?>) 
                                            - <?php echo format_currency($medicine['price']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity[]" class="quantity-input" min="1" value="1" required onchange="calculateSubtotal(this)">
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price[]" class="price-input" step="0.01" readonly>
                            </div>

                            <div class="form-group">
                                <label>Subtotal</label>
                                <input type="number" name="subtotal[]" class="subtotal-input" step="0.01" readonly>
                            </div>

                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary" onclick="addItem()">+ Add Item</button>
            </div>

            <!-- TOTAL -->
            <div class="total-section">
                <div class="total-display">
                    Total: <span id="totalAmount">Rs. 0.00</span>
                    <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                </div>
            </div>

            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select id="payment_status" name="payment_status" required>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">Create Bill</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="../assets/css/billing.css">
<script rel="javascript" src="../assets/js/billing.js"></script>



<?php include '../includes/footer.php'; ?>
