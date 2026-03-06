# User Stories — UniStack

## Student Role

**US-01** — As a student, I want to register using my @ines.ac.rw email so that the platform remains student-only.
- *Acceptance:* Registration is rejected for non-@ines.ac.rw emails. Student receives a clear error.

**US-02** — As a student, I want to log in securely so that I can access my account and posts.
- *Acceptance:* Valid credentials redirect to student dashboard. Invalid credentials show an error.

**US-03** — As a student, I want to create a "For Sale" post with a price so that other students can find items I'm selling.
- *Acceptance:* Post appears in moderator queue immediately after creation. Price is stored and displayed.

**US-04** — As a student, I want to create a "Housing" post so that I can share available rental rooms.
- *Acceptance:* Post type "housing" is saved. Post is submitted for moderation.

**US-05** — As a student, I want to create an "Announcement" post so that I can notify peers about events.
- *Acceptance:* Announcement posts do not require a price field.

**US-06** — As a student, I want to view my own posts with their current status (Pending/Approved/Rejected) so I know which posts are live.
- *Acceptance:* Dashboard shows a table of my posts with badges for each status.

**US-07** — As a student, I want to edit my post if I made a mistake, and have it resubmitted for review.
- *Acceptance:* Edited post status resets to "Pending". Moderators see the updated version.

**US-08** — As a student, I want to delete my post at any time so I can remove sold items or outdated info.
- *Acceptance:* Confirmation prompt before deletion. Post removed from database immediately.

**US-09** — As a student, I want to report a suspicious post so that moderators can review it.
- *Acceptance:* Report is saved. Post is flagged. Moderators see report count on flagged post.

**US-10** — As a student, I want to search and filter posts by category so I can find what I need faster.
- *Acceptance:* Search by keyword or filter by type returns matching approved posts only.

---

## Moderator Role

**US-11** — As a moderator, I want to see all pending posts so I can review them before they go live.
- *Acceptance:* Moderator dashboard lists all posts with status "pending" ordered by oldest first.

**US-12** — As a moderator, I want to approve or reject a post so that only appropriate content is published.
- *Acceptance:* Clicking Approve/Reject updates post status and records who approved/rejected it.

**US-13** — As a moderator, I want to see flagged posts and their report count so I can prioritize problematic content.
- *Acceptance:* Flagged posts page lists posts sorted by report count descending.

---

## Admin Role

**US-14** — As an admin, I want to view all registered users and disable/enable their accounts so I can manage access.
- *Acceptance:* User table shows all users. Toggle active/inactive prevents login for disabled users.

**US-15** — As an admin, I want to permanently delete any post so I can remove harmful content immediately.
- *Acceptance:* Confirmation required. Post is removed from the database.

**US-16** — As an admin, I want to view an audit log of all actions so I can trace who did what and when.
- *Acceptance:* Audit log shows user name, action description, target post ID, and timestamp.
