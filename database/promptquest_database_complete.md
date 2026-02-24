# PromptQuest Database Schema - Complete Guide for Beginners

## 🎯 WHAT THIS IS

This is your COMPLETE database structure for PromptQuest. I've designed it to be:
- ✅ Production-ready (can scale to millions of users)
- ✅ Beginner-friendly (detailed comments explaining everything)
- ✅ Copy-paste ready (just paste into Supabase SQL editor)

---

## 📊 DATABASE OVERVIEW

### Tables We're Creating:

1. **users** - User accounts and profiles
2. **challenges** - Prompt engineering challenges
3. **submissions** - User attempts at challenges
4. **achievements** - Badge/achievement definitions
5. **user_achievements** - Which users earned which badges
6. **leaderboard_entries** - Leaderboard rankings
7. **subscriptions** - Pro/Team/Enterprise tiers
8. **streaks** - Daily login tracking
9. **skill_progress** - Progress in 7 skill trees

**Total: 9 tables**

---

## 🚀 STEP 1: CREATE SUPABASE PROJECT

### 1.1: Sign Up for Supabase
1. Go to: supabase.com
2. Click "Start your project"
3. Sign up with GitHub (easiest)
4. Create new organization (name it "PromptQuest")

### 1.2: Create Database
1. Click "New project"
2. Project name: "promptquest-prod"
3. Database password: (generate strong password, save it!)
4. Region: Choose closest to your users
5. Plan: Free (starts with 500MB, enough for MVP)
6. Click "Create new project"

**Wait 2 minutes for setup...**

### 1.3: Open SQL Editor
1. Left sidebar → Click "SQL Editor"
2. Click "New query"
3. You're ready to paste the schema!

---

## 📝 COMPLETE DATABASE SCHEMA

Copy-paste this entire schema into Supabase SQL Editor:

