# Live Real-Time Quiz — Requirements Document v2.0
**Project:** ArihantPLUS AI & Algo Conclave 2026
**Feature:** Live Real-Time Quiz (Multiple Quiz Types)
**Version:** 2.0
**Date:** September 2026

---

## 1. Overview

The Live Real-Time Quiz system supports multiple independent quiz types (Reasoning Quiz, Aptitude Quiz, GK Quiz, etc.). Each quiz type has its own question bank and can be run as a separate live session at any time. Each session has its own QR code, PIN, and real-time dashboard. Admin controls which quiz type is active and which question to display. A per-quiz scoreboard shows live rankings with response time tracking.

Key Characteristics:
- Multiple quiz types — Reasoning, Aptitude, GK, etc.
- Independent sessions — each quiz type runs separately at different times
- Separate QR + PIN per session — each quiz type has its own QR code
- One session active at a time globally — starting a new one ends the previous
- Real-time sync via WebSockets per session
- Per-quiz scoreboard — unique scorecard per quiz type

---

## 2. Quiz Types

System supports multiple named quiz types. Each is independent:

| Quiz Type | Description |
|---|---|
| Reasoning Quiz | Logical reasoning, patterns, sequences |
| Aptitude Quiz | Quantitative aptitude, math problems |
| GK Quiz | General knowledge, current affairs |
| Custom Quiz | Any other category (admin-defined) |

Each quiz type has:
- A unique name
- A description
- Its own set of questions (independent of other types)
- Can be run as a live session independently

Admin dashboard shows all quiz types. For each:
- Manage its questions (add/edit/delete/reorder)
- Start a new live session
- View active/past sessions
- Access live dashboard

Only ONE session active globally at any time. Starting new auto-ends previous.

---

## 3. Admin Quiz Management

### 3.1 Question Bank (per quiz type)

| Field | Type | Description |
|---|---|---|
| quiz_type | string | Which quiz type this belongs to |
| question_text | text | Question content |
| options | JSON | 4 options: ["A","B","C","D"] |
| correct_option | tinyint | Index 0-3 |
| order | integer | Display order within quiz type |
| time_limit | integer (nullable) | Seconds (null = no limit) |

Constraints:
- Min 1 question to start a session
- Max 50 questions per quiz type
- Exactly 4 options per question

### 3.2 Admin Actions

Per Quiz Type:
- CRUD questions
- Reorder questions
- Start Quiz (generates session + PIN + QR)
- View Live Dashboard

Global Controls (during active session):
- Show Question / Previous Question
- Pause / Resume
- End Quiz

Session Management:
- See which quiz type is currently active
- Switch between quiz types to manage questions
- Starting new session auto-ends any existing one

---

## 4. Quiz Session Flow

```
Admin creates quiz types with questions
 |
 v
Admin selects "Reasoning Quiz" and clicks "Start Quiz"
 |
 v
System generates: session_id + PIN + QR for Reasoning Quiz
QR points to: https://[domain]/quiz?type=reasoning
 |
 v
Admin shares PIN
Participants scan Reasoning QR -> enter PIN -> enter details -> lobby
 |
 v
Admin clicks "Show Question 1"
 |
 v
 All participants see Question 1
 Participants answer -> Submit
 System records all answers per participant
 |
 v
 Admin sees live analytics for Reasoning Quiz
 |
 v
Admin clicks "Next" -> Q1 analytics freeze -> Q2 appears
 |
 v
 ... all questions ...
 |
 v
Admin clicks "End Quiz"
 |
 v
 Final scorecard for Reasoning Quiz
 |
 v
 Admin starts "Aptitude Quiz" with its own QR, PIN, questions
```

Session States: waiting, active, paused, completed

One Session at a Time:
- Only one session active globally
- Starting new auto-ends previous
- Participants in old session see "Quiz ended"

---

## 5. Participant Flow

### Step 1: Scan QR (quiz-type specific)
- QR encodes: `https://[domain]/quiz?type={quiz_type}` (e.g., `?type=reasoning`)
- Saved to: `storage/qrcodes/quiz_{quiz_type}.png`
- Each quiz type has its own QR
- Displayed on admin screen when that quiz's session is active

### Step 2: Enter PIN
- Page: `/quiz?type={quiz_type}`
- "Enter the PIN shared by the host"
- 6-digit numeric PIN
- Validated against active session for that quiz type
- No active session: "Quiz is not currently active"
- Wrong PIN: "Incorrect PIN, please try again"
- Session completed: "This quiz has ended"

