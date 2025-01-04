-- Database: fitzone_fitness_center

CREATE DATABASE fitzone_fitness_center;
USE fitzone_fitness_center;

-- Table: users
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    role ENUM('customer', 'staff', 'admin') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: membership_plans
CREATE TABLE membership_plans (
    plan_id INT AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration_in_months INT NOT NULL,
    benefits TEXT NOT NULL,
    special_promotions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: fitness_classes
CREATE TABLE fitness_classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    schedule VARCHAR(255) NOT NULL,
    trainer_id INT,
    FOREIGN KEY (trainer_id) REFERENCES users(user_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: trainers
CREATE TABLE trainers (
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    trainer_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    specialty VARCHAR(255),
    certification_details TEXT,
    pricing_packages TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: appointments
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_type ENUM('personal_training', 'group_class', 'nutrition_counseling') NOT NULL,
    class_id INT,
    appointment_date DATETIME NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (class_id) REFERENCES fitness_classes(class_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: inquiries
CREATE TABLE inquiries (
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
CREATE TABLE blogs (
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
('Basic Plan', 29.99, 1, 'Access to gym equipment', NULL),
('Standard Plan', 59.99, 3, 'Access to gym equipment, group classes', '10% off for referrals'),
('Premium Plan', 99.99, 6, 'Access to gym equipment, group classes, personal training', 'Free month on yearly subscription');

-- Insert dummy fitness classes
INSERT INTO fitness_classes (class_name, description, schedule, trainer_id)
VALUES 
('Yoga Basics', 'Introductory yoga for beginners', 'Monday, Wednesday, Friday: 8 AM - 9 AM', NULL),
('Cardio Blast', 'High-energy cardio session', 'Tuesday, Thursday: 6 PM - 7 PM', NULL),
('Strength Training', 'Full-body strength training', 'Saturday: 10 AM - 11 AM', NULL);

-- Insert dummy trainers
INSERT INTO trainers (trainer_name, phone_number, specialty, certification_details, pricing_packages, image_url)
VALUES 
('Alice Smith', '0711234567', 'Yoga and Cardio Specialist', 'Certified Yoga Trainer, Certified Cardio Instructor', 'Yoga: $30/session, Cardio: $25/session', 'img/trainers/alice.jpg'),
('Bob Johnson', '0723456789', 'Strength Training Expert', 'Certified Strength Trainer', 'Strength Training: $40/session', 'img/trainers/bob.jpg'),
('Charlie Brown', '0734567890', 'Nutrition and Wellness Coach', 'Certified Nutritionist, Wellness Expert', 'Nutrition Counseling: $50/session', 'img/trainers/charlie.jpg'),
('David Lee', '0745678901', 'Personal Trainer', 'Certified Personal Trainer', 'Personal Training: $45/session', 'img/trainers/david.jpg');

-- Insert dummy appointments
INSERT INTO appointments (user_id, service_type, class_id, appointment_date, status)
VALUES 
(2, 'group_class', 1, '2024-01-01 08:00:00', 'approved'),
(2, 'personal_training', NULL, '2024-01-02 10:00:00', 'pending');

-- Insert dummy inquiries
INSERT INTO inquiries (user_id, subject, message, response, status)
VALUES 
(2, 'Membership Options', 'Can I get a discount on the Premium Plan?', NULL, 'open'),
(NULL, 'Class Schedules', 'What are the timings for Yoga classes?', 'Monday, Wednesday, Friday: 8 AM - 9 AM', 'closed');

-- Insert dummy blogs
INSERT INTO blogs (title, content, author_id, category, image_url)
VALUES 
('5 Best Exercises for Beginners', 'Here are the top 5 exercises...', 1, 'workout_routines', 'img/exercise.jpg'),
('Healthy Breakfast Recipes', 'Start your day with these recipes...', 1, 'healthy_recipes', 'img/breakfast.jpg'),
('Meal Plans for Weight Loss', 'Follow this guide to plan your meals...', 1, 'meal_plans', 'img/meal_plans.jpg'),
('Success Story: John Doe', 'John transformed his life with fitness...', 2, 'success_stories', 'img/success.jpg');
