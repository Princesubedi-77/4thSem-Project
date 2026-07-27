# Hotel Management System — Frontend Prototype

## 1. Project Structure

```text
hotel-management-system/
hotel-management-system/
│
├── config/
│   └── db.php                     # Database connection configuration
│
├── api/                           # Backend REST endpoints (PHP)
│   ├── auth.php                   # Login, logout, session checks
│   ├── staff.php                  # CRUD for staff members
│   ├── rooms.php                  # CRUD for rooms & statuses
│   ├── guests.php                 # CRUD for guest records
│   ├── bookings.php               # CRUD for bookings
│   ├── checkin.php                # Check-in processing logic
│   └── checkout.php               # Check-out & billing logic
│
├── database/
│   └── schema.sql                 # MySQL table definitions & sample data
│
├── index.html                     # Login page
├── dashboard.html
├── staff.html
├── rooms.html
├── guests.html
├── bookings.html
├── checkin.html
├── checkout.html
├── profile.html
│
├── receptionist-dashboard.html
├── receptionist-rooms.html
├── receptionist-guests.html
├── receptionist-bookings.html
├── receptionist-checkin.html
├── receptionist-checkout.html
│
├── css/
│   ├── login.css
│   ├── dashboard.css
│   ├── staff.css
│   ├── rooms.css
│   ├── guests.css
│   └── checkin-checkout.css
│
└── js/
    ├── login.js
    ├── dashboard.js
    ├── staff.js                   # Dedicated JS per view
    ├── rooms.js
    ├── guests.js
    ├── bookings.js
    └── app.js                     # Shared utilities & API fetch wrappers
```

---

# 2. Login Page

## `index.html`

The login page is used by both:

```text
Admin
Receptionist
```

### Prototype Login

```text
Username: admin
Password: admin123
Role: Admin
```

or:

```text
Username: receptionist
Password: reception123
Role: Receptionist
```

After login:

```text
Admin
    ↓
Admin Dashboard

Receptionist
    ↓
Receptionist Dashboard
```

---

# 3. Admin Dashboard

## Admin Navigation

```text
Dashboard
Staff Management
Room Management
Guest Management
Booking Management
Check-in
Check-out
Profile
Logout
```

### Dashboard Cards

```text
Total Rooms          50
Available Rooms      25
Occupied Rooms       20
Reserved Rooms        5
```

### Additional Information

```text
Today's Check-ins
Today's Check-outs
Recent Bookings
Recent Guests
```

---

# 4. Staff Management

Only the Admin can access this page.

```text
Staff Management
```

### Add Staff

```text
Name
Username
Password
Phone
Role
```

### Staff Table

```text
-----------------------------------------------------
Name          Username       Role          Actions
-----------------------------------------------------
Admin         admin          Admin         Edit Delete
John Smith    john           Receptionist  Edit Delete
```

### CRUD Buttons

```text
+ Add Staff
View
Edit
Delete
```

---

# 5. Room Management

Both Admin and Receptionist can use this page, but their permissions can be different.

## Admin

```text
Add Room
Edit Room
Delete Room
View Room
```

## Receptionist

```text
View Room
```

### Room Form

```text
Room Number
Room Type
Price Per Night
Room Status
```

### Room Types

```text
Single Room
Double Room
Deluxe Room
Suite Room
```

### Room Status

```text
Available
Reserved
Occupied
Maintenance
```

### Room Table

```text
---------------------------------------------------
Room | Type    | Price | Status      | Actions
---------------------------------------------------
101  | Single  | 2500  | Available   | Edit Delete
102  | Double  | 4000  | Occupied    | View
103  | Deluxe  | 6000  | Reserved    | View
```

---

# 6. Guest Management

The guest does not directly access the system.

The Receptionist enters guest details.

### Guest Form

```text
Full Name
Phone Number
Email
Address
ID Number
```

### Guest Table

```text
------------------------------------------------
Name        Phone       Email           Actions
------------------------------------------------
Ram Thapa   98XXXXXXX   ram@gmail.com   Edit Delete
John Doe    97XXXXXXX   john@gmail.com  Edit Delete
```