### Step 3: Enter Details
- Full Name (required)
- Email (required)
- Mobile (required)
- Duplicate email in same session: blocked

### Step 4: Lobby
- "Waiting for the quiz to start..."
- WebSocket: `quiz.{session_id}`
- Participant count updates live
- Auto-transitions to quiz when first question shown
- Quiz ends while in lobby: "Quiz has ended"

### Step 5: Answer Questions
- 4 options (A, B, C, D)
- Optional countdown timer
- Submit locks answer
- Refresh: re-enter email, system restores session

### Step 6: Final Scorecard
- After quiz ends
- Shows: rank, score, correct count, avg response time
- Per-question breakdown
- Only their own results for that quiz type

---

## 6. Real-Time Architecture

### Technology: Laravel WebSockets + Echo

**Connection Flow:**
1. Participant opens `/quiz?type={quiz_type}` -> page loads
2. After PIN + details -> connects to `quiz.{session_id}`
3. Admin connects to `quiz.{session_id}` + `admin.quiz.{session_id}`
4. Events broadcast on `quiz.{session_id}` reach all participants of that quiz

### Session Isolation
- Each session has unique `session_id`
- Channels are per-session: `quiz.{session_id}`
- No cross-talk between different quiz sessions
- Participants only receive events for their session

### Fallback
- Poll `GET /api/quiz/session/{id}/state` every 3 seconds if WebSocket fails

---

## 7. Database Schema

### 7.1 quiz_sessions

| Column | Type | Description |
|---|---|---|
| id | UUID (PK) | Unique session identifier |
| quiz_type | string | Quiz type (e.g., "reasoning") |
| pin | string(6) | 6-digit PIN |
| status | enum | waiting, active, paused, completed |
| current_question_order | integer | Current question order (0 = none) |
| created_by | FK -> users.id | Admin who started |
| started_at | timestamp (nullable) | When started |
| ended_at | timestamp (nullable) | When ended |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

Indexes: unique on pin, index on quiz_type, index on status

### 7.2 quiz_questions

| Column | Type | Description |
|---|---|---|
| id | bigint (PK) | Auto-increment |
| quiz_type | string | Which quiz type |
| question_text | text | Question content |
| options | JSON | 4 option strings |
| correct_option | tinyint | Index 0-3 |
| order | integer | Order within quiz type |
| time_limit | integer (nullable) | Seconds |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

Indexes: `[quiz_type, order]`, `quiz_type`

### 7.3 quiz_participants

| Column | Type | Description |
|---|---|---|
| id | bigint (PK) | Auto-increment |
| session_id | FK -> quiz_sessions.id | The session |
| name | string | Name |
| email | string | Email |
| mobile | string | Mobile |
| joined_at | timestamp | Join time |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

Unique: `[session_id, email]`

### 7.4 quiz_answers

| Column | Type | Description |
|---|---|---|
| id | bigint (PK) | Auto-increment |
| session_id | FK -> quiz_sessions.id | Session |
| participant_id | FK -> quiz_participants.id | Who answered |
| question_id | FK -> quiz_questions.id | Which question |
| selected_option | tinyint | Index 0-3 |
| is_correct | boolean | Correct? |
| response_time_ms | integer (nullable) | Response time in ms |
| submitted_at | timestamp | Submit time |

Unique: `[session_id, participant_id, question_id]`

Indexes: `[session_id, question_id]`, `[session_id, participant_id]`

### ER Diagram

quiz_sessions (1) -> (N) quiz_participants
quiz_sessions (1) -> (N) quiz_answers
quiz_questions (1) -> (N) quiz_answers
quiz_participants (1) -> (N) quiz_answers

---

## 8. Scoring & Ranking Logic

### 8.1 Per-Question
- Correct: +10 points
- Wrong: 0
- No answer: 0

### 8.2 First-Correct
- Among correct answers, lowest response_time_ms wins
- Shown as "First to answer: [Name] (X.Xs)"

### 8.3 Total Score
Sum of (is_correct ? 10 : 0)

### 8.4 Ranking (Per Quiz Scoreboard)
1. Total Score (descending)
2. Number of correct answers (descending)
3. Average response time (ascending)

Shared rank if still tied.

### 8.5 Per-Quiz Scoreboard
Each quiz type has independent scoreboard. Rankings calculated per session.

---

## 9. Admin Analytics Dashboard

### 9.1 Quiz Dashboard (`/admin/quiz`)
- Lists all quiz types
- Shows which is currently active (highlighted)
- Shows active session's PIN + QR
- Quick actions per quiz type