```sql
-- ============================================
-- PROMPTQUEST DATABASE SCHEMA
-- Version: 1.0
-- Last Updated: 2025-02-24
-- ============================================

-- Enable UUID extension (for unique IDs)
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- ============================================
-- TABLE 1: USERS
-- Stores user accounts, profiles, and XP
-- ============================================

CREATE TABLE users (
    -- Primary key: unique identifier for each user
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    -- Authentication (managed by Supabase Auth, but we store reference)
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    
    -- Profile information
    full_name VARCHAR(255),
    avatar_url TEXT,
    bio TEXT,
    
    -- Gamification stats
    total_xp INTEGER DEFAULT 0,
    level INTEGER DEFAULT 1,
    current_streak INTEGER DEFAULT 0,
    longest_streak INTEGER DEFAULT 0,
    
    -- Subscription
    subscription_tier VARCHAR(20) DEFAULT 'free', -- free, pro, team, enterprise
    subscription_status VARCHAR(20) DEFAULT 'active', -- active, canceled, past_due
    
    -- Metadata
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    last_login_at TIMESTAMP WITH TIME ZONE,
    
    -- Indexes for fast queries
    CONSTRAINT valid_email CHECK (email ~* '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$'),
    CONSTRAINT valid_username CHECK (username ~* '^[a-zA-Z0-9_]{3,50}$')
);

-- Index for fast username lookups (for leaderboards)
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_total_xp ON users(total_xp DESC);
CREATE INDEX idx_users_level ON users(level DESC);

-- Auto-update timestamp on row update
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ language 'plpgsql';

CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON users
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- ============================================
-- TABLE 2: CHALLENGES
-- Stores all prompt engineering challenges
-- ============================================

CREATE TABLE challenges (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    -- Challenge details
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    difficulty VARCHAR(20) NOT NULL, -- beginner, intermediate, advanced, expert
    category VARCHAR(50) NOT NULL, -- text_precision, image_mastery, code_assistance, etc.
    
    -- Challenge content
    task TEXT NOT NULL, -- What the user needs to do
    success_criteria JSONB NOT NULL, -- Array of criteria for success
    hints JSONB, -- Array of hints (each costs XP to unlock)
    
    -- Scoring
    base_xp INTEGER NOT NULL, -- XP awarded for completion
    bonus_xp INTEGER DEFAULT 0, -- Bonus for perfect score
    
    -- AI Configuration
    ai_model VARCHAR(50), -- openai-gpt4, anthropic-claude, etc.
    evaluation_prompt TEXT, -- Prompt to evaluate user's submission
    
    -- Metadata
    is_active BOOLEAN DEFAULT true,
    difficulty_rating DECIMAL(3,2), -- Actual difficulty based on completion rates
    average_attempts DECIMAL(5,2), -- How many tries on average
    completion_rate DECIMAL(5,2), -- Percentage who complete it
    
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    -- Constraints
    CONSTRAINT valid_difficulty CHECK (difficulty IN ('beginner', 'intermediate', 'advanced', 'expert')),
    CONSTRAINT valid_category CHECK (category IN (
        'text_precision', 'image_mastery', 'code_assistance', 
        'creative_writing', 'red_teaming', 'efficiency', 'multi_model'
    ))
);

-- Indexes for filtering challenges
CREATE INDEX idx_challenges_difficulty ON challenges(difficulty);
CREATE INDEX idx_challenges_category ON challenges(category);
CREATE INDEX idx_challenges_is_active ON challenges(is_active);

CREATE TRIGGER update_challenges_updated_at BEFORE UPDATE ON challenges
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- ============================================
-- TABLE 3: SUBMISSIONS
-- Stores user attempts at challenges
-- ============================================

CREATE TABLE submissions (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    -- Foreign keys
    user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    challenge_id UUID NOT NULL REFERENCES challenges(id) ON DELETE CASCADE,
    
    -- Submission content
    user_prompt TEXT NOT NULL, -- What the user submitted
    ai_response TEXT, -- What the AI returned
    
    -- Scoring
    score INTEGER, -- 0-100 score
    xp_earned INTEGER DEFAULT 0,
    is_perfect BOOLEAN DEFAULT false, -- Perfect score (100)
    is_completed BOOLEAN DEFAULT false,
    
    -- Performance metrics
    attempt_number INTEGER DEFAULT 1, -- Which attempt is this (1st, 2nd, 3rd...)
    time_spent_seconds INTEGER, -- How long they spent
    tokens_used INTEGER, -- For efficiency challenges
    
    -- Feedback
    feedback JSONB, -- Detailed feedback on what worked/didn't work
    
    -- Metadata
    submitted_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    -- Composite index for user's challenge history
    CONSTRAINT unique_submission UNIQUE (user_id, challenge_id, attempt_number)
);

-- Indexes for queries
CREATE INDEX idx_submissions_user_id ON submissions(user_id);
CREATE INDEX idx_submissions_challenge_id ON submissions(challenge_id);
CREATE INDEX idx_submissions_score ON submissions(score DESC);
CREATE INDEX idx_submissions_submitted_at ON submissions(submitted_at DESC);

-- ============================================
-- TABLE 4: ACHIEVEMENTS
-- Defines all possible achievements/badges
-- ============================================

CREATE TABLE achievements (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    -- Achievement details
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    category VARCHAR(50) NOT NULL, -- streak, skill, social, special
    icon_url TEXT, -- Badge icon
    
    -- Unlock criteria
    unlock_criteria JSONB NOT NULL, -- JSON describing how to unlock
    -- Example: {"type": "streak", "days": 7}
    -- Example: {"type": "challenges_completed", "category": "text_precision", "count": 50}
    
    -- Rarity
    rarity VARCHAR(20) DEFAULT 'common', -- common, rare, epic, legendary
    xp_reward INTEGER DEFAULT 0,
    
    -- Stats
    total_earned INTEGER DEFAULT 0, -- How many users have this
    
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    CONSTRAINT valid_category CHECK (category IN ('streak', 'skill', 'social', 'special')),
    CONSTRAINT valid_rarity CHECK (rarity IN ('common', 'rare', 'epic', 'legendary'))
);

CREATE INDEX idx_achievements_category ON achievements(category);
CREATE INDEX idx_achievements_rarity ON achievements(rarity);

-- ============================================
-- TABLE 5: USER_ACHIEVEMENTS
-- Tracks which users earned which achievements
-- ============================================

CREATE TABLE user_achievements (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    achievement_id UUID NOT NULL REFERENCES achievements(id) ON DELETE CASCADE,
    
    earned_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    -- Prevent duplicate achievements
    CONSTRAINT unique_user_achievement UNIQUE (user_id, achievement_id)
);

CREATE INDEX idx_user_achievements_user_id ON user_achievements(user_id);
CREATE INDEX idx_user_achievements_earned_at ON user_achievements(earned_at DESC);

-- ============================================
-- TABLE 6: LEADERBOARD_ENTRIES
-- Stores leaderboard rankings (can be reset weekly)
-- ============================================

CREATE TABLE leaderboard_entries (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    
    -- Leaderboard type
    board_type VARCHAR(50) NOT NULL, -- global, weekly, category_specific
    category VARCHAR(50), -- Only for category-specific boards
    
    -- Ranking data
    rank INTEGER,
    xp INTEGER DEFAULT 0,
    challenges_completed INTEGER DEFAULT 0,
    perfect_scores INTEGER DEFAULT 0,
    
    -- Time period (for weekly boards)
    period_start DATE,
    period_end DATE,
    
    -- Metadata
    last_updated TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    CONSTRAINT valid_board_type CHECK (board_type IN ('global', 'weekly', 'category_specific'))
);

CREATE INDEX idx_leaderboard_board_type ON leaderboard_entries(board_type);
CREATE INDEX idx_leaderboard_rank ON leaderboard_entries(rank);
CREATE INDEX idx_leaderboard_xp ON leaderboard_entries(xp DESC);
CREATE INDEX idx_leaderboard_period ON leaderboard_entries(period_start, period_end);

-- ============================================
-- TABLE 7: SUBSCRIPTIONS
-- Manages Pro/Team/Enterprise subscriptions
-- ============================================

CREATE TABLE subscriptions (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    
    -- Stripe data
    stripe_customer_id VARCHAR(255) UNIQUE,
    stripe_subscription_id VARCHAR(255) UNIQUE,
    
    -- Subscription details
    tier VARCHAR(20) NOT NULL, -- pro, team, enterprise
    status VARCHAR(20) NOT NULL, -- active, canceled, past_due, trialing
    
    -- Billing
    current_period_start TIMESTAMP WITH TIME ZONE,
    current_period_end TIMESTAMP WITH TIME ZONE,
    cancel_at_period_end BOOLEAN DEFAULT false,
    
    -- Trial
    trial_start TIMESTAMP WITH TIME ZONE,
    trial_end TIMESTAMP WITH TIME ZONE,
    
    -- Metadata
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    CONSTRAINT valid_tier CHECK (tier IN ('pro', 'team', 'enterprise')),
    CONSTRAINT valid_status CHECK (status IN ('active', 'canceled', 'past_due', 'trialing', 'incomplete'))
);

CREATE INDEX idx_subscriptions_user_id ON subscriptions(user_id);
CREATE INDEX idx_subscriptions_stripe_customer_id ON subscriptions(stripe_customer_id);
CREATE INDEX idx_subscriptions_status ON subscriptions(status);

CREATE TRIGGER update_subscriptions_updated_at BEFORE UPDATE ON subscriptions
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- ============================================
-- TABLE 8: STREAKS
-- Tracks daily login streaks
-- ============================================

CREATE TABLE streaks (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    user_id UUID NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    
    -- Streak data
    current_streak INTEGER DEFAULT 0,
    longest_streak INTEGER DEFAULT 0,
    last_activity_date DATE NOT NULL,
    streak_start_date DATE,
    
    -- Freeze power-ups (skip a day without breaking streak)
    freeze_count INTEGER DEFAULT 0, -- How many freezes user has
    
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

CREATE INDEX idx_streaks_user_id ON streaks(user_id);
CREATE INDEX idx_streaks_current_streak ON streaks(current_streak DESC);

-- ============================================
-- TABLE 9: SKILL_PROGRESS
-- Tracks progress in 7 skill trees
-- ============================================

CREATE TABLE skill_progress (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    
    user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    
    -- Skill category
    skill_category VARCHAR(50) NOT NULL,
    
    -- Progress
    challenges_completed INTEGER DEFAULT 0,
    total_xp INTEGER DEFAULT 0,
    level INTEGER DEFAULT 1, -- Skill-specific level (1-10)
    
    -- Mastery
    mastery_percentage DECIMAL(5,2) DEFAULT 0.00, -- 0.00 to 100.00
    
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    -- Unique constraint: one entry per user per skill
    CONSTRAINT unique_user_skill UNIQUE (user_id, skill_category),
    CONSTRAINT valid_skill_category CHECK (skill_category IN (
        'text_precision', 'image_mastery', 'code_assistance',
        'creative_writing', 'red_teaming', 'efficiency', 'multi_model'
    ))
);

CREATE INDEX idx_skill_progress_user_id ON skill_progress(user_id);
CREATE INDEX idx_skill_progress_skill_category ON skill_progress(skill_category);

-- ============================================
-- FUNCTIONS: HELPFUL DATABASE FUNCTIONS
-- ============================================

-- Function: Calculate user level from XP
-- XP required for each level: level^2 * 100
-- Level 1: 100 XP, Level 2: 400 XP, Level 3: 900 XP, etc.

CREATE OR REPLACE FUNCTION calculate_level(xp INTEGER)
RETURNS INTEGER AS $$
BEGIN
    RETURN FLOOR(SQRT(xp / 100.0));
END;
$$ LANGUAGE plpgsql;

-- Function: Get XP needed for next level

CREATE OR REPLACE FUNCTION xp_for_next_level(current_level INTEGER)
RETURNS INTEGER AS $$
BEGIN
    RETURN (current_level + 1) * (current_level + 1) * 100;
END;
$$ LANGUAGE plpgsql;

-- Function: Award XP to user and update level

CREATE OR REPLACE FUNCTION award_xp(
    p_user_id UUID,
    p_xp_amount INTEGER
)
RETURNS VOID AS $$
DECLARE
    v_new_xp INTEGER;
    v_new_level INTEGER;
BEGIN
    -- Add XP to user
    UPDATE users
    SET total_xp = total_xp + p_xp_amount
    WHERE id = p_user_id
    RETURNING total_xp INTO v_new_xp;
    
    -- Calculate new level
    v_new_level := calculate_level(v_new_xp);
    
    -- Update level if changed
    UPDATE users
    SET level = v_new_level
    WHERE id = p_user_id AND level < v_new_level;
END;
$$ LANGUAGE plpgsql;

-- ============================================
-- VIEWS: PRE-BUILT QUERIES FOR COMMON TASKS
-- ============================================

-- View: Current Global Leaderboard (Top 100)
CREATE OR REPLACE VIEW global_leaderboard AS
SELECT 
    u.id,
    u.username,
    u.avatar_url,
    u.total_xp,
    u.level,
    ROW_NUMBER() OVER (ORDER BY u.total_xp DESC) as rank
FROM users u
WHERE u.subscription_status = 'active'
ORDER BY u.total_xp DESC
LIMIT 100;

-- View: User Stats Summary
CREATE OR REPLACE VIEW user_stats_summary AS
SELECT 
    u.id,
    u.username,
    u.total_xp,
    u.level,
    u.current_streak,
    COUNT(DISTINCT s.challenge_id) as challenges_completed,
    COUNT(DISTINCT CASE WHEN s.is_perfect THEN s.challenge_id END) as perfect_scores,
    COUNT(DISTINCT ua.achievement_id) as achievements_earned,
    COALESCE(AVG(s.score), 0) as average_score
FROM users u
LEFT JOIN submissions s ON u.id = s.user_id AND s.is_completed = true
LEFT JOIN user_achievements ua ON u.id = ua.user_id
GROUP BY u.id, u.username, u.total_xp, u.level, u.current_streak;

-- ============================================
-- SEED DATA: Sample Challenges
-- ============================================

INSERT INTO challenges (title, description, difficulty, category, task, success_criteria, base_xp, ai_model, evaluation_prompt)
VALUES 
(
    'Coffee Haiku',
    'Write a prompt that makes the AI generate a haiku about coffee with the traditional 5-7-5 syllable pattern.',
    'beginner',
    'text_precision',
    'Create a prompt that generates a haiku (5-7-5 syllable pattern) about coffee.',
    '["Contains exactly 3 lines", "Line 1 has 5 syllables", "Line 2 has 7 syllables", "Line 3 has 5 syllables", "Topic is clearly about coffee"]'::jsonb,
    100,
    'openai-gpt4',
    'Check if the response is a valid haiku about coffee with correct syllable count (5-7-5).'
),
(
    'JSON Architect',
    'Generate a valid JSON object with specific structure and data types.',
    'intermediate',
    'text_precision',
    'Create a prompt that generates a JSON object containing an array of 3 users, each with id (number), name (string), email (string), and active (boolean).',
    '["Valid JSON syntax", "Array contains exactly 3 objects", "Each object has id, name, email, active fields", "Correct data types"]'::jsonb,
    250,
    'openai-gpt4',
    'Validate JSON structure and check all requirements are met.'
);

-- ============================================
-- ROW LEVEL SECURITY (RLS)
-- Ensures users can only access their own data
-- ============================================

-- Enable RLS on all tables
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE submissions ENABLE ROW LEVEL SECURITY;
ALTER TABLE user_achievements ENABLE ROW LEVEL SECURITY;
ALTER TABLE subscriptions ENABLE ROW LEVEL SECURITY;
ALTER TABLE streaks ENABLE ROW LEVEL SECURITY;
ALTER TABLE skill_progress ENABLE ROW LEVEL SECURITY;

-- Policy: Users can read their own data
CREATE POLICY "Users can view own profile"
    ON users FOR SELECT
    USING (auth.uid() = id);

CREATE POLICY "Users can update own profile"
    ON users FOR UPDATE
    USING (auth.uid() = id);

-- Policy: Users can read/write their own submissions
CREATE POLICY "Users can view own submissions"
    ON submissions FOR SELECT
    USING (auth.uid() = user_id);

CREATE POLICY "Users can create own submissions"
    ON submissions FOR INSERT
    WITH CHECK (auth.uid() = user_id);

-- Policy: Anyone can read challenges (they're public)
CREATE POLICY "Anyone can view active challenges"
    ON challenges FOR SELECT
    USING (is_active = true);

-- Policy: Anyone can read leaderboards (public)
ALTER TABLE leaderboard_entries ENABLE ROW LEVEL SECURITY;
CREATE POLICY "Anyone can view leaderboards"
    ON leaderboard_entries FOR SELECT
    USING (true);

-- ============================================
-- COMPLETE!
-- ============================================

-- Run these queries to verify setup:

-- 1. Check all tables created
SELECT table_name 
FROM information_schema.tables 
WHERE table_schema = 'public' 
ORDER BY table_name;

-- 2. Check sample challenges
SELECT id, title, difficulty, category, base_xp 
FROM challenges;

-- 3. Test level calculation
SELECT calculate_level(0) as level_0,    -- Should be 0
       calculate_level(100) as level_1,   -- Should be 1
       calculate_level(400) as level_2,   -- Should be 2
       calculate_level(900) as level_3;   -- Should be 3

-- Success! Your database is ready! 🎉
```

