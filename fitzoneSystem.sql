-- Database: fitzone_fitness_center

CREATE DATABASE IF NOT EXISTS fitzone_fitness_center;
USE fitzone_fitness_center;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    role ENUM('customer', 'staff', 'admin') NOT NULL DEFAULT 'customer',
    age INT NULL,
    address VARCHAR(255) NULL,
    height DECIMAL(5, 2) NULL,
    weight DECIMAL(5, 2) NULL,
    guardian_name VARCHAR(255) NULL,
    fullname VARCHAR(255) NULL,
    image_url VARCHAR(255) NULL,
    subscription ENUM('Basic', 'Standard', 'Premium') NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: trainers (Moved above fitness_classes to resolve FK issue)
CREATE TABLE IF NOT EXISTS trainers (
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    trainer_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    specialty VARCHAR(255),
    certification_details TEXT,
    pricing_packages TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: membership_plans
CREATE TABLE IF NOT EXISTS membership_plans (
    plan_id INT AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration_in_months INT NOT NULL,
    benefits TEXT NOT NULL,
    special_promotions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: fitness_classes
CREATE TABLE IF NOT EXISTS fitness_classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    schedule VARCHAR(255) NOT NULL,
    trainer_id INT,
    FOREIGN KEY (trainer_id) REFERENCES trainers(trainer_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: appointments
CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    service_type ENUM('personal_training', 'group_class', 'nutrition_counseling') NOT NULL,
    class_id INT,
    trainer_id INT,
    appointment_date DATETIME NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (class_id) REFERENCES fitness_classes(class_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (trainer_id) REFERENCES trainers(trainer_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: inquiries
CREATE TABLE IF NOT EXISTS inquiries (
    inquiry_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    response TEXT,
    status ENUM('open', 'closed') DEFAULT 'open',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: blogs
CREATE TABLE IF NOT EXISTS blogs (
    blog_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT,
    category ENUM('workout_routines', 'healthy_recipes', 'meal_plans', 'success_stories') NOT NULL,
    image_url VARCHAR(255),
    FOREIGN KEY (author_id) REFERENCES users(user_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user
INSERT INTO users (username, password_hash, email, phone_number, role)
VALUES 
('admin', '$2y$10$EXAMPLEHASHFORPASSWORD', 'admin@fitzone.com', '0712345678', 'admin'),
('john_doe', '$2y$10$EXAMPLEHASHFORPASSWORD', 'john@example.com', '0723456789', 'customer'),
('jane_staff', '$2y$10$EXAMPLEHASHFORPASSWORD', 'jane@example.com', '0734567890', 'staff');

-- Insert dummy membership plans
INSERT INTO membership_plans (plan_name, price, duration_in_months, benefits, special_promotions)
VALUES 
('Basic', 29.99, 1, 'Access to gym equipment', NULL),
('Standard', 59.99, 3, 'Access to gym equipment, group classes', '10% off for referrals'),
('Premium', 99.99, 6, 'Access to gym equipment, group classes, personal training', 'Free month on yearly subscription');

-- Insert dummy trainers
INSERT INTO trainers (trainer_name, phone_number, specialty, certification_details, pricing_packages, image_url)
VALUES 
('Alice Smith', '0711234567', 'Yoga and Cardio Specialist', 'Certified Yoga Trainer, Certified Cardio Instructor', 'Yoga: $30/session, Cardio: $25/session', 'img/trainers/trainer_alice.jpg'),
('Bob Johnson', '0723456789', 'Strength Training Expert', 'Certified Strength Trainer', 'Strength Training: $40/session', 'img/trainers/trainer_bob.jpg'),
('Charlie Brown', '0734567890', 'Nutrition and Wellness Coach', 'Certified Nutritionist, Wellness Expert', 'Nutrition Counseling: $50/session', 'img/trainers/trainer_charlie.jpg'),
('David Lee', '0745678901', 'Personal Trainer', 'Certified Personal Trainer', 'Personal Training: $45/session', 'img/trainers/trainer_david.jpg'),
('Eva Green', '0756789012', 'Pilates Instructor', 'Certified Pilates Trainer', 'Pilates: $35/session', 'img/trainers/trainer_eva.jpg'),
('Frank White', '0767890123', 'Zumba Instructor', 'Certified Zumba Trainer', 'Zumba: $20/session', 'img/trainers/trainer_frank.jpg');

-- Insert dummy fitness classes
INSERT INTO fitness_classes (class_name, description, schedule, trainer_id)
VALUES 
('Yoga Basics', 'Introductory yoga for beginners', 'Monday, Wednesday, Friday: 8 AM - 9 AM', 1),
('Cardio Blast', 'High-energy cardio session', 'Tuesday, Thursday: 6 PM - 7 PM', 2),
('Strength Training', 'Full-body strength training', 'Saturday: 10 AM - 11 AM', 3),
('Nutrition Workshop', 'Learn about healthy eating habits', 'Monthly: 2nd Saturday 11 AM - 12 PM', 3);

-- Insert dummy appointments
INSERT INTO appointments (user_id, customer_name, service_type, class_id, trainer_id, appointment_date, status)
VALUES 
(2, 'John Doe', 'group_class', 1, NULL, '2024-01-01 08:00:00', 'approved'),
(2, 'John Doe', 'personal_training', NULL, 2, '2024-01-02 10:00:00', 'pending');

-- Insert dummy inquiries
INSERT INTO inquiries (user_id, subject, message, response, status)
VALUES 
(2, 'Membership Options', 'Can I get a discount on the Premium Plan?', NULL, 'open'),
(NULL, 'Class Schedules', 'What are the timings for Yoga classes?', 'Monday, Wednesday, Friday: 8 AM - 9 AM', 'closed');

-- Insert dummy blogs
INSERT INTO blogs (title, content, author_id, category, image_url)
VALUES 
('5 Best Exercises for Beginners', 'Here are the top 5 exercises...', 1, 'workout_routines', 'img/blog-images/exercise.jpg'),
('Healthy Breakfast Recipes', 'Start your day with these recipes...', 1, 'healthy_recipes', 'img/blog-images/breakfast.jpg'),
('Meal Plans for Weight Loss', 'Follow this guide to plan your meals...', 1, 'meal_plans', 'img/blog-images/meal_plans.jpg'),
('Success Story: John Doe', 'John transformed his life with fitness...', 2, 'success_stories', 'img/blog-images/success.jpg'),
('10 Tips for a Healthier Lifestyle', 'Simple changes to improve your health...', 1, 'workout_routines', 'img/blog-images/health.jpg'),
('Quick and Easy Dinner Recipes', 'Delicious recipes for busy evenings...', 1, 'healthy_recipes', 'img/blog-images/dinner.jpg');