### 9.2 Live Dashboard (`/admin/quiz/{type}/live`)
For the active session of a quiz type:
- Current question (text, options, timer, first-correct badge)
- Live bar chart per option with counts + percentages
- Total responses, correct rate, avg response time
- Frozen analytics cards for previous questions
- Live leaderboard (top 10)

### 9.3 Post-Quiz Results (`/admin/quiz/{type}/results`)
- Overview stats
- Per-question breakdown
- Final leaderboard
- CSV export

### 9.4 Controls
Show Question, Previous Question, Pause, Resume, End Quiz

---

## 10. Participant Scorecard

### 10.1 During Quiz
- "Answer submitted! Waiting for next question..."
- No reveals during quiz

### 10.2 After Quiz (`/quiz/results?session={id}`)
- Rank, Score, Correct count, Avg Time
- Per-question breakdown
- Only their own results

---

## 11. Routes & Controllers

### 11.1 Public Routes

| Method | URI | Description |
|---|---|---|
| GET | `/quiz?type={quiz_type}` | Single entry — PIN, lobby, quiz, results (SPA) |
| POST | `/api/quiz/validate-pin` | Validate PIN for quiz type's session |
| POST | `/api/quiz/join` | Join session with details |
| POST | `/api/quiz/submit-answer` | Submit answer |
| GET | `/quiz/results?session={id}` | Personal scorecard |
| GET | `/api/quiz/session/{id}/state` | Polling fallback |

### 11.2 Admin Routes

Quiz Type Management:
| Method | URI | Description |
|---|---|---|
| GET | `/admin/quiz` | Quiz dashboard |
| POST | `/admin/quiz/types` | Create quiz type |
| PUT | `/admin/quiz/types/{type}` | Edit quiz type |
| DELETE | `/admin/quiz/types/{type}` | Delete quiz type |

Question Management (per quiz type):
| Method | URI | Description |
|---|---|---|
| GET | `/admin/quiz/{type}/questions` | Question bank |
| POST | `/admin/quiz/{type}/questions` | Add question |
| PUT | `/admin/quiz/{type}/questions/{id}` | Edit question |
| DELETE | `/admin/quiz/{type}/questions/{id}` | Delete question |
| POST | `/admin/quiz/{type}/questions/reorder` | Reorder |

Session Control (per quiz type):
| Method | URI | Description |
|---|---|---|
| POST | `/admin/quiz/{type}/start` | Start session |
| POST | `/admin/quiz/{type}/show-question` | Next question |
| POST | `/admin/quiz/{type}/prev-question` | Previous question |
| POST | `/admin/quiz/{type}/pause` | Pause |
| POST | `/admin/quiz/{type}/resume` | Resume |
| POST | `/admin/quiz/{type}/end` | End session |

Dashboards:
| Method | URI | Description |
|---|---|---|
| GET | `/admin/quiz/{type}/live` | Live dashboard |
| GET | `/admin/quiz/{type}/results` | Post-quiz results |

### 11.3 WebSocket Events

| Event | Channel | Broadcast To | Triggered By |
|---|---|---|---|
| quiz.question.shown | quiz.{session_id} | All + admin | Admin |
| quiz.question.paused | quiz.{session_id} | All + admin | Admin |
| quiz.question.resumed | quiz.{session_id} | All + admin | Admin |
| quiz.ended | quiz.{session_id} | All + admin | Admin |
| quiz.answer.received | admin.quiz.{session_id} | Admin only | System |
| quiz.participant.joined | admin.quiz.{session_id} | Admin only | System |
| quiz.question.analytics | admin.quiz.{session_id} | Admin only | System |

---

## 12. Views & Pages

### 12.1 Public

| Page | Route | Description |
|---|---|---|
| Quiz Entry SPA | `GET /quiz?type={quiz_type}` | PIN -> lobby -> play -> results |
| Results | `GET /quiz/results?session={id}` | Personal scorecard |

### 12.2 Admin

| Page | Route | Description |
|---|---|---|
| Quiz Dashboard | `GET /admin/quiz` | Quiz types list + active session + QR/PIN |
| Question Bank | `GET /admin/quiz/{type}/questions` | CRUD per quiz type |
| Start Quiz Modal | On dashboard | QR + PIN display |
| Live Dashboard | `GET /admin/quiz/{type}/live` | Real-time analytics + controls |
| Session Results | `GET /admin/quiz/{type}/results` | Post-quiz analytics + export |

---

## 13. API Endpoints

### 13.1 Participant

