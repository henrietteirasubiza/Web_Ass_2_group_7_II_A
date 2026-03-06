# Testing Document — UniStack

## Test Environment
- Local: XAMPP / WAMP with PHP 8.1+ and MySQL 8.0
- Browser tested: Chrome 121, Firefox 122, Mobile Chrome (Android)

---

## Test Cases

| # | Feature | Test Case | Steps | Expected Result | Status |
|---|---------|-----------|-------|-----------------|--------|
| TC-01 | Registration | Valid school email registers successfully | 1. Go to /register 2. Enter name, valid @ines.ac.rw email, password 3. Submit | Account created, redirected to login with success message | ✅ PASS |
| TC-02 | Registration | Non-school email is rejected | 1. Go to /register 2. Enter name, gmail.com email, password 3. Submit | Error: "Only @ines.ac.rw email addresses are allowed." | ✅ PASS |
| TC-03 | Registration | Mismatched passwords rejected | 1. Enter valid email, different password and confirm 2. Submit | Error: "Passwords do not match." | ✅ PASS |
| TC-04 | Login | Valid credentials log in correctly | 1. Enter student@ines.ac.rw, correct password 2. Submit | Redirected to student dashboard | ✅ PASS |
| TC-05 | Login | Invalid credentials show error | 1. Enter wrong email or password 2. Submit | Error: "Invalid email or password." | ✅ PASS |
| TC-06 | Post Creation | Student creates For Sale post | 1. Login as student 2. Click New Post 3. Select For Sale, fill form, submit | Post saved with status=pending. Visible in moderator queue. | ✅ PASS |
| TC-07 | Post Creation | Announcement post hides price field | 1. Login as student 2. Select Announcement type | Price input field is hidden via JS | ✅ PASS |
| TC-08 | Moderation | Moderator approves a post | 1. Login as moderator 2. Click Approve on pending post | Post status changes to approved. Post appears on homepage. | ✅ PASS |
| TC-09 | Moderation | Moderator rejects a post | 1. Login as moderator 2. Click Reject on pending post | Post status changes to rejected. Post does NOT appear on homepage. | ✅ PASS |
| TC-10 | Report | Student reports a post | 1. Login as student 2. Click Report on a post 3. Select reason 4. Submit | Post is_flagged=1. Flagged count visible in moderator flags panel. | ✅ PASS |
| TC-11 | Search | Search by keyword finds posts | 1. Enter "textbook" in search bar 2. Submit | Only approved posts matching "textbook" in title/description returned | ✅ PASS |
| TC-12 | Filter | Filter by category works | 1. Select "Housing" from dropdown 2. Submit | Only housing type approved posts displayed | ✅ PASS |
| TC-13 | Admin | Admin disables a user | 1. Login as admin 2. Go to Users 3. Click Disable | User is_active=0. Disabled user cannot log in (findByEmail checks is_active). | ✅ PASS |
| TC-14 | Admin | Admin deletes a post | 1. Login as admin 2. Click Delete on any post 3. Confirm | Post removed from all views and database | ✅ PASS |
| TC-15 | Audit Log | Actions appear in audit log | 1. Perform any create/approve/delete 2. Go to Admin > Audit Log | Action is recorded with user name, action string, target ID, timestamp | ✅ PASS |
| TC-16 | Polling | JS polling detects new posts | 1. Open homepage 2. Have another user submit + approve a post | Within 10 seconds, new post appears on homepage with toast notification | ✅ PASS |
| TC-17 | Edit | Editing resets post to pending | 1. Login as student 2. Edit approved post 3. Save | Post status = pending. Post no longer shows on public homepage until re-approved. | ✅ PASS |
| TC-18 | Role Access | Student cannot access moderator panel | 1. Login as student 2. Navigate to ?page=moderator | Redirected to home with unauthorized error | ✅ PASS |
| TC-19 | SQL Injection | Prepared statements prevent injection | 1. Enter `' OR 1=1; --` in search bar 2. Submit | No SQL error. Query treated as literal string. No unintended data returned. | ✅ PASS |
| TC-20 | Responsive | Layout works on mobile | 1. Open on mobile or resize to <768px | Nav collapses to hamburger. Cards stack to single column. Forms readable. | ✅ PASS |

---

## Summary
| Result | Count |
|--------|-------|
| ✅ PASS | 20 |
| ❌ FAIL | 0 |
| ⚠️ SKIP | 0 |

All 20 test cases passed. Application is stable across tested environments.
