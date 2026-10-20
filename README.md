# Desis technical test (2023) — voting form

Technical test for a web developer position (Desis, 2023). A single-page voting form in
plain PHP + MySQL with a jQuery frontend:

- Region → commune cascading selects loaded from the database (all Chilean regions and communes)
- Candidate and "how did you hear about us" options loaded from the database
- Client-side validation (name, alias, Chilean RUT, email, at least two sources)
- Server-side duplicate check: one vote per RUT

## Stack

PHP 7.4+ · MySQL 8 · jQuery 3.7 · vanilla CSS (no framework)

## Project layout

```text
index.php            # form
controller/          # small PHP endpoints (regions, communes, candidates, sources, vote)
database.php         # mysqli connection, configured via environment variables
js/scripts.js        # AJAX loading + validation
sql/init_db.sql      # schema + seed data (regions, communes, sample candidates)
```

## Run locally

```bash
mysql -u <user> -p -e "CREATE DATABASE desis2023"
mysql -u <user> -p desis2023 < sql/init_db.sql

export DB_HOST=localhost DB_NAME=desis2023 DB_USER=<user> DB_PASS=<password>
php -S localhost:8000
# open http://localhost:8000
```

See `.env.example` for the available variables. Original Spanish install notes: `LEEME.txt`.