**POST /api/quiz/validate-pin**
```
Request: { "quiz_type": "reasoning", "pin": "123456" }
Response 200: { "valid": true, "session_id": "uuid", "status": "waiting" }
Response 404: { "valid": false, "message": "No active session for this quiz" }
Response 403: { "valid": false, "message": "Incorrect PIN" }
```

**POST /api/quiz/join**
```
Request: { "session_id": "uuid", "quiz_type": "reasoning", "name": "John", "email": "john@example.com", "mobile": "9876543210" }
Response 201: { "participant_id": 1, "session_id": "uuid", "name": "John" }
Response 422: { "message": "Quiz has already started. Joining closed." }
Response 422: { "message": "You have already joined this quiz" }
```

**POST /api/quiz/submit-answer**
```
Request: { "session_id": "uuid", "question_id": 1, "selected_option": 2 }
Response 200: { "success": true, "is_correct": true }
Response 400: Various error messages
```

**GET /api/quiz/session/{id}/state** (polling fallback)
```
Response: { status, current_question, time_remaining, participant_answered, is_correct }
```

### 13.2 Admin

**POST /api/admin/quiz/types**
```
Request: { "name": "Reasoning Quiz", "description": "..." }
Response 201: { "id": 1, "name": "Reasoning Quiz", "slug": "reasoning" }
```

**POST /api/admin/quiz/{type}/start**
```
Request: { }
Response 201: { "session_id": "uuid", "pin": "123456", "qr_url": "/storage/qrcodes/quiz_reasoning.png" }
```

**POST /api/admin/quiz/{type}/show-question**
```
Request: { }
Response 200: { "success": true, "question_order": 1 }
```

**POST /api/admin/quiz/{type}/end**
```
Request: { }
Response 200: { "success": true, "total_participants": 50 }
```

---

## 14. QR Code & PIN System

### 14.1 QR Code (per quiz type)
- Generated when admin starts session for that quiz type
- Encodes: `https://[domain]/quiz?type={quiz_type}`
- Saved to: `storage/qrcodes/quiz_{quiz_type}.png`
- Displayed on admin dashboard when session active
- Different QR per quiz type

### 14.2 PIN System
- 6-digit numeric PIN per session
- Displayed on admin dashboard
- Shared verbally/on-screen
- Validated against active session for that quiz type

### 14.3 Security
- Rate limiting on PIN validation (5/min per IP)
- UUID v4 session tokens unguessable
- PIN obfuscated in DB
- Admin auth required

---

## 15. Edge Cases & Rules

### Participant
- Wrong PIN: retry message
- No active session: "not currently active"
- Quiz already started: "joining closed"
- Duplicate email: blocked
- Page refresh: restore session
- Double submit: blocked

### Admin
- Start new while active: previous auto-ended
- Edit question during live: pushed on next display
- Delete shown question: analytics preserved
- Go back: participants see it again
- Pause: timer stops, submit disabled
- End early: redirect to results

### Data
- Identical score + time: shared rank
- 0 answers: score 0, bottom rank
- Special chars: standard validation

### Performance
- 500+ participants
- 50 questions max
- Real-time analytics on every answer
- Synchronous DB write for answers

---

## Appendix A: Configuration

```php
// config/quiz.php
return [
 'points_per_correct' => 10,
 'max_questions' => 50,
 'max_participants' => 1000,
 'pin_length' => 6,
 'polling_interval_ms' => 3000,
 'quiz_types' => [
 'reasoning' => 'Reasoning Quiz',
 'aptitude' => 'Aptitude Quiz',
 'gk' => 'GK Quiz',
 ],
];
```

---

## Appendix B: Files to be Created/Modified

### New Files
- app/Models/QuizSession.php
- app/Models/QuizQuestion.php
- app/Models/QuizParticipant.php
- app/Models/QuizAnswer.php
- app/Http/Controllers/QuizController.php
- app/Http/Controllers/Admin/AdminQuizController.php
- app/Services/QuizService.php
- database/migrations/xxxx_xx_xx_create_quiz_tables.php
- resources/views/quiz/index.blade.php (SPA)
- resources/views/quiz/results.blade.php
- resources/views/admin/quiz/index.blade.php
- resources/views/admin/quiz/questions.blade.php
- resources/views/admin/quiz/live.blade.php
- resources/views/admin/quiz/results.blade.php
- resources/js/quiz.js
- resources/js/admin-quiz.js

### Modified Files
- routes/web.php
- config/event.php

---

*End of Requirements Document v2.0*