### CRUD

```text
Create → Add Guest
Read   → View Guest
Update → Edit Guest
Delete → Delete Guest
```

---

# 7. Booking Management

This page connects:

```text
Guest + Room + Dates
```

### Booking Form

```text
Select Guest
Select Room
Check-in Date
Check-out Date
Number of Guests
Booking Status
```

### Example

```text
Guest:
Ram Thapa

Room:
101

Check-in:
25 July 2026

Check-out:
28 July 2026

Status:
Reserved
```

### Booking Table

```text
----------------------------------------------------------
Guest       Room  Check-in    Check-out    Status
----------------------------------------------------------
Ram Thapa   101   25 July     28 July      Reserved
John Doe    102   26 July     30 July      Checked-in
```

### Booking Actions

```text
View
Edit
Cancel
```

When a booking is cancelled:

```text
Reserved
    ↓
Cancelled
```

The room becomes:

```text
Reserved
    ↓
Available
```

---

# 8. Check-in

The receptionist searches for an existing booking.

```text
Search Booking
        ↓
Select Booking
        ↓
Confirm Guest Information
        ↓
Confirm Room
        ↓
Check-in Guest
```

### Before Check-in

```text
Booking Status: Reserved
Room Status: Reserved
```

### After Check-in

```text
Booking Status: Checked-in
Room Status: Occupied
```

---

# 9. Check-out

The receptionist searches for the guest's booking.

```text
Search Guest
      ↓
View Booking
      ↓
Calculate Bill
      ↓
Confirm Payment
      ↓
Check-out Guest
```

### Example Bill

```text
Room Price:       Rs. 2500
Number of Nights: 3
-------------------------
Total:            Rs. 7500
```

After checkout:

```text
Booking Status: Checked-out
Room Status: Available
```

---

# 10. Receptionist Dashboard

The Receptionist has a simpler dashboard.

```text
Dashboard
Rooms
Guests
Bookings
Check-in
Check-out
Profile
Logout
```

The Receptionist does not see:

```text
Staff Management
```

because staff account management belongs to the Admin.

---

# 11. Role Permission Structure

## Admin

```text
Login                 ✓
Dashboard             ✓
Staff Management      ✓
Room Management       ✓
Guest Management      ✓
Booking Management    ✓
Check-in              ✓
Check-out             ✓
```

## Receptionist

```text
Login                 ✓
Dashboard             ✓
Staff Management      ✗
Room Management       ✓
Guest Management      ✓
Booking Management    ✓
Check-in              ✓
Check-out             ✓
```

---

# 12. Complete User Flow

```text
                    LOGIN
                      │
          ┌───────────┴───────────┐
          │                       │
        ADMIN                RECEPTIONIST
          │                       │
          ▼                       ▼
      DASHBOARD              DASHBOARD
          │                       │
    ┌─────┼─────┐           ┌─────┼─────┐
    │     │     │           │     │     │
  STAFF  ROOMS GUESTS     ROOMS GUESTS BOOKINGS
    │     │     │           │     │     │
    └─────┴─────┘           └─────┴─────┘
          │                       │
          └───────────┬───────────┘
                      │
                 BOOKINGS
                      │
              ┌───────┴───────┐
              │               │
           CHECK-IN       CHECK-OUT
              │               │
          OCCUPIED        AVAILABLE
```

---

# Recommended Prototype Development Order

Build the frontend in this order:

```text
1. Login Page
       ↓
2. Admin Dashboard
       ↓
3. Receptionist Dashboard
       ↓
4. Room Management
       ↓
5. Guest Management
       ↓
6. Booking Management
       ↓
7. Check-in
       ↓
8. Check-out
       ↓
9. Staff Management
       ↓
10. Connect everything with JavaScript
```

This prototype will first use **dummy data** in HTML/JavaScript. Later, you can replace the dummy data with **PHP and MySQL** when you start implementing the database.
