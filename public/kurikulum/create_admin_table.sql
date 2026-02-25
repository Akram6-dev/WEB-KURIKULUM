-- Add admin table to smkn1_kurikulum_v3 database
USE smkn1_kurikulum_v3;

CREATE TABLE admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (username: admin, password: NESAS_CEREN)
INSERT INTO admin (username, password) VALUES ('admin', 'NESAS_CEREN');