---

## ✅ STEP 2: RUN THE SCHEMA

1. **Copy** the entire SQL above
2. **Paste** into Supabase SQL Editor
3. **Click** "Run" (bottom right)
4. **Wait** 10-15 seconds
5. **You should see:** "Success. No rows returned"

---

## 🎯 STEP 3: VERIFY IT WORKED

Run this query to see all your tables:

```sql
SELECT table_name 
FROM information_schema.tables 
WHERE table_schema = 'public' 
ORDER BY table_name;
```

**You should see 9 tables:**
- achievements
- challenges
- leaderboard_entries
- skill_progress
- streaks
- submissions
- subscriptions
- user_achievements
- users

---

## 📚 UNDERSTANDING THE DATABASE (Quick Tutorial)

### What is a "Foreign Key"?

Think of it like a reference/link between tables:

```
users table:
- id: abc123
- username: "john"

submissions table:
- id: xyz789
- user_id: abc123  ← This links to john's id!
- challenge_id: def456
```

**When john submits a challenge**, we store:
- WHAT challenge (challenge_id)
- WHO submitted it (user_id)
- WHAT they submitted (user_prompt)
- WHAT score they got (score)

### What is an "Index"?

Makes queries FAST! Like a book index:

```sql
-- Without index: Search 1 million users (slow!)
-- With index: Jump directly to user (fast!)

CREATE INDEX idx_users_username ON users(username);
```

