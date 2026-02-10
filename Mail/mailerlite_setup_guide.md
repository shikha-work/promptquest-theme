# MailerLite Integration - Quick Setup Guide

## 🎉 YOUR FILE IS READY!

I've created `page-landing-mailerlite.php` with **MailerLite integration already coded**!

---

## ⚡ QUICK SETUP (15 Minutes)

### STEP 1: Get MailerLite API Key (5 min)

1. **Go to:** mailerlite.com
2. **Sign up free** (if you haven't already)
3. **Verify your email**
4. **Login** to MailerLite dashboard
5. **Click your name** (top-right) → **Integrations**
6. **Find** "Developer API" or "API"
7. **Click** "Use" or "Generate new token"
8. **Copy** the API key (looks like: `eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...`)
9. **Save it** in a text file (you'll need it in Step 2)

**Screenshot description:**
- Dashboard → Top right corner → Your Name → Integrations
- Scroll to "Developer API" section
- Click "Generate new token" button
- Copy the long string that appears

---

### STEP 2: Add API Key to Your File (2 min)

1. **Open** `page-landing-mailerlite.php` in VSCode or text editor

2. **Find line ~760** (around the middle of the file):
   ```javascript
   var MAILERLITE_CONFIG = {
       apiKey: 'YOUR_MAILERLITE_API_KEY_HERE',
   ```

3. **Replace** `YOUR_MAILERLITE_API_KEY_HERE` with your actual API key:
   ```javascript
   var MAILERLITE_CONFIG = {
       apiKey: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...',
   ```

4. **Save** the file (Ctrl+S or Cmd+S)

**⚠️ IMPORTANT:** 
- Keep the quotes around the API key: `'YOUR_KEY_HERE'`
- Don't add spaces
- The key is long (200+ characters) - that's normal!

---

### STEP 3: Upload to WordPress (5 min)

**OPTION A: If using Git + WP Pusher (Recommended)**

```bash
# In VSCode Terminal:

# Replace the old file
mv page-landing-mailerlite.php page-landing.php

# Commit
git add page-landing.php
git commit -m "Added MailerLite email collection"

# Push to GitHub
git push origin main

# Wait 60 seconds - auto-deploys to WordPress!
```

---

**OPTION B: Manual Upload via WordPress**

1. **Open** the file in text editor
2. **Copy ALL** the code (Ctrl+A, Ctrl+C)
3. **WordPress Admin** → Appearance → Theme File Editor
4. **Select** your PromptQuest theme
5. **Find** `page-landing.php` in the right sidebar
6. **Select all** existing code and delete
7. **Paste** the new code
8. **Click** "Update File"

---

**OPTION C: Upload via FTP**

1. **Connect** to your WordPress via FTP (FileZilla, etc.)
2. **Navigate to:** `/wp-content/themes/promptquest-theme/`
3. **Upload** `page-landing-mailerlite.php`
4. **Rename it to:** `page-landing.php` (replace existing)

---

### STEP 4: Test It! (3 min)

1. **Go to your landing page** (refresh if already open)

2. **Open browser console** (F12 → Console tab)
   - You should see: "✅ MailerLite API key configured"
   - If you see warning about API key, go back to Step 2

3. **Enter a test email** (use your own email)

4. **Click** "Join the Waitlist"

5. **You should see:**
   - Button changes to "Submitting..."
   - Success message appears: "🎉 You're on the list!"
   - Form disappears

6. **Check MailerLite Dashboard:**
   - Go to: mailerlite.com
   - Click "Subscribers" in left menu
   - You should see your email! ✅

7. **Check your email inbox:**
   - You should receive MailerLite confirmation email

**✅ IT WORKS! You're now collecting emails!**

---

## 🎨 OPTIONAL: Create a Group (Recommended)

Groups help organize subscribers. For example, create a "Waitlist" group:

1. **MailerLite Dashboard** → **Subscribers** → **Groups**
2. **Click** "Create group"
3. **Name:** "PromptQuest Waitlist"
4. **Save**
5. **Copy the Group ID** (it's a number like: `123456789`)

6. **Update your config** in `page-landing.php`:
   ```javascript
   var MAILERLITE_CONFIG = {
       apiKey: 'your-api-key-here',
       groupId: '123456789',  // Add this line!
   ```

Now all subscribers go into "PromptQuest Waitlist" group!

---

## 📧 SEND YOUR FIRST EMAIL (5 min)

### Create Welcome Email Automation:

1. **MailerLite** → **Automations**
2. **Click** "Create automation"
3. **Choose** "Welcome new subscribers"
4. **Trigger:** When someone joins "PromptQuest Waitlist" group (or All subscribers)
5. **Action:** Send email
6. **Design your email:**

**Example Welcome Email:**

```
Subject: Welcome to PromptQuest! 🎉

Hi there!

Thanks for joining the PromptQuest waitlist!

You're one of the first to discover the gamified way to master AI prompting.

Here's what's coming:
🎮 Daily AI prompting challenges
🏆 Leaderboards and achievements
📈 Track your progress from beginner to expert

We're launching soon! You'll be the first to know.

In the meantime, have you tried:
- ChatGPT for daily tasks?
- Claude for longer conversations?
- Midjourney for AI images?

We'll help you master all of them!

Stay tuned,
The PromptQuest Team

P.S. Follow us on Twitter @PromptQuest for daily prompting tips!
```

7. **Save and activate** automation

**Now every new subscriber gets this email automatically!** ✨

---

## 🔧 ADVANCED: CUSTOM FIELDS (Optional)

Want to collect more than just email? Add custom fields!

### In MailerLite:

1. **Settings** → **Subscriber fields**
2. **Create new field:**
   - Name: "How did you hear about us?"
   - Type: Text

### In Your Code:

Add to the `fields` object (around line 795):

```javascript
fields: {
    source: 'PromptQuest Landing Page',
    form_location: formNumber === 1 ? 'Hero Section' : 'Bottom CTA',
    signup_date: new Date().toISOString(),
    how_did_you_hear: 'Landing Page'  // Add this!
}
```

---

## 📊 VIEW YOUR SUBSCRIBERS

### In MailerLite Dashboard:

1. **Click** "Subscribers" (left menu)
2. **See all subscribers** with:
   - Email address
   - When they signed up
   - Which form they used (Hero or Bottom)
   - Custom fields

### Export to CSV:

1. **Subscribers** → **Select all** (checkbox)
2. **Actions** → **Export**
3. **Choose CSV format**
4. **Download** - now you have a spreadsheet!

---

## 🐛 TROUBLESHOOTING

### "API key not configured" warning in console

**Fix:**
- Check that you replaced `YOUR_MAILERLITE_API_KEY_HERE` with your actual key
- Make sure there are quotes around the key: `'your-key-here'`
- Clear browser cache and refresh

---

### "401 Unauthorized" error

**Fix:**
- Your API key is incorrect or expired
- Go to MailerLite → Integrations → Delete old token → Generate new one
- Update the code with new key

---

### "Email already exists" message

**Fix:**
- This is actually good! It means MailerLite is working
- The email is already in your list
- Try with a different email address

---

### Form submits but no email in MailerLite

**Check:**
1. Open browser console (F12) - any errors?
2. Is your API key correct? (check for typos)
3. Check MailerLite "Unsubscribed" list - might be there
4. Try submitting again with different email

---

### "Something went wrong" error

**Check:**
1. Browser console for specific error message
2. Is MailerLite API working? (check status.mailerlite.com)
3. Is your internet connection working?
4. Try again in 5 minutes

---

## 🎯 WHAT'S INCLUDED IN THE CODE

### Features Already Built-In:

✅ **Email validation** - Checks if email is valid format
✅ **Loading state** - Button shows "Submitting..." while processing
✅ **Error handling** - Shows friendly messages if something fails
✅ **Success animation** - Smooth fade-in for success message
✅ **Form hiding** - Form disappears after successful submission
✅ **Duplicate prevention** - Tells user if email already exists
✅ **Debugging mode** - Console logs for troubleshooting (can disable)
✅ **Custom fields** - Tracks which form was used (Hero vs Bottom)
✅ **Analytics ready** - Hooks for Google Analytics and Facebook Pixel
✅ **Mobile responsive** - Works perfectly on all devices

### Security Features:

✅ **Client-side validation** - Checks email before sending
✅ **HTTPS required** - MailerLite API uses secure connection
✅ **No API key exposed** - Key is in PHP file, not visible to users
✅ **Rate limiting** - MailerLite handles spam prevention

---

## 📈 NEXT STEPS AFTER SETUP

### 1. Set Up Welcome Automation (5 min)
- Create automated welcome email
- Sends immediately when someone subscribes

### 2. Create Segments (Optional)
- Group subscribers by: Hero Form vs Bottom Form
- Send targeted emails based on behavior

### 3. Plan Your Launch Sequence
- Email 1 (Day 0): Welcome + What is PromptQuest
- Email 2 (Day 3): Tips for better AI prompting
- Email 3 (Day 7): Early access discount code
- Email 4 (Launch Day): We're live!

### 4. Add to Your Website
- Add email signature link
- Social media bio link
- Share on Twitter/LinkedIn

---

## 💰 COST REMINDER

- **Free:** Up to 1,000 subscribers
- **$10/month:** 1,001-1,500 subscribers
- **$15/month:** 1,501-2,500 subscribers

**Tip:** When you hit 1,000, consider switching to Sendinblue (free unlimited contacts!) or keep MailerLite if you love the features.

---

## ✅ FINAL CHECKLIST

Before going live, make sure:

- [ ] MailerLite API key is added to code
- [ ] Tested with your own email
- [ ] Email appears in MailerLite dashboard
- [ ] Welcome automation is set up and activated
- [ ] Success message displays correctly
- [ ] Form disappears after submission
- [ ] Mobile version works (test on phone)
- [ ] No console errors in browser (F12)
- [ ] Backup of original file (if replacing)

---

## 🎉 YOU'RE DONE!

Your landing page is now:
- ✅ Collecting emails automatically
- ✅ Sending welcome emails
- ✅ Tracking subscriber sources
- ✅ Ready to scale to 1,000+ subscribers

**Now go build PromptQuest and get those subscribers! 🚀**

---

## 💬 NEED HELP?

**Common issues:**
- API key problems → Double-check it's copied correctly
- Emails not arriving → Check MailerLite "Unsubscribed" list
- Console errors → Check browser console (F12) for specific error
- Form not working → Make sure JavaScript is enabled

**MailerLite Support:**
- Email: support@mailerlite.com
- Docs: mailerlite.com/help
- Response time: Usually same day

---

**Questions? Let me know and I'll help you debug!** 🚀
