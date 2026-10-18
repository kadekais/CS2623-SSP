# COPILOT_NOTES.md - CS 2623 Week 1

## Accepted
- copilot generated the full CSS for SSP01 (main.css) with the colors and font I asked for
- include_header.php code wasn't showing up in apollo, asked it to fix the bug

## Rejected
- it took out the php code in inlude_header.php and made it a basic header.

## Improved
- the original include_header.php used the ?? operator, which caused a parse error on Apollo because Apollo runs an older PHP version than my local XAMPP. A classmate posted a fix in the class discussion that replaces ?? with an isset() check and an if/else. I used their version and it worked.