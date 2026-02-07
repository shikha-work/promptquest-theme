<?php
/**
 * Template Name: PromptQuest Landing Page (Full Width)
 * Description: Full-width landing page template with no header, footer, or sidebar
 * 
 * @package PromptQuest
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> | Master AI Prompting</title>
    
    <?php wp_head(); ?>
    
    <style>
    /* ========================================
       WORDPRESS CLEANUP - Remove toolbar & containers
       ======================================== */
    
    /* Hide WordPress Admin Bar */
    #wpadminbar {
        display: none !important;
    }

    html {
        margin-top: 0 !important;
    }

    body {
        padding-top: 0 !important;
        margin: 0 !important;
    }

    body.logged-in {
        padding-top: 0 !important;
    }

    /* Hide WordPress theme elements */
    .site-header,
    header.header,
    .header,
    header {
        display: none !important;
    }

    .site-footer,
    footer.footer,
    .footer,
    footer {
        display: none !important;
    }

    .sidebar,
    .widget-area {
        display: none !important;
    }

    /* Remove page title */
    .entry-title,
    .page-title,
    .entry-header,
    .page-header,
    h1.entry-title {
        display: none !important;
    }

    /* Break out of WordPress container */
    .promptquest-landing {
        width: 100vw !important;
        max-width: 100vw !important;
        margin-left: calc(-50vw + 50%) !important;
        margin-right: calc(-50vw + 50%) !important;
        position: relative !important;
    }

    /* Remove theme padding/margins */
    .entry-content,
    .site-content,
    .content-area,
    main,
    article {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* Fix for WordPress Block Editor wrapper */
    .wp-site-blocks {
        padding: 0 !important;
        margin: 0 !important;
    }

    .wp-site-blocks > * {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Remove block editor default styles */
    .wp-block-post-content {
        padding: 0 !important;
        margin: 0 !important;
    }

    body > .wp-site-blocks {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    /* ========================================
       PROMPTQUEST STYLES
       ======================================== */

    /* Reset for this page only */
    .promptquest-landing * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .promptquest-landing {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        line-height: 1.6;
        color: #0F172A;
    }

    /* Hero Section */
    .pq-hero {
        background: linear-gradient(135deg, #6366F1 0%, #4F46E5 50%, #4338CA 100%);
        color: white;
        padding: 80px 20px;
        text-align: center;
        position: relative;
        margin: 0 -20px;
    }

    .pq-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .pq-logo {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 20px;
        display: inline-block;
        color: white;
    }

    .pq-logo-icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: #22C55E;
        border-radius: 8px;
        margin-right: 10px;
        vertical-align: middle;
        position: relative;
        line-height: 40px;
        font-size: 24px;
    }

    .pq-hero h1 {
        font-size: 56px !important;
        font-weight: 900 !important;
        line-height: 1.2 !important;
        margin-bottom: 20px !important;
        letter-spacing: -0.02em;
        color: white !important;
    }

    .pq-tagline {
        font-size: 24px;
        margin-bottom: 40px;
        opacity: 0.95;
        font-weight: 500;
        color: white;
    }

    /* Email Form */
    .pq-email-form {
        max-width: 500px;
        margin: 0 auto 30px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pq-email-input {
        flex: 1;
        min-width: 250px;
        padding: 16px 20px;
        font-size: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 12px;
        background: rgba(255,255,255,0.95);
        color: #0F172A;
    }

    .pq-email-input:focus {
        outline: none;
        border-color: #22C55E;
        background: white;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
    }

    .pq-cta-button {
        padding: 16px 32px;
        font-size: 16px;
        font-weight: 700;
        background: #22C55E;
        color: white;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(34, 197, 94, 0.4);
    }

    .pq-cta-button:hover {
        background: #16A34A;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.6);
    }

    .pq-social-proof {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 20px;
        color: white;
    }

    .pq-social-proof strong {
        font-weight: 700;
        color: #22C55E;
    }

    /* Features Section */
    .pq-features {
        padding: 80px 20px;
        background: #FAFAFA;
        margin: 0 -20px;
    }

    .pq-section-title {
        text-align: center;
        font-size: 42px !important;
        font-weight: 800 !important;
        margin-bottom: 60px !important;
        color: #1F2937 !important;
    }

    .pq-features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .pq-feature-card {
        text-align: center;
        padding: 40px 30px;
        border-radius: 16px;
        background: white;
        transition: all 0.3s ease;
        border: 1px solid #E5E7EB;
    }

    .pq-feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.15);
        border-color: #6366F1;
    }

    .pq-feature-icon {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .pq-feature-title {
        font-size: 24px !important;
        font-weight: 700 !important;
        margin-bottom: 15px !important;
        color: #0F172A !important;
    }

    .pq-feature-description {
        color: #64748B;
        font-size: 16px;
        line-height: 1.6;
    }

    /* Challenge Preview Section */
    .pq-challenge-preview {
        padding: 80px 20px;
        background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);
        margin: 0 -20px;
    }

    .pq-challenge-box {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        border-left: 5px solid #6366F1;
    }

    .pq-challenge-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pq-challenge-title {
        font-size: 24px !important;
        font-weight: 700 !important;
        color: #0F172A !important;
        margin: 0 !important;
    }

    .pq-difficulty-badge {
        padding: 6px 16px;
        background: #22C55E;
        color: white;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .pq-challenge-content {
        color: #475569;
        font-size: 16px;
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .pq-challenge-content p {
        margin-bottom: 10px;
    }

    .pq-challenge-content ul {
        margin-left: 20px;
        margin-top: 10px;
    }

    .pq-points-badge {
        display: inline-block;
        padding: 8px 16px;
        background: #FBBF24;
        color: #0F172A;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
    }

    /* Waitlist CTA Section */
    .pq-waitlist-cta {
        padding: 80px 20px;
        background: linear-gradient(135deg, #6366F1 0%, #4F46E5 50%, #4338CA 100%);
        color: white;
        text-align: center;
        margin: 0 -20px;
    }

    .pq-waitlist-cta h2 {
        font-size: 42px !important;
        font-weight: 800 !important;
        margin-bottom: 20px !important;
        color: white !important;
    }

    .pq-waitlist-cta p {
        font-size: 20px;
        margin-bottom: 40px;
        opacity: 0.95;
        color: white;
    }

    /* Success Message */
    .pq-success-message {
        display: none;
        max-width: 500px;
        margin: 20px auto;
        padding: 16px 24px;
        background: rgba(34, 197, 94, 0.2);
        border: 2px solid #22C55E;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        text-align: center;
    }

    .pq-success-message.show {
        display: block;
    }

    .pq-preview-text {
        text-align: center;
        margin-top: 40px;
    }

    .pq-preview-text p {
        font-size: 18px;
        color: #475569;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pq-hero h1 {
            font-size: 36px !important;
        }

        .pq-tagline {
            font-size: 18px;
        }

        .pq-section-title {
            font-size: 32px !important;
        }

        .pq-email-form {
            flex-direction: column;
        }

        .pq-email-input {
            width: 100%;
        }

        .pq-challenge-box {
            padding: 30px 20px;
        }

        .pq-hero {
            padding: 60px 20px;
        }

        .pq-features {
            padding: 60px 20px;
        }

        .pq-challenge-preview {
            padding: 60px 20px;
        }

        .pq-waitlist-cta {
            padding: 60px 20px;
        }
    }
</style>
</head>
<body <?php body_class(); ?>>

<div class="promptquest-landing">
    <!-- Hero Section -->
    <section class="pq-hero">
        <div class="pq-container">
            <div class="pq-logo">
                <span class="pq-logo-icon">⚡</span>
                PromptQuest
            </div>
            
            <h1>Master AI, One Prompt at a Time</h1>
            
            <p class="pq-tagline">
                Level up your ChatGPT, Claude, and Midjourney skills with gamified daily challenges
            </p>

            <form class="pq-email-form" id="pqEmailForm1" onsubmit="return handlePQSubmit(event, 1);">
                <input 
                    type="email" 
                    class="pq-email-input" 
                    placeholder="Enter your email" 
                    required
                    id="pqEmailInput1"
                >
                <button type="submit" class="pq-cta-button">
                    Join the Waitlist (Free)
                </button>
            </form>

            <div class="pq-success-message" id="pqSuccess1">
                🎉 You're on the list! Check your email for early access details.
            </div>

            <p class="pq-social-proof">
                Join <strong>2,000+</strong> people mastering AI prompting
            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="pq-features">
        <div class="pq-container">
            <h2 class="pq-section-title">Why PromptQuest?</h2>
            
            <div class="pq-features-grid">
                <div class="pq-feature-card">
                    <div class="pq-feature-icon">🎮</div>
                    <h3 class="pq-feature-title">Daily Challenges</h3>
                    <p class="pq-feature-description">
                        New prompting challenges every day. Build your skills one quest at a time with structured, progressive difficulty.
                    </p>
                </div>

                <div class="pq-feature-card">
                    <div class="pq-feature-icon">🏆</div>
                    <h3 class="pq-feature-title">Compete & Earn</h3>
                    <p class="pq-feature-description">
                        Climb leaderboards, earn achievements, and maintain streaks. See how you stack up against prompt engineers worldwide.
                    </p>
                </div>

                <div class="pq-feature-card">
                    <div class="pq-feature-icon">📈</div>
                    <h3 class="pq-feature-title">Track Your Growth</h3>
                    <p class="pq-feature-description">
                        From beginner to expert across 7 skill trees. Visual progress tracking shows exactly how you're improving.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Challenge Preview Section -->
    <section class="pq-challenge-preview">
        <div class="pq-container">
            <h2 class="pq-section-title">Try a Sample Challenge</h2>
            
            <div class="pq-challenge-box">
                <div class="pq-challenge-header">
                    <h3 class="pq-challenge-title">Coffee Haiku</h3>
                    <span class="pq-difficulty-badge">Beginner</span>
                </div>
                
                <div class="pq-challenge-content">
                    <p><strong>Objective:</strong> Get the AI to write a haiku about coffee that follows the traditional 5-7-5 syllable pattern.</p>
                    
                    <p><strong>Your Task:</strong> Craft a prompt that makes ChatGPT or Claude write a perfect haiku. It must have exactly 3 lines with 5, 7, and 5 syllables.</p>
                    
                    <p><strong>Success Criteria:</strong></p>
                    <ul>
                        <li>✓ Correct syllable count (5-7-5)</li>
                        <li>✓ Topic is clearly about coffee</li>
                        <li>✓ Sounds natural and poetic</li>
                    </ul>
                </div>
                
                <span class="pq-points-badge">⭐ 100 Points + Bonuses</span>
            </div>

            <div class="pq-preview-text">
                <p>
                    This is just 1 of <strong>500+ challenges</strong> across text, image, code, and creative prompting
                </p>
            </div>
        </div>
    </section>

    <!-- Waitlist CTA Section -->
    <section class="pq-waitlist-cta">
        <div class="pq-container">
            <h2>Ready to Level Up Your AI Skills?</h2>
            <p>Join the waitlist and get early access + exclusive launch discount</p>
            
            <form class="pq-email-form" id="pqEmailForm2" onsubmit="return handlePQSubmit(event, 2);">
                <input 
                    type="email" 
                    class="pq-email-input" 
                    placeholder="Enter your email" 
                    required
                    id="pqEmailInput2"
                >
                <button type="submit" class="pq-cta-button">
                    Get Early Access
                </button>
            </form>

            <div class="pq-success-message" id="pqSuccess2">
                🎉 You're on the list! Check your email for early access details.
            </div>
        </div>
    </section>
</div>

<script>
function handlePQSubmit(event, formNumber) {
    event.preventDefault();
    
    var input = document.getElementById('pqEmailInput' + formNumber);
    var form = document.getElementById('pqEmailForm' + formNumber);
    var message = document.getElementById('pqSuccess' + formNumber);
    
    var email = input.value;
    
    // Log email (you can send to your backend here)
    console.log('Email submitted:', email);
    
    // Show success message
    message.classList.add('show');
    
    // Hide form
    form.style.display = 'none';
    
    // TODO: Integrate with your email service (MailerLite, ConvertKit, etc.)
    // Example:
    // fetch('https://your-backend.com/api/subscribe', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify({ email: email })
    // });
    
    return false;
}
</script>

<?php wp_footer(); ?>
</body>
</html>
