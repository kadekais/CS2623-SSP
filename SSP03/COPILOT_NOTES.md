# COPILOT_NOTES.md - CS 2623 Week 2
## SSP03 / Chapter 8 & 13

Prompt: Fix functions_SSP03.php and index.php to be compatible with PHP 5.5

| # | File | Copilot Suggestion | Decision | Notes |
|---|------|--------------------|----------|-------|
| 1 | functions_SSP03.php, index.php | Remove declare(strict_types=1) | ACCEPTED | Apollo runs PHP 5.5.12, which has no strict_types and throws a fatal error on it. |
| 2 | functions_SSP03.php | Remove parameter and return types | ACCEPTED | PHP 5.5 has no scalar types or return types (added in 7.0/7.1), so the spec's signatures can't run on Apollo. I accepted losing those rubric points. |