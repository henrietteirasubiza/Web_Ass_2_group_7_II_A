# Street Report — UniStack
**Scenario:** UniStack — INES Digital Notice Board + Marketplace

---

## User Quote
> "We use WhatsApp groups to sell books and find housing, but posts get buried within hours and we've had people get scammed. We need a proper place just for INES students."
>
> — *Final Year Computer Science Student, INES-Ruhengeri, February 2026*

---

## Exact Problem Being Solved
Students at INES-Ruhengeri use informal WhatsApp groups to:
- Buy and sell secondhand academic items (books, calculators, laptops)
- Share housing opportunities near campus
- Announce academic and social events

This creates three core problems:
1. **Posts get lost** — high-volume chats bury important posts within hours
2. **Scams happen** — no identity verification; anyone can post anything
3. **No moderation** — spam and inappropriate content cannot be removed systematically

---

## Chosen Scenario
**UniStack — INES Digital Notice Board + Marketplace (C)**

A student-only platform where posts go through moderation before becoming public, reducing scam risk and improving information quality.

---

## Scope for This Assignment
- Student registration restricted to @ines.ac.rw email addresses (simulated school email validation)
- Three roles: Student, Moderator, Admin
- Three post types: For Sale, Housing, Announcement
- Approval workflow: Pending → Approved or Rejected
- Report/flagging system for community safety
- JS polling every 10 seconds for real-time-like updates
- Student dashboard with post status tracking
- Moderator panel with review queue and flagged posts
- Admin panel with user management and audit log
- Fully responsive UI for mobile and desktop
- Deployed on InfinityFree or 000webhost with MySQL

**Out of scope (future iterations):**
- Real-time chat between buyer/seller
- Image uploads (placeholders used)
- Email notifications
- Payment integration
