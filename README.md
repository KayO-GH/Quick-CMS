# Quick CMS Template

A very quick CMS template built with raw PHP, and based off the
[Creating a CMS in 1 HOUR] course.

### Tables to create and corresponding columns

**articles**
* article_id (int, primary key, auto increment)
* article_title (varchar 255)
* article_content (text)
* article_timestamp (int) - to be generated using the PHP time() function

**users**
* user_id (int, primary key, auto increment)
* user_name (varchar 255)
* user_password (varchar 255)

_Be careful to use good security standards for your password security_

[Creating a CMS in 1 HOUR]: https://www.youtube.com/watch?v=QNxU3Qa6QZs

