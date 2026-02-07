# PromptQuest WordPress Theme

Custom WordPress theme for PromptQuest landing page with GitHub auto-deploy via WP Pusher.

## 📋 Description

Full-width landing page theme for PromptQuest - a gamified AI prompting platform. This theme provides a clean, modern landing page with email capture forms and no WordPress header/footer interference.

## 🚀 Features

- ✅ Full-width landing page template
- ✅ No header/footer/sidebar (clean canvas)
- ✅ Email capture forms
- ✅ Mobile responsive design
- ✅ Purple/indigo gradient hero with green CTAs
- ✅ Sample challenge preview section
- ✅ Auto-deploy ready (WP Pusher compatible)

## 📦 Installation

### Method 1: Via WP Pusher (Recommended - Auto-Deploy)

1. Install WP Pusher plugin on WordPress
2. Authenticate with GitHub
3. Install theme from repository: `YOUR-USERNAME/promptquest-theme`
4. Enable "Push-to-Deploy"
5. Activate theme

### Method 2: Manual Upload

1. Download theme as ZIP
2. WordPress Admin → Appearance → Themes → Add New → Upload Theme
3. Upload ZIP file
4. Activate theme

## 🎨 Usage

### Create Landing Page:

1. **Pages → Add New**
2. **Title:** "Home" or "Landing Page"
3. **Page Attributes → Template:** Select "PromptQuest Landing Page (Full Width)"
4. **Publish** (you don't need to add content - it's in the template!)
5. **(Optional) Settings → Reading → Homepage:** Set as static homepage

The landing page content is built into the template, so you don't need to paste anything!

## 📁 File Structure

```
promptquest-theme/
├── style.css                 # Theme header (required by WordPress)
├── functions.php             # WordPress functions & hooks
├── index.php                 # Fallback template
├── page-landing.php          # Landing page template (main file)
├── README.md                 # This file
└── .gitignore               # Git ignore rules
```

## 🔧 Customization

### Change Colors:

Edit `page-landing.php` and find these CSS variables:

- **Hero gradient:** `#6366F1`, `#4F46E5`, `#4338CA` (purple/indigo)
- **CTA buttons:** `#22C55E` (green)
- **Hover state:** `#16A34A` (darker green)

### Change Text:

Edit `page-landing.php` HTML section:

- **Main heading:** Line ~540 (`<h1>Master AI, One Prompt at a Time</h1>`)
- **Tagline:** Line ~542
- **Features:** Lines ~570-600
- **Social proof:** Line ~560 ("Join 2,000+ people...")

### Add Email Integration:

Edit the JavaScript function `handlePQSubmit()` in `page-landing.php` (around line ~770):

```javascript
// Add your email service API call
fetch('https://api.mailerlite.com/api/v2/subscribers', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-MailerLite-ApiKey': 'YOUR_API_KEY'
    },
    body: JSON.stringify({ email: email })
});
```

## 🔄 Development Workflow

### With WP Pusher (Auto-Deploy):

```bash
# 1. Make changes in VSCode
# Edit page-landing.php, functions.php, etc.

# 2. Commit changes
git add .
git commit -m "Updated hero section colors"

# 3. Push to GitHub
git push origin main

# 4. WordPress auto-updates in 60 seconds! ✨
```

### Manual Updates:

1. Edit files locally
2. FTP/SFTP upload to: `/wp-content/themes/promptquest-theme/`
3. Refresh your WordPress site

## 🐛 Troubleshooting

### "Template not showing in dropdown"

- Make sure `page-landing.php` has the template header comment
- Deactivate and reactivate theme
- Clear WordPress cache

### "Admin bar still showing"

- Check `functions.php` - `promptquest_hide_admin_bar()` function
- Add more aggressive CSS in `page-landing.php` style section

### "Content wrapped in container"

- The template uses aggressive CSS to break out of containers
- Check if your theme has custom CSS that's overriding
- Try adding more `!important` declarations

### "Email form not working"

- Check browser console (F12) for JavaScript errors
- Integrate with email service (MailerLite, ConvertKit, etc.)
- Test with `console.log(email)` first

## 📝 Version History

### 1.0.0 - Initial Release
- Full-width landing page template
- Email capture forms
- Features section
- Sample challenge preview
- Mobile responsive design

## 🤝 Contributing

This is a private theme for PromptQuest. For suggestions or bug reports, create an issue in the GitHub repository.

## 📄 License

GPL-2.0+ - WordPress compatible license

## 👨‍💻 Author

PromptQuest Team
- Website: https://promptquest.com
- Repository: https://github.com/YOUR-USERNAME/promptquest-theme

## 🚀 Next Steps

After installation:

1. ✅ Create landing page with template
2. ✅ Set as homepage (optional)
3. ✅ Integrate email service (MailerLite recommended)
4. ✅ Customize colors/text to your brand
5. ✅ Test on mobile devices
6. ✅ Set up WP Pusher auto-deploy
7. ✅ Start building PromptQuest! 🎉

---

**Questions?** Check the WP Pusher Complete Guide or create an issue on GitHub.
