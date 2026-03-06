# Page Map — UniStack

```
/ (index.php)
├── ?page=home                    → Browse approved posts (public)
├── ?page=auth&action=login       → Login page (public)
├── ?page=auth&action=register    → Register page (public)
├── ?page=auth&action=logout      → Logout (any authenticated)
│
├── [STUDENT]
│   ├── ?page=student             → Student dashboard (my posts + stats)
│   ├── ?page=posts&action=create → New post form
│   ├── ?page=posts&action=store  → POST: save new post
│   ├── ?page=posts&action=edit   → Edit post form
│   ├── ?page=posts&action=update → POST: save edited post
│   ├── ?page=posts&action=delete → Delete own post
│   ├── ?page=posts&action=view   → View single approved post
│   └── ?page=posts&action=report → POST: report a post
│
├── [MODERATOR]
│   ├── ?page=moderator&action=index   → Pending posts queue + stats
│   ├── ?page=moderator&action=approve → Approve post by ID
│   ├── ?page=moderator&action=reject  → Reject post by ID
│   └── ?page=moderator&action=flags   → Flagged/reported posts
│
└── [ADMIN]
    ├── ?page=admin&action=index       → Dashboard + all posts
    ├── ?page=admin&action=users       → All users + toggle active
    ├── ?page=admin&action=toggle_user → Toggle user active/inactive
    ├── ?page=admin&action=delete_post → Permanently delete any post
    └── ?page=admin&action=audit       → Audit log (last 100 actions)
```
