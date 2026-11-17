-- Eternity Esports — MySQL / MariaDB schema (for a live, writable deployment).

CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at    DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS alerts_info (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(500) NOT NULL,
    link        VARCHAR(500) NOT NULL,
    type        ENUM('success', 'warning', 'danger') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS scrim_info (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type        ENUM('public', 'hidden') NOT NULL,
    code        VARCHAR(20)  NULL,
    posted_by   VARCHAR(50)  NOT NULL,
    date        DATETIME     NOT NULL,
    header      VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL,
    INDEX idx_scrim_info_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS scrim_token (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    scrim_id   VARCHAR(50)  NOT NULL,
    token      VARCHAR(50)  NOT NULL,
    wa_link    VARCHAR(500) NOT NULL,
    certi_link VARCHAR(500) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS scrim_member (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id   INT UNSIGNED NOT NULL,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    date       DATETIME     NOT NULL,
    squad_pic  VARCHAR(64)  NULL,
    ig_proof   VARCHAR(64)  NULL,
    ig_proof_2 VARCHAR(64)  NULL,
    rank_1     SMALLINT     NULL,
    kill_1     SMALLINT     NULL,
    rank_2     SMALLINT     NULL,
    kill_2     SMALLINT     NULL,
    CONSTRAINT fk_member_event FOREIGN KEY (event_id) REFERENCES scrim_token (id) ON DELETE CASCADE,
    CONSTRAINT fk_member_user  FOREIGN KEY (username) REFERENCES users (username) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS present_participant (
    id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(50)  NOT NULL UNIQUE,
    event_id INT UNSIGNED NULL,
    date     DATETIME     NOT NULL,
    CONSTRAINT fk_present_event FOREIGN KEY (event_id) REFERENCES scrim_token (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS gallery (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_name   VARCHAR(64) NOT NULL,
    uploaded_on DATETIME    NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS message (
    id      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name    TEXT        NOT NULL,
    email   TEXT        NOT NULL,
    comment TEXT        NOT NULL,
    type    VARCHAR(20) NOT NULL,
    date    DATETIME    NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS rate_limits (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bucket     VARCHAR(30) NOT NULL,
    key_hash   CHAR(64)    NOT NULL,
    created_at DATETIME    NOT NULL,
    INDEX idx_rate_limits_lookup (bucket, key_hash, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
