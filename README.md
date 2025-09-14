# Food Delivery System

A complete food delivery web application built with PHP, MySQL, HTML, CSS, and JavaScript.

## Features

### Customer Features
- User registration and login
- Browse restaurants and menus
- Add items to cart
- Place orders with delivery details
- View order history and status

### Restaurant Owner Features
- Restaurant dashboard
- Add and manage menu items
- View incoming orders
- Update order status (pending → confirmed → preparing → out for delivery → delivered)

### Admin Features
- System overview dashboard
- User management capabilities

## Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP
- **Database**: MySQL
- **Server**: Apache (XAMPP)

## Installation

1. **Install XAMPP**
   - Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Start Apache and MySQL services

2. **Setup Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the SQL file: `sql/dbrestupdate.sql`
   - This will create the database and sample data

3. **Deploy Files**
   - Copy the project folder to `xampp/htdocs/`
   - Access the application at `http://localhost/food%20delivery%20system/frontend/`

## Default Login Credentials

- **Admin**: admin@admin.com / password
- **Customer**: john@customer.com / password
- **Restaurant Owner**: pizza@restaurant.com / password

## Project Structure

```
food-delivery-system/
├── frontend/
│   ├── index.html              # Homepage
│   ├── login.html              # Login page
│   ├── signup.html             # Registration page
│   ├── style.css               # Main stylesheet
│   ├── script.js               # Main JavaScript
│   ├── customer/
│   │   └── customer_dashboard.html
│   ├── restaurant/
│   │   └── owner_dashboard.html
│   └── admin/
│       └── admin_dashboard.html
├── backend/
│   ├── db.php                  # Database connection
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   ├── customer/
│   │   ├── get_restaurents.php
│   │   ├── add_to_cart.php
│   │   ├── get_cart.php
│   │   ├── place_order.php
│   │   ├── get_orders.php
│   │   └── remove_from_cart.php
│   └── restaurant/
│       ├── get_menu.php
│       ├── add_menu_item.php
│       ├── get_orders.php
│       └── update_order_status.php
└── sql/
    └── dbrestupdate.sql        # Database schema
```

## Database Schema

- **users**: User accounts (customers, restaurant owners, admin)
- **restaurants**: Restaurant information
- **menu_items**: Restaurant menu items
- **orders**: Customer orders
- **order_items**: Individual items in orders
- **cart**: Temporary cart storage

## Features Implemented

✅ User authentication (login/register)  
✅ Role-based access (customer, restaurant, admin)  
✅ Restaurant browsing  
✅ Menu viewing  
✅ Shopping cart functionality  
✅ Order placement  
✅ Order status tracking  
✅ Restaurant order management  
✅ Responsive design  
✅ Modern UI with animations  

## Usage

1. **For Customers**:
   - Register/login as customer
   - Browse restaurants
   - View menus and add items to cart
   - Checkout with delivery details
   - Track order status

2. **For Restaurant Owners**:
   - Register/login as restaurant owner
   - Add menu items with descriptions and prices
   - View incoming orders
   - Update order status through the workflow

3. **For Admins**:
   - Login with admin credentials
   - Access system overview dashboard

## Security Features

- Password hashing with PHP's password_hash()
- Prepared statements to prevent SQL injection
- Input validation and sanitization
- Role-based access control

## Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge

## License

This project is open source and available under the MIT License.