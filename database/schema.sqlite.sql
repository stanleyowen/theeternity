-- Eternity Esports — SQLite schema (default for the archive edition).
-- Usernames are stored in plain text (they are public identifiers shown on
-- every page); passwords use password_hash(); contact-form personal data is
-- encrypted with AES-256-GCM by the application.

CREATE TABLE IF NOT EXISTS users (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          VARCHAR(10)  NOT NULL DEFAULT 'user' CHECK (role IN ('user', 'admin')),
    created_at    DATETIME     NOT NULL
);

CREATE TABLE IF NOT EXISTS alerts_info (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    description VARCHAR(500) NOT NULL,
    link        VARCHAR(500) NOT NULL,
    type        VARCHAR(10)  NOT NULL CHECK (type IN ('success', 'warning', 'danger'))
);

CREATE TABLE IF NOT EXISTS scrim_info (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    type        VARCHAR(10)  NOT NULL CHECK (type IN ('public', 'hidden')),
    code        VARCHAR(20)  NULL,
    posted_by   VARCHAR(50)  NOT NULL,
    date        DATETIME     NOT NULL,
    header      VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL
);
CREATE INDEX IF NOT EXISTS idx_scrim_info_code ON scrim_info (code);

CREATE TABLE IF NOT EXISTS scrim_token (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    event_name VARCHAR(100) NOT NULL,
    scrim_id   VARCHAR(50)  NOT NULL,
    token      VARCHAR(50)  NOT NULL,
    wa_link    VARCHAR(500) NOT NULL,
    certi_link VARCHAR(500) NULL
);

CREATE TABLE IF NOT EXISTS scrim_member (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    event_id   INTEGER      NOT NULL REFERENCES scrim_token (id) ON DELETE CASCADE,
    username   VARCHAR(50)  NOT NULL UNIQUE REFERENCES users (username) ON DELETE CASCADE,
    date       DATETIME     NOT NULL,
    squad_pic  VARCHAR(64)  NULL,
    ig_proof   VARCHAR(64)  NULL,
    ig_proof_2 VARCHAR(64)  NULL,
    rank_1     INTEGER      NULL,
    kill_1     INTEGER      NULL,
    rank_2     INTEGER      NULL,
    kill_2     INTEGER      NULL
);

CREATE TABLE IF NOT EXISTS present_participant (
    id       INTEGER PRIMARY KEY AUTOINCREMENT,
    name     VARCHAR(50) NOT NULL UNIQUE,
    event_id INTEGER     NULL REFERENCES scrim_token (id) ON DELETE SET NULL,
    date     DATETIME    NOT NULL
);

CREATE TABLE IF NOT EXISTS gallery (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    file_name   VARCHAR(64) NOT NULL,
    uploaded_on DATETIME    NOT NULL
);

CREATE TABLE IF NOT EXISTS message (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    name    TEXT        NOT NULL,  -- encrypted
    email   TEXT        NOT NULL,  -- encrypted
    comment TEXT        NOT NULL,  -- encrypted
    type    VARCHAR(20) NOT NULL,
    date    DATETIME    NOT NULL
);

CREATE TABLE IF NOT EXISTS rate_limits (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    bucket     VARCHAR(30) NOT NULL,
    key_hash   CHAR(64)    NOT NULL,
    created_at DATETIME    NOT NULL
);
CREATE INDEX IF NOT EXISTS idx_rate_limits_lookup ON rate_limits (bucket, key_hash, created_at);
