
# SchoolMS

The School Management System is a comprehensive web application built with Laravel, designed to streamline and automate the administrative and academic operations of educational institutions. It features an intuitive dashboard tailored for different user roles, including superadmin, admin, teacher, student, and parent. Each role has access to relevant tools and information, enabling efficient management of daily activities, communication, and performance tracking. The system offers:

- Student, teacher, and classroom management
- Attendance tracking and reporting
- Academic levels and subjects organization
- Marks and performance analytics
- Gender and grade distribution charts
- Recent activity and quick actions for common tasks

The system supports role-based access, ensuring that users only see information relevant to their responsibilities. With interactive charts and real-time statistics, the School Management System empowers schools to efficiently manage daily activities and make data-driven decisions.

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Yasinhassani98/SchoolMS.git
   cd school-management-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Copy and configure environment file**
   ```bash
   cp .env.example .env
   ```
   Edit `.env` and set your database credentials and other environment variables.

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations and seed the database**
   ```bash
   php artisan migrate --seed
   ```

6. **Build frontend assets**
   ```bash
   npm run dev
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Start the reverb on different terminal**
   ```bash
   php artisan reverb:start
   ```

8. **Access the application**
   Open your browser and go to [http://localhost:8000](http://localhost:8000)

---

For more details, refer to the documentation or contact the project maintainer.