### What is JSONB?

Store flexible data as JSON:

```sql
-- success_criteria stored as JSONB
{
  "criteria": [
    "Has 5 syllables in first line",
    "Has 7 syllables in second line",
    "Has 5 syllables in third line"
  ]
}
```

**Benefits:**
- Store complex data structures
- Query inside JSON
- Flexible schema

---

## 🔥 NEXT STEPS (What We Build Next Week)

Now that database is ready:

**Week 3-4: Build Authentication**
- Supabase Auth integration
- Login/signup pages
- Protected routes

**Week 5-6: Connect Database to App**
- Query challenges
- Display on frontend
- Submit to database

**Week 7-8: Build Challenge System**
- Submit prompts
- Call AI APIs
- Calculate scores
- Award XP

---

## 💡 COMMON DATABASE OPERATIONS YOU'LL USE

I'll give you these as reusable functions:

### Get User Profile:
```javascript
const { data } = await supabase
  .from('users')
  .select('*')
  .eq('id', userId)
  .single();
```

### Get All Challenges:
```javascript
const { data } = await supabase
  .from('challenges')
  .select('*')
  .eq('is_active', true)
  .order('difficulty', { ascending: true });
```

### Submit Challenge:
```javascript
const { data } = await supabase
  .from('submissions')
  .insert({
    user_id: userId,
    challenge_id: challengeId,
    user_prompt: userPrompt,
    score: calculatedScore,
    xp_earned: xpEarned
  });
```

