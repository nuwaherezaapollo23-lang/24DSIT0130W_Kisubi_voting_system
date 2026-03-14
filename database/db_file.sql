-- DATABASE
CREATE DATABASE IF NOT EXISTS kisubi_voting;
USE kisubi_voting;

-- -------------------------
-- ADMIN TABLE
-- -------------------------
CREATE TABLE admin (
  admin_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

-- -------------------------
-- POSITIONS
-- -------------------------
CREATE TABLE positions (
  position_id INT AUTO_INCREMENT PRIMARY KEY,
  position_name VARCHAR(100) NOT NULL
);

-- -------------------------
-- VOTERS
-- -------------------------
CREATE TABLE voters (
  voter_id INT AUTO_INCREMENT PRIMARY KEY,
  reg_no VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  voted TINYINT DEFAULT 0
);

-- -------------------------
-- CANDIDATES
-- -------------------------
CREATE TABLE candidates (
  candidate_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  reg_no VARCHAR(50) NOT NULL UNIQUE,
  faculty VARCHAR(50) NOT NULL,
  position_id INT NOT NULL,
  votes INT DEFAULT 0,
  FOREIGN KEY (position_id) REFERENCES positions(position_id)
  ON DELETE CASCADE
);

-- -------------------------
-- VOTES
-- -------------------------
CREATE TABLE votes (
  vote_id INT AUTO_INCREMENT PRIMARY KEY,
  voter_id INT NOT NULL,
  candidate_id INT NOT NULL,
  position_id INT NOT NULL,
  vote_date DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (voter_id) REFERENCES voters(voter_id) ON DELETE CASCADE,
  FOREIGN KEY (candidate_id) REFERENCES candidates(candidate_id) ON DELETE CASCADE,
  FOREIGN KEY (position_id) REFERENCES positions(position_id) ON DELETE CASCADE,

  -- Prevent multiple voting for the same position
  UNIQUE KEY unique_vote (voter_id, position_id)
);