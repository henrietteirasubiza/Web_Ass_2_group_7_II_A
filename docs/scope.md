# Scope — UniStack

## In Scope
- User registration (school email validation: @ines.ac.rw only)
- Login/logout with session management
- Three roles: Student, Moderator, Admin
- Post CRUD (Create, Read, Update, Delete) for students
- Three post types: For Sale, Housing, Announcement
- Moderation workflow: Pending → Approved / Rejected
- Flagging/reporting system
- Student dashboard with post status
- Moderator dashboard with review queue and flagged posts
- Admin dashboard with user management and audit log
- JS-based polling simulation (10s refresh)
- Search and category filter
- Fully responsive layout (mobile + desktop)
- MySQL database with prepared statements
- Deployment on InfinityFree/000webhost

## Out of Scope
- Real-time WebSocket notifications
- Image/file uploads
- Direct messaging between users
- Email notifications
- Payment processing
- Advanced analytics

## Non-Functional Requirements
- **Security:** All DB queries use MySQLi prepared statements; passwords hashed with bcrypt
- **Usability:** All flows completable in 3 clicks or fewer
- **Performance:** Pages load under 2 seconds on local network
- **Accessibility:** Semantic HTML, sufficient color contrast, keyboard-navigable forms
- **Maintainability:** MVC structure with no SQL in views
- **Responsiveness:** Tested on viewport widths 320px–1440px
