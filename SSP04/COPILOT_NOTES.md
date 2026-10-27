# COPILOT_NOTES.md - CS 2623 Week 2
## SSP04 / Chapter 9 & 10

| # | File | Copilot Suggestion | Decision | Notes |
|---|------|--------------------|----------|-------|
| 1 | ex1_strings.php, ex2_datetime.php | Remove declare(strict_types=1) | ACCEPTED | Apollo runs PHP 5.5.12, which fatals on strict_types. |
| 2 | ex1_strings.php | Replace str_contains() with strpos() !== false | ACCEPTED | str_contains() is PHP 8.0+ so it can't run on Apollo. The spec itself calls strpos() the "old style" but it's the only option on 5.5. |