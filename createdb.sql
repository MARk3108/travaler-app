SELECT 'CREATE DATABASE travaler_app'
    WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'travaler_app')\gexec
SELECT 'CREATE DATABASE testing'
    WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'testing')\gexec