### Get Leaderboard:
```javascript
const { data } = await supabase
  .from('global_leaderboard')  // This is a view we created!
  .select('*')
  .limit(100);
```

**I'll provide all these patterns as you need them!**

---

## 📖 DATABASE CHEAT SHEET

Keep this handy:

| Want to... | Use this table |
|------------|----------------|
| Get user info | `users` |
| List challenges | `challenges` |
| Record submission | `submissions` |
| Award achievement | `user_achievements` |
| Show leaderboard | `leaderboard_entries` or `global_leaderboard` view |
| Check subscription | `subscriptions` |
| Track streak | `streaks` |
| Skill tree progress | `skill_progress` |

---

## ✅ CHECKLIST

- [ ] Created Supabase account
- [ ] Created new project
- [ ] Pasted schema into SQL Editor
- [ ] Ran the schema (click "Run")
- [ ] Verified 9 tables created
- [ ] Checked sample challenges exist

**Once you complete this checklist, you're ready for Week 3!** 🎉

---

## 💬 QUESTIONS?

Common questions I can help with:

**"What if I get an error?"**
→ Copy-paste the error message, I'll help debug

**"How do I add more challenges?"**
→ Use INSERT statements (I'll show you)

**"Can I change the schema later?"**
→ Yes! Use ALTER TABLE (I'll guide you)

**"How do I backup the database?"**
→ Supabase does this automatically + I'll show manual backup

---

## 🚀 READY?

**Tell me when you've:**
1. Created Supabase project
2. Run the schema
3. Verified it worked

**Then I'll give you:**
- Week 3-4 tasks (Authentication)
- Supabase + Next.js integration code
- Login/signup components

**Let's build this! 💪**
