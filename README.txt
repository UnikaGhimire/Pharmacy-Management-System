===============================================
SUNWAY-PHARMACY MEDICAL MANAGEMENT SYSTEM
===============================================

INSTALLATION INSTRUCTIONS:
--------------------------

How to Access the System?
   - Open your browser
   - Go to: http://localhost/sunway-pharmacy/
   - You will see the login page

1. DEFAULT LOGIN CREDENTIALS:
   
   Admin Account:
   Email: admin@sunway.com
   Password: admin123
   
   Staff Account:
   Email: staff@sunway.com
   Password: staff123
   
   Patient Account:
   Email: patient@example.com
   Password: unikaghimire


2. FEATURES AVAILABLE:

   Admin Features:
   - View dashboard with statistics
   - Manage staff (Add, Edit, Delete)
   - View activity logs
   - Generate reports (Sales, Stock, Expiry)

   Staff Features:
   - Manage patients
   - Manage medicines
   - Create bills for patients or guests
   - View all bills
   - Update stock automatically after sales

   Patient Features:
   - View profile
   - Edit profile information
   - View purchase history
   - Change password

3. SECURITY FEATURES:
   - Password hashing (bcrypt)
   - Login attempt limiting (5 attempts)
   - 1-minute lockout after failed attempts
   - Forgot password with OTP
   - Session-based authentication
   - Activity logging

4. TROUBLESHOOTING:

   Problem: "Connection failed" error
   Solution: Make sure MySQL is running in XAMPP

   Problem: "Database not found" error
   Solution: Check if database is created properly

   Problem: Can't login
   Solution: Verify database contains user records

   Problem: Page not found (404)
   Solution: Check project is in htdocs folder

5. PROJECT STRUCTURE:
   
   sunway-pharmacy/
   ├── config/           (Database & constants)
   ├── auth/             (Login, forgot password)
   ├── admin/            (Admin panel)
   ├── staff/            (Staff panel)
   ├── patient/          (Patient panel)
   ├── includes/         (Header, footer, navbar)
   ├── assets/           (CSS, JS, images)
   └── index.php         (Login page)

6. SUPPORT:
   - For issues, check error logs in: xampp/apache/logs/
   - Enable error reporting in php.ini if needed
   - Check browser console for JavaScript errors


===============================================
ENJOY USING SUNWAY-PHARMACY SYSTEM!
===============================================