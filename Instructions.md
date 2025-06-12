# 💰 Micro-Investment Platform – Laravel Take-Home Assignment

## 📋 Overview

This project is a take-home coding challenge for a mid-level Laravel engineering role at a Ensibuuko. The goal is to build a simplified **Micro-Investment Platform** with a RESTful API, where users can invest in predefined plans with specific return rates and lock periods.

---

## 🚀 Core Features to Implement

### 1. **Authentication**
- Implement user registration and login endpoints.

### 2. **Investment Plans**
- Plans are predefined and seeded in the database.
- Each plan should include:
  - **Name** (e.g., "SaveDaily", "GrowFast")
  - **Return rate** (e.g., 1.5% daily)
  - **Lock period** (e.g., 7 days)

### 3. **Invest in a Plan**
- A logged-in user can invest a specific amount in a plan.
- Save the following information:
  - -**********
  - -**********
  - -**********
  - -**********
  - -**********
- Investments should be stored and tracked in the database.

### 4. **View User Portfolio**
- Authenticated users should be able to:
  - View all active and past investments
  - See the current value (with accrued interest)
  - Know if each investment is eligible for withdrawal

### 5. **Withdraw Investment**
- Allow users to withdraw funds **only after** the lock period has passed.
- Withdrawal amount should be the **initial investment + accrued interest**.


### 6. **Notifications**
- Send the user email notifications when they register, invest and withdraw their investment.
---

## 🎁 Bonus Features (Optional)
- Use Laravel Queues or Scheduled Jobs to simulate daily interest accrual.
- Include unit/feature tests.
- Use Laravel API Resources for clean JSON output.
- RESTful API for all the features.

---

## 🛠️ Tech Stack

- Laravel 9+
- PHP 8+
- MySQL or SQLite
- Vue.js/Livewire

---

## ⚙️ Setup Instructions

1. **Create and push your repository**

   Push your code to a public GitHub repository and email the link to:

   **📩 ambrose@ensibuuko.com**
