# EcomPulse 🛒

A full-featured **Seller Dashboard** web application for managing inventory, tracking sales, and monitoring revenue — built for e-commerce sellers.

---


---

## ✨ Features

- 🔐 **Seller Authentication** — Secure login with email and password; each seller gets a unique Seller UID (e.g. `SELLER5361`)
- 📊 **Dashboard Overview** — At-a-glance stats cards for:
  - Total Products
  - Total Stock
  - Low Stock Items
  - Total Revenue (₹)
- 🥧 **Product Stock Distribution Chart** — Interactive pie chart showing stock breakdown by product
- ⚠️ **Low Stock Alerts** — Automatically flags products below threshold (stock ≤ 5)
- 📦 **Product Management**
  - Add products (name, category, price, stock quantity)
  - View all products in a searchable table
  - Edit or delete existing products
- 🛍️ **Sell Product** — Record sales by selecting a product and quantity; stock updates automatically
- 📈 **Sales History** — Full log of past sales with product name, quantity, total price, and timestamp
- 👤 **Seller Profile** — View account details including email, UID, total products, revenue, and account creation date

---

## 🗂️ Pages

| Page | Description |
|------|-------------|
| `/login` | Seller login screen |
| `/dashboard` | Main overview with stats and charts |
| `/add-product` | Form to add a new product |
| `/products` | View, search, edit, and delete products |
| `/sell` | Record a product sale |
| `/sales-history` | View all past sales transactions |
| `/profile` | Seller account info |

---

## 🧭 Navigation

The sidebar (dark theme) includes:

- 📊 Dashboard
- ➕ Add Product
- 📦 View Products
- 🛒 Sell Product
- 📈 Sales History
- 👤 Profile
- 🚪 Logout

---

## 🛠️ Tech Stack

> *(Update this section based on your actual implementation)*

- **Frontend:** HTML / CSS / JavaScript *(or React / Vue)*
- **Backend:** Node.js / Python / PHP *(or your framework)*
- **Database:** MySQL / PostgreSQL / MongoDB *(or your DB)*
- **Charts:** Chart.js / Recharts *(for pie chart)*

---

## 🚀 Getting Started

### Prerequisites

- Node.js ≥ 18 *(or your runtime)*
- Database set up and running

### Installation

```bash
# Clone the repository
git clone https://github.com/your-username/ecompulse.git

# Navigate into the project
cd ecompulse

# Install dependencies
npm install

# Set up environment variables
cp .env.example .env
# Edit .env with your DB credentials and secret keys

# Run the development server
npm run dev
```

Open [http://localhost:3000](http://localhost:3000) in your browser.

---

## ⚙️ Environment Variables

Create a `.env` file in the root directory:

```env
DB_HOST=localhost
DB_USER=your_db_user
DB_PASSWORD=your_db_password
DB_NAME=ecompulse
JWT_SECRET=your_jwt_secret
PORT=3000
```

---

## 📁 Project Structure

```
ecompulse/
├── public/             # Static assets
├── src/
│   ├── pages/          # Route pages (dashboard, products, sales, etc.)
│   ├── components/     # Reusable UI components
│   ├── api/            # Backend API routes
│   └── db/             # Database models and queries
├── .env.example
├── package.json
└── README.md
```

---

## 👤 Author

**Rajveer Soni**
- Email: rajveer2005soni@gmail.com
- Seller UID: SELLER5361

---

## Website Preview

## Login Page

![Login](screenshots/login.png)

# Dashboard

![Dashboard Overview](screenshots/dashboard-overview.png)

![Dashboard Analytics](screenshots/dashboard-chart.png)

![Low Stock Products](screenshots/dashboard-low-stock.png)

# Add Product

![Add Product](screenshots/add-product.png)

# View Products

![View Products](screenshots/view-products.png)

# Sell Product

![Sell Product](screenshots/sell-product.png)

# Sales History

![Sales History](screenshots/sales-history.png)

# Profile

![Profile](screenshots/profile.png)

# Navigation Sidebar

![Sidebar](screenshots/sidebar.png)


---

> Built with ❤️ for efficient seller inventory management.
