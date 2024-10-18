create database register;
use register;
select * from registration;
select * from rental_agreements_approval;

CREATE TABLE registration (
    SR_NO INT(11) NOT NULL AUTO_INCREMENT,
    EMAIL_ID VARCHAR(256) NOT NULL,
    FULL_NAME VARCHAR(256),
    MOBILE BIGINT(20),
    PASSWORD VARCHAR(100),
    INSERT_DATE DATETIME DEFAULT CURRENT_TIMESTAMP,
    IS_VERIFIED TINYINT(1) DEFAULT 0,
    USER_TYPE VARCHAR(50),
    PRIMARY KEY (SR_NO),
    UNIQUE KEY (EMAIL_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


select * from rental_agreements_approval;
SELECT * FROM rental_agreements_approval WHERE Owner_email = '1234@123.com' AND Is_approved !=1 ;
CREATE TABLE rental_agreements_approval (
    Srno INT(11) NOT NULL AUTO_INCREMENT,
    Tenant_email VARCHAR(255) NOT NULL,
    Owner_email VARCHAR(255) NOT NULL,
    Rent_monthly INT(11),
    Date_of_rent DATE,
    Agreement_months INT(11),
    Deposit INT(11),
    Is_approved TINYINT(4) DEFAULT 0,
    Insert_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    rent_start_date DATE,
    PRIMARY KEY (Srno)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

select * from tenant_profile;
CREATE TABLE tenant_profile (
    tenant_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255) NOT NULL,
    user_type VARCHAR(50) NOT NULL,
    college_name VARCHAR(255) NOT NULL,
    permanent_address TEXT NOT NULL,
    alt_contact_number VARCHAR(15) NOT NULL,
    aadhaar_card_path VARCHAR(255) NOT NULL,
    upi_qr_path VARCHAR(255) NOT NULL,
    upi_id VARCHAR(100) NOT NULL,
    bank_account_number VARCHAR(20) NOT NULL,
    ifsc_number VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

select * from owner_profile;
CREATE TABLE owner_profile (
    tenant_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255) NOT NULL,
    user_type VARCHAR(50) NOT NULL,
    permanent_address TEXT NOT NULL,
    alt_contact_number VARCHAR(15) NOT NULL,
    aadhaar_card_path VARCHAR(255) NOT NULL,
    upi_qr_path VARCHAR(255) NOT NULL,
    upi_id VARCHAR(100) NOT NULL,
    bank_account_number VARCHAR(20) NOT NULL,
    ifsc_number VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE owner_profile ADD UNIQUE (user_email);

ALTER TABLE tenant_profile ADD UNIQUE (user_email);



CREATE TABLE rent_payments (
    serial_no INT(11) NOT NULL AUTO_INCREMENT,
    tenant_email VARCHAR(255) NOT NULL,
    owner_email VARCHAR(255) NOT NULL,
    rent_date DATE NOT NULL,
    rent_amount DECIMAL(10, 2) NOT NULL,
    is_paid TINYINT(1) DEFAULT 0,
    receipt_uploaded VARCHAR(255),  -- Assuming file path or filename
    month VARCHAR(20) NOT NULL,      -- e.g., 'January 2024'
    updated_datetime DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    inserted_datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (serial_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE rent_payments 
ADD COLUMN rental_agreements_approval_id INT(11) NOT NULL;

select * from rent_payments;





