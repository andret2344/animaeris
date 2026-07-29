# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Single-page marketing site for Animaeris, a fitness/aerial/wellness studio in Gdańsk. Symfony 8.0 on PHP >= 8.5. No database, no ORM, no entities, no user accounts. One controller, one real page, one POST endpoint for the contact form.

All user-facing copy is **Polish**. Keep it Polish, including error messages, log messages, and email bodies.

## Commands

```powershell
composer install                       # deps
symfony serve                          # dev server (Symfony CLI v4 installed)
php -S 127.0.0.1:8000 -t public public/index.php   # fallback dev server

php -l src/Controller/HomeController.php   # PHP syntax check
php bin/console lint:twig templates        # Twig lint
php bin/console cache:clear
```

No test suite exists (`bin/phpunit` is the Flex bridge stub, but there is no `tests/` dir and no `phpunit.xml.dist`). No asset build step — CSS and JS are hand-written and served straight from `public/`. Do not introduce Webpack/Vite/AssetMapper unless asked.

## Architecture

**Content lives in PHP, not in a CMS or fixtures.** `src/Controller/HomeController.php` holds every piece of site content as private methods returning nested arrays: `getClasses()`, `getSchedule()`, `getPricing()`, `getFaq()`, `getTrainers()`. `pageData()` merges them (plus empty `contact_errors` / `contact_old`) into one array passed to the template. To change classes, prices, trainers, or the timetable, edit those methods — never the templates.

**Key content contracts** — the `type` field is load-bearing, not decorative:

- Class `type` is `wellness` | `soft` | `premium`. The template filters on it: the single `wellness` entry renders as a feature banner, `soft` and `premium` render as separate card grids. Pricing tiers (`getPricing()['soft']` / `['premium']`) mirror the same keys.
- Schedule is keyed by Polish day name (`'Poniedziałek'` … `'Niedziela'`); each entry needs `time`, `name`, `room`, `type`. Empty day arrays render the "no classes" fallback. `room` is matched against the literal strings `'Sala Liliowa'` / `'Sala Cream'` to pick the row's colour stripe — a new room name silently falls back to `room-other`.
- `img` values are bare filenames resolved as `/images/{{ img }}.jpg`.

**Templates**: `base.html.twig` (nav, sport-card partners strip, footer, meta/OG tags) + `home/index.html.twig` (~850 lines, all sections) + `home/contact_success.html.twig`. The partners strip is driven by an inline `sport_cards` Twig array in `base.html.twig`; set `hidden: true` on a card to pull it without deleting it (PZU Sport is currently hidden this way).

**CSS**: `public/css/style.css` is one design-system file — CSS custom properties at the top (surface/mauve/text scales, 8px space scale, radii, shadows, easings), then banner-delimited sections matching the page sections (`NAVBAR`, `HERO`, `CLASSES`, `SCHEDULE`, …), then a mobile-first `min-width` responsive block at the end. Use the existing tokens; do not add hardcoded colours or new breakpoints.

**JS**: `public/js/main.js` is vanilla, no framework, no bundler — six independent IIFEs (navbar, scroll reveals via `data-ani`, schedule tabs, FAQ accordion, stat counters, client-side form validation). Elements are wired by `id` / class, so renaming markup hooks breaks JS silently.

## Contact form

`POST /kontakt` → `HomeController::contact()`. Layered defences, in order:

1. **Honeypot** — hidden `website` field; **time trap** — hidden `_ts` (render timestamp), rejects submissions under 3s. Either trip → log and render the success page *without sending mail*, so bots do not retry. Preserve this silent-success behaviour.
2. **CSRF** — token id `contact`, validated in `validateContact()`.
3. Server-side validation of name / email / message / consent. `main.js` mirrors this client-side but the form is `novalidate`; the server is the authority.

On error the controller re-renders `home/index.html.twig` with HTTP 422 plus `contact_errors` and `contact_old` so the form repopulates. Success sends two mails: one to the studio (reply-to the sender) and a confirmation to the sender, both sharing `contactSummary()`.

## Config and secrets

`.env` holds only placeholders. Real `APP_SECRET` and the Gmail `MAILER_DSN` live in gitignored `.env.local`; the committed default is `MAILER_DSN=null://null`, so mail silently no-ops in a fresh checkout. Gmail needs an App Password, not the account password.

## Style

`.editorconfig` is authoritative and unusual: **tabs** for indentation, **CRLF** line endings, final newline, trimmed trailing whitespace. Existing PHP/Twig use tabs; `main.js` and `style.css` use 2-space indent — match the file you are editing. Twig attributes in the templates are written one per line